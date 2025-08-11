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
            $table->string('email')->nullable()->change(); // Allow email to be nullable
            $table->string('name')->nullable()->change(); // Allow name to be nullable
            $table->string('password')->nullable()->change(); // Allow password to be nullable
            $table->timestamp('email_verified_at')->nullable()->change(); // Allow email_verified_at to be nullable
            $table->rememberToken()->nullable()->change(); // Allow remember_token to be nullable
            $table->string('uid')->nullable()->after('id'); // Add uid column for user identification
            $table->string('type')->after('uid')->default('normal')->comment('Type of the user, e.g., normal, zalo_oa, zalo_user, facebook, tiktok.');
            $table->string('role')->default('user')->after('email')->comment('Role of the user, e.g., admin, tenant, sales, customer.');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uid'); // Remove uid column
            $table->dropColumn('role'); // Remove role column
            $table->string('email')->change(); // Revert email to not nullable
            $table->string('name')->change(); // Revert name to not nullable
            $table->string('password')->change(); // Revert password to not nullable
            $table->timestamp('email_verified_at')->change(); // Revert email_verified_at to not nullable
            $table->rememberToken()->change(); // Revert remember_token to not nullable
        });
    }
};
