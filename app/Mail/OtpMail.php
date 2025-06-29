<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $locale;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otpCode, string $locale = 'ar', string $userName = null)
    {
        $this->otpCode = $otpCode;
        $this->locale = $locale;
        $this->userName = $userName; // إذا كنت تريد تمرير اسم المستخدم
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = Lang::get('messages.otp_subject', [], $this->locale);

        return new Envelope(
            subject: $subject,

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp', // القالب هو نفسه، والمنطق داخل القالب
            with: [
                'otpCode' => $this->otpCode,
                'locale' => $this->locale,
                 'userName' => $this->userName, // إذا كنت تمرر اسم المستخدم
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
