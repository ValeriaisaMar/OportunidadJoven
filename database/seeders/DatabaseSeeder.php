<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $this->call([
            EmpleoSeeder::class,        // borra las ofertas de ejemplo que hubiera
            EmpleosRealesSeeder::class,
            PasantiaSeeder::class,
            CursoSeeder::class,
            ForoSeeder::class,
        ]);
    }
}
