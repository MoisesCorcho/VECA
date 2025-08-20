<?php

namespace App\Filament\Widgets;

use App\Models\SurveyAnswer;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?string $heading = 'Actividad Reciente';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SurveyAnswer::with(['user', 'survey'])
                    ->orderBy('created_at', 'desc')
                    ->limit(15)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('survey.title')
                    ->label(__('Survey'))
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.roles.name')
                    ->label(__('Role'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Admin' => 'danger',
                        'Seller' => 'success',
                        'Manager' => 'warning',
                        default => 'primary',
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
