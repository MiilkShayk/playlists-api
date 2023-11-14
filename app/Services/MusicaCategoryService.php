<?php

namespace App\Services;

use App\Models\MusicaCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MusicaCategoryService
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

        $musicaCategoryRequest = $request->all();
        $musicaCategory = new MusicaCategory();
        $musicaCategory->name = $musicaCategoryRequest['name'];
        $musicaCategory->save();
        return $musicaCategory;
    }
    public function read()
    {
        $musicaCategorys = MusicaCategory::all();

        if ($musicaCategorys->isEmpty()) {
            throw new Exception('Nenhum musica category encontrado.');
        }

        return ['message' => 'Lista de musicaCategorys', 'musicaCategorys' => $musicaCategorys];
    }
    public function update(Request $request, $id)
    {
        $musicaCategory = MusicaCategory::find($id);

        if (!$musicaCategory) {
            throw new Exception('ID de musica category não encontrado', 404);
        }

        $musicaCategory->update($request->all());

        return $musicaCategory;
    }
    public function delete($id)
    {
        $musicaCategory = MusicaCategory::find($id);

        if (!$musicaCategory) {
            throw new Exception('ID de musica category não encontrado', 404);
        }
        $musicaCategory->delete();
        return response()->json(['message' => 'musica category deletado com sucesso'], 200);
    }
}
