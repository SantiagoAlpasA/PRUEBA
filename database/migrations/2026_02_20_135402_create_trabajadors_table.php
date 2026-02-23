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
        Schema::create('trabajadors', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('dni', 8)->unique();
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->integer('cantidad_hijos');
            
            
            $table->string('foto')->nullable();
            $table->string('area');
            $table->string('cargo');
            $table->date('fecha_ingreso');
            
            
            $table->decimal('sueldo_base', 10, 2);
            $table->decimal('asignacion_familiar', 10, 2)->default(0);
            $table->decimal('sueldo_bruto', 10, 2)->default(0);
            $table->decimal('descuento_afp_obligatoria', 10, 2)->default(0);
            $table->decimal('descuento_afp_comision', 10, 2)->default(0);
            $table->decimal('descuento_renta_5ta', 10, 2)->default(0);
            $table->decimal('descuento_eps', 10, 2)->default(100.00);
            $table->decimal('sueldo_neto', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadors');
    }
};
