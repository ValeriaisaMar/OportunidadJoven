<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empleos', function (Blueprint $table) {
            $table->string('url_postulacion', 500)->nullable()->after('salario');
            $table->string('contacto')->nullable()->after('url_postulacion');
            $table->date('fecha_cierre')->nullable()->after('contacto');
        });
    }

    public function down(): void
    {
        Schema::table('empleos', function (Blueprint $table) {
            $table->dropColumn(['url_postulacion', 'contacto', 'fecha_cierre']);
        });
    }
};
