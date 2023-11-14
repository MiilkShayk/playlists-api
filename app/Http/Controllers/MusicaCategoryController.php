<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MusicaCategoryService;
use Illuminate\Http\Request;

class MusicaCategoryController extends Controller
{
    protected $musicaCategoryService;

    public function __construct(MusicaCategoryService $musicaCategoryService)
    {
        $this->musicaCategoryService = $musicaCategoryService;
    }

    // MusicaCategoryController.php
    public function handle(Request $request, $action, $id = null)
    {
        switch ($action) {
            case 'create':
                return $this->createMusicaCategoryController($request);
            case 'read':
                return $this->read();
            case 'update':
                return $this->update($request, $id);
            case 'delete':
                return $this->delete($id);
            default:
                return response()->json(['message' => 'Ação inválida'], 400);
        }
    }
    public function createMusicaCategoryController(Request $request)
    {
        try {
            $user = $this->musicaCategoryService->create($request);
            return response()->json(['message' => 'Musica Category criado com sucesso', 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Musica Category', 'error' => $e->getMessage()], 500);
        }
    }
    public function read()
    {
        try {
            $user = $this->musicaCategoryService->read();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $user = $this->musicaCategoryService->update($request, $id);
            return response()->json(['message' => 'Musica Category atualizado com sucesso', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function delete($id)
    {
        try {
            $this->musicaCategoryService->delete($id);
            return response()->json(['message' => 'Musica Category Deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Musica Category', 'error' => $e->getMessage()], 500);
        }
    }
}
