<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $userEmail; // للإيميل اللي بيستقبل الرسالة
    public $locale; // للغة

    /**
     * Create a new message instance.
     */
    public function __construct(string $token, string $userEmail, string $locale = 'ar')
    {
        $this->token = $token;
        $this->userEmail = $userEmail;
        $this->locale = $locale;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // استخدم Lang::get() لجلب الموضوع المترجم
        $subject = Lang::get('messages.password_reset_subject', [], $this->locale);

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
            view: 'emails.password-reset', // سننشئ هذا الـ view
            with: [
                'resetUrl' => env('FRONTEND_URL') . '/reset-password?token=' . $this->token . '&email=' . $this->userEmail,
                'locale' => $this->locale,
                'userEmail' => $this->userEmail, // يمكن استخدامها في القالب
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
