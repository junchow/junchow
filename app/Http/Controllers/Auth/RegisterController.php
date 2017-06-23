<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use app\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username'=>'required|max:255',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username'=>$data['username'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])
        ]);
    }
}