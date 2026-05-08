<?php

namespace App\Filament\Resources\Assignments;

use App\Filament\Resources\Assignments\Pages\CreateAssignment;
use App\Filament\Resources\Assignments\Pages\EditAssignment;
use App\Filament\Resources\Assignments\Pages\ListAssignments;
use App\Models\Assignment;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->label('Subject'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Assignment Title'),

                Textarea::make('details')
                    ->required()
                    ->columnSpanFull()
                    ->label('Details / Instructions'),

                Select::make('status')
                    ->options([
                        'To Do' => 'To Do',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                    ])
                    ->default('To Do')
                    ->required()
                    ->label('Status'),

                DatePicker::make('due_date')
                    ->required()
                    ->label('Due Date')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'To Do' => 'gray',
                        'In Progress' => 'warning',
                        'Completed' => 'success',
                    })
                    ->sortable(),

                TextColumn::make('due_date')
                    ->date()
                    ->sortable()
                    ->label('Due Date'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'To Do' => 'To Do',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                    ])
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListAssignments::route('/'),
            'create' => CreateAssignment::route('/create'),
            'edit' => EditAssignment::route('/{record}/edit'),
        ];
    }
}