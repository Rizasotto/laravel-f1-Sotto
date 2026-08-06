<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:buyer,artist'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create cart for buyer
        if ($user->role === 'buyer') {
            Cart::create(['user_id' => $user->id]);
        }

        auth()->login($user);

        // Redirect based on role
        if ($user->role === 'artist') {
            return redirect()->route('artist.dashboard')->with('success', 'Welcome! Create your first artwork!');
        } else {
            return redirect()->route('buyer.dashboard')->with('success', 'Welcome! Start browsing artworks!');
        }
    }
}
