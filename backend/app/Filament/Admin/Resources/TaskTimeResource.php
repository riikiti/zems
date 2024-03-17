<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskTimeResource\Pages;
use App\Filament\Admin\Resources\TaskTimeResource\RelationManagers;
use App\Models\TaskTime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskTimeResource extends Resource
{
    protected static ?string $model = TaskTime::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Время';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id')->searchable(),
                TextColumn::make('task.name')->label('Задача')->searchable(),
                TextColumn::make('time_start')->label('Начало'),
                TextColumn::make('time_finish')->label('Конец'),
                TextColumn::make('time')->label('Время'),
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
            'index' => Pages\ListTaskTimes::route('/'),
        ];
    }
}
