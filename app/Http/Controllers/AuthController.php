<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,artist',
        ]);

        // Handle artist role
        if ($credentials['role'] === 'artist') {
            // Check if artist exists with correct role
            $artist = User::where('email', $credentials['email'])
                         ->where('role', 'artist')
                         ->first();

            if ($artist) {
                // If artist exists, attempt normal login
                if (Auth::attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password']
                ], $request->boolean('remember'))) {
                    
                    $request->session()->regenerate();
                    return redirect()->intended('/artist/dashboard');
                } else {
                    // Password incorrect
                    throw ValidationException::withMessages([
                        'email' => __('auth.failed'),
                    ]);
                }
            } else {
                // Artist not found - create a real artist account
                $newArtist = User::create([
                    'name' => 'Artist User',
                    'email' => $credentials['email'],
                    'password' => bcrypt($credentials['password']), // Use the provided password
                    'role' => 'artist',
                ]);

                // Login the newly created artist
                Auth::login($newArtist, $request->boolean('remember'));
                $request->session()->regenerate();
                
                return redirect()->intended('/artist/dashboard');
            }
        }

        // Admin login
        if ($credentials['role'] === 'admin') {
            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ], $request->boolean('remember'))) {

                $request->session()->regenerate();
                $user = Auth::user();

                // Check if user has admin role
                if ($user->role === 'admin') {
                    return redirect()->intended('/admin/dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors([
                        'role' => 'You do not have admin access.',
                    ]);
                }
            }

            // Admin failed authentication
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login'); // Changed from '/' to '/login'
    }
}