<?php

namespace Database\Seeders;

use App\Models\NoVisitReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoVisitReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            'Cliente no disponible',
            'Cambio de ruta',
            'Trabajo desde la oficina'
        ];

        foreach ($reasons as $reason) {
            NoVisitReason::create([
                'reason' => $reason
            ]);
        }
    }
}
