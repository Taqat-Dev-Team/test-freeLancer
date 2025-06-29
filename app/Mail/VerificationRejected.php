<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationRejected extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $reason;
    public $locale;

    public function __construct($user, $locale = null, $reason = null)
    {
        $this->user = $user;
        // If no locale specified, use user's locale or fallback to 'ar'
        $this->locale = $locale ?? ($user->lang ?? 'ar');
        $this->reason = $reason ?? 'No specific reason provided';
    }


    public function build()
    {
        return $this->subject(
            $this->locale === 'en'
                ? 'Identity Verification Rejected'
                : 'تم رفض التحقق من الهوية'
        )
            ->view('emails.verification_rejected')
            ->with([
                'user' => $this->user,
                'locale' => $this->locale,
            ]);
    }


}
