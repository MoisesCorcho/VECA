<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $users = [
            [
                'firstName' => 'Jorge David', //SuperAdmin
                'lastName'  => 'Galvis Tamara',
                'photo'     =>  null,
                'cellphone' => '3225687425',
                'email'     => 'jorge@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478121',
                'password'  =>  Hash::make('password'),
                'surveyId'  =>  null,
                'visits_per_day' => null
            ],
            [
                'firstName' => 'Francisco Manuel', //Admin
                'lastName'  => 'Macea Arrieta',
                'photo'     =>  null,
                'cellphone' => '3225687426',
                'email'     => 'francisco@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478122',
                'password'  =>  Hash::make('password'),
                'surveyId'  =>  null,
                'visits_per_day' => null
            ],
            [
                'firstName' => 'Maira',
                'lastName'  => 'Gómez',
                'photo'     =>  null,
                'cellphone' => '3225687425',
                'email'     => 'maira@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478123',
                'password'  =>  Hash::make('password'),
                'surveyId'  =>  null,
                'visits_per_day' => 8
            ],
            [
                'firstName' => 'Hector',
                'lastName'  => 'Corcho',
                'photo'     =>  null,
                'cellphone' => '3181548725',
                'email'     => 'hector@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005472347',
                'password'  =>  Hash::make('password'),
                'surveyId'  =>  null,
                'visits_per_day' => 8
            ],
            [
                'firstName' => 'Verónica',
                'lastName'  => 'Cordero',
                'photo'     =>  null,
                'cellphone' => '3186512431',
                'email'     => 'veronica@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005479536',
                'password'  =>  Hash::make('password'),
                'surveyId'  =>  null,
                'visits_per_day' => 8
            ],

        ];

        foreach ($users as $user) {
            if (!User::query()->where('dni', $user['dni'])->first()) {
                $response = new User();
                $response->name = $user['firstName'];
                $response->last_name  = $user['lastName'];
                $response->cellphone = $user['cellphone'];
                $response->email     = $user['email'];
                $response->dni_type   = $user['dniType'];
                $response->dni       = $user['dni'];
                $response->password  = $user['password'];
                $response->survey_id  = $user['surveyId'];
                $response->visits_per_day = $user['visits_per_day'];
                $response->save();
            }
        }

        User::query()
            ->where('email', 'like', '%hector%')
            ->orWhere('email', 'like', '%maira%')
            ->orWhere('email', 'like', '%veronica%')
            ->get()
            ->each(function ($user) {
                $user->assignRole('Seller');
            });
    }
}
