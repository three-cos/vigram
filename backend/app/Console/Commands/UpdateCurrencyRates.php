<?php

namespace App\Console\Commands;

use App\Contracts\CurrencyUpdater;
use App\Models\Currency;
use Illuminate\Console\Command;
use Throwable;

class UpdateCurrencyRates extends Command
{
    protected $signature = 'currency:update';

    protected $description = 'Get latests currencies rates';

    public function handle(CurrencyUpdater $updater): int
    {
        Currency::query()
            ->where('code', '!=', 'RUB')
            ->each(function (Currency $currency) use ($updater) {
                try {
                    $updater->update($currency);

                    $this->line("Update cost for {$currency->code}");
                } catch (Throwable $th) {
                    $this->error("Cannot update cost for {$currency->code}");
                }
            });

        return Command::SUCCESS;
    }
}
