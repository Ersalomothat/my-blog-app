<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthorLoginForm extends Component
{
    public $password, $login_id; //$email had been deleted
    public $returnUrl; //ketika user mengclick Cart padahal belum login, ketika login maka akan di lanjutkan ke cart lagi

    public function mount()
    {
        $this->returUrl = request()->returnUrl;
    }

    public function loginHandler()
    {

        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $this->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:8'
            ], [
                'login_id.required' => 'Enter your email or username correctly',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'This email is not registered',
                'password.required' => 'Enter your password | required'
            ]);
        } else {
            $this->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:8'
            ], [
                'login_id.required' => 'Enter your username',
                'login_id.username' => 'Invalid username',
                'login_id.exists' => 'This username is not registered',
                'password.required' => 'Enter your password'
            ]);
        }

        $user = array($fieldType => $this->login_id, 'password' => $this->password);

        if (Auth::guard('web')->attempt($user)) {
            $checkUser = User::where($fieldType, $this->login_id)->first();
            if ($checkUser->blocked == 1) {
                Auth::guard('web')->logout();
                return redirect()->route('author/login')->with('failed', 'your account had been deleted');
            } else {
                return redirect()->route('author/home');
                if ($this->returnUrl != null) {
                    return redirect()->to($this->returnUrl);
                }
                return to_route('author.home');
            }
        } else {
            session()->flash('failed', 'Invalid username,email or password');
        }

        // $this->validate(
        //     [
        //         'emsail' => 'required|email|exists:users,email',
        //         'password' => 'required|min:8'
        //     ],
        //     [
        //         // 'email.required' => 'Enter your email address correctly',
        //         'email.email' => 'Invalid email address',
        //         'email.exists' => 'This email address already exists',
        //         'password.required' => 'Enter your password'
        //     ]
        // );

        // $user = array('email' => $this->email, 'password' => $this->password);

        // if (Auth::guard('web')->attempt($user)) {
        //     $checkUser = User::where('email', $this->email)->first();
        //     if ($checkUser->blocked == 1) {
        // Auth::where('email', $this->email)->first(); chooose 1 or 2
        // Auth::guard('web')->logout();
        //         return redirect()->route('author/login')->with('failed', 'your account had been deleted');
        //     } else {
        //         return redirect()->route('author/home');
        //     }
        // } else {
        //     session()->flash('failed', 'Incorrect username or password');
        // }
    }
    public function render()
    {
        return view('livewire.author-login-form');
    }
}
