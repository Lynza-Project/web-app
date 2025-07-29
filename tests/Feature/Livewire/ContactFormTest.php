<?php

use App\Livewire\ContactForm;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('contact form component can render', function () {
    Livewire::test(ContactForm::class)
        ->assertStatus(200);
});

test('contact form validates input', function () {
    Livewire::test(ContactForm::class)
        ->set('name', '')
        ->set('email', 'not-an-email')
        ->set('message', 'too short')
        ->call('send')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'email',
            'message' => 'min',
        ]);
});

test('contact form sends email and resets form on success', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('message', '')
        ->assertSet('success', true);

    Mail::assertSent(ContactFormMail::class, function ($mail) {
        return $mail->name === 'Test User' &&
               $mail->email === 'test@example.com' &&
               $mail->message === 'This is a test message that is long enough to pass validation.';
    });
});
