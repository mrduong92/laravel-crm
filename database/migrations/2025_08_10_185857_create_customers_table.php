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
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->comment('user is assigned to this customer');
            $table->foreign('user_id')->nullable()
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
            $table->string('uid');
            $table->string('type')->comment('zalo user, zalo oa, fanpage or tiktok');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
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
