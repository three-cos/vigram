<?php

namespace App\Enums;

enum TransactionReason: string
{
    case STOCK = 'stock';

    case REFUND = 'refund';
}