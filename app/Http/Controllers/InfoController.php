<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInfoRequest;
use App\lib\My_func;
use App\Mail\Admin;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->class_func = new My_func();
        $this->name = "";
        $my_url = config('my-url.url');
        $this->my_url = $my_url;
        $this->to_email = "tnitoh@global-software.co.jp";
        $this->users =  User::orderBy('email')->where('registration', true)->get();
        $this->categories = array("お知らせ", "メニュー",  "リンク", "各種原紙","管理者メニュー","トップにリンクなし");
        $this->send_users = array("送付なし","管理者","正社員","在籍者");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authority_user = $this->class_func->login_user_authority(Auth::user());
        if ($request->alldis ==1 && $authority_user) {
            $infos = Info::orderBy('created_at', 'desc')->paginate(100);
        } else {
            $infos = Info::orderBy('created_at', 'desc')->where('category', 1)->paginate(10);
        }
        if ($request->alluserdis ==1 && $authority_user) {
            $users = User::orderBy('authority')->orderBy('email')->get();
        } else {
            $users = $this->users;
        }
        $user_count = count($users);
        $current_user = Auth::user();
        $authorities = array("管理者","一般","契約","退職");
        return view('infos.index', [
            'users' => $users,
            'infos' => $infos,
            'authorities'=> $authorities,
            'user_count' => $user_count,
            'current_user' => $current_user,
            'authority_user' => $authority_user,
            'class_func' => $this->class_func
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authority_user = $this->class_func->login_user_authority(Auth::user());
        if ($authority_user) {
            return view('infos.create', ['categories' => $this->categories,'authority_user' => $authority_user]);
        } else {
            return redirect()->route('infos.index')->with('danger', '権限がありません');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInfoRequest $request)
    {
        $create = $this->class_func->request_info_content($request);
        $image = $request->file('image');
        if (isset($image)) {
            // ファイルの保存とパスの取得
            $path =  $image->store('files', 'inside');
            $image = ltrim($path, 'files/');
            $create['image'] = $image;
            $request->file("image")->getClientOriginalName();
            $original_file_name = $request->file("image")->getClientOriginalName();
            $create['image_file_name'] = $original_file_name;
        }
        $current_user = Auth::user();
        $create['user_id'] = $current_user->id;
        //if ($request->replay == "on") {
        //$create['replay'] = 2;
        //}
        $result = Info::create($create);
        $info = Info::latest('id')->first();//メール送信用のために新規登録のid取得
        //$users =  User::orderBy('email')->where('authority', 1)->get();
        //メール本文に内容を表示させる
        $authority = $request->auth;
        $send_user = $this->send_users[$authority];
        $send_user = "{$send_user}　各位\n{$current_user->name} 殿";
        $users = User::where('authority', '<=', $authority)->get();
        if ($request->content_dis == "on") {
            $message = "{$info->title}\n$info->body";
        } else {
            $message = "「{$info->title}」\nの新規お知らせ情報の登録が社内ホームページにありました。\n下記URLをクリックしてご確認ください。";
        }
        if ($result && $this->my_url != "http://localhost" && $authority != "0") {
            $my_url = $this->my_url."/internal/infos/".$info->id;
            $plus_message = "";
            foreach ($users as $user) {
                //後で消す
                if ($request->content_dis=="on") {
                    //$plus_message = $this->start_user($user->email, $user->note);
                }
                Mail::to($user->email)->send(new Admin("{$send_user}", $message.$plus_message, $my_url));
            }
        }
        if ($result) {
            return redirect()->route('infos.show', $info->id)
                            ->with('success', '新規作成しました。');
        } else {
            return redirect()->route('infos.index')
                            ->with('danger', '新規作成に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $authority_user = $this->class_func->login_user_authority(Auth::user());
        $info = Info::find($id);
        if ($info == null) {
            return redirect()->route('infos.index')
                            ->with('danger', '該当のページは存在しません');
        }
        $current_user = Auth::user();
        $reader =  $info->reader;
        $name = $current_user->name;
        $reader_count = 0;
        if (str_contains($reader, $name) == false && is_null($reader)) {
            $info->reader = $name;
            $info->save();
        } elseif (str_contains($reader, $name) == false) {
            $info->reader = $reader.",".$name;
            $info->save();
        }
        if (str_contains($info->reader, $name) == false && isset($info->reader)) {
            $reader_count = 1;
        } elseif (isset($info->reader)) {
            $reader_count = substr_count($info->reader, ",") + 1;
        }
        return view('infos.show', [
        'info' => $info,
        'class_func' => $this->class_func,
        'authority_user' => $authority_user,
        'reader_count' => $reader_count
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *bnm
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(Info $info)
    {
        $authority_user = $this->class_func->login_user_authority(Auth::user());
        if ($authority_user) {
            return view('infos.edit', compact('info'), ['categories' => $this->categories,'authority_user' => $authority_user]);
        } else {
            return redirect()->route('infos.index')->with('danger', '権限がありません');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInfoRequest $request, Info $info)
    {
        $update = $this->class_func->request_info_content($request);
        $image = $request->file('image');
        if (isset($image)) {
            $path =  $image->store('files', 'inside');
            $image = ltrim($path, 'files/');
            $update['image'] = $image;
            $original_file_name = $request->file("image")->getClientOriginalName();
            $update['image_file_name'] = $original_file_name;
            //前回ファイル削除
            Storage::disk('inside')->delete("/files/".$info->image);
        }
        $result = $info->update($update);
        $authority = $request->auth;
        $current_user = Auth::user();
        $send_user = $this->send_users[$authority];
        $send_user = "{$send_user} 各位\n{$current_user->name} 殿";
        $users = User::where('authority', '<=', $authority)->get();
        if ($request->content_dis=="on") {
            $message = "{$info->title}\n{$info->body}";
        } else {
            $message = "「{$info->title}」\nのお知らせ情報の更新がありました。\n下記URLをクリックしてご確認ください。";
        }
        if ($result && $this->my_url != "http://localhost" && $authority != "0") {
            $my_url = $this->my_url."/internal/infos/".$info->id;
            $plus_message = "";
            foreach ($users as $user) {
                if ($request->content_dis == "on") {
                    //後で消す
                    //$plus_message = $this->start_user($user->email, $user->note);
                    //
                }
                Mail::to($user->email)->send(new Admin("{$send_user}", $message.$plus_message, $my_url));
            }
        }
        if ($result) {
            return redirect()->route('infos.show', $info->id)
                            ->with('success', '更新しました');
        } else {
            return redirect()->route('infos.index')
                            ->with('danger', '更新に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Info $info)
    {
        $result = $info->delete();
        if ($result) {
            return redirect()->route('infos.index')
                                ->with('success', '削除しました');
        } else {
            return redirect()->route('infos.show', $info->id)
                                ->with('danger', '削除に失敗しました');
        }
    }
    public function download(int $id)
    {
        $info = Info::find($id);
        $filePath = "inside/files/{$info->image}";
        if ($info->image_file_name) {
            return Storage::download($filePath, $info->image_file_name);
        } else {
            return Storage::download($filePath);
        }
    }
    public function send_mail(Request $request, int $id)
    {
        $info = Info::find($id);
        $current_user = Auth::user();
        $introduce = "社内ホームページ「{$info->title}」にメッセージがありました\n投稿者：{$current_user->name}　殿\nアドレス：{$current_user->email}";
        $introduce_tosender = "{$current_user->name} 様\n下記にてメールを送信しましたので返信をお待ち下さい";
        $message = $request->message;
        $my_url = config('my-url.url')."/internal/infos/{$info->id}";
        if ($this->my_url != "http://localhost") {
            //管理者全員に返信する設定の場合
            if ($info->replay == 1) {
                $users =  User::orderBy('email')->where('authority', 1)->get();
                foreach ($users as $user) {
                    $introduce = "管理者各位\n".$introduce;
                    Mail::to($user->email)->send(new Admin($introduce, $message, $my_url));
                }
            //投稿者のみに返信する設定の場合
            } elseif ($info->replay == 2) {
                $introduce = "投稿者　殿\n".$introduce;
                Mail::to($info->user->email)->send(new Admin($introduce, $message, $my_url));
            }
            //送信者が管理者以外の場合の送信控え
            if ($current_user->authority != 1) {
                Mail::to($current_user->email)->send(new Admin($introduce_tosender, $message, $my_url));
            }
        }
        return redirect()->route('infos.show', $info->id)
                            ->with('success', "{$info->title}に関してコメントをメール送信しました");
    }
    public function start_user($email, $note)
    {
        $plus_message1 = "\n\nログイン情報\nEmail:{$email}\n初期パスワード:{$note}";
        $plus_message2 = "\n社内ホームページ\nhttps://global-software.jp/internal/infos";
        $plus_message3 = "\nログインできない場合はログイン画面の Forgot your password? をクリックしてパスワードを変更して下さい";
        $plus_message4 = "\n※初期パスワードは必ず変更して下さい";
        return $plus_message1.$plus_message2.$plus_message3.$plus_message4;
    }
}
