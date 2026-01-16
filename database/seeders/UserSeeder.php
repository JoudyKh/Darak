<?php

namespace Database\Seeders;

use App\Constants\Constants;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'phone' => '0900000000',
                'role_id' => Role::where('name', Constants::ROLES['admin'])->first()->id,
            ],
        ];
        User::insert($user);
    }
}
