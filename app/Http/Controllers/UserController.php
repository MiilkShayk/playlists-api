<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UsersService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function handle(Request $request, $action, $id = null)
    {
        switch ($action) {
            case 'create':
                return $this->createUserController($request);
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
    public function createUserController(Request $request)
    {
        try {
            $user = $this->usersService->create($request);
            return response()->json(['message' => 'Usuário criado com sucesso', 'users' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar usuário', 'error' => $e->getMessage()], 500);
        }
    }


    public function read(Request $request)
    {
        try {
            $filters = $request->all();

            $users = $this->usersService->read($filters);

            return response()->json(['message' => 'Lista de usuários', 'users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->usersService->update($request, $id);
            return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function delete($id)
    {
        try {
            $this->usersService->delete($id);
            return response()->json(['message' => 'Usuário Deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar usuário', 'error' => $e->getMessage()], 500);
        }
    }
}
