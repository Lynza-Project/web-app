<?php

namespace App\Livewire;

use App\Mail\SupportFormMail;
use App\Mail\SupportFormConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SupportForm extends Component
{

    #[Validate('required|min:3|max:100')]
    public string $title = '';

    #[Validate('required|min:10|max:1000')]
    public string $description = '';

    #[Validate('required|in:bug,improvement,question')]
    public string $category = '';

    #[Validate('required|email|max:100')]
    public string $email = '';

    public bool $success = false;

    public function mount(): void
    {
        $this->email = auth()->user()->email;
    }

    public function send(): void
    {
        $this->validate();

        Mail::send(new SupportFormMail(
            title: $this->title,
            description: $this->description,
            category: $this->category,
            email: $this->email
        ));

        Mail::send(new SupportFormConfirmation(
            email: $this->email,
            title: $this->title
        ));

        $this->reset(['title', 'description', 'category']);
        $this->email = auth()->user()->email;
        $this->success = true;
    }

    public function render(): View
    {
        return view('livewire.support-form');
    }
}
