<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check the user's role and redirect to the corresponding dashboard
        if ($user->role->role_name == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->role_name == 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role->role_name == 'student') {
            return redirect()->route('student.dashboard');
        }

        // Default redirection if no specific role matches
        return redirect('/home');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
