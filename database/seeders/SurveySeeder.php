<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\User;

class SurveySeeder extends Seeder
{
    public function run()
    {
        $surveys = [
            [
                'title'       => 'Surtimed - clientes',
                'description' => 'Encuesta a completar durante las visitas con clientes.',
                'status'      => 1,
            ],
        ];

        $owner  = User::where('dni', '1005478122')->first();

        foreach ($surveys as $survey) {

            Survey::create([
                'title'       => $survey['title'],
                'description' => $survey['description'],
                'status'      => $survey['status'],
                'user_id'    => $owner->id
            ]);
        }

        $sellers = User::role('Seller')->get();

        $survey  = Survey::first();

        foreach ($sellers as $seller) {
            $seller->survey_id = $survey->id;
            $seller->save();
        }

        User::role('Seller')->update(['survey_id' => $survey->id]);
    }
}
