<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendMail extends Mailable
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
        if ($this->params['description'] == 'send') {

            $this->subject('Picktime 驗證碼'); //標題
            $this->view('mail.sendLetter');   //夾帶內容
            // $this->from('yang.li@sonet-tw.net.tw', ''); //誰寄的
            $this->from('picktime@so-net.net.tw', ''); //誰寄的
            $this->with(['params' => $this->params,]); //內容
            $this->to($this->params['mail']); //寄給誰 名子

            return $this;
        } else {
            $this->view('mail.receivingLetter');   //夾帶內容
            if ($this->params['mail'] != "" || $this->params['mail'] != NULL) {
                $this->subject('問題回報'); //標題
                $this->from($this->params['mail'], ''); //誰寄的
            } else {
                $this->subject('意見回饋'); //標題
                $this->from('picktime@so-net.net.tw', ''); //誰寄的
            }
            $this->with(['params' => $this->params]); //內容
            $this->to('picktime@so-net.net.tw'); //寄給誰 名子 +
            // $this->to('yang.li@sonet-tw.net.tw'); //寄給誰 名子 -

            return $this;
        }
    }
}
