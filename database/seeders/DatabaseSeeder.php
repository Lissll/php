<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_ADMIN,
        ]);
        
        // Создаем менеджера
        User::create([
            'name' => 'Менеджер',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_MANAGER,
        ]);
        
        // Создаем мастера
        User::create([
            'name' => 'Мастер',
            'email' => 'master@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_MASTER,
        ]);
        
        // Создаем обычного пользователя
        User::create([
            'name' => 'Пользователь',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'role' => User::ROLE_CLIENT,
        ]);
        
        // Вызываем сидер для услуг
        $this->call(ServiceSeeder::class);
    }
}