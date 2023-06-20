<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $link;
    public function __construct($user, $link)
    {
        $this->user = $user;
        $this->link = $link;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cấp lại mật khẩu')
        ->view('email.email_reset_password')
        ->with([
            'user' => $this->user,
            'link' => $this->link
        ]);
    }
}
