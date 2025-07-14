<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visit;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('password'),
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(NoVisitReasonSeeder::class);
        $this->call(MemberPositionSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(SurveySeeder::class);
        $this->call(SurveyQuestionSeeder::class);
        $this->call(VisitSeeder::class);
        $this->call(SurveyQuestionAnswerSeeder::class);
    }
}
