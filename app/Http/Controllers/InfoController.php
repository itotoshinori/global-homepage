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
        $this->categories = array("お知らせ", "メニュー",  "リンク", "管理者メニュー","トップにリンクなし");
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
        $authorities = array("管理者","一般","契約");
        return view('infos.index', [
            'users' => $users,
            'infos' => $infos,
            'authorities'=> $authorities,
            'user_count' => $user_count,
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
     *
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
        $curret_user = Auth::user();
        $create['user_id'] = $curret_user->id;
        if ($request->replay == "on") {
            $create['replay'] = 2;
        }
        $result = Info::create($create);
        $info = Info::latest('id')->first();//メール送信用のために新規登録のid取得
        //$users =  User::orderBy('email')->where('authority', 1)->get();
        //メール本文に内容を表示させる
        //未公開中は管理者をメールアドレスにする
        $authority = $request->auth;
        $users = User::where('authority', '<=', $authority)->get();
        if ($request->content_dis=="on") {
            $message = "{$info->title}の件\n$info->title$info->body";
        } else {
            $message = "「{$info->title}」\nの新規お知らせ情報の登録が社内ホームページにありました。\n下記URLをクリックしてご確認ください。";
        }
        if ($result && $this->my_url != "http://localhost" && $authority != "0") {
            $my_url = $this->my_url."/internal/infos/".$info->id;
            foreach ($users as $user) {
                Mail::to($user->email)->send(new Admin("社員各位", $message, $my_url));
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
        return view('infos.show', [
        'info' => $info,
        'class_func' => $this->class_func,
        'authority_user' => $authority_user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
        $request->replay == "on" ? $update['replay'] = 2 : $update['replay'] = 1;
        $result = $info->update($update);
        //未公開中は管理者をメールアドレスにする
        $authority = $request->auth;
        $users = User::where('authority', '<=', $authority)->get();
        //$users =  User::orderBy('email')->where('authority', 1)->get();
        //メール本文に内容を表示させる
        if ($request->content_dis=="on") {
            $message = "{$info->title}の件\n$info->title$info->body";
        } else {
            $message = "「{$info->title}」\nのお知らせ情報の更新がありました。\n下記URLをクリックしてご確認ください。";
        }
        if ($result && $this->my_url != "http://localhost" && $authority != "0") {
            $my_url = $this->my_url."/internal/infos/".$info->id;
            foreach ($users as $user) {
                Mail::to($user->email)->send(new Admin("社員各位", $message, $my_url));
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
        $authority_user = $this->class_func->login_user_authority(Auth::user());
        if ($authority_user) {
            $info->delete();
            return redirect()->route('infos.index')
                            ->with('success', '削除しました。');
        } else {
            return redirect()->route('infos.index')->with('danger', '権限がありません');
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
        $introduce = "管理者各位\n社内ホームページ「{$info->title}」にメッセージがありました\n投稿者：{$current_user->name}　殿\nアドレス：{$current_user->email}";
        $introduce_tosender = "{$current_user->name} 様\n下記にてメールを送信しましたので返信をお待ち下さい";
        $message = $request->message;
        $my_url = config('my-url.url')."/internal/infos/{$info->id}";
        if ($this->my_url != "http://localhost") {
            //管理者全員に返信する設定の場合
            if ($info->replay ==2) {
                $users =  User::orderBy('email')->where('authority', 1)->get();
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new Admin($introduce, $message, $my_url));
                }
            //投稿者のみに返信する設定の場合
            } else {
                Mail::to($info->user->email)->send(new Admin($introduce, $message, $my_url));
            }
            //送信者が管理者以外の場合の送信控え
            if ($current_user->authority != 1) {
                Mail::to($current_user->email)->send(new Admin($introduce_tosender, $message, $my_url));
            }
        }
        return redirect()->route('infos.index')
                            ->with('success', "{$info->title}に関してコメントをメール送信しました");
    }
}
