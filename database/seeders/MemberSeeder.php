<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MemberPosition;
use App\Enums\DniType;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $members = [
            [
                'first_name' => 'Eugenio David',
                'last_name'  => 'Hernandez Hernandez',
                'dni_type'   => DniType::CC,
                'dni'       => '1005478121',
                'cellphone' => '3225687426',
                'birthday'  => Carbon::now(),
                'email'     => 'eugenio@gmail.com',
            ],
            [
                'first_name' => 'Daniel Eduardo',
                'last_name'  => 'Perez Doria',
                'dni_type'   => DniType::CC,
                'dni'       => '1005478132',
                'cellphone' => '3225687427',
                'birthday'  => Carbon::now(),
                'email'     => 'danieleduardo@gmail.com',
            ],
            [
                'first_name' => 'Daniel Enrique',
                'last_name'  => 'Guerra Mezquida',
                'dni_type'   => DniType::CC,
                'dni'       => '1005478156',
                'cellphone' => '3225687428',
                'birthday'  => Carbon::now(),
                'email'     => 'danielenrique@gmail.com',
            ],
        ];

        $organization   = Organization::query()->where('nit', '812005726')->first();
        $memberPosition = MemberPosition::query()->where('name', 'Gerente - Administrador')->first();

        foreach ($members as $member) {
            Member::create([
                'first_name' => $member['first_name'],
                'last_name'  => $member['last_name'],
                'dni_type'   => $member['dni_type'],
                'dni'       => $member['dni'],
                'cellphone_1' => $member['cellphone'],
                'birthdate'  => $member['birthday'],
                'email'     => $member['email'],
                'organization_id' => $organization->id,
                'member_position_id' => $memberPosition->id,
            ]);
        }
    }
}
