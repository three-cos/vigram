<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                ->references('id')
                ->on('users');
            
            $table->foreignId('currency_id')
                ->references('id')
                ->on('currencies');

            $table->unique(['user_id', 'currency_id']);

            $table->bigInteger('balance')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};
