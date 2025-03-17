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
        Schema::create('role_permission_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('role_permission_id')->constrained('role_permissions');
            $table->unique(['role_id', 'role_permission_id']); // Ensure unique role-permission pair
            $table->string('role_permission_setting_description')->nullable(); // Optional description
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom 'deleted_at' untuk soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission_settings');
    }
};
