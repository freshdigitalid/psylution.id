<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Psychologist;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['role'] != UserRole::Admin->value && $data['is_new_person']) {
            $data['name'] = trim($data['person_first_name'] . ' ' . $data['person_last_name']);
        }

        if (!$data['is_new_person']) {
            $person = Person::find($data['person']);
            $data['name'] = trim($person->first_name . ' ' . $person->last_name);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $user = $this->record;

        if ($this->form->getState()['is_new_person']) {
            if ($user->role !== UserRole::Admin) {
                $first_name = $this->form->getState()['person_first_name'];
                $last_name = $this->form->getState()['person_last_name'];
                $dob = $this->form->getState()['person_dob'];

                if ($user->role === UserRole::Psychologist) {
                    Psychologist::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'first_name' => $first_name,
                            'last_name'  => $last_name,
                            'dob'        => $dob,
                        ]
                    );
                }

                if ($user->role === UserRole::Patient) {
                    Patient::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'first_name' => $first_name,
                            'last_name'  => $last_name,
                            'dob'        => $dob,
                        ]
                    );
                }
            }
        } else {
            Person::where('id', $this->form->getState()['person'])
                ->update(['user_id' => $user->id]);
        }
    }
}
