<?php

namespace App\Filament\Pages;

use App\Enums\UserRole;
use App\Models\Location;
use App\Models\Patient;
use App\Models\Psychologist;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Notifications\Notification;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->role != UserRole::Admin) {
            $user->load('person');
        }

        if ($user->role == UserRole::Psychologist && $user->person instanceof Psychologist) {
            $user->person->load(['locations', 'specializations']);
        }

        if ($user->role == UserRole::Admin) {
            $this->profileForm->fill([
                'name'       => $user->name,
                'email'      => $user->email,
            ]);
        }

        if ($user->role == UserRole::Patient) {
            $this->profileForm->fill([
                'name'       => $user->name,
                'email'      => $user->email,
                'first_name' => $user->person?->first_name,
                'last_name'  => $user->person?->last_name,
                'description'  => $user->person?->description,
                'dob'  => $user->person?->dob,
            ]);
        }

        if ($user->role == UserRole::Psychologist) {
            $this->profileForm->fill([
                'name'       => $user->name,
                'email'      => $user->email,
                'first_name' => $user->person?->first_name,
                'last_name'  => $user->person?->last_name,
                'description'  => $user->person?->description,
                'dob'  => $user->person?->dob,
                'education'  => $user->person?->education,
                'experience'  => $user->person?->experience,
                'locations' => $user->person?->locations->pluck('id')->toArray() ?? [],
                'specializations' => $user->person?->specializations->pluck('id')->toArray() ?? [],
                'is_online'  => $user->person?->is_online,
                'is_offline'  => $user->person?->is_offline,
            ]);
        }
    }

    private function getSchema(): array
    {
        $schema = [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                // Use a standard unique rule since this is a Page (no record context):
                ->rule(fn() => Rule::unique('users', 'email')->ignore(Auth::id())),
        ];

        if (Auth::user()->role == UserRole::Psychologist) {
            $psychologistSchema = [
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('last_name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\DatePicker::make('dob')
                    ->label('Birthday')
                    ->format('Y-m-d H:i:s')
                    ->displayFormat('d M Y')
                    ->timezone('Asia/Jakarta')
                    ->native(false)
                    ->required(),

                Forms\Components\RichEditor::make('description')
                    ->disableToolbarButtons([
                        'attachFiles',
                    ]),

                Forms\Components\Select::make('locations')
                    ->multiple()
                    ->options(Location::pluck('location_name', 'id'))
                    ->preload(),

                Forms\Components\Select::make('specializations')
                    ->multiple()
                    ->options(Specialization::pluck('specialization_name', 'id'))
                    ->preload(),

                Forms\Components\RichEditor::make('education')
                    ->toolbarButtons([
                        'bulletList'
                    ]),

                Forms\Components\RichEditor::make('experience')
                    ->toolbarButtons([
                        'bulletList'
                    ]),

                Forms\Components\Checkbox::make('is_online')
                    ->label('Available for Online Consultation?')
                    ->default(false),

                Forms\Components\Checkbox::make('is_offline')
                    ->label('Available for Offline Consultation?')
                    ->default(false),
            ];

            $schema = array_merge($schema, $psychologistSchema);
        } else if (Auth::user()->role == UserRole::Patient) {
            $patientSchema = [
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('last_name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\DatePicker::make('dob')
                    ->label('Birthday')
                    ->format('Y-m-d H:i:s')
                    ->displayFormat('d M Y')
                    ->timezone('Asia/Jakarta')
                    ->native(false)
                    ->required(),

                Forms\Components\RichEditor::make('description')
                    ->disableToolbarButtons([
                        'attachFiles',
                    ]),
            ];

            $schema = array_merge($schema, $patientSchema);
        }

        return $schema;
    }
    /**
     * Define multiple named forms for this page.
     */
    protected function getForms(): array
    {
        $schema = $this->getSchema();
        return [
            'profileForm' => $this->makeForm()
                ->schema([
                    Forms\Components\Section::make('Profile Information')
                        ->description('Update your account’s profile information.')
                        ->schema($schema),
                ])
                ->statePath('profileData'),

            'passwordForm' => $this->makeForm()
                ->schema([
                    Forms\Components\Section::make('Update Password')
                        ->description('Ensure your account is using a strong password.')
                        ->schema([
                            Forms\Components\TextInput::make('current_password')
                                ->label('Current password')
                                ->password()
                                ->required()
                                ->currentPassword(),

                            Forms\Components\TextInput::make('password')
                                ->password()
                                ->required()
                                ->rule(Password::default())
                                ->autocomplete('new-password')
                                ->same('password_confirmation')
                                // Hash the password before dehydration:
                                ->dehydrateStateUsing(fn($state): string => Hash::make($state)),

                            Forms\Components\TextInput::make('password_confirmation')
                                ->label('Confirm new password')
                                ->password()
                                ->required()
                                ->dehydrated(false),
                        ]),
                ])
                ->statePath('passwordData'),
        ];
    }

    public function saveProfile(): void
    {
        $data = $this->profileForm->getState();
        $user = Auth::user();

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if ($user->person instanceof Patient) {
            $user->person()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $data['first_name'] ?? null,
                    'last_name'  => $data['last_name'] ?? null,
                    'description'  => $data['description'] ?? null,
                ]
            );
        }

        if ($user->person instanceof Psychologist) {
            $user->person()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $data['first_name'] ?? null,
                    'last_name'  => $data['last_name'] ?? null,
                    'description'  => $data['description'] ?? null,
                    'experience'  => $data['experience'] ?? null,
                    'education'  => $data['education'] ?? null,
                    'is_online'  => $data['is_online'] ?? false,
                    'is_offline'  => $data['is_offline'] ?? false,
                ]
            );
            $user->person->locations()->sync($data['locations'] ?? []);
            $user->person->specializations()->sync($data['specializations'] ?? []);
        }


        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }

    public function savePassword(): void
    {
        $data = $this->passwordForm->getState();
        $user = Auth::user();

        $user->update([
            'password' => $data['password'], // already hashed via dehydrateStateUsing
        ]);

        // Optionally clear fields after update
        $this->passwordForm->fill([
            'current_password' => null,
            'password' => null,
            'password_confirmation' => null,
        ]);

        Notification::make()
            ->title('Password updated successfully!')
            ->success()
            ->send();
    }
}
