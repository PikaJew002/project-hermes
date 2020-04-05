<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\User;
use App\Family;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([
          'login', 'register'
        ]);
    }

    /**
     * Registers a new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        if($request->filled('family_name')) {
            $family = new Family;
            $family->admin_id = $user->id;
            $family->name = $request->input('family_name');
            $family->save();
        }
        $this->guard()->login($user);

        return response()->json(['user'=> $user, 'message'=> 'registration successful'], 200);
    }

    /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'family_name' => ['nullable', 'string', 'max:255'],
          ]);
    }

    /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\User
    */
    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
          ]);
    }

    protected function guard() {
        return Auth::guard();
    }

    /**
     * Logs in the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json(['user' => Auth::user(), 'message' => 'Login successful'], 200);
        }
    }

    /**
     * Gets the currently logged in user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request) {
        if(Auth::check()) {
            return response()->json(['user' => Auth::user()], 200);
        } else {
            return response()->json(['message' => 'Not logged in'], 403);
        }
    }

    /**
     * Logs out the current user
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
