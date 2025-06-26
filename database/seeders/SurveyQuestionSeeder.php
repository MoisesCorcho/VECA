<?php

namespace Database\Seeders;

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
                "tableType" => "newclient",
                'data' => ['Si', 'No']
            ],
            [
                'id' => 2,
                'type' => 'select',
                'question' => 'Cliente',
                'description' => null,
                "tableType" => "organization",
                'data' => []
            ],
            [
                'id' => 3,
                'type' => 'select',
                'question' => 'Nombre de contacto',
                'description' => null,
                "tableType" => "member",
                'data' => []
            ],
            [
                'id' => 4,
                'type' => 'select',
                'question' => 'Cargo de contacto',
                'description' => null,
                "tableType" => "memberPosition",
                'data' => []
            ],
            [
                'id' => 5,
                'type' => 'select',
                'question' => 'Proposito',
                'description' => null,
                "tableType" => null,
                'data' => $proposito
            ],
            [
                'id' => 6,
                'type' => 'select',
                'question' => '¿Realizó venta?',
                'description' => null,
                "tableType" => null,
                'data' => []
            ],
            [
                'id' => 7,
                'type' => 'select',
                'question' => '¿El cliente realizó pago?',
                'description' => null,
                "tableType" => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 8,
                'type' => 'select',
                'question' => '¿Se obtuvo un logro?',
                'description' => null,
                "tableType" => null,
                'data' => ['Si', 'No']
            ],
            [
                'id' => 9,
                'type' => 'text',
                'question' => 'Breve descripción SI obtuvo algún logro',
                'description' => null,
                "tableType" => null,
                'data' => []
            ],
            [
                'id' => 10,
                'type' => 'text',
                'question' => 'Breve observación entorno a la visita',
                'description' => null,
                "tableType" => null,
                'data' => []
            ],
            [
                'id' => 11,
                'type' => 'text',
                'question' => 'Tarea y/o Pendiente',
                'description' => null,
                "tableType" => null,
                'data' => []
            ],
            [
                'id' => 12,
                'type' => 'date',
                'question' => 'Hora de Inicio',
                'description' => null,
                "tableType" => "HoraDeInicio",
                'data' => []
            ],
            [
                'id' => 13,
                'type' => 'date',
                'question' => 'Hora de Finalización',
                'description' => null,
                "tableType" => "HoraDeFin",
                'data' => []
            ]
        ];

        $survey = Survey::first();

        foreach ($questions as $question) {
            SurveyQuestion::create([
                'type'                 => $question['type'],
                'question'             => $question['question'],
                'data'                 => $question['data'],
                'survey_id'            => $survey->id
            ]);
        }
    }
}
