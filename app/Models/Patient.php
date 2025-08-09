<?php

namespace App\Models;

use Parental\HasParent;

class Patient extends Person
{
    use HasParent;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
