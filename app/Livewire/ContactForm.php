<?php

namespace App\Livewire;

use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:100')]
    public string $name = '';

    #[Validate('required|email|max:100')]
    public string $email = '';

    #[Validate('required|min:10|max:1000')]
    public string $message = '';

    public bool $success = false;

    public function send(): void
    {
        $this->validate();

        Mail::send(new ContactFormMail(
            name: $this->name,
            email: $this->email,
            message: $this->message
        ));

        $this->reset(['name', 'email', 'message']);
        $this->success = true;
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
