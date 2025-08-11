<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Namu\WireChat\Models\Conversation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table((new Conversation)->getTable(), function (Blueprint $table) {
            $table->string('thread_id')->nullable()->comment('Thread ID for the conversation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table((new Conversation)->getTable(), function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });
    }
};
