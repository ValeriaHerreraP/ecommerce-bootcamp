<?php

namespace App\Actions\UserActions;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserListAction
{
    public static function execute(string $search): LengthAwarePaginator
    {
        return User::where('name', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->latest()->paginate();
    }
}
