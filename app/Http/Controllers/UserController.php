<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $users = User::all();
        return view('admin_users', compact('users')); // ✅ Changed to admin_users.blade.php
    }

   public function store(Request $request)
{
    if (auth()->user()->role !== 'admin') abort(403);

    $request->validate([
        'name'        => 'required|string|max:100',
        'email'       => 'required|email|unique:users,email',
        'password'    => 'required|min:6',
        'role'        => 'required|in:admin,counselor,student',
        'grade_level' => 'nullable|in:11,12',   // Only for students
        'strand'      => 'nullable|string|max:50', // Only for students
    ]);

    $user = User::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'password'    => Hash::make($request->password),
        'role'        => $request->role,
        'grade_level' => $request->role === 'student' ? $request->grade_level : null,
        'strand'      => $request->role === 'student' ? $request->strand : null,
    ]);

    Log::create([
        'user_id' => auth()->id(),
        'action'  => "Created user: {$user->name} ({$user->role})",
    ]);

    return redirect()->back()->with('success', 'User added successfully!');
}

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action'  => "Deleted user: {$user->name} ({$user->role})",
        ]);

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // ------------------ UPDATE METHOD ------------------
    public function update(Request $request, User $user)
{
    if (auth()->user()->role !== 'admin') abort(403);

    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email,' . $user->id,
        'role'        => 'required|in:admin,counselor,student',
        'password'    => 'nullable|string|min:6',
        'grade_level' => 'nullable|in:11,12',
        'strand'      => 'nullable|string|max:50',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->grade_level = $request->role === 'student' ? $request->grade_level : null;
    $user->strand      = $request->role === 'student' ? $request->strand : null;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    Log::create([
        'user_id' => auth()->id(),
        'action'  => "Updated user: {$user->name} ({$user->role})",
    ]);

    return redirect()->back()->with('success', 'User updated successfully.');
}
}
