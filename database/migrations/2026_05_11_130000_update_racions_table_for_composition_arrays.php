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
        Schema::table('racions', function (Blueprint $table) {
            if (! Schema::hasColumn('racions', 'insumos')) {
                $table->json('insumos')->nullable()->after('nombre');
            }

            if (! Schema::hasColumn('racions', 'porcentajes')) {
                $table->json('porcentajes')->nullable()->after('insumos');
            }
        });

        if (Schema::hasColumn('racions', 'insumo_id')) {
            $insumosPorId = DB::table('insumos')->pluck('insumo', 'id');

            DB::table('racions')
                ->select('id', 'insumo_id')
                ->orderBy('id')
                ->get()
                ->each(function (object $racion) use ($insumosPorId): void {
                    $nombreInsumo = $insumosPorId[$racion->insumo_id] ?? null;

                    DB::table('racions')
                        ->where('id', $racion->id)
                        ->update([
                            'insumos' => json_encode($nombreInsumo ? [$nombreInsumo] : [], JSON_UNESCAPED_UNICODE),
                            'porcentajes' => json_encode($nombreInsumo ? [100] : [], JSON_UNESCAPED_UNICODE),
                        ]);
                });
        }

        if (Schema::hasColumn('racions', 'dieta_id')) {
            Schema::table('racions', function (Blueprint $table) {
                $table->dropForeign(['dieta_id']);
            });
        }

        if (Schema::hasColumn('racions', 'insumo_id')) {
            Schema::table('racions', function (Blueprint $table) {
                $table->dropForeign(['insumo_id']);
            });
        }

        Schema::table('racions', function (Blueprint $table) {
            $columnsToDrop = array_values(array_filter([
                Schema::hasColumn('racions', 'dieta_id') ? 'dieta_id' : null,
                Schema::hasColumn('racions', 'insumo_id') ? 'insumo_id' : null,
                Schema::hasColumn('racions', 'cantidad') ? 'cantidad' : null,
                Schema::hasColumn('racions', 'unidad_medida') ? 'unidad_medida' : null,
                Schema::hasColumn('racions', 'descripcion') ? 'descripcion' : null,
                Schema::hasColumn('racions', 'observaciones') ? 'observaciones' : null,
            ]));

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('racions', function (Blueprint $table) {
            if (! Schema::hasColumn('racions', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('nombre');
            }

            if (! Schema::hasColumn('racions', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('descripcion');
            }

            if (Schema::hasColumn('racions', 'insumos')) {
                $table->dropColumn('insumos');
            }

            if (Schema::hasColumn('racions', 'porcentajes')) {
                $table->dropColumn('porcentajes');
            }
        });
    }
};