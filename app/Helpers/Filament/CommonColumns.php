<?php

namespace App\Helpers\Filament;

use Filament\Tables\Columns\TextColumn;

class CommonColumns
{
    public static function cellphone(string $fieldName = 'cellphone'): TextColumn
    {
        return TextColumn::make($fieldName)
            ->label(__('Cellphone'))
            ->searchable()
            ->sortable()
            ->icon('heroicon-o-phone')
            ->copyable()
            ->copyMessage(__('Copied!'))
            ->copyMessageDuration(1500);
    }

    public static function email(string $fieldName = 'email'): TextColumn
    {
        return TextColumn::make($fieldName)
            ->label(__('Email'))
            ->searchable()
            ->sortable()
            ->icon('heroicon-o-envelope')
            ->copyable()
            ->copyMessage(__('Copied!'))
            ->copyMessageDuration(1500);
    }

    public static function dniType(string $fieldName = 'dni_type'): TextColumn
    {
        return TextColumn::make($fieldName)
            ->label(__('ID Type'))
            ->searchable()
            ->sortable()
            ->badge();
    }
}
