<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostAnswers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    
        Public $name;
        Public $classTitle;
        Public $email;
        Public $data;
        Public $counts;

    
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->classTitle = $data['classTitle'];
        $this->email = $data['email'];
        $this->data = $data['data'];
        $this->counts = $data['counts'];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.post-answers')
        ->subject( $this->classTitle.' Answer');
    }
}



