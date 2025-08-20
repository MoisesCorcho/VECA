<?php

namespace App\Filament\Widgets;

use App\Models\SurveyAnswer;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SellerResponsesChart extends ChartWidget
{
    protected static ?string $heading = 'Answers by Seller (Top 10)';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $sellerResponses = SurveyAnswer::select('user_id', DB::raw('count(*) as responses_count'))
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Seller');
                });
            })
            ->with('user:id,name')
            ->groupBy('user_id')
            ->orderBy('responses_count', 'desc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Answers'),
                    'data' => $sellerResponses->pluck('responses_count')->toArray(),
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $sellerResponses->pluck('user.name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'indexAxis' => 'y',
        ];
    }
}
