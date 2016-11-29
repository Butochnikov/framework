<?php
namespace SleepingOwl\Framework\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use SleepingOwl\Framework\Contracts\Routing\Router;
use SleepingOwl\Framework\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->redirectTo = backend_url('/');
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return themeView('auth.login');
    }
}
