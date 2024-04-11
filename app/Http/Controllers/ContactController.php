<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin;
use Illuminate\Support\Facades\Log;
use App\Consts\NumConst;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $file_list = NumConst::LIST[$request->random_number];
        if ($request->img_num == $file_list['num']) {
            $request = $request->merge(['imgnumber' => 'OK']);
        } else {
            $request = $request->merge(['imgnumber' => null]);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'imgnumber' => 'required',
            'message' => 'required',
        ]);
        $file_list = NumConst::LIST[$request->random_number];
        $introduce = $request->name . "様より\nホームページお問合せページからメッセージがありました\nアドレス：" . $request->email . "\n電話番号：" . $request->tel;
        $introduce_tosender = $request->name . " 様\n下記にてメールを送信しました\nアドレス：" . $request->email . "\n電話番号：" . $request->tel;
        $message = $request->message;
        $my_url = config('my-url.url');
        $users = User::where('authority', '<=', 1)->get();
        if ($my_url != "http://localhost") {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new Admin($introduce, $message, $my_url));
            }
            //送信者にも控えを送付する
            Mail::to($request->email)->send(new Admin($introduce_tosender, $message, $my_url));
        }
        $message_status = 'success';
        $message = '送信に成功しました';
        return redirect()->route('articles.index')->with($message_status, $message);
    }
}
