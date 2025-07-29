<?php

namespace Tests\Unit\Mail;

use App\Mail\ContactFormMail;
use PHPUnit\Framework\TestCase;

class ContactFormMailTest extends TestCase
{
    public function test_envelope_contains_correct_data()
    {
        $name = 'John Doe';
        $email = 'john.doe@example.com';
        $message = 'This is a test message';

        $mail = new ContactFormMail($name, $email, $message);
        $envelope = $mail->envelope();

        $this->assertEquals('Nouveau message depuis le formulaire de contact', $envelope->subject);
        $this->assertEquals('louisreynard919@gmail.com', $envelope->to[0]->address);
        $this->assertEquals($email, $envelope->replyTo[0]->address);
    }

    public function test_content_contains_correct_data()
    {
        $name = 'John Doe';
        $email = 'john.doe@example.com';
        $message = 'This is a test message';

        $mail = new ContactFormMail($name, $email, $message);
        $content = $mail->content();

        $this->assertEquals('emails.contact-form', $content->view);
        $this->assertEquals($message, $content->with['messageContent']);
    }

    public function test_attachments_returns_empty_array()
    {
        $name = 'John Doe';
        $email = 'john.doe@example.com';
        $message = 'This is a test message';

        $mail = new ContactFormMail($name, $email, $message);
        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertEmpty($attachments);
    }
}
