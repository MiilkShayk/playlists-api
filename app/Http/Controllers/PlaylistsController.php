<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PlaylistsService;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    protected $playlistsService;

    public function __construct(PlaylistsService $playlistsService)
    {
        $this->playlistsService = $playlistsService;
    }

    public function handle(Request $request, $action, $id = null)
    {
        switch ($action) {
            case 'create':
                return $this->createPlaylistsController($request);
            case 'read':
                return $this->read($request);
            case 'update':
                return $this->update($request, $id);
            case 'delete':
                return $this->delete($id);
            default:
                return response()->json(['message' => 'Ação inválida'], 400);
        }
    }
    public function createPlaylistsController(Request $request)
    {
        try {
            $playlist = $this->playlistsService->create($request);
            return response()->json(['message' => 'Playlist criado com sucesso', 'playlists' => $playlist], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Playlist', 'error' => $e->getMessage()], 500);
        }
    }
    public function addMusicas(Request $request, $playlistId)
    {
        try {
            $playlist = $this->playlistsService->addMusicas($request, $playlistId);
            return response()->json(['message' => 'Músicas adicionadas à playlist com sucesso', 'playlist' => $playlist], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao adicionar músicas à playlist', 'error' => $e->getMessage()], 500);
        }
    }
    public function showMusicasOnPlaylist($playlistId)
    {
        try {
            $musicas = $this->playlistsService->showMusicasOnPlaylist($playlistId);
            return response()->json([$musicas], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao obter músicas da playlist', 'error' => $e->getMessage()], 500);
        }
    }
    public function read(Request $request)
    {
        try {
            $filters = $request->all();

            $playlists = $this->playlistsService->read($filters);

            return response()->json(['message' => 'Lista de Playlists', 'playlists' => $playlists], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $playlist = $this->playlistsService->update($request, $id);
            return response()->json(['message' => 'Playlist atualizado com sucesso', 'playlist' => $playlist], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function delete($id)
    {
        try {
            $this->playlistsService->delete($id);
            return response()->json(['message' => 'Playlist Deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Playlist', 'error' => $e->getMessage()], 500);
        }
    }
}
