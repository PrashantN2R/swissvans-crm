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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('budget')->nullable();
            $table->string('event_type')->nullable();
            $table->date('event_date')->nullable();
            $table->enum('source', ['website', 'crm', 'facebook', 'instagram', 'google'])->default('crm');
            $table->text('meta')->nullable();
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->enum('status', ['New', 'Contacted', 'Quoted', 'Negotiation', 'Won', 'Lost'])->default('New');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('superadmins')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('superadmins')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
