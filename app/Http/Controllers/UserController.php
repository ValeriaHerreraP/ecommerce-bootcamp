<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;

use App\Actions\UserActions\UserListAction;
use App\Actions\UserActions\UserUpdateAction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $users = UserListAction::execute($search);

        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update( UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user = UserUpdateAction::execute($request, $user);

        return redirect()->route('users.index');
    }

    public function updateState(Request $request, User $user): RedirectResponse
    {
        if ($request->state == 'Habilitar') {
            $state = 1;
        } else {
            $state = 0;
        }

        $user->update([
            'state' => $state,
        ]);

        return back();
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
