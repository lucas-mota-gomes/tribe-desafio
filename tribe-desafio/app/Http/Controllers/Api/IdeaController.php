<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $idea = Idea::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'autor_id' => auth()->id(),
        ]);

        return response()->json($idea, 201);
    }

    public function votar($id)
    {
        $idea = Idea::findOrFail($id);
        $user = auth()->user();

        if ($idea->votos()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Já votou nesta ideia'], 403);
        }

        $idea->votos()->create(['user_id' => $user->id]);

        $count = $idea->votos()->count();

        return response()->json(['votos' => $count]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
