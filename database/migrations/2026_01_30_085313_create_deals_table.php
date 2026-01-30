<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            // Unique Business Reference (e.g., DEAL-2026-XQ3)
            $table->string('deal_number')->unique();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

             $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');


            $table->unsignedBigInteger('salesperson_id')->nullable();
            $table->foreign('salesperson_id')->references('id')->on('superadmins')->onUpdate('cascade')->onDelete('cascade');

            // Deal Classification
            $table->enum('type', ['Sale', 'Lease'])->default('Sale');
            $table->enum('status', ['Draft', 'Pending', 'Completed', 'Cancelled'])->default('Draft');

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();

            // Business Lease
            $table->boolean('is_business_lease')->default(0);
            $table->decimal('business_lease_price', 10, 2)->nullable();
            $table->decimal('business_lease_discount_price', 10, 2)->nullable();

            // Hire Purchase
            $table->boolean('is_hire_purchase')->default(0);
            $table->decimal('hire_purchase_price', 10, 2)->nullable();
            $table->decimal('hire_purchase_discount_price', 10, 2)->nullable();

            $table->decimal('commission_amount', 12, 2)->default(0.00);
            $table->decimal('vat', 12, 2)->default(0.00);
              $table->decimal('interest_rate', 10, 2)->nullable();

            // Logic Flags
            $table->boolean('is_immutable')->default(false); // Locked when status = Completed

            // Dates
            $table->timestamp('completed_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->softDeletes(); // For auditing cancelled/archived deals

            // Indexing for performance
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
