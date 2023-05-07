<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $users = User::where('name', 'LIKE', "%{$search}%") -> orWhere ('lastname', 'LIKE', "%{$search}%") -> latest()->paginate();
        
        return view('users.index',['users' => $users]);
    }

    public function edit(User $user): View
    {
        return view('users.edit',['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $request->validate();

        $user->update([
            'name'=> $request->name,
            'lastname'=> $request->lastname,
            'phone'=> $request->phone,
            'email'=> $request->email,
        ]);

        return redirect()->route('users.index', $user);
    }


    public function updateState(Request $request, User $user)
    {
        if ($request->state == "Habilitar"){

            $state = 1;
        }
        else
        {
            $state = 0;
        }

        $user->update([
            'state' => $state,
        ]);

        return back();
    }

    
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
