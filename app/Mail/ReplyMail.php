<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class ReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replyText;
    public $locale;
    public $userName;
    /**
     * Create a new message instance.
     */
    public function __construct($replyText, $locale = 'ar', $userName = null)
    {
        $this->replyText = $replyText;
        $this->locale = $locale;
        $this->userName = $userName;
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
            view: 'emails.reply', // استخدام القالب المعدل للرد
            with: [
                'replyText' => $this->replyText,
                'locale' => $this->locale,
                'userName' => $this->userName,
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
