<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Two customers may share a name; only email and phone identify a user.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('name');
        });
    }
};
