<?php

namespace App\Filament\Widgets;

use App\Models\Card;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CardType extends ChartWidget
{
    protected ?string $heading = 'Card Type';

    protected function getData(): array
    {
        // Group cards by type (from bin) and month
        $data = Card::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('bin'),
            DB::raw('count(*) as total')
        )
            ->groupBy('month', 'bin')
            ->orderBy('month')
            ->get();

        // Define bins (card types)
        $bins = ['49387520', '537100', '428852', '517746']; // replace with your actual bin values

        // Prepare chart data for each type
        $datasets = [];
        foreach ($bins as $bin) {
            $datasets[] = [
                'label' => $bin,
                'data' => collect(range(1, 12))->map(
                    fn($m) =>
                    $data->firstWhere(fn($d) => $d->month == $m && $d->bin == $bin)->total ?? 0
                ),
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'fill' => false,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
