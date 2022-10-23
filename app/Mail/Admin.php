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
    public function __construct($m, $id)
    {
        $this->message = $m;
        $this->id = $id;
    }
    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->from('info@titonet384.sakura.ne.jp')
                    ->subject("コメントがありました")
                    ->view('mails.admin')
                    ->with([
                        'id' => $this->id ,
                        'my_text'   => $this->message ,
                    ]);
    }
}
