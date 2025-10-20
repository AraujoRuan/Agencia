<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('type'); // credit_purchase, featured_ad, highlighted_ad
            $table->decimal('amount', 10, 2);
            $table->integer('credits');
            $table->string('payment_method'); // pix, credit_card, boleto
            $table->string('status'); // pending, completed, failed, cancelled
            $table->string('payment_id')->nullable(); // ID do gateway de pagamento
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};