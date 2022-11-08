<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthForgotForm extends Component
{
    public $email;
    function forgotHandler()
    {

        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The email is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The email is not registered'
        ]);
        //create a new token to be sent to the user.
        // DB::table('password_resets')->insert([
        //     'email' => $request->email,
        //     'token' => str_random(60), //change 60 to any length you want
        //     'created_at' => Carbon::now()
        // ]);

        // $tokenData = DB::table('password_resets')
        // ->where('email', $request->email)->first();
        // $token = base64_decode(Str::random(64));
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $this->email,
            // 'token' => $token,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $user = User::where('email', $this->email)->first();
        $link = route('author/reset-form', ['token' => $token, 'email' => $this->email]);


        // $bodyMessage = "We're received a request to reset the password for <b>{{Auth::user()->name}} account assosiated with</b>" . $this->email . ".<br>";
        $bodyMessage = "We're received a request to reset the password for <b> account assosiated with</b>" . $this->email . ".<br>";
        $bodyMessage .= '<a href="' . $link . '" target="_blank" style="color:#FFF; border-color:#22bc66; border-style:solid;border-width:10px 180px;background-color:#22bc66;display:inline-block; text-decoration:none; border-radius:3px;box-shadow:0 2px 3px rgba(0,e,0,0.16);-webkit-text-size-adjust:none;box-sizing:border-box">Reset Password</a>';
        $bodyMessage .= "<br>";
        $bodyMessage .= "If you did not request forapassword reset, please ignore this email";

        $data = array(
            'name' => $user->name,
            'bodyMessage' => $bodyMessage
        );
        try {
            Mail::send('forgot-email-template', $data, function ($message) use ($user) {
                $message->from('noreply@example.com', 'Larablog');
                $message->to($user->email, $user->name)
                    ->subject('Reset Passwor');
            });
            $this->email = null;
            session()->flash('success', "We have e-mailed your password reset");
        } catch (\Exception $e) {
            session()->flash('failure', "We're sorry there something went wrong!");
            $this->dispatchBrowserEvent('redirectFail', [
                'status' => 'error',
                'code' => 404,
                'message' => 'Something went wrong'
            ]);
        }
    }
    public function redirectFail()
    {
    }

    public function render()
    {
        return view('livewire.auth-forgot-form');
    }
}
