<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(fn($get) => $get('role') === UserRole::Admin->value)
                            ->maxLength(255)
                            ->placeholder('Enter user name')
                            ->visible(fn($get) => $get('role') === UserRole::Admin->value)
                            ->columnSpanFull(),


                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Enter user email')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->placeholder('Enter password'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirm new password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(false),

                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->live()
                            ->options([
                                UserRole::Admin->value => 'Admin',
                                UserRole::Psychologist->value => 'Psychologist',
                                UserRole::Patient->value => 'Patient'
                            ])
                            ->required()
                            ->searchable()
                            ->placeholder('Select user role')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if ($state == UserRole::Admin->value) return;
                                $set('name', '');
                            })
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_new_person')
                            ->live()
                            ->label('Create New Person')
                            ->visible(fn(string $context, $get): bool => $context === 'create' && $get('role') && $get('role') !== UserRole::Admin->value)
                            ->default(false)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('person')
                            ->relationship(
                                name: 'person',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn(Builder $query) => $query->where('type', 'App\Models\Patient')->whereNull('user_id')
                            )
                            ->label('Patient')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                            ->visible(fn($get) => $get('role') === UserRole::Patient->value && !$get('is_new_person'))
                            ->required(fn($get) => $get('role') === UserRole::Patient->value && !$get('is_new_person'))
                            ->disabled(fn(string $context): bool => $context !== 'create')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('person')
                            ->relationship(
                                name: 'person',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn(Builder $query) => $query->where('type', 'App\Models\Psychologist')->whereNull('user_id')
                            )
                            ->label('Psychologist')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                            ->visible(fn($get) => $get('role') === UserRole::Psychologist->value && !$get('is_new_person'))
                            ->required(fn($get) => $get('role') === UserRole::Psychologist->value && !$get('is_new_person'))
                            ->disabled(fn(string $context): bool => $context !== 'create')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Person Info Section (conditionally visible)
                Forms\Components\Section::make('Person Information')
                    ->schema([
                        Forms\Components\TextInput::make('person_first_name')
                            ->label('First Name')
                            ->maxLength(255)
                            ->required(),

                        Forms\Components\TextInput::make('person_last_name')
                            ->label('Last Name')
                            ->maxLength(255)
                            ->required(),

                        Forms\Components\DatePicker::make('person_dob')
                            ->label('Date of Birth')
                            ->format('Y-m-d H:i:s')
                            ->displayFormat('d M Y')
                            ->timezone('Asia/Jakarta')
                            ->native(false)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn($get) => $get('role') !== UserRole::Admin->value && $get('role') && $get('is_new_person')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(UserRole $state): string => match ($state) {
                        UserRole::Admin => 'danger',
                        UserRole::Psychologist => 'warning',
                        UserRole::Patient => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        UserRole::Admin->value => 'Admin',
                        UserRole::Psychologist->value => 'Psychologist',
                        UserRole::Patient->value => 'Patient'
                    ])
                    ->label('Filter by Role'),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->placeholder('All users')
                    ->trueLabel('Verified users')
                    ->falseLabel('Unverified users'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
