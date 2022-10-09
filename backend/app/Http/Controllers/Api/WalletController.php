<?php

namespace App\Http\Controllers\Api;

use App\Dtos\Factories\TransactionDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\Wallet\WalletBalanceHandler;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function __construct(private WalletBalanceHandler $walletBalanceHandler)
    {
    }

    public function store(TransactionRequest $request): JsonResponse
    {
        $dto = TransactionDtoFactory::fromRequest($request);

        $this->walletBalanceHandler->handle($dto);

        return response()->json([
            'status' => 'ok',
            'balance' => $dto->getWallet()->fresh()->getBalanceAmount()->getAmount(),
        ]);
    }
}
