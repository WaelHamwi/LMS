<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;

class EmailVerification extends Controller
{
    public function verify($token)
    {
        $pendingUser = PendingUser::where('verification_token', $token)->first();

        if ($pendingUser) {
            $user = User::create([
                'name' => $pendingUser->name,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
            ]);

            auth()->login($user);
            $pendingUser->delete();

            Session::regenerate();
            return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Invalid or expired verification token.']);
        }
    }
}
