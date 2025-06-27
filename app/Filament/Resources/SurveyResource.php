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
use App\Models\SurveyQuestion;
use Filament\Forms\Set;
use Illuminate\Support\Str;

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
                            ->required()
                            ->default(true),
                    ]),

                Section::make()
                    ->schema([
                        Repeater::make('questions')
                            ->relationship()
                            ->schema([
                                Select::make('type')
                                    ->live()
                                    ->options(SurveyQuestionsTypeEnum::keyValuesCombined())
                                    ->required()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        // If the type is not a type without options (text, textarea, date) and the data is empty, set the data to an empty array with a single option
                                        // This is to prevent the user from creating a question without any options
                                        if (!in_array($get('type'), SurveyQuestionsTypeEnum::nonOptionsTypes() ?? []) && !$get('data')) {
                                            $set('data', [(string) Str::uuid() => ['option' => '']]);
                                        }
                                    }),
                                TextInput::make('question')
                                    ->required(),
                                TextInput::make('description')
                                    ->columnSpanFull(),
                                Select::make('parent_id')
                                    ->label(__('Parent question'))
                                    ->live()
                                    ->options(fn($record) => $record?->survey->questions->where('type', 'select')->where('question', '!=', $record->question)->pluck('question', 'id'))
                                    ->visible(fn($record) => $record)
                                    ->disabled(function (Get $get, $state, $context, $record) {
                                        return collect($get('../../questions'))
                                            ->contains('parent_id', $record?->id);
                                    })
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('triggering_answer', null);
                                    })
                                    ->nullable(),
                                Select::make('triggering_answer')
                                    ->label(__('Triggering answer'))
                                    ->visible(fn(Get $get, $record): bool => filled($get('parent_id')) && $record)
                                    ->options(function (Get $get) {
                                        return collect(SurveyQuestion::find($get('parent_id'))?->data)
                                            ->mapWithKeys(function ($item) {
                                                return [$item => $item];
                                            });
                                    })
                                    ->required(),
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
                                            ->reorderableWithButtons()
                                            ->deletable(fn(Get $get) => collect($get('data'))->count() > 1)
                                            ->defaultItems(1),
                                    ])
                                    ->visible(fn(Get $get): bool => !in_array($get('type'), SurveyQuestionsTypeEnum::nonOptionsTypes()) && !empty($get('type')))
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                if (in_array($data['type'], SurveyQuestionsTypeEnum::nonOptionsTypes() ?? [])) {
                                    $data['data'] = null;
                                }

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                // If the question type is not an option type, then we set the data to null.
                                // $data['triggering_answer'] = $data['parent_id'] ?? null;
                                if (empty($data['parent_id'])) {
                                    $data['triggering_answer'] = null;
                                }

                                // If the question type is not an option type, then we set the data to null.
                                if (in_array($data['type'], SurveyQuestionsTypeEnum::nonOptionsTypes() ?? [])) {
                                    $data['data'] = null;
                                }

                                return $data;
                            })
                            ->addActionLabel('Add Question')
                            ->cloneable()
                            ->reorderable(false)
                            ->reorderableWithButtons(false)
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
                    ->icon('heroicon-m-newspaper')
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
