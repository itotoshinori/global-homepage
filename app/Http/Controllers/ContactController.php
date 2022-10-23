<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $introduce = $request->name."様<".$request->email.">(".$request->tel.")様より";
        $message = $request->message;
        $my_url = config('my-url.url');
        $to_email = "tnitoh@global-software.co.jp";
        if ($my_url=="http://global-asagaya.tk") {
            Mail::to($to_email)->send(new Admin($introduce, $message, $my_url));
        }
        return redirect("articles/4")->with('success', '送信完了しました。少々お待ち下さい。');
    }
}
