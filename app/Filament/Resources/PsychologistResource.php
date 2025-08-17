<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PsychologistResource\Pages;
use App\Filament\Resources\PsychologistResource\RelationManagers;
use App\Models\Psychologist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PsychologistResource extends Resource
{
    protected static ?string $model = Psychologist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                      ->label('First Name')
                      ->placeholder('First Name')
                      ->required(),
                      
                    Forms\Components\TextInput::make('last_name')
                      ->label('Last Name')
                      ->placeholder('Last Name')
                      ->required(),
                      
                    Forms\Components\Select::make('locations')
                        ->multiple()
                        ->relationship('locations', 'location_name')
                        ->preload(),
                      
                    Forms\Components\Select::make('specializations')
                        ->multiple()
                        ->relationship('specializations', 'specialization_name')
                        ->preload()
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPsychologists::route('/'),
            'create' => Pages\CreatePsychologist::route('/create'),
            'edit' => Pages\EditPsychologist::route('/{record}/edit'),
        ];
    }
}
