<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;


class AuthorPersonalDetails extends Component
{
    public
        $author,
        $name,
        $email,
        $username,
        $biography;
    function mount()
    {
        $this->author = User::find(auth('web')->id());
        $this->name = $this->author->name;
        $this->email = $this->author->email;
        $this->username = $this->author->username;
        $this->biography = $this->author->biography;
    }

    public function render()
    {
        return view('livewire.author-personal-details');
    }
    function updateDetails()
    {
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username,' . auth('web')->id()
        ]);
        User::where('id', auth('web')->id())->update([
            'name' => $this->name,
            'username' => $this->username,
            'biography' => $this->biography
        ]);
        $this->emit('UpdateAuthorProfileHeader');
        $this->emit('UpdateTopHeader');
        $this->showToastr('Your Profile info have been successfully updated', 'info');
        // $this->resetForm();

    }
    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message
        ]);
    }


    private function resetForm()
    {
        $this->name = "";
        $this->email = "";
        $this->username = "";
        $this->biography = "";
    }
}
