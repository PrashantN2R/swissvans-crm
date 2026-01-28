<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('registration')->nullable();
            $table->string('vin')->nullable();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
// Prices
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('interest_rate', 10, 2)->nullable();
            // Business Lease
            $table->boolean('is_business_lease')->default(0);
            $table->decimal('business_lease_price', 10, 2)->nullable();
            $table->decimal('business_lease_discount_price', 10, 2)->nullable();

            // Hire Purchase
            $table->boolean('is_hire_purchase')->default(0);
            $table->decimal('hire_purchase_price', 10, 2)->nullable();
            $table->decimal('hire_purchase_discount_price', 10, 2)->nullable();

            // HPI (CAP)
            $table->string('van_type')->nullable();
            $table->string('hpi_mancode')->nullable();
            $table->string('hpi_modcode')->nullable();
            $table->string('hpi_derivative')->nullable();

            // Thumbnail (your fillable uses 'thumbnail')
            $table->string('thumbnail')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->boolean('status')->default(true);
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
