<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criar usuário admin se não existir
        User::firstOrCreate(
            ['email' => 'admin@automarket.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'type' => 'business',
                'document' => '00.000.000/0001-00',
                'phone' => '(11) 99999-9999',
                'credits' => 1000,
                'email_verified_at' => now(),
            ]
        );

        // Criar usuários de teste individuais se não existirem
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => 'individual' . $i . '@email.com'],
                [
                    'name' => 'Usuário Individual ' . $i,
                    'password' => Hash::make('password'),
                    'type' => 'individual',
                    'document' => $this->generateCpf(),
                    'phone' => '(11) 98888-888' . $i,
                    'bio' => 'Vendedor particular de veículos usados',
                    'rating' => rand(30, 50) / 10,
                    'rating_count' => rand(5, 50),
                    'credits' => rand(0, 200),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Criar usuários de teste empresariais se não existirem
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => 'empresa' . $i . '@email.com'],
                [
                    'name' => 'Concessionária ' . $i,
                    'password' => Hash::make('password'),
                    'type' => 'business',
                    'document' => $this->generateCnpj(),
                    'phone' => '(11) 97777-777' . $i,
                    'bio' => 'Concessionária autorizada - Veículos novos e seminovos',
                    'rating' => rand(40, 50) / 10,
                    'rating_count' => rand(10, 100),
                    'credits' => rand(100, 500),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Criar planos
        $this->createPlans();

        // Criar veículos apenas se não existirem
        $this->createVehicles();
    }

    private function createPlans()
    {
        $plans = [
            [
                'name' => 'Plano Básico',
                'description' => 'Ideal para quem está começando',
                'price' => 49.90,
                'credits' => 100,
                'duration_days' => 30,
                'features' => json_encode([
                    'Anúncios básicos',
                    '5 fotos por anúncio',
                    'Suporte por email'
                ])
            ],
            [
                'name' => 'Plano Profissional',
                'description' => 'Para vendedores frequentes',
                'price' => 99.90,
                'credits' => 250,
                'duration_days' => 30,
                'features' => json_encode([
                    'Anúncios destacados',
                    '10 fotos por anúncio', 
                    'Suporte prioritário',
                    'Relatórios básicos'
                ])
            ],
            [
                'name' => 'Plano Empresarial',
                'description' => 'Para lojas e concessionárias',
                'price' => 199.90,
                'credits' => 600,
                'duration_days' => 30,
                'features' => json_encode([
                    'Anúncios em destaque',
                    'Fotos ilimitadas',
                    'Relatórios avançados',
                    'Suporte dedicado',
                    'API access'
                ])
            ]
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['name' => $planData['name']],
                $planData
            );
        }
    }

    private function createVehicles()
    {
        // Verificar se já existem veículos
        if (Vehicle::count() > 0) {
            return;
        }

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

        $descriptions = [
            "Excelente estado de conservação, único dono, toda revisão em dia na concessionária. Documentação toda regularizada, sem débitos. Carro muito econômico e bem cuidado.",
            "Veículo em perfeito estado, pintura original, interior impecável. Aceito troca por modelo similar ou valor menor. Financiamento facilitado através das melhores financeiras.",
            "Carro muito bem conservado, mecânica impecável, pneus novos. Único dono, todas as revisões feitas conforme manual do fabricante. Não aceito troca.",
            "Veículo seminovo, com pouquíssimo uso. Todas as revisões em dia, pneus com menos de 5000km. Documentação em dia, IPVA pago. Ótimo custo-benefício.",
            "Estado de novo, com garantia de fábrica ainda. Acessórios originais, completo. Melhor oferta leva. Financiamento através do banco de sua preferência."
        ];

        foreach ($users as $user) {
            $vehicleCount = rand(1, 5);
            
            for ($i = 0; $i < $vehicleCount; $i++) {
                $brand = $brands[array_rand($brands)];
                $model = $models[$brand][array_rand($models[$brand])];
                
                Vehicle::create([
                    'user_id' => $user->id,
                    'title' => "{$brand} {$model} " . rand(2015, 2023),
                    'description' => $descriptions[array_rand($descriptions)],
                    'brand' => $brand,
                    'model' => $model,
                    'year' => rand(2015, 2023),
                    'mileage' => rand(0, 100000),
                    'fuel_type' => $fuels[array_rand($fuels)],
                    'transmission' => $transmissions[array_rand($transmissions)],
                    'color' => $colors[array_rand($colors)],
                    'price' => rand(20000, 150000),
                    'state' => $states[array_rand($states)],
                    'city' => 'Cidade ' . ($i + 1),
                    'is_featured' => rand(0, 1),
                    'is_highlighted' => rand(0, 1),
                    'highlight_color' => rand(0, 1) ? ['red', 'blue', 'green', 'gold'][array_rand(['red', 'blue', 'green', 'gold'])] : null,
                    'is_active' => true,
                    'view_count' => rand(0, 500)
                ]);
            }
        }
    }

    private function generateCpf()
    {
        $n1 = rand(0, 9); $n2 = rand(0, 9); $n3 = rand(0, 9);
        $n4 = rand(0, 9); $n5 = rand(0, 9); $n6 = rand(0, 9);
        $n7 = rand(0, 9); $n8 = rand(0, 9); $n9 = rand(0, 9);
        
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) $d1 = 0;
        
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) $d2 = 0;
        
        return sprintf('%d%d%d.%d%d%d.%d%d%d-%d%d', $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $d1, $d2);
    }

    private function generateCnpj()
    {
        $n1 = rand(0, 9); $n2 = rand(0, 9); $n3 = rand(0, 9); $n4 = rand(0, 9);
        $n5 = rand(0, 9); $n6 = rand(0, 9); $n7 = rand(0, 9); $n8 = rand(0, 9);
        $n9 = 0; $n10 = 0; $n11 = 0; $n12 = 1;
        
        $d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) $d1 = 0;
        
        $d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) $d2 = 0;
        
        return sprintf('%d%d.%d%d%d.%d%d%d/%d%d%d%d-%d%d', $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10, $n11, $n12, $d1, $d2);
    }
}