<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('wallet_id')
                ->references('id')
                ->on('wallets')
                ->cascadeOnDelete();
            
            $table->foreignId('currency_id')
                ->references('id')
                ->on('currencies');

            $table->string('type');
            
            $table->string('reason');

            $table->unsignedBigInteger('amount');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
