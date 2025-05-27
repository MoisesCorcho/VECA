<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberPositionResource\Pages;
use App\Filament\Resources\MemberPositionResource\RelationManagers;
use App\Models\MemberPosition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\Filament\CommonColumns;

class MemberPositionResource extends Resource
{
    protected static ?string $model = MemberPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): string
    {
        return __('Clients');
    }

    public static function getNavigationLabel(): string
    {
        return __('Member Positions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CommonColumns::baseTextColumn('name', 'Name'),
                CommonColumns::baseTextColumn('description', 'Description'),
                CommonColumns::createdAt()
                    ->label('Registered On'),
                CommonColumns::updatedAt()
                    ->label('Last Updated'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberPositions::route('/'),
            'create' => Pages\CreateMemberPosition::route('/create'),
            'edit' => Pages\EditMemberPosition::route('/{record}/edit'),
        ];
    }
}
