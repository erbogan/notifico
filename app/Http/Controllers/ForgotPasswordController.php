<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\CustomResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('forget.password.confirm')
                ->withErrors(['email' => 'Diese E-Mail-Adresse ist nicht registriert.']);
        }

        $token = Password::createToken($user);

        $user->notify(new CustomResetPassword($token, $user->email));

        return redirect()->route('forget.password.confirm')
            ->with('status', 'E-Mail zum Zurücksetzen wurde gesendet.');
    }

}
