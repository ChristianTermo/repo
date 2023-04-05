<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginMail;
use App\Models\AuthToken;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', '=', $request['email'])->first();
        if (Auth::loginUsingId($user->id)) {
            $token = Str::random(6);

            DB::table('auth_tokens')->insert([
                'token' => $token,
                'expires_at' => Carbon::now()->addHours(2),
                'email_associated' => $request->input('email'),
            ]);
    
            Mail::to($request->email)->send(new LoginMail($token));
    
            return redirect('validate');
        } else {
            return redirect('login')->withErrors('credenziali errate');
        };      
    }

    public function getValidation()
    {
        return view('ValidationToken');
    }

    public function validateToken(Request $request, User $user)
    {
        $request->validate([
            'token' => 'required',
        ]);
        $token = AuthToken::where('token', '=', $request['token'])->where('expires_at', '>', Carbon::now());
        $tokenString = AuthToken::where('token', '=', $request['token'])->where('expires_at', '>', Carbon::now())->value('token');
        $email_associated = AuthToken::where('token', '=', $request['token'])->value('email_associated');

        $id = User::where('email', '=', $email_associated)->value('id');
        $role = User::where('email', '=', $email_associated)->value('role');

        if ($token) {
            if ($role == 'admin') {
                $token->delete();
                return redirect('getPanel');
            } elseif ($role == 'player') {
                $token->delete();
                return redirect()->route('index');
            }
        } else {
            return redirect('validate')->withErrors('token inesistente o scaduto');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
