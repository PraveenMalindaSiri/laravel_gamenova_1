<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('access-admin');

        $users = User::withTrashed()->get();
        return view('dashboard.admin.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('access-admin');

        return view('dashboard.admin.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        Gate::authorize('access-admin');

        if ($user->trashed()) {
            return redirect()->route('users.index')->with('error', 'User is banned!!!.');
        }
        return view('dashboard.admin.update', ['user' => $user]);
    }

    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        Gate::authorize('access-admin');

        if ($user->trashed()) {
            return redirect()->route('users.index')->with('error', 'User is banned!!!.');
        }

        $validated = $request->validated();

        if (! Hash::check($validated['admin_password'], Auth::user()->password)) {
            abort(403, 'Admin Password is wrong!!!');
        }


        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return redirect()->route('users.index')->with('success', 'User Password Changed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User  $user, Request $request)
    {
        /** @var \App\Models\User $user */
        $actor = $request->user();

        Gate::authorize('access-admin');

        if ($user->isAdmin()) {
            abort(403, 'You cannot deactivate an admin.');
        }

        $user->delete();
        $user->tokens()->delete();
        return redirect()->back()->with('success', 'User deactivated.');
    }

    public function restore(String $id, Request $request)
    {
        Gate::authorize('access-admin');

        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'User restored.');
    }
}
