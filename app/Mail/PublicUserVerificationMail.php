<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublicUserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verify Your Email - MySebenarnya')
                    ->view('manageUser.verify_public_user')
                    ->with([
                        'name' => $this->user->PublicName,
                        'url' => url('/verify/' . $this->user->remember_token), // or $user->verification_token if you use that
                    ]);
    }
}
