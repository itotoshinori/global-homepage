<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Admin extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $message;
    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct($message, $id)
    {
        $this->message = $message;
        $this->id = $id;
    }
    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->from('info@titonet384.sakura.ne.jp')
                    ->subject("記事の新規登録がありました")
                    ->view('mails.admin')
                    ->with([
                        'id' => $this->id ,
                        'message'   => $this->message ,
                    ]);
    }
}
