<?php

namespace App\Http\Controllers;

use App\Actions\UserActions\UserListAction;
use App\Actions\UserActions\UserUpdateAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Loggers\Logger;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.edit')->only('edit','update');
        $this->middleware('can:users.destroy')->only('destroy');
    }

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

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Logger::update_users_admin($user);
        $user = UserUpdateAction::execute($request, $user);
  

        return redirect()->route('users.index');
    }

    public function update_state_enable(User $user): RedirectResponse
    {
        $user->update([
            'state' => 0,
        ]);

        Logger::update_users_state($user);

        return redirect()->route('users.index');
    }

    public function update_state_disable(User $user): RedirectResponse
    {
        $user->update([
            'state' => 1,
        ]);

        Logger::update_users_state($user);
        return redirect()->route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        Logger::delete_users($user);
        $user->delete();
      
        return redirect()->route('users.index');
    }
}
