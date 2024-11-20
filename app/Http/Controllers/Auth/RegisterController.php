<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date',
        ]);

        // Check age
        $birthDate = $request->birth_date;
        $age = \Carbon\Carbon::parse($birthDate)->age;
        if ($age < 13) {
            return back()->withErrors(['birth_date' => 'Sorry, you are too young to create an account.'])->withInput();
        }

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'aura' => 0,
            //'profile_picture' => null, // user can't add a profile picture for now
            'created' => now(),
            'deleted' => false,
            'is_mod' => false,
        ]);

        auth()->login($user);
        return redirect('/');
    }
}
?>