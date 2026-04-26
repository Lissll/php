<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_ADMIN,
        ]);
        
        User::create([
            'name' => 'Менеджер',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_MANAGER,
        ]);
        
        User::create([
            'name' => 'Мастер',
            'email' => 'master@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_MASTER,
        ]);
        
        User::create([
            'name' => 'Пользователь',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_CLIENT,
        ]);
        
        $this->call(ServiceSeeder::class);
    }
}