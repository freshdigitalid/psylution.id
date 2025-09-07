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
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $psychologists = Psychologist::query()
            ->select(['id', 'first_name', 'last_name', 'education', 'experience', 'description', 'created_at', 'updated_at'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('education', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('psychologist/find/index', [
            'psychologists' => $psychologists,
            'filters' => [
                'q' => $q,
            ],
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
