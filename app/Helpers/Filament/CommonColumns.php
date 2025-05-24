<?php

namespace App\Helpers\Filament;

use Filament\Tables\Columns\TextColumn;

/**
 * This class provides common column definitions used in Filament tables.
 * facilitating reuse and consistency across different parts of the application.
 */
class CommonColumns
{
    /**
     * Creates a base text column with the given field name and label.
     *
     * This column is searchable, sortable and toggleable.
     *
     * @param string $fieldName  The name of the field.
     * @param string $label      The label for the column.
     * @return TextColumn
     */
    public static function baseTextColumn(string $fieldName, string $label): TextColumn
    {
        return TextColumn::make($fieldName)
            ->label(__($label))
            ->searchable()
            ->sortable()
            ->toggleable();
    }

    /**
     * Creates a base text column with an icon and copyable functionality.
     *
     * @param string $fieldName  The name of the field.
     * @param string $label      The label for the column.
     * @param string $iconName   The name of the icon to display.
     * @param string $copyMessage The message displayed upon copying.
     * @return TextColumn
     */
    public static function baseIconCopyableTextColumn(
        string $fieldName,
        string $label,
        string $iconName,
        string $copyMessage = 'Copied!'
    ): TextColumn {
        return static::baseTextColumn($fieldName, $label)
            ->icon($iconName)
            ->copyable()
            ->copyMessage(__($copyMessage))
            ->copyMessageDuration(1500);
    }

    public static function createdAt(): TextColumn
    {
        return static::baseTextColumn('created_at', 'Created At')
            ->date('Y-m-d')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function updatedAt(): TextColumn
    {
        return static::baseTextColumn('updated_at', 'Updated At')
            ->since()
            ->dateTimeTooltip()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
