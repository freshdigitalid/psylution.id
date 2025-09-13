<?php

namespace App\Filament\PsychologistPanel\Pages;

use App\Models\Psychologist;
use App\Models\Package as PackageModel;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Package extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'My Packages';
    protected static string $view = 'filament.form';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user()->load('person');

        $employmentStart = Carbon::parse($user->person->employment_start_date);
        $yoe = $employmentStart->diffInYears(now());

        $packages = PackageModel::whereHas('psychologists', function ($q) use ($user) {
            $q->where('persons.id', $user->person->id);
        })
        ->whereHas('details', function ($q) use ($yoe, $user) {
            $q->where('min_yoe', '<=', $yoe)
              ->where('max_yoe', '>=', $yoe)
              ->where(function ($query) use ($user) {
                  $query->where('is_online', $user->person->is_online)
                        ->orWhere('is_online', !$user->person->is_offline);
              });
        })
        ->with(['details' => function ($q) use ($yoe, $user) {
            $q->where('min_yoe', '<=', $yoe)
              ->where('max_yoe', '>=', $yoe)
              ->where(function ($query) use ($user) {
                  $query->where('is_online', $user->person->is_online)
                        ->orWhere('is_online', !$user->person->is_offline);
              });
        }])
        ->get();

        if($packages->isEmpty()) {
            $this->data = [];
            return;
        }

        $formData = [
            'packages' => $packages->map(function ($package) {
                return [
                    'title' => $package->title,
                    'description' => $package->description,
                    'details' => $package->details->map(function ($detail) {
                        return [
                            'title' => $detail->title,
                            'description' => $detail->description,
                            'price' => $detail->price,
                            'is_online' => $detail->is_online,
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];

        $this->form->fill($formData);
    }

    protected function getFormSchema(): array
    {

        return [
            Forms\Components\Placeholder::make('no_packages')
                ->hiddenLabel(true)
                ->content('No packages available.')
                ->visible(fn ($get) => empty($get('packages'))),

            Forms\Components\Repeater::make('packages')
                ->hidden(fn ($get) => empty($get('packages')))
                ->hiddenLabel(true)
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Package Name')
                        ->disabled(),

                    Forms\Components\Textarea::make('description')
                        ->disabled(),

                    Forms\Components\Repeater::make('details')
                        ->hiddenLabel(true)
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->disabled(),

                                Forms\Components\Textarea::make('description')
                                    ->disabled(),

                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled(),

                                Forms\Components\Toggle::make('is_online')
                                    ->label('Online?')
                                    ->disabled(),
                        ]),
                ])
        ];
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }
}
