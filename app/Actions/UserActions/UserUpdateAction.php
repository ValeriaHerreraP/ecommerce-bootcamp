<?php

namespace App\Actions\UserActions;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserUpdateAction
{
    public static function execute(UpdateUserRequest $request, User $user)
    {
        $data = $request->all();
       
        return $user->update($data);
    }
}