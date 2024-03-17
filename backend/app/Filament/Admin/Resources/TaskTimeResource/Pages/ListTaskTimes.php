<?php

namespace App\Filament\Admin\Resources\TaskTimeResource\Pages;

use App\Filament\Admin\Resources\TaskTimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskTimes extends ListRecords
{
    protected static string $resource = TaskTimeResource::class;

    protected static ?string $title = 'Время';
}
