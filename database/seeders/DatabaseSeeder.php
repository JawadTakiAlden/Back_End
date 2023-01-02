<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ConsultationType;
use App\Models\Day;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // day seed
        Day::create([
            'name' => 'sunday',
        ]);

        Day::create([
            'name' => 'monday',
        ]);
        Day::create([
            'name' => 'tuesday',
        ]);
        Day::create([
            'name' => 'wednesday',
        ]);
        Day::create([
            'name' => 'thursday',
        ]);
        Day::create([
            'name' => 'friday',
        ]);
        Day::create([
            'name' => 'saturday',
        ]);
        ConsultationType::create([
            'name' => 'family'
        ]);
        ConsultationType::create([
            'name' => 'psychological'
        ]);
        ConsultationType::create([
            'name' => 'medical'
        ]);
        ConsultationType::create([
            'name' => 'vocational'
        ]);
        ConsultationType::create([
            'name' => 'business/management'
        ]);
        Role::create([
            'name' => 'user',
        ]);
        Role::create([
            'name' => 'expert',
        ]);
    }
}
