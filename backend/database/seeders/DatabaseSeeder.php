<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CurrencySeeder::class,
        ]);
        
        if (app('env') !== 'production') {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $user->wallet()->create([
                'currency_id' => 1,
            ]);
        }
    }
}
