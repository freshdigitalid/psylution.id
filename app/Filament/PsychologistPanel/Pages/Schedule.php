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
                $date = $start->copy()->addDays($i)->setTimezone('Asia/Jakarta');

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
                    $start = Carbon::parse($s->start_time)->setTimezone('Asia/Jakarta');
                    $end = Carbon::parse($s->end_time)->setTimezone('Asia/Jakarta');
                    $break_start_time = $s->break_start_time ? Carbon::parse($s->break_start_time)->setTimezone('Asia/Jakarta')->format('H:i') : null;
                    $break_end_time = $s->break_end_time ? Carbon::parse($s->break_end_time)->setTimezone('Asia/Jakarta')->format('H:i') : null;

                    return [
                        'day' => $start->format('l'), // e.g. "Monday"
                        'datetime' => $start->copy()->startOfDay()->format('Y-m-d'), // keep same as your schema
                        'start_time' => $start->format('H:i'),
                        'end_time' => $end->format('H:i'),
                        'break_start_time' => $break_start_time,
                        'break_end_time' => $break_end_time,
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
                        ->label('Start Time')
                        ->seconds(false)
                        ->required(),

                    Forms\Components\TimePicker::make('end_time')
                        ->label('End Time')
                        ->seconds(false)
                        ->required(),

                    Forms\Components\TimePicker::make('break_start_time')
                        ->seconds(false)
                        ->label('Rest Start Time'),

                    Forms\Components\TimePicker::make('break_end_time')
                        ->seconds(false)
                        ->label('Rest End Time'),
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
        for ($i = 0; $i < count($data); $i++) {
            $baseDate = $start->copy()->addDays($i);
            [$start_hour, $start_minute] = explode(':', $data[$i]['start_time']);
            [$end_hour, $end_minute] = explode(':', $data[$i]['end_time']);

            [$break_start_hour, $break_start_minute] = [null, null];
            if ($data[$i]['break_start_time']) {
                [$break_start_hour, $break_start_minute] = explode(':', $data[$i]['break_start_time']);
            }

            [$break_end_hour, $break_end_minute] = [null, null];
            if ($data[$i]['break_end_time']) {
                [$break_end_hour, $break_end_minute] = explode(':', $data[$i]['break_end_time']);
            }

            ScheduleModel::create([
                'psychologist_id' => $user->person->id,
                'start_time' => $baseDate->copy()->addHours((int)$start_hour)->addMinutes((int)$start_minute),
                'end_time' => $baseDate->copy()->addHours((int)$end_hour)->addMinutes((int)$end_minute),
                'break_start_time' => $break_start_hour
                    ? $baseDate->copy()->addHours((int)$break_start_hour)->addMinutes((int)$break_start_minute)
                    : null,
                'break_end_time' => $break_end_hour
                    ? $baseDate->copy()->addHours((int)$break_end_hour)->addMinutes((int)$break_end_minute)
                    : null,
            ]);
        }

        Notification::make()
            ->title('Schedule saved successfully!')
            ->success()
            ->send();
    }
}
