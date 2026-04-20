<?php

namespace Database\Seeders;

use App\Models\MotivoSanidadEstructura;
use Illuminate\Database\Seeder;

class MotivoSanidadEstructuraSeeder extends Seeder
{
    public function run(): void
    {
        $motivos = [
            'Antibiotico',
            'Antiparasitario',
            'Hormonas',
            'Vac. Respiratoria 2 ds',
            'Vac. Triple (9) 2 ds',
            'tulatromicina',
        ];

        foreach ($motivos as $motivo) {
            MotivoSanidadEstructura::create([
                'motivo' => $motivo,
                'tipo' => 'sanidad',
            ]);
        }
    }
}