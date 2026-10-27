<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the project-specific account fields.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Stores the username required for collector registration.
            $table->string('username')->nullable()->after('name');

            // All normal registrations begin with the collector role.
            $table->string('role')->default('collector')->after('password');
        });
    }

    /**
     * Remove the project-specific account fields.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role']);
        });
    }
};