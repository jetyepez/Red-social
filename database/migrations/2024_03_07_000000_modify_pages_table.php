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
        Schema::table('pages', function (Blueprint $table) {
            // Hacer los campos de imágenes nullable
            $table->string('icon')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
            
            // Agregar soft deletes
            $table->softDeletes();
            
            // Agregar índices
            $table->index('name');
            $table->index('type');
            $table->index('is_private');
            
            // Hacer el UUID único
            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Revertir los campos de imágenes a required
            $table->string('icon')->nullable(false)->change();
            $table->string('thumbnail')->nullable(false)->change();
            
            // Eliminar soft deletes
            $table->dropSoftDeletes();
            
            // Eliminar índices
            $table->dropIndex(['name']);
            $table->dropIndex(['type']);
            $table->dropIndex(['is_private']);
            
            // Eliminar restricción única del UUID
            $table->dropUnique(['uuid']);
        });
    }
}; 