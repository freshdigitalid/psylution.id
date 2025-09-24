<?php

namespace App\Filament\PsychologistPanel\Pages;

use App\Models\Schedule as ScheduleModel;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Schedule extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'My Schedules';
    protected static string $view = 'filament.form-with-save';

    public ?array $data = [];

    public function mount(): void
    {
        $start = Carbon::now('Asia/Jakarta')
            ->startOfWeek()
            ->startOfDay()
            ->timezone('UTC');

        $end = Carbon::now('Asia/Jakarta')
            ->endOfWeek()
            ->endOfDay()
            ->timezone('UTC');

        $schedules = ScheduleModel::where('psychologist_id', Auth::user()->person->id)
            ->whereBetween('start_time', [$start, $end])
            ->get();

        if ($schedules->isEmpty()) {
            // Start from Monday
            $weekly = collect(range(0, 6))->map(function ($i) use ($start) {
                $date = $start->copy()->addDays($i);
                
                return [
                    'day' => $date->format('l'), // Monday, Tuesday, ...
                    'datetime' => $date,
                    'start_time' => null,
                    'end_time' => null,
                    'break_start_time' => null,
                    'break_end_time' => null,
                ];
            })->toArray();

            $this->form->fill([
                'weekly_schedule' => $weekly,
            ]);
        } else {
            $this->form->fill([
                'weekly_schedule' => $schedules->map(function ($s) {
                    $start = Carbon::parse($s->start_time);

                    return [
                        'day' => $start->format('l'), // e.g. "Monday"
                        'datetime' => $start->copy()->startOfDay()->format('Y-m-d'), // keep same as your schema
                        'start_time' => $start,
                        'end_time' => $s->end_time,
                        'break_start_time' => $s->break_start_time,
                        'break_end_time' => $s->break_end_time,
                    ];
                })->toArray(),
            ]);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Repeater::make('weekly_schedule')
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->label('Weekly Schedule')
                ->defaultItems(7)
                ->schema([
                    Forms\Components\TextInput::make('day')
                        ->hiddenLabel()
                        ->disabled(),

                    Forms\Components\DatePicker::make('datetime')
                        ->hiddenLabel()
                        ->format('Y-m-d')
                        ->timezone('Asia/Jakarta')
                        ->disabled()
                        ->dehydrated(true),

                    Forms\Components\TimePicker::make('start_time')
                        ->timezone('Asia/Jakarta')
                        ->label('Start Time')
                        ->seconds(false)
                        ->required(),

                    Forms\Components\TimePicker::make('end_time')
                        ->timezone('Asia/Jakarta')
                        ->label('End Time')
                        ->seconds(false)
                        ->required(),

                    Forms\Components\TimePicker::make('break_start_time')
                        ->timezone('Asia/Jakarta')
                        ->seconds(false)
                        ->label('Rest Time'),

                    Forms\Components\TimePicker::make('break_end_time')
                        ->timezone('Asia/Jakarta')
                        ->seconds(false)  
                        ->label('Rest Time'),
                ])
                ->default(function () {
                    return collect([
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday',
                        'Sunday',
                    ])->map(fn($day) => ['day' => $day])->toArray();
                })
                ->columns(2)
                ->columnSpanFull(),
        ];
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $user = Auth::user()->load('person');
        $data = $this->form->getState()['weekly_schedule'];

        // Clear old schedules
        $start = Carbon::now('Asia/Jakarta')
            ->startOfWeek()
            ->startOfDay()
            ->timezone('UTC');

        $end = Carbon::now('Asia/Jakarta')
            ->endOfWeek()
            ->endOfDay()
            ->timezone('UTC');

        ScheduleModel::where('psychologist_id', Auth::user()->person->id)
            ->whereBetween('start_time', [$start, $end])
            ->delete();

        // Insert new ones
        foreach ($data as $schedule) {
            $baseDate = Carbon::parse($schedule['datetime'], 'Asia/Jakarta');

            ScheduleModel::create([
                'psychologist_id' => $user->person->id,
                'start_time' => $baseDate->copy()->setTimeFromTimeString($schedule['start_time']),
                'end_time' => $baseDate->copy()->setTimeFromTimeString($schedule['end_time']),
                'break_start_time' => $schedule['break_start_time']
                    ? $baseDate->copy()->setTimeFromTimeString($schedule['break_start_time'])
                    : null,
                'break_end_time' => $schedule['break_end_time']
                    ? $baseDate->copy()->setTimeFromTimeString($schedule['break_end_time'])
                    : null,
            ]);
        }

        Notification::make()
            ->title('Schedule saved successfully!')
            ->success()
            ->send();
    }
}
