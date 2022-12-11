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
        //$infos = Info::orderBy('created_at', 'desc')->where('category', 1)->paginate(10);
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
        $result = Info::create($create);
        $info = Info::latest('id')->first();
        if ($result && $this->my_url != "http://localhost" && $info->category ==1) {
            $my_url = $this->my_url."/internal/infos/".$info->id;
            $message = "社内ホームページの更新がありました。下記URLをクリックしてご確認ください。\n".$my_url;
            foreach ($this->users as $user) {
                //Mail::to($user->to_email)->send(new Admin("", $message, $my_url));
            }
            //メールテスト用に残す。テスト時コメントアウト
            Mail::to($user->to_email)->send(new Admin("", $message, $my_url));
            //Mail::to($this->to_email)->send(new Admin($this->name, $message, $this->my_url));
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
    public function update(Request $request, Info $info)
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
        $info->update($update);

        return redirect()->route('infos.show', $info->id)
                        ->with('success', '更新しました。');
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
        //$fileName = $info->image;
        //$mimeType = Storage::mimeType($filePath);
        //$headers = [['Content-Type' => $mimeType]];
        if ($info->image_file_name) {
            return Storage::download($filePath, $info->image_file_name);
        } else {
            return Storage::download($filePath);
        }
    }
}
