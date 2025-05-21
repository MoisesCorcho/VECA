<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Helpers\FilamentHelpers;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    FilamentHelpers::preventDeletionIfHasRelated(
                        $record,
                        'members',
                        fn() => $this->halt()
                    );
                }),
        ];
    }
}
