<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/getting-started';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|max:191|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $name  = $data['first_name'].' '.$data['last_name'];

        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'name' => $name,
            'sex' => $data['sex'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)),
            'birthday' => $data['year'].'-'.$data['month'].'-'.$data['day'],
         ]);

    }
}
