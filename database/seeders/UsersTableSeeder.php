<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password'),
        ]);
        $admin->assignRole(1);

        $hr = User::create([
            'first_name' => 'HR',
            'last_name' => 'User',
            'email' => 'hr@example.com',
            'password' => bcrypt('Password'),
        ]);
        $hr->assignRole(2);
    }
}
