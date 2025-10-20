<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->integer('mileage');
            $table->string('fuel_type'); // gasoline, ethanol, diesel, electric, hybrid
            $table->string('transmission'); // manual, automatic
            $table->string('color');
            $table->decimal('price', 10, 2);
            $table->string('state');
            $table->string('city');
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_highlighted')->default(false);
            $table->string('highlight_color')->nullable();
            $table->timestamp('featured_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            $table->index(['brand', 'model']);
            $table->index('price');
            $table->index('year');
            $table->index('state');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};