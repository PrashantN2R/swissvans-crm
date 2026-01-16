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
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('id')->on('leads')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['Created', 'Updated', 'Status Changed', 'Notes Added', 'Attachment Uploaded', 'Reminder Created'])->default('Created')->nullable();
            $table->enum('created_by', ['Administrator', 'Manager', 'Sales Executive'])->default('Administrator')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('superadmins')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('old_status', ['New', 'Contacted', 'Quoted', 'Negotiation', 'Won', 'Lost'])->nullable();
            $table->enum('new_status', ['New', 'Contacted', 'Quoted', 'Negotiation', 'Won', 'Lost'])->nullable();
            $table->unsignedBigInteger('lead_note_id')->nullable();
            $table->foreign('lead_note_id')->references('id')->on('lead_notes')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
    }
};
