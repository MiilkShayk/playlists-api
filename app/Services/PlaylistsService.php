<?php

namespace App\Services;

use App\Models\Playlists;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PlaylistsService
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $playlistRequest = $request->all();
        $playlist = new Playlists();
        $playlist->name = $playlistRequest['name'];
        $playlist->users_id = $playlistRequest['users_id'];
        $playlist->save();
        return $playlist;
    }
    public function addMusicas(Request $request, $playlistId)
    {
        $playlist = Playlists::find($playlistId);
        if (!$playlist) {
            throw new Exception('Playlist não encontrada.', 404);
        }

        $musicasIds = $request->input('musicas_ids');

        if (empty($musicasIds) || !is_array($musicasIds)) {
            throw new Exception('IDs de músicas inválidos.', 400);
        }


        $playlist->musicas()->sync($musicasIds);

        return $playlist;
    }
    public function showMusicasOnPlaylist($playlistId)
    {
        $playlist = Playlists::find($playlistId);

        if (!$playlist) {
            throw new Exception('Playlist não encontrada.');
        }

        $musicas = $playlist->musicas->map(function ($musica) {
            return [
                'ID da Música' => $musica->id,
                'Musica' => $musica->name,
                'Categoria' => $musica->category->name,  // Substitua 'category' pelo nome do relacionamento correto
                'Author' => $musica->author->name,  // Substitua 'author' pelo nome do relacionamento correto
            ];
        });
        return [
            'playlist' => [
                'Nome da Playlist' => $playlist->name,
                'ID da Playlist' => $playlist->id,
                'Usuário' => [
                    'Nome' => $playlist->user->name,
                    'ID do usuário' => $playlist->user->id,
                ],
                'musicas' => $musicas
            ],
        ];
    }
    public function read(array $filters = [])
    {
        $query = Playlists::query();

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

        $playlists = $query->get();

        return $playlists;
    }
    public function update(Request $request, $id)
    {
        $playlist = Playlists::find($id);

        if (!$playlist) {
            throw new Exception('ID de playlist não encontrado', 404);
        }

        $playlist->update($request->all());

        return $playlist;
    }
    public function delete($id)
    {
        $playlist = Playlists::find($id);

        if (!$playlist) {
            throw new Exception('ID de playlist não encontrado', 404);
        }
        $playlist->delete();
        return response()->json(['message' => 'playlist deletada com sucesso'], 200);
    }
}
