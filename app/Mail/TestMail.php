<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $params;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject( $this->params['subject'] );
        $this->from( $this->params['fromMail'], $this->params['fromName'] );
        $this->to( $this->params['toMail'], $this->params['toName'] );

        $this->view('mail.test');
        $this->with(['params' => $this->params,]);
        
        return $this;
    }
}
