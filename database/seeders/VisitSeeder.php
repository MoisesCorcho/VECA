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

            if (!$user) {
                $this->command->info("User with DNI {$item['dni']} not found. Skipping visits for this user.\n");
                continue;
            }

            $userOrganizations = $user->organizations;

            if ($userOrganizations->isEmpty()) {
                $this->command->info("User with DNI {$item['dni']} has no organizations. Skipping visits for this user.\n");
                continue;
            }

            for ($i = 0; $i < 20; $i++) {
                $randomOrganization = fake()->randomElement($userOrganizations);

                Visit::factory()
                    ->visited()
                    ->for($user)
                    ->for($randomOrganization)
                    ->create();

                Visit::factory()
                    ->scheduled()
                    ->for($user)
                    ->for($randomOrganization)
                    ->create();
            }
        }
    }
}
