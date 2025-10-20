<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Faker\Factory;

class VehicleSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function run()
    {
        $users = User::where('id', '>', 1)->get(); // Exclui o admin
        $brands = ['Volkswagen', 'Fiat', 'Ford', 'Chevrolet', 'Toyota', 'Honda', 'Hyundai', 'Renault'];
        $models = [
            'Volkswagen' => ['Gol', 'Polo', 'Virtus', 'T-Cross', 'Nivus'],
            'Fiat' => ['Argo', 'Mobi', 'Cronos', 'Toro', 'Strada'],
            'Ford' => ['Ka', 'Fiesta', 'Focus', 'EcoSport', 'Ranger'],
            'Chevrolet' => ['Onix', 'Prisma', 'Cruze', 'Tracker', 'S10'],
            'Toyota' => ['Corolla', 'Yaris', 'Hilux', 'SW4', 'Etios'],
            'Honda' => ['Civic', 'Fit', 'HR-V', 'WR-V', 'City'],
            'Hyundai' => ['HB20', 'Creta', 'Tucson', 'Santa Fe', 'Azera'],
            'Renault' => ['Kwid', 'Sandero', 'Logan', 'Duster', 'Captur']
        ];
        $fuels = ['gasoline', 'ethanol', 'diesel', 'electric', 'hybrid'];
        $transmissions = ['manual', 'automatic'];
        $states = ['SP', 'RJ', 'MG', 'RS', 'PR', 'SC', 'BA', 'DF'];
        $colors = ['Preto', 'Branco', 'Prata', 'Cinza', 'Vermelho', 'Azul', 'Verde', 'Marrom'];

        foreach ($users as $user) {
            $vehicleCount = rand(1, 5);
            
            for ($i = 0; $i < $vehicleCount; $i++) {
                $brand = $brands[array_rand($brands)];
                $model = $models[$brand][array_rand($models[$brand])];
                
                Vehicle::create([
                    'user_id' => $user->id,
                    'title' => "{$brand} {$model} " . rand(2015, 2023),
                    'description' => $this->generateDescription($brand, $model),
                    'brand' => $brand,
                    'model' => $model,
                    'year' => rand(2015, 2023),
                    'mileage' => rand(0, 100000),
                    'fuel_type' => $fuels[array_rand($fuels)],
                    'transmission' => $transmissions[array_rand($transmissions)],
                    'color' => $colors[array_rand($colors)],
                    'price' => rand(20000, 150000),
                    'state' => $states[array_rand($states)],
                    'city' => $this->faker->city(),
                    'is_featured' => rand(0, 1),
                    'is_highlighted' => rand(0, 1),
                    'highlight_color' => rand(0, 1) ? ['red', 'blue', 'green', 'gold'][array_rand(['red', 'blue', 'green', 'gold'])] : null,
                    'is_active' => true,
                    'view_count' => rand(0, 500)
                ]);
            }
        }
    }

    private function generateDescription($brand, $model)
    {
        $descriptions = [
            "Excelente estado de conservação, único dono, toda revisão em dia na concessionária. Documentação toda regularizada, sem débitos. Carro muito econômico e bem cuidado.",
            "Veículo em perfeito estado, pintura original, interior impecável. Aceito troca por modelo similar ou valor menor. Financiamento facilitado através das melhores financeiras.",
            "Carro muito bem conservado, mecânica impecável, pneus novos. Único dono, todas as revisões feitas conforme manual do fabricante. Não aceito troca.",
            "Veículo seminovo, com pouquíssimo uso. Todas as revisões em dia, pneus com menos de 5000km. Documentação em dia, IPVA pago. Ótimo custo-benefício.",
            "Estado de novo, com garantia de fábrica ainda. Acessórios originais, completo. Melhor oferta leva. Financiamento através do banco de sua preferência."
        ];

        return $descriptions[array_rand($descriptions)];
    }
}