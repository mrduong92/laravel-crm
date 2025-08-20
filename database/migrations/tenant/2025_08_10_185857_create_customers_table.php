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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('source')->comment('zalo, facebook, webchat, …');
            $table->string('external_id')->comment('ZaloID, FBUID, …');
            $table->unsignedBigInteger('assigned_to')->nullable()->comment('sale phụ trách');
            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->string('status')->comment('lead, potential, closed, lost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
