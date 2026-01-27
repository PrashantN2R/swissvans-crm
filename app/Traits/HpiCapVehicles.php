<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Throwable;

trait HpiCapVehicles
{
    /**
     * Build the credential XML fragment using env/config values.
     */
    protected function hpiAuthXml(): string
    {
        // Use env or config() as appropriate for your project
        $subscriberId = htmlspecialchars((string) config('services.hpi.subscriber_id', env('HPI_SUBSCRIBER_ID')), ENT_XML1);
        $password     = htmlspecialchars((string) config('services.hpi.password', env('HPI_PASSWORD')), ENT_XML1);
        $database     = htmlspecialchars((string) config('services.hpi.database', env('HPI_DATABASE')), ENT_XML1);

        return "<subscriberId>{$subscriberId}</subscriberId>"
            . "<password>{$password}</password>"
            . "<database>{$database}</database>";
    }

    /**
     * Perform a SOAP call, persist raw XML for inspection, and return <Table> nodes.
     *
     * @param  string $soapBody      Full SOAP envelope to send
     * @param  string $endpointUrl   HPI SOAP endpoint
     * @param  string $soapAction    SOAPAction header
     * @param  string $fileName      Local XML file name (stored in storage/app/hpi/)
     * @return SimpleXMLElement[]    Array of <Table> SimpleXMLElement nodes
     *
     * @throws \RuntimeException     On HTTP or parsing errors
     */
    protected function hpiProcess(string $soapBody, string $endpointUrl, string $soapAction, string $fileName): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction'   => $soapAction,
            ])
                ->timeout(20)
                ->post($endpointUrl, $soapBody);

            if (! $response->ok()) {
                throw new \RuntimeException("HPI request failed: HTTP {$response->status()}");
            }

            $xmlBody = $response->body();

            // Persist raw response for debugging/auditing (storage/app/hpi/{fileName})
            $path = "hpi/{$fileName}";
            Storage::disk('local')->put($path, $xmlBody);

            $xml = @simplexml_load_string($xmlBody);
            if (! $xml instanceof SimpleXMLElement) {
                throw new \RuntimeException('Unable to parse HPI SOAP XML.');
            }

            // Register namespaces used by the HPI SOAP responses
            $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
            $xml->registerXPathNamespace('ns', 'https://soap.cap.co.uk/vehicles');
            $xml->registerXPathNamespace('diffgr', 'urn:schemas-microsoft-com:xml-diffgram-v1');

            // Extract <Table> nodes under diffgram/NewDataSet
            $tables = $xml->xpath('//diffgr:diffgram/NewDataSet/Table');

            return is_array($tables) ? $tables : [];
        } catch (Throwable $e) {
            Log::error('HPI SOAP error', [
                'endpoint'   => $endpointUrl,
                'soapAction' => $soapAction,
                'message'    => $e->getMessage(),
            ]);

            throw new \RuntimeException('HPI service is currently unavailable. Please try again later : .' . $e->getMessage());
        }
    }

    /**
     * Get current manufacturers.
     *
     * @return array<array{CMan_Code:string, CMan_Name:string}>
     */
    public function hpiGetCapMan(): array
    {
        $auth = $this->hpiAuthXml();

        $soap = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                       xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                       xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <GetCapMan xmlns="https://soap.cap.co.uk/vehicles">
              {$auth}
              <justCurrentManufacturers>true</justCurrentManufacturers>
              <bodyStyleFilter xsi:nil="true" />
            </GetCapMan>
          </soap:Body>
        </soap:Envelope>
        XML;

        $tables = $this->hpiProcess(
            soapBody: $soap,
            endpointUrl: 'https://soap.cap.co.uk/Vehicles/CapVehicles.asmx',
            soapAction: 'https://soap.cap.co.uk/vehicles/GetCapMan',
            fileName: 'man_response.xml'
        );

        $out = [];
        foreach ($tables as $t) {
            $out[] = [
                'CMan_Code' => (string) ($t->CMan_Code ?? ''),
                'CMan_Name' => trim((string) ($t->CMan_Name ?? '')),
            ];
        }
        return $out;
    }

    /**
     * Get current models for a given manufacturer code.
     *
     * @param  string $manCode
     * @return array<array{CMod_Code:string, CMod_Name:string, CMod_Introduced:string, CMod_Discontinued:string}>
     */
    public function hpiGetCapMod(string $manCode): array
    {
        $auth = $this->hpiAuthXml();

        $manCode = htmlspecialchars($manCode, ENT_XML1);

        $soap = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                       xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                       xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <GetCapMod xmlns="https://soap.cap.co.uk/vehicles">
              {$auth}
              <manRanCode>{$manCode}</manRanCode>
              <manRanCodeIsMan>true</manRanCodeIsMan>
              <justCurrentModels>true</justCurrentModels>
              <bodyStyleFilter xsi:nil="true" />
            </GetCapMod>
          </soap:Body>
        </soap:Envelope>
        XML;

        $tables = $this->hpiProcess(
            soapBody: $soap,
            endpointUrl: 'https://soap.cap.co.uk/Vehicles/CapVehicles.asmx?op=GetCapMod',
            soapAction: 'https://soap.cap.co.uk/vehicles/GetCapMod',
            fileName: 'model_response.xml'
        );

        $out = [];
        foreach ($tables as $t) {
            $out[] = [
                'CMod_Code'         => (string) ($t->CMod_Code ?? ''),
                'CMod_Name'         => trim((string) ($t->CMod_Name ?? '')),
                'CMod_Introduced'   => (string) ($t->CMod_Introduced ?? ''),
                'CMod_Discontinued' => (string) ($t->CMod_Discontinued ?? ''),
            ];
        }
        return $out;
    }

    /**
     * Get current derivatives for a given model code.
     *
     * @param  string $modCode
     * @return array<array{CDer_ID:string, CDer_Name:string, CDer_Introduced:string, LastSpecDate:string, ModelYearRef:string}>
     */
    public function hpiGetCapDer(string $modCode): array
    {
        $auth = $this->hpiAuthXml();

        $modCode = htmlspecialchars($modCode, ENT_XML1);

        $soap = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                       xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                       xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <GetCapDer xmlns="https://soap.cap.co.uk/vehicles">
              {$auth}
              <modCode>{$modCode}</modCode>
              <justCurrentDerivatives>true</justCurrentDerivatives>
            </GetCapDer>
          </soap:Body>
        </soap:Envelope>
        XML;

        $tables = $this->hpiProcess(
            soapBody: $soap,
            endpointUrl: 'https://soap.cap.co.uk/Vehicles/CapVehicles.asmx?op=GetCapDer',
            soapAction: 'https://soap.cap.co.uk/vehicles/GetCapDer',
            fileName: 'derivative_response.xml'
        );

        $out = [];
        foreach ($tables as $t) {
            $out[] = [
                'CDer_ID'        => (string) ($t->CDer_ID ?? ''),
                'CDer_Name'      => trim((string) ($t->CDer_Name ?? '')),
                'CDer_Introduced' => (string) ($t->CDer_Introduced ?? ''),
                'LastSpecDate'   => (string) ($t->LastSpecDate ?? ''),
                'ModelYearRef'   => (string) ($t->ModelYearRef ?? ''),
            ];
        }
        return $out;
    }
}
