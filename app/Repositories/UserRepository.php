<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        };
        return $user;
    }

    public function getOne($id)
    {
        return User::find($id);
    }
}
