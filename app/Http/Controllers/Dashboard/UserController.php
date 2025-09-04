<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withTrashed()->get();
        return view('dashboard.admin.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('dashboard.admin.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User  $user, Request $request)
    {
        /** @var \App\Models\User $user */
        $actor = $request->user();

        if (!$actor->isAdmin()) {
            abort(403, 'Only admins can deactivate users.');
        }

        if ($user->isAdmin()) {
            abort(403, 'You cannot deactivate an admin.');
        }

        $user->delete();
        $user->tokens()->delete();
        return back()->with('success', 'User deactivated.');
    }

    public function restore(String $id, Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return back()->with('success', 'User restored.');
    }
}
