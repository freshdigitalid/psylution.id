<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->role == UserRole::Psychologist;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('patient_full_name')
                    ->label('Patient')
                    ->disabled()
                    ->formatStateUsing(fn($record) => $record?->patient->first_name . ' ' . $record?->patient->last_name)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('psychologist_full_name')
                    ->label('Psychologist')
                    ->disabled()
                    ->formatStateUsing(fn($record) => $record?->psychologist->first_name . ' ' . $record?->psychologist->last_name)
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('start_time')
                    ->format('Y-m-d H:i:s')
                    ->timezone('Asia/Jakarta')
                    ->disabled(),

                Forms\Components\DateTimePicker::make('end_time')
                    ->format('Y-m-d H:i:s')
                    ->timezone('Asia/Jakarta')
                    ->disabled(),

                Forms\Components\Toggle::make('is_online')
                    ->label('Is Online')
                    ->disabled()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('complaints')
                    ->disabled()
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options(function (?Appointment $record) {
                        if (! $record) {
                            return []; // no options when creating
                        }

                        $options = [];

                        // pending → can go to approved / rejected
                        if ($record->status === \App\Enums\AppointmentStatus::Pending) {
                            $options[\App\Enums\AppointmentStatus::Approved->value] = 'Approved';
                            $options[\App\Enums\AppointmentStatus::Rejected->value] = 'Rejected';
                        }

                        // when now > end_time → can go to completed
                        if (now()->greaterThan($record->end_time)) {
                            $options[\App\Enums\AppointmentStatus::Completed->value] = 'Completed';
                        }

                        return $options;
                    })
                    ->required()
                    ->disabled(Auth::user()->role == UserRole::Patient)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->role == UserRole::Admin) {
                    return $query;
                }

                $col_to_filter = $user->role == UserRole::Psychologist ? 'psychologist_id' : 'patient_id';
                return $query->where($col_to_filter, $user->person->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('psychologist.full_name')
                    ->label('Psychologist')
                    ->searchable(),

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime('d M Y H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime('d M Y H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        // Support both enum-cast and raw string values
                        $value = $state instanceof AppointmentStatus ? $state->value : $state;

                        return match ($value) {
                            'pending'   => 'Pending',
                            'approved'  => 'Approved',
                            'rejected'  => 'Rejected',
                            'completed' => 'Completed',
                            default     => (string) $value,
                        };
                    })
                    ->color(fn (AppointmentStatus $state): string => match ($state) {
                        AppointmentStatus::Pending => 'warning',
                        AppointmentStatus::Approved => 'success',
                        AppointmentStatus::Rejected => 'danger',
                        AppointmentStatus::Completed => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        \App\Enums\AppointmentStatus::Pending->value   => 'Pending',
                        \App\Enums\AppointmentStatus::Approved->value  => 'Approved',
                        \App\Enums\AppointmentStatus::Rejected->value  => 'Rejected',
                        \App\Enums\AppointmentStatus::Completed->value => 'Completed',
                    ]),

                Tables\Filters\SelectFilter::make('psychologist_id')
                    ->label('Psychologist')
                    ->relationship('psychologist', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name),

                Tables\Filters\SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
