<?php

namespace App\Filament\Resources\Tags\Pages;

use App\Filament\Resources\Tags\TagsResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateTags extends CreateRecord
{
    protected static string $resource = TagsResource::class;

    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl('index');
    }
}
