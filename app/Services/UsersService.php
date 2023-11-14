<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersService
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $userRequest = $request->all();
        $user = new User();
        $user->name = $userRequest['name'];
        $user->email = $userRequest['email'];
        $user->save();
        return $user;
    }
    // UsersService.php
    public function read(array $filters = [])
    {
        $query = User::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['order_by'])) {
            $orderDirection = $filters['order_direction'] ?? 'asc';

            switch ($filters['order_by']) {
                case 'name':
                    $query->orderBy('name', $orderDirection);
                    break;
                case 'email':
                    $query->orderBy('email', $orderDirection);
                    break;
            }
        }

        $users = $query->get();

        return $users;
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new Exception('ID de usuário não encontrado', 404);
        }

        $user->update($request->all());

        return $user;
    }
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new Exception('ID de usuário não encontrado', 404);
        }
        $user->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
    }
}
