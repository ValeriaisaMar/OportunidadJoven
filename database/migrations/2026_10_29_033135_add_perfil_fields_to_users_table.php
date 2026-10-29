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
        $table->string('telefono')->nullable()->after('rol');
        $table->string('ubicacion')->nullable()->after('telefono');
        $table->date('fecha_nacimiento')->nullable()->after('ubicacion');
        $table->string('educacion')->nullable()->after('fecha_nacimiento');
        $table->text('bio')->nullable()->after('educacion');
        $table->json('habilidades')->nullable()->after('bio');
        $table->string('cv_path')->nullable()->after('habilidades');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['telefono', 'ubicacion', 'fecha_nacimiento', 'educacion', 'bio', 'habilidades', 'cv_path']);
    });
}
};
