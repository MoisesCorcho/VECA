<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Enums\SurveyQuestionsTypeEnum;
use App\Filament\Pages\SurveyResponse;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SurveyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveyResource\RelationManagers;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationLabel(): string
    {
        return __('Surveys');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('description'),
                        Toggle::make('status')
                            ->required(),
                    ]),

                Section::make()
                    ->schema([
                        Repeater::make('questions')
                            ->relationship()
                            ->schema([
                                Select::make('type')
                                    ->live()
                                    ->options(SurveyQuestionsTypeEnum::keyValuesCombined())
                                    ->required(),
                                TextInput::make('question')
                                    ->required(),
                                TextInput::make('description')
                                    ->columnSpanFull(),
                                Section::make()
                                    ->schema([
                                        Repeater::make('data')
                                            ->label('')
                                            ->simple(
                                                TextInput::make('option')
                                                    ->required(),
                                            )
                                            ->addActionLabel('Add Option')
                                            ->reorderable(true)
                                            ->reorderableWithButtons(),
                                    ])
                                    ->visible(fn(Get $get): bool => !in_array($get('type'), SurveyQuestionsTypeEnum::nonOptionsTypes()) && !empty($get('type')))
                            ])
                            ->addActionLabel('Add Question')
                            ->cloneable()
                            ->reorderable(true)
                            ->reorderableWithButtons()
                            ->columns(2)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                ToggleColumn::make('status'),
                TextColumn::make('questions_count')
                    ->sortable()
                    ->counts('questions')
                    ->label('N. questions'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('response')
                    ->icon('heroicon-m-x-mark')
                    ->color('warning')
                    ->action(function (Survey $record) {
                        return redirect()->to(SurveyResponse::getUrlWithSurvey($record));
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
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
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }
}
