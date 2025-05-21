<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\FilamentHelpers;
use Filament\Notifications\Notification;
use Filament\Actions\DeleteAction as PageDeleteAction;
use Filament\Tables\Actions\DeleteAction as TableDeleteAction;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $preventDeletionWithRelatedFn = function ($relation) {
            /** @var TableDeleteAction|PageDeleteAction $this */
            return $this->before(function ($record) use ($relation) {
                FilamentHelpers::preventDeletionIfHasRelated($record, $relation, function () {
                    /** @var TableDeleteAction|PageDeleteAction $this */
                    $this->halt();
                });
            });
        };

        TableDeleteAction::macro('preventDeletionWithRelated', $preventDeletionWithRelatedFn);

        PageDeleteAction::macro('preventDeletionWithRelated', $preventDeletionWithRelatedFn);
    }
}
