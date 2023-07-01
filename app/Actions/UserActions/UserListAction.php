<?php

namespace App\Actions\UserActions;

use App\Models\User;

class UserListAction
{
    public static function execute($search)
    {
        return User::where('name', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->latest()->paginate();
    }
}
