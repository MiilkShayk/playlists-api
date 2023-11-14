<?php

namespace App\Services;

use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthorService
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $authorRequest = $request->all();
        $author = new Author();
        $author->name = $authorRequest['name'];
        $author->save();
        return $author;
    }
    public function read(array $filters = [])
    {
        $query = Author::query();

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

        $authors = $query->get();

        return $authors;
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            throw new Exception('ID de usuário não encontrado', 404);
        }

        $author->update($request->all());

        return $author;
    }
    public function delete($id)
    {
        $author = Author::find($id);

        if (!$author) {
            throw new Exception('ID de usuário não encontrado', 404);
        }
        $author->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
    }
}
