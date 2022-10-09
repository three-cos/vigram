<?php

use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

Route::post('/wallet/transaction', [WalletController::class, 'store'])->name('wallet.transaction');
Route::post('/user/wallet/', [WalletController::class, 'show'])->name('wallet.show');