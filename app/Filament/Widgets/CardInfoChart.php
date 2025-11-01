<?php

namespace App\Filament\Widgets;

use App\Models\Card;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CardInfoChart extends ChartWidget
{
    protected ?string $heading = 'Card Info Chart';

    protected function getData(): array
    {
        $cards = Card::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $data = array_fill(0, 12, 0);

        foreach ($cards as $card) {
            $data[$card->month - 1] = $card->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cards Registered / Bought',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.5)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
