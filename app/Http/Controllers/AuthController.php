<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        if (!$request->session()->has('captcha_answer')) {
            $firstNumber = random_int(1, 9);
            $secondNumber = random_int(1, 9);
            $request->session()->put([
                'captcha_question' => $firstNumber.' + '.$secondNumber,
                'captcha_answer' => (string) ($firstNumber + $secondNumber),
            ]);
        }

        return view('auth.login', ['captchaQuestion' => $request->session()->get('captcha_question')]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $captcha = $request->validate(['captcha' => ['required', 'string']])['captcha'];

        if ($captcha !== $request->session()->pull('captcha_answer')) {
            return back()->withErrors(['captcha' => 'Jawaban CAPTCHA salah.'])->onlyInput('email');
        }
        $request->session()->forget('captcha_question');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
