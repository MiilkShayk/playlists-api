<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MusicasService;
use Illuminate\Http\Request;

class MusicasController extends Controller

{
    protected $musicasService;

    public function __construct(MusicasService $musicasService)
    {
        $this->musicasService = $musicasService;
    }

    // UserController.php
    public function handle(Request $request, $action, $id = null)
    {
        switch ($action) {
            case 'create':
                return $this->createMusicasController($request);
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
    public function createMusicasController(Request $request)
    {
        try {
            $user = $this->musicasService->create($request);
            return response()->json(['message' => 'Musica criado com sucesso', 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Musica', 'error' => $e->getMessage()], 500);
        }
    }
    public function read()
    {
        try {
            $user = $this->musicasService->read();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $user = $this->musicasService->update($request, $id);
            return response()->json(['message' => 'Musica atualizado com sucesso', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function delete($id)
    {
        try {
            $this->musicasService->delete($id);
            return response()->json(['message' => 'Musica deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Musica', 'error' => $e->getMessage()], 500);
        }
    }
}