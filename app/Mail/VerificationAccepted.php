<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $locale;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string|null  $locale
     * @return void
     */
    public function __construct($user, $locale = null)
    {
        $this->user = $user;
        // If no locale specified, use user's locale or fallback to 'ar'
        $this->locale = $locale ?? ($user->lang ?? 'ar');
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(
            $this->locale === 'en'
                ? 'Identity Verification Successful'
                : 'تم التحقق من الهوية بنجاح'
        )
            ->view('emails.verification_accepted')
            ->with([
                'user' => $this->user,
                'locale' => $this->locale,
            ]);
    }
}
