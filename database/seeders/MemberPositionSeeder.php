<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberPosition;

class MemberPositionSeeder extends Seeder
{
    public function run()
    {
        $memberPositions = [
            'Gerente - Administrador',
            'Farmacia - Regente de Farmacia - Bodega - Almacén',
            'Compras',
            'Pagador - Financiero - Tesorería/Jurídica',
        ];

        foreach ($memberPositions as $memberPosition) {
            MemberPosition::create([
                'name' => $memberPosition
            ]);
        }
    }
}
