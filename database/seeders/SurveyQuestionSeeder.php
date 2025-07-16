<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\SurveyQuestion;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proposito = [
            'Vender / Promoción de productos / Documentos de crédito',
            'Recaudo de cartera / Acuerdos de Pago'
        ];

        $questions = [
            [
                'id' => 1,
                'type' => 'select',
                'question' => '¿Es nuevo el cliente?',
                'description' => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 2,
                'type' => 'select',
                'question' => 'Cliente',
                'description' => null,
                'options_source' => 'database',
                'options_model' => Organization::class,
                'options_label_column' => 'name',
                'data' => []
            ],
            [
                'id' => 3,
                'type' => 'select',
                'question' => 'Nombre de contacto',
                'description' => null,
                'options_source' => 'database',
                'options_model' => Member::class,
                'options_label_column' => 'first_name',
                'data' => []
            ],
            [
                'id' => 4,
                'type' => 'select',
                'question' => 'Cargo de contacto',
                'description' => null,
                'options_source' => 'database',
                'options_model' => MemberPosition::class,
                'options_label_column' => 'name',
                'data' => []
            ],
            [
                'id' => 5,
                'type' => 'select',
                'question' => 'Proposito',
                'description' => null,
                'data' => $proposito
            ],
            [
                'id' => 6,
                'type' => 'select',
                'question' => '¿Realizó venta?',
                'description' => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 7,
                'type' => 'select',
                'question' => '¿El cliente realizó pago?',
                'description' => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 8,
                'type' => 'select',
                'question' => '¿Se obtuvo un logro?',
                'description' => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 9,
                'type' => 'textarea',
                'question' => 'Breve descripción SI obtuvo algún logro',
                'description' => null,
                'data' => []
            ],
            [
                'id' => 10,
                'type' => 'textarea',
                'question' => 'Breve observación entorno a la visita',
                'description' => null,
                'data' => []
            ],
            [
                'id' => 11,
                'type' => 'textarea',
                'question' => 'Tarea y/o Pendiente',
                'description' => null,
                'is_task_trigger' => true,
                'data' => []
            ],
            [
                'id' => 12,
                'type' => 'time',
                'question' => 'Hora de Inicio',
                'description' => null,
                'data' => []
            ],
            [
                'id' => 13,
                'type' => 'time',
                'question' => 'Hora de Finalización',
                'description' => null,
                'data' => []
            ]
        ];

        $survey = Survey::first();

        foreach ($questions as $question) {
            SurveyQuestion::create([
                'type'                 => $question['type'],
                'question'             => $question['question'],
                'data'                 => $question['data'],
                'options_source'       => $question['options_source'] ?? 'static',
                'options_model'        => $question['options_model'] ?? null,
                'options_label_column' => $question['options_label_column'] ?? null,
                'is_task_trigger'      => $question['is_task_trigger'] ?? false,
                'survey_id'            => $survey->id
            ]);
        }

        SurveyQuestion::find([2, 3, 4])->each(function ($question) {
            $question->update([
                'parent_id' => 1,
                'triggering_answer' => 'No'
            ]);
        });

        SurveyQuestion::find(9)->update([
            'parent_id' => 8,
            'triggering_answer' => 'Si'
        ]);
    }
}
