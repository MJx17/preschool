<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredTeacherUserController extends Controller
{
    /**
     * Display the teacher registration form for admin.
     */
    public function create(): View
    {
        return view('auth.register_teacher'); // View for admin to add teachers
    }

    /**
     * Handle the teacher creation request by admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults()], // No confirmation needed
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the 'teacher' role
        $user->assignRole('teacher');

        return redirect()->route('teachers.create')->with('success', 'teacher account created successfully!');

    }
}
