<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Score extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    
    public $name;
    public $message;
    public $question;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->message = $data['message'];
        $this->question = $data['question'];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.score')
        ->subject( ' Notification for '. $this->question);
    }
}
