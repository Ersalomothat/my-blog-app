<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthorChangePasswordForm extends Component
{
    public $current_password, $new_password, $confirm_password;
    function changePassword()
    {
        $this->validate([
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, User::find(auth('web')->id())->password)) {
                        return $fail(__('The current password is incorrect'));
                    }
                },
            ],
            'new_password' => 'required|min:5|max:25',
            'confirm_password' => 'same:new_password'
        ], [
            'current_password.required' => 'Enter your current password',
            'new_password.required' => 'Enter new password',
            'confirm_password.same' => 'must be same'
        ]);
        $query = User::find(Auth::user()->id)->update([
            'password' => Hash::make($this->new_password)
        ]);
        if ($query) {
            $this->showToastr('Your password has been updated successfully', 'success');
            $this->current_password = $this->new_password = $this->confirm_password = null;
        } else {
            $this->showToastr('Something went wrong', 'error');
        }
    }


    function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToaster', [
            'type' => $type,
            'message' => $message
        ]);
    }
    public function render()
    {
        return view('livewire.author-change-password-form');
    }
}
