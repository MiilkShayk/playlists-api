<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function handle(Request $request, $action, $id = null)
    {
        switch ($action) {
            case 'create':
                return $this->createAuthorController($request);
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
    public function createAuthorController(Request $request)
    {
        try {
            $author = $this->authorService->create($request);
            return response()->json(['message' => 'author criado com sucesso', 'authors' => $author], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar author', 'error' => $e->getMessage()], 500);
        }
    }


    public function read(Request $request)
    {
        try {
            $filters = $request->all();

            $authors = $this->authorService->read($filters);

            return response()->json(['message' => 'Lista de authors', 'authors' => $authors], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $author = $this->authorService->update($request, $id);
            return response()->json(['message' => 'author atualizado com sucesso', 'author' => $author], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function delete($id)
    {
        try {
            $this->authorService->delete($id);
            return response()->json(['message' => 'author deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar author', 'error' => $e->getMessage()], 500);
        }
    }
}
