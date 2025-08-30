<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PsychologistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psychologists = Psychologist::paginate(10);

        return Inertia::render('psychologist/find/index', [
            'psychologists' => $psychologists
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $psychologist = Psychologist::select('id', 'first_name', 'last_name', 'education', 'experience', 'description')
            ->with('locations:location_name')
            ->with('specializations:specialization_name')
            ->findOrFail($id);

        $psychologist->locations->each->makeHidden('pivot');
        $psychologist->specializations->each->makeHidden('pivot');

        return Inertia::render('psychologist/detail/index', [
            'psychologist' => $psychologist
        ]);
    }
}
