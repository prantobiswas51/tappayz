<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (or create one if none exists)
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create([
            'email' => 'demo@tappayz.com',
            'name' => 'Demo User',
        ]);

        // Create some demo cards for the user
        \App\Models\Card::factory()->active()->count(3)->create(['user_id' => $user->id]);
        \App\Models\Card::factory()->frozen()->count(1)->create(['user_id' => $user->id]);
        \App\Models\Card::factory()->terminated()->count(2)->create(['user_id' => $user->id]);
    }
}
