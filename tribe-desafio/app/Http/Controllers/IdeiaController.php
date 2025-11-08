<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ideia;
use App\Models\Voto;

class IdeiaController extends Controller
{
    public function index()
    {
        $ideias = Ideia::with('autor')
            ->withCount([
                'votos as votos_positivos' => function ($query) {
                    $query->where('tipo', 'positivo');
                },
                'votos as votos_negativos' => function ($query) {
                    $query->where('tipo', 'negativo');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ideia) {
                $ideia->total_votos = $ideia->votos_positivos - $ideia->votos_negativos;
                return $ideia;
            });
        
        return response()->json($ideias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $ideia = Ideia::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'autor_id' => auth()->id(),
        ]);

        $ideia->load('autor');
        $ideia->votos_positivos = 0;
        $ideia->votos_negativos = 0;
        $ideia->total_votos = 0;

        return response()->json($ideia, 201);
    }

    public function votar(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:positivo,negativo'
        ]);

        $ideia = Ideia::findOrFail($id);
        $user = auth()->user();

        $votoExistente = Voto::where('user_id', $user->id)
            ->where('ideia_id', $ideia->id)
            ->first();

        if ($votoExistente) {
            if ($votoExistente->tipo === $request->tipo) {
                $votoExistente->delete();
                $mensagem = 'Voto removido';
            } else {
                $votoExistente->update(['tipo' => $request->tipo]);
                $mensagem = 'Voto atualizado';
            }
        } else {
            Voto::create([
                'user_id' => $user->id,
                'ideia_id' => $ideia->id,
                'tipo' => $request->tipo
            ]);
            $mensagem = 'Voto registrado';
        }

        $votosPositivos = $ideia->votos()->where('tipo', 'positivo')->count();
        $votosNegativos = $ideia->votos()->where('tipo', 'negativo')->count();

        return response()->json([
            'message' => $mensagem,
            'votos_positivos' => $votosPositivos,
            'votos_negativos' => $votosNegativos,
            'total_votos' => $votosPositivos - $votosNegativos
        ]);
    }

    public function show($id)
    {
        $ideia = Ideia::with('autor')
            ->withCount([
                'votos as votos_positivos' => function ($query) {
                    $query->where('tipo', 'positivo');
                },
                'votos as votos_negativos' => function ($query) {
                    $query->where('tipo', 'negativo');
                }
            ])
            ->findOrFail($id);

        $ideia->total_votos = $ideia->votos_positivos - $ideia->votos_negativos;

        return response()->json($ideia);
    }

    public function update(Request $request, $id)
    {
        $ideia = Ideia::findOrFail($id);
        
        if ($ideia->autor_id !== auth()->id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|required|string',
        ]);

        $ideia->update($request->only(['titulo', 'descricao']));
        $ideia->load('autor');

        return response()->json($ideia);
    }

    public function destroy($id)
    {
        $ideia = Ideia::findOrFail($id);
        
        if ($ideia->autor_id !== auth()->id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $ideia->delete();

        return response()->json(['message' => 'Ideia deletada com sucesso']);
    }
}
