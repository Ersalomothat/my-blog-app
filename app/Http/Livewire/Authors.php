<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Authors extends Component
{
    public $name, $email, $username, $author_type, $publisher;
    public $search, $perPage = 4, $selected_author_id, $blocked = 0;
    protected $listeners = [
        'resetForm',
        'deleteAuthorAction'
    ];
    use WithPagination;
    public function mount()
    {
        $this->resetForm();
    }
    public function resetForm()
    {
        $this->name = $this->email = $this->username = $this->author_type = $this->publisher = null;
        $this->resetErrorBag();
    }
    public function render()
    {
        return view('livewire.authors', [
            'authors' => User::search(trim($this->search))
                ->where('id', '!=', auth()->id())->paginate($this->perPage),
        ]);
    }

    public function updateAuthor()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->selected_author_id,
            'username' => 'required|min:6|unique:users,username,' . $this->selected_author_id
        ]);
        if ($this->selected_author_id) {
            $author = User::find($this->selected_author_id);
            $author->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                // 'type' => $this->author_type,
                'blocked' => $this->blocked,
                // 'direct_publish' => $this->publisher
            ]);
            $this->showToastr('Author berhasil diupdate successfully updated', 'success');
            $this->dispatchBrowserEvent('hide_edit_author_modal');
        }
    }
    public function deleteAuthor($author)
    {
        $this->dispatchBrowserEvent('deleteAuthor', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete this author:<br><b>' . $author["name"] . "</b>",
            'id' => $author['id'],
        ]);
    }
    public function deleteAuthorAction($id)
    {
        $author = User::find($id);
        $path = "back/dist/img/authors/";
        $author_pic = $author->getAttributes()['picture'];
        $author_full_pic = $path . $author_pic;
        if ($author_pic != null || File::exists(public_path($author_full_pic))) {
            File::delete(public_path($author_full_pic));
        }
        $author->delete();
        $this->showToastr('Author has been deleted', 'success');
    }
    public function editAuthor($author)
    {
        $this->selected_author_id = $author['id'];
        $this->name = $author['name'];
        $this->email = $author['email'];
        $this->username = $author['username'];
        $this->direct_publish = $author['direct_publish'];
        $this->blocked = $author['blocked'];
        $this->dispatchBrowserEvent('showEditAuthorModal');
    }
    public function isOnline($site = 'https://youtube.com'): bool
    {
        if (@fopen($site, 'r')) {
            return true;
        }
        return false;
    }
    function addAuthor()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|min:6|max:20',
            'username' => 'required|unique:users|min:6|max:20',
            'author_type' => 'required',
            'publisher' => 'required'
        ], []);

        if ($this->isOnline()) {
            $default_pass = Random::generate(8);
            $author = new User;
            $author->name = $this->name;
            $author->email = $this->email;
            $author->username = $this->username;
            $author->type = $this->author_type;
            $author->picture = '';
            $author->biography = '';
            $author->blocked = $this->blocked;
            $author->direct_publish = $this->publisher;
            $author->password = $default_pass;
            $save = $author->save();

            $data = array(
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => $default_pass,
                'url' => route('author/profile'),
            );

            $author_email = $this->email;
            $author_name = $this->name;

            if ($save) {
                // Mail::send('new-author-email-template', $data, function ($message) use ($author_email, $author_name) {
                //     $message->from('noreply@gmail.com');
                //     $message->to($author_email, $author_name)
                //         ->subject('Account creation');
                // });
                $mail_body = view('new-author-email-template', $data)->render();
                $email_config = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $author_email,
                    'mail_recipient_name' => $author_name,
                    'mail_subject' => 'Reset Password',
                    'mail_body' => $mail_body,
                );
                sendEmail($email_config);
                $this->showToastr('New author has been added', 'success');
                $this->dispatchBrowserEvent('hide_add_author_modal');
            } else {
                $this->showToastr('somwthing went wrong', 'error');
                $this->name = $this->email = $this->username = $this->author_type = $this->publisher = null;
                $this->dispatchBrowserEvent('hide_add_author_modal');
            }
        } else {
            $this->showToastr('Youre not onlinne', 'error');
        }
    }
    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message,
        ]);
    }
}
