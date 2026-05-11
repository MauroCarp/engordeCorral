<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('modelos', function (Blueprint $table) {
            $table->json('dieta_json')->nullable()->after('nombre');
        });

        DB::table('modelos')
            ->select('id', 'dieta')
            ->orderBy('id')
            ->get()
            ->each(function (object $modelo): void {
                $dietas = [];

                if (! empty($modelo->dieta)) {
                    $dietas[] = [
                        'nombre' => $modelo->dieta,
                        'porcentaje' => 100,
                    ];
                }

                DB::table('modelos')
                    ->where('id', $modelo->id)
                    ->update([
                        'dieta_json' => json_encode($dietas, JSON_UNESCAPED_UNICODE),
                    ]);
            });

        Schema::table('modelos', function (Blueprint $table) {
            $table->dropColumn('dieta');
        });

        Schema::table('modelos', function (Blueprint $table) {
            $table->renameColumn('dieta_json', 'dieta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modelos', function (Blueprint $table) {
            $table->string('dieta_texto')->nullable()->after('nombre');
        });

        DB::table('modelos')
            ->select('id', 'dieta')
            ->orderBy('id')
            ->get()
            ->each(function (object $modelo): void {
                $dietas = json_decode($modelo->dieta ?? '[]', true);
                $primeraDieta = is_array($dietas) && isset($dietas[0]['nombre'])
                    ? $dietas[0]['nombre']
                    : null;

                DB::table('modelos')
                    ->where('id', $modelo->id)
                    ->update([
                        'dieta_texto' => $primeraDieta,
                    ]);
            });

        Schema::table('modelos', function (Blueprint $table) {
            $table->dropColumn('dieta');
        });

        Schema::table('modelos', function (Blueprint $table) {
            $table->renameColumn('dieta_texto', 'dieta');
        });
    }
};