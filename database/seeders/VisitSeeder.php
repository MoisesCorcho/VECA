<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Survey;
use App\Models\Visit;

class VisitSeeder extends Seeder
{
    public function run()
    {
        $visits1 = [
            [
                'visitDate' => '2023-03-13',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-14',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-16',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-16',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-16',
                'status'    => 'scheduled',
            ],
        ];

        $visits2 = [
            [
                'visitDate' => '2023-03-13',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-14',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-15',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-03-16',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-20',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-20',
                'status'    => 'scheduled',
            ],
        ];

        $visits3 = [
            [
                'visitDate' => '2023-04-2',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-3',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-4',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-4',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-3',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-4',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-4',
                'status'    => 'scheduled',
            ],
            [
                'visitDate' => '2023-04-4',
                'status'    => 'scheduled',
            ],
        ];

        //Llenamos visitas del primer vendedor
        $seller1 = User::query()->where('dni', '1005478123')->first(); //Kaled
        $organization = Organization::query()->where('nit', '1004731778')->first();
        $survey = Survey::query()->where('title', 'Surtimed - clientes')->first();

        foreach ($visits1 as $visit1) {
            $response = new Visit();
            $response->visitDate = $visit1['visitDate'];
            $response->status    = $visit1['status'];
            $response->seller()->associate($seller1);
            $response->organization()->associate($organization);
            $response->survey()->associate($survey);
            $response->save();
        }

        //Llenamos visitas del segundo vendedor
        $seller2 = User::query()->where('dni', '1005472347')->first(); //Jose Alvarez
        $organization = Organization::query()->where('nit', '1004731745')->first();
        $survey = Survey::query()->where('title', 'Surtimed - clientes')->first();

        foreach ($visits2 as $visit2) {
            $response = new Visit();
            $response->visitDate = $visit2['visitDate'];
            $response->status    = $visit2['status'];
            $response->seller()->associate($seller2);
            $response->organization()->associate($organization);
            $response->survey()->associate($survey);
            $response->save();
        }

        //Llenamos visitas del tercer vendedor
        $seller3 = User::query()->where('dni', '1005479536')->first(); //Ramiro Contreras
        $organization = Organization::query()->where('nit', '1004731734')->first();
        $survey = Survey::query()->where('title', 'Surtimed - clientes')->first();

        foreach ($visits3 as $visit3) {
            $response = new Visit();
            $response->visitDate = $visit3['visitDate'];
            $response->status    = $visit3['status'];
            $response->seller()->associate($seller3);
            $response->organization()->associate($organization);
            $response->survey()->associate($survey);
            $response->save();
        }
    }
}
