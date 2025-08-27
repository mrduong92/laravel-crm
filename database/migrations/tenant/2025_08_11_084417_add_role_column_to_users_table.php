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
        Schema::table('users', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('password'); // Add external_id column for user identification
            $table->string('source')->after('external_id')->nullable()->comment('source of the user, e.g., normal, zalo_oa, zalo_user, facebook, tiktok.');
            $table->string('phone')->nullable()->after('email')->comment('Phone number of the user.');
            $table->string('role')->default('sales')->after('phone')->comment('Role of the user, e.g., owner, admin, sales.');
            $table->string('status')->default('active')->after('role')->comment('Status of the user, e.g., active, inactive.');
            $table->unsignedBigInteger('created_by')->nullable(); // user nào tạo ra
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['external_id', 'role', 'source', 'created_by']);
        });
    }
};
