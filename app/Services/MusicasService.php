<?php

namespace App\Services;
use App\Events\MusicaUpdated;
use App\Models\Musicas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MusicasService
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'categories_id' => 'required|exists:musica_categories,id',
            'authors_id' => 'required|exists:authors,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    
        $musicasRequest = $request->all();
        
        // Criar a nova música
        $musica = new Musicas();
        $musica->name = $musicasRequest['name'];
        $musica->categories_id = $musicasRequest['categories_id'];
        $musica->authors_id = $musicasRequest['authors_id'];
        $musica->save();
    
        return $musica;
    }
    public function read(array $filters = [])
    {
        $query = Musicas::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['order_by'])) {
            $orderDirection = $filters['order_direction'] ?? 'asc';

            switch ($filters['order_by']) {
                case 'name':
                    $query->orderBy('name', $orderDirection);
                    break;
            }
        }

        $users = $query->get();

        return $users;
    }
    public function update(Request $request, $id)
    {
        $musicas = Musicas::find($id);

        if (!$musicas) {
            throw new Exception('ID de musica não encontrado', 404);
        }

        $musicas->update($request->all());

        return $musicas;
    }
    public function delete($id)
    {
        $musicas = Musicas::find($id);

        if (!$musicas) {
            throw new Exception('ID de musica não encontrado', 404);
        }
        $musicas->delete();
        return response()->json(['message' => 'musica deletado com sucesso', $musicas], 200);
    }
    public function updateMusica($musica)
    {
        event(new MusicaUpdated($musica));
    }
}
