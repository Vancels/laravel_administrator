<?php

namespace Vancels\Administrator\Auth;

use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use App\Http\Controllers\Controller;
use Vancels\Administrator\Models\AdminUser;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';
    protected $guard = 'admin';
    protected $loginView = 'administrator::auth.login';
    protected $registerView = 'administrator::auth.register';

    public function __construct()
    {
        $this->middleware($this->getMiddleware(), ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view($this->loginView);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:admins',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return AdminUser::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}