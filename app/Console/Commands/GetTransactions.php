<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CardController;

class GetTransactions extends Command
{
    
    protected $signature = 'app:get-transactions';
    protected $description = 'Fetch transactions from the API';

    public function handle()
    {
        $controller = new CardController();
        $controller->get_transactions();
        $this->info('Transactions fetched at ' . now());
    }
}
