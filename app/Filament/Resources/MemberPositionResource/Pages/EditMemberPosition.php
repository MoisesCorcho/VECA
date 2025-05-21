<?php

namespace App\Filament\Resources\MemberPositionResource\Pages;

use Filament\Actions;
use App\Helpers\FilamentHelpers;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MemberPositionResource;

class EditMemberPosition extends EditRecord
{
    protected static string $resource = MemberPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->preventDeletionWithRelated('members'),
        ];
    }
}
