<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInfoRequest;
use App\lib\My_func;
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
        $this->users = User::all();
        $this->categories = array("お知らせ", "メニュー",  "リンク", "管理者メニュー");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infos = Info::orderBy('created_at', 'desc')->where('category', 1)->paginate(10);
        $users = User::orderBy('email')->get();
        return view('infos.index', [
            'users' => $users,
            'infos' => $infos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('infos.create', ['categories' => $this->categories]);
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
        }
        $curret_user = Auth::user();
        $create['user_id'] = $curret_user->id;
        $result = Info::create($create);

        return redirect()->route('infos.index')
                        ->with('success', '新規作成しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $info = Info::find($id);
        return view('Infos.show', [
            'info' => $info,
            'class_func' => $this->class_func,
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
        return view('infos.edit', compact('info'), ['categories' => $this->categories]);
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
            //前回ファイル削除
            Storage::disk('inside')->delete("/files/".$info->image);
        }
        $info->update($update);

        return redirect()->route('infos.index')
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
        $info->delete();
        return redirect()->route('infos.index')
                        ->with('success', '削除しました。');
    }
    public function download(int $id)
    {
        $info = Info::find($id);
        $filePath = "inside/files/{$info->image}";
        $fileName = $info->image;
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        return Storage::download($filePath, $fileName, $headers);
    }
}
