<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(20);
        return view('admin.index', compact('users'));
    }

    public function setRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required','in:participant,jury,admin'],
        ]);

        $user->update(['role' => $data['role']]);

        return back()->with('ok', 'Роль изменена');
    }
}
