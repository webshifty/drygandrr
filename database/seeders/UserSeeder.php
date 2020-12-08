<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('secret'),
            'access' => User::ACCESS_SUPER_ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@mail.com',
            'password' => Hash::make('secret'),
            'access' => User::ACCESS_OPERATOR,
        ]);
    }
}
