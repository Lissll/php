<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Стрижка женская',
                'description' => 'Стрижка любой сложности с укладкой',
                'duration' => 60,
                'price' => 1500.00,
            ],
            [
                'name' => 'Стрижка мужская',
                'description' => 'Классическая мужская стрижка',
                'duration' => 30,
                'price' => 800.00,
            ],
            [
                'name' => 'Окрашивание волос',
                'description' => 'Окрашивание любой сложности',
                'duration' => 120,
                'price' => 3500.00,
            ],
            [
                'name' => 'Маникюр',
                'description' => 'Классический или аппаратный маникюр',
                'duration' => 60,
                'price' => 1200.00,
            ],
            [
                'name' => 'Педикюр',
                'description' => 'Комплексный педикюр',
                'duration' => 90,
                'price' => 1800.00,
            ],
            [
                'name' => 'Укладка волос',
                'description' => 'Вечерняя или повседневная укладка',
                'duration' => 45,
                'price' => 1000.00,
            ],
        ];
        
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}