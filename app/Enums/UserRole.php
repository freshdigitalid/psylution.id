<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Psychologist = 'psychologist';
    case Patient = 'patient';
}