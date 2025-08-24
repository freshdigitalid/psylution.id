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
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Mokhosh\FilamentRating\Components\Rating;

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
        if (Auth::user()->role === UserRole::Patient && $record->status == AppointmentStatus::Completed) {
            return true;
        }

        return Auth::user()->role == UserRole::Psychologist;
    }

    public static function canView(Model $record): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Appointment Information')
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
                            ->live()
                            ->label('Is Online')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('complaints')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status')
                            ->live()
                            ->options(function (?Appointment $record) {
                                $options = [];

                                // pending → can go to approved / rejected
                                if ($record->status === AppointmentStatus::Pending) {
                                    $options[AppointmentStatus::Approved->value] = 'Approved';
                                    $options[AppointmentStatus::Rejected->value] = 'Rejected';
                                }

                                // when now > end_time → can go to completed
                                if (now()->greaterThanOrEqualTo($record->end_time)) {
                                    $options[AppointmentStatus::Completed->value] = 'Completed';
                                }

                                switch ($record->status) {
                                    case AppointmentStatus::Pending:
                                        $options[AppointmentStatus::Pending->value] = 'Pending';
                                        break;

                                    case AppointmentStatus::Approved:
                                        $options[AppointmentStatus::Approved->value] = 'Approved';
                                        break;

                                    case AppointmentStatus::Rejected:
                                        $options[AppointmentStatus::Rejected->value] = 'Rejected';
                                        break;

                                    case AppointmentStatus::Completed:
                                        $options[AppointmentStatus::Completed->value] = 'Completed';
                                        break;
                                }

                                return $options;
                            })
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('meet_url')
                            ->label('Meet Url')
                            ->url()
                            ->visible(fn($get) => $get('status') == AppointmentStatus::Approved->value && $get('is_online'))
                            ->required(fn($get) => $get('status') == AppointmentStatus::Approved->value && $get('is_online'))
                            ->columnSpanFull(),
                    ])
                    ->disabled(Auth::user()->role !== UserRole::Psychologist),

                // Person Info Section (conditionally visible)
                Forms\Components\Section::make('Appointment Review')
                    ->schema([
                        Rating::make('score')
                            ->label('Score')
                            ->required(Auth::user()->role == UserRole::Patient),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notes'),
                    ])
                    ->columns(1)
                    ->disabled(Auth::user()->role !== UserRole::Patient)
                    ->visible(fn($get) => $get('status') == AppointmentStatus::Completed->value),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->role == UserRole::Admin) {
                    return $query->with('review');
                }

                $col_to_filter = $user->role == UserRole::Psychologist ? 'psychologist_id' : 'patient_id';
                return $query->with('review')->where($col_to_filter, $user->person->id);
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
                    ->color(fn(AppointmentStatus $state): string => match ($state) {
                        AppointmentStatus::Pending => 'warning',
                        AppointmentStatus::Approved => 'success',
                        AppointmentStatus::Rejected => 'danger',
                        AppointmentStatus::Completed => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                RatingColumn::make('review.score'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        AppointmentStatus::Pending->value   => 'Pending',
                        AppointmentStatus::Approved->value  => 'Approved',
                        AppointmentStatus::Rejected->value  => 'Rejected',
                        AppointmentStatus::Completed->value => 'Completed',
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
            'view' => Pages\ViewAppointment::route('/{record}/view'),
        ];
    }
}
