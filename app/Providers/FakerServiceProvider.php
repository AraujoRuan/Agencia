<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create('pt_BR');
            $faker->addProvider(new \App\Faker\CustomProvider($faker));
            return $faker;
        });
    }
}