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
    public function __construct($name, $message, $url)
    {
        $this->name = $name;
        $this->message = $message;
        $this->url = $url;
    }
    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->from('info@global-software.co.jp')
                    ->subject("グローバルホームページからのお知らせ")
                    ->view('mails.admin')
                    ->with([
                        'name' => $this->name ,
                        'url' => $this->url ,
                        'my_text' => $this->message ,
                    ]);
    }
}
