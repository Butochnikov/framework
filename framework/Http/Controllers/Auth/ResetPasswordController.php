<?php
namespace SleepingOwl\Framework\Http\Controllers\Auth;

use Illuminate\Http\Request;
use SleepingOwl\Framework\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('guest:backend');
    }

    /**
     * {@inheritdoc}
     */
    public function showResetForm(Request $request, $token = null)
    {
        return themeView('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
