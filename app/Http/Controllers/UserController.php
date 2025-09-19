<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('strand', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        return view('admin_users', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'role'        => 'required|in:admin,counselor,student',
            'grade_level' => 'nullable|in:11,12',
            'strand'      => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'grade_level' => $request->role === 'student' ? $request->grade_level : null,
            'strand'      => $request->role === 'student' ? $request->strand : null,
            'status'      => 'active', // default active
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action'  => "Created user: {$user->name} ({$user->role})",
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function import(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $userData = [
                'name'        => $data[0] ?? null,
                'email'       => $data[1] ?? null,
                'password'    => Hash::make($data[2] ?? 'password123'),
                'role'        => $data[3] ?? 'student',
                'grade_level' => ($data[3] === 'student') ? ($data[4] ?? null) : null,
                'strand'      => ($data[3] === 'student') ? ($data[5] ?? null) : null,
                'status'      => 'active',
            ];

            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }

        fclose($handle);

        return redirect()->route('admin.users')
                         ->with('success', 'Users imported successfully!');
    }

    public function toggleStatus(User $user)
{
    if (auth()->user()->role !== 'admin') abort(403);

    $user->status = $user->status === 'active' ? 'inactive' : 'active';
    $user->save();

    Log::create([
        'user_id' => auth()->id(),
        'action'  => "Toggled status for user: {$user->name} → {$user->status}",
    ]);

    return redirect()->back()->with('success', "User status updated to {$user->status}.");
}


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

        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->role        = $request->role;
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
