<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin;

class AdoptionController extends Controller
{
    public function send(Request $request)
    {
        $introduce = $request->name."様よりホームページ採用のページから面談の申し込みがありました\nemail:".$request->email."\n電話番号:".$request->tel;
        $message = $request->message;
        $my_url = config('my-url.url');
        $to_email = "tnitoh@global-software.co.jp";
        if ($my_url=="http://global-asagaya.tk") {
            Mail::to($to_email)->send(new Admin($introduce, $message, $my_url));
        }
        return redirect("articles/5?dis=true")->with('success', '送信完了しました。返信まで少々お待ち下さい。');
    }
}
