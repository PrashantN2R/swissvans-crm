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
        Schema::create('models', function (Blueprint $table) {
            $table->id();

            $table->string('cap_id')->nullable();
            $table->string('manufacturer');          // e.g. "B-ON"

            $table->string('capmod_id')->nullable(); // CAP model ID
            $table->string('introduced')->nullable(); // Year

            $table->decimal('discount_percent', 10, 2)->default(0.00);
            $table->decimal('profit_percent', 10, 2)->default(0.00);
            $table->decimal('profit', 15, 2)->default(0.00);
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
