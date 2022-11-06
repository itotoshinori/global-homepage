<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Database\Eloquent\Collection;

use App\lib\My_func;
use App\Mail\Admin;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->class_func = new My_func();
        $this->name = "";
        $my_url = config('my-url.url');
        $this->my_url = $my_url;
        $this->articles_url = "${my_url}/articles/";
        $this->to_email = "tnitoh@global-software.co.jp";
        $this->users = User::all();
    }

    public function index()
    {
        $articles = $this->class_func->main_articles();
        $info_articles = Article::where('category', '=', 1)->orderBy('id', 'desc')->paginate(9);
        $urls = $this->class_func->urls();
        return view('articles.index', [
            'articles' => $articles,
            'info_articles' => $info_articles,
            'class_func' => $this->class_func,
            'urls' => $urls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $main = $request->main_content;
        return view('articles.create', compact('main'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $create = $this->class_func->request_content($request);
        $image = $request->file('image');
        if (isset($image)) {
            // ファイルの保存とパスの取得
            $path =  $image->store('images', 'public');
            $image = ltrim($path, 'images/');
            $create['image'] = $image;
        }
        $image_detail = $request->file('image_detail');
        if (isset($image_detail)) {
            // ファイルの保存とパスの取得
            $path =  $image_detail->store('images', 'public');
            $image_detail = ltrim($path, 'images/');
            $create['image_detail'] = $image_detail;
        }
        $result = Article::create($create);
        if ($result && $this->my_url != "http://localhost") {
            $message = "記事の新規登録がありました。ご確認ください。\n".$this->articles_url;
            foreach ($this->users as $user) {
                Mail::to($user->to_email)->send(new Admin($this->name, $message, $this->my_url));
            }
            //メールテスト用に残す。テスト時コメントアウト
            //Mail::to($this->to_email)->send(new Admin($this->name, $message, $this->my_url));
        }
        return redirect()->route('articles.index')->with('success', '新規登録完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $length = 4;
        $max = pow(10, $length) - 1;                    // コードの最大値算出
        $rand = random_int(0, $max);                    // 乱数生成
        $randam_num = sprintf('%0'. $length. 'd', $rand);// 乱数の頭0埋め
        $url_get = str_replace('/', '', $_SERVER['REQUEST_URI']);
        $urls = $this->class_func->urls();
        $result = array_search($url_get, $urls);
        if ($result && $url_get != 'NG') {
            $article = Article::find($result);
        }
        return view('articles.show', [
            'article' => $article,
            'class_func' => $this->class_func,
            'randam_num'=> $randam_num,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if ($article->category==0) {
            $main = true;
        } else {
            $main = false;
        }
        return view('articles.edit', compact('article', 'main'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArticleRequest $request, Article $article)
    {
        $update = $this->class_func->request_content($request);
        $image = $request->file('image');
        if (isset($image)) {
            $path =  $image->store('images', 'public');
            $image = ltrim($path, 'images/');
            $update['image'] = $image;
        } elseif ($request->image_del == "on") {
            //ファイル削除システム
            Storage::disk('public')->delete("/images/".$article->image);
            $update['image'] = null;
        }
        $image_detail = $request->file('image_detail');
        if (isset($image_detail)) {
            // ファイルの保存とパスの取得
            $path =  $image_detail->store('images', 'public');
            $image_detail = ltrim($path, 'images/');
            $update['image_detail'] = $image_detail;
        } elseif ($request->image_detail_del == "on") {
            //ファイル削除システム
            Storage::disk('public')->delete("/images/".$article->image_detail);
            $update['image_detail'] = null;
        }
        $article->update($update);
        $message = "記事の更新がありました。ご確認ください\n".$this->articles_url.$article->id;
        if ($this->my_url != "http://localhost") {
            foreach ($this->users as $user) {
                Mail::to($user->email)->send(new Admin($this->name, $message, $this->my_url));
            }
            //メールテスト用に残す。テスト時コメントアウト
            //Mail::to($this->to_email)->send(new Admin($this->name, $message, $this->my_url));
        }
        return redirect("articles/".$article->id)->with('success', '更新完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //画像ファイルを削除
        if (isset($article->image)) {
            Storage::disk('public')->delete("/images/".$article->image);
        }
        $article->delete();
        return redirect()->route('articles.index')
                        ->with('success', '削除しました。');
    }
}
