<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingTransactions extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        $users = \App\Models\User::count();
        $totalCards = \App\Models\Card::count();
        $PendingTransactions = \App\Models\Transaction::where('status', 'pending')->count();
        $pendingDeposits = \App\Models\Deposit::where('status', 'pending')->count();
        $pendingKyc = \App\Models\Kyc::where('status', 'pending')->count();
        $currentBins = \App\Models\Bin::count();
        $totalDeposits = \App\Models\Deposit::where('status', 'approved')->orWhere('status', 'SUCCESS')->sum('amount');
        $manualDeposits = \App\Models\Deposit::where('type', 'Manual')->where('status', 'approved')->sum('amount');
        $autoDeposits = \App\Models\Deposit::where('type', 'Auto')->orWhere('status', 'SUCCESS')->sum('amount');
        $pendingCards = \App\Models\Card::where('state', 4)->count();

        return [
            Stat::make('Total Cards', $totalCards),
            Stat::make('Pending Transactions', $PendingTransactions),
            Stat::make('Pending Deposits', $pendingDeposits),
            Stat::make('Pending KYC', $pendingKyc),
            Stat::make('Total Deposits', '$ ' . number_format($totalDeposits, 2)),
            Stat::make('Manual Deposits', '$ ' . number_format($manualDeposits, 2)),
            Stat::make('Auto Deposits', '$ ' . number_format($autoDeposits, 2)),
            Stat::make('Pending Cards', $pendingCards),
            Stat::make('Current Bins', $currentBins),
            Stat::make('Total Users', $users),

        ];
    }
}
