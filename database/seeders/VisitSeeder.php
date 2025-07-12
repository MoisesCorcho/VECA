<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\Survey;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $survey = Survey::where('title', 'Surtimed - clientes')->first();

        $data = [
            [
                'dni' => '1005478123',
                'organization_nit' => '1004731778',
            ],
            [
                'dni' => '1005472347',
                'organization_nit' => '1004731745',
            ],
            [
                'dni' => '1005479536',
                'organization_nit' => '1004731734',
            ],
        ];

        foreach ($data as $item) {
            $user = User::where('dni', $item['dni'])->first();
            $organization = Organization::where('nit', $item['organization_nit'])->first();

            Visit::factory()
                ->count(20)
                ->visited()
                ->for($user)
                ->for($organization)
                ->for($survey)
                ->create();
        }
    }
}
