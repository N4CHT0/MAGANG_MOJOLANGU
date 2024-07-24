<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

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
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:20'],
            'jenis_kelamin_lainnya' => ['nullable', 'string'],
            'nik' => ['required', 'string', 'max:16'],
            'rt' => ['required', 'string', 'max:16'],
            'rw' => ['required', 'string', 'max:16'],
            'alamat' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'jenis_kelamin' => $data['jenis_kelamin'] === 'Lainnya' ? $data['jenis_kelamin_lainnya'] : $data['jenis_kelamin'],
            'nik' => $data['nik'],
            'alamat' => $data['alamat'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
