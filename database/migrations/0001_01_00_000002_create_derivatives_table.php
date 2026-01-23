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
        Schema::create('derivatives', function (Blueprint $table) {
            $table->id(); // 5174

            $table->unsignedBigInteger('derivative_id'); // 57421
            $table->string('cap_id'); // 59029
            $table->string('manufacturer'); // B-ON
            $table->string('capmod_id'); // 59030
            $table->string('model'); // B4 ELECTRIC

            $table->string('introduced')->nullable();
            $table->string('last_spec_date')->nullable();

            $table->string('model_ref_year')->nullable(); // 2022 ... padded

            $table->decimal('discount_percent', 10, 2)->default(0.00);
            $table->decimal('profit_percent', 10, 2)->default(0.00);
            $table->decimal('profit', 10, 2)->default(0.00);

            $table->string('name'); // 51kW 40kWh...

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivatives');
    }
};
