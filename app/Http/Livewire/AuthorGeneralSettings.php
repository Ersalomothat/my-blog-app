<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;

class AuthorGeneralSettings extends Component
{
    public $settings;
    public $blog_name, $blog_email, $blog_desc;
    public function render()
    {
        return view('livewire.author-general-settings');
    }
    public function mount()
    {
        $this->settings = Setting::find(1);
        $this->blog_name = $this->settings->blog_name ?? '';
        $this->blog_email = $this->settings->blog_email ?? '';
        $this->blog_desc = $this->settings->blog_desc ?? '';
    }

    function updateGeneralSettings()
    {
        $this->validate([
            'blog_name' => 'required',
            'blog_email' => 'required|email',
            'blog_desc' => 'required'
        ]);
        $update = $this->settings->update([
            'blog_name' => $this->blog_name,
            'blog_email' => $this->blog_email,
            'blog_desc' => $this->blog_desc,

        ]);
        if ($update) {
            $this->showToastr("General settings have been successfully updated", "success");
            $this->emit('updateAuthorFooter');
        } else {
            $this->showToastr("General settings have not been updated", "error");
        }
    }

    function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message
        ]);
    }
}
