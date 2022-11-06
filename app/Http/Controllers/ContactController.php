<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $introduce = $request->name."様より\nホームページお問合せページからメッセージがありました\nアドレス：".$request->email."\n電話番号：".$request->tel;
        $introduce_tosender = $request->name." 様\n下記にてメールを送信しましたので返信をお待ち下さい\nアドレス：".$request->email."\n電話番号：".$request->tel;
        $message = $request->message;
        $my_url = config('my-url.url');
        $users = User::all();
        if ($my_url != "http://localhost") {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new Admin($introduce, $message, $my_url));
                //Mail::to($request->email)->send(new Admin($introduce_tosender, $message, $my_url));
            }
            //送信者にも控えを送付する
            Mail::to($request->email)->send(new Admin($introduce_tosender, $message, $my_url));
        }
        return redirect("contact")->with('success', '送信完了しました。返信まで少々お待ち下さい。');
    }
}
