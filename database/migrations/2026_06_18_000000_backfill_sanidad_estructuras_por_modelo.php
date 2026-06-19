<?php

use App\Support\SanidadEstructuraBootstrapService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $service = app(SanidadEstructuraBootstrapService::class);

        $service->backfillOrphanRecords();
        $service->syncMissingMotivosForAllModelos();
    }

    public function down(): void
    {
        //
    }
};
