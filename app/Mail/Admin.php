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
    public function __construct($m, $url)
    {
        $this->message = $m;
        $this->url = $url;
    }
    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->from('info@titonet384.sakura.ne.jp')
                    ->subject("グローバルホームページからのお知らせ")
                    ->view('mails.admin')
                    ->with([
                        'url' => $this->url ,
                        'my_text'   => $this->message ,
                    ]);
    }
}
