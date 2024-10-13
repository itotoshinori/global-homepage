@extends('app')

<head>
    <title>株式会社グローバル</title>
    <meta name="description" content="株式会社グローバル　東京都杉並区のソフトウェア開発会社です">
    <meta name="keywords" content="グローバル,宮島郁夫,国松勇次,宮坂栄一,伊藤利典,日本郵政グループ,手話言語化アプリ">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta charset="utf-8">
</head>

<body>
    <link rel="stylesheet" href="{{ asset('/css/article.css') }}">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <div class="header">
        <div class="header_title">株式会社グローバル</div>
        <div class="header_content">東京都杉並区にあるソフトウェア会社です</div>
        <nav>
            <ul>
                <li id="nav-drawer">
                    <input id="nav-input" type="checkbox" class="nav-unshown" />
                    <label id="nav-open" for="nav-input"><span></span></label>
                    <label class="nav-unshown" id="nav-close" for="nav-input"></label>
                    <div id="nav-content">
                        <div class="hm-close">
                            <a id="close" href="javascript:void(0);">✖️</a>
                        </div>
                        @foreach ($articles as $article)
                        <div class="hm-link">
                            <a id="{{ $article->introductory }}_link_hm" href="javascript:void(0);">{{ $article->title }}</a>
                        </div>
                        @endforeach
                        <div class="hm-link">
                            <a id="contact_link_hm" href="javascript:void(0);">お問合せ </a>
                        </div>
                        <div class="hm-link">
                            <a id="information_link_hm" href="javascript:void(0);">お知らせ </a>
                            <span class="pc-new-hm">{{ $info_new }}</span>
                        </div>
                    </div>
                </li>
                <li><a href="/">ホーム</a></li>
                @foreach ($articles as $article)
                <li>
                    <a class="pc-menu" id="{{ $article->introductory }}_link" href="javascript:void(0);">{{ $article->title }}</a>
                </li>
                @endforeach
                <li>
                    <a class="pc-menu" id="contact_link" href="javascript:void(0);">お問合せ</a>
                </li>
                <li>
                    <a class="pc-menu" id="information_link" href="javascript:void(0);">お知らせ</a>
                </li>
                <li><span class="pc-new">{{ $info_new }}</span></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert_success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('danger'))
        <p class="alert alert-danger mt-2">{{ $message }}</p>
        @endif
        @if ($authority_user && $article_count < $article_max)
            <div class="new_article">
            <span style="margin-right:5px;"><a
                    href="/articles/create?category=0">項目新規</a></span>（あと{{ $article_max - $article_count }}項目追加可能）
            @elseif ($authority_user && $article_count >= $article_max)
            <div class="new_article">
                <span style="margin-right:5px;">項目の追加はできません</span>
            </div>
            @endif
            @if (isset($headline))
            <div class="box">
                <div class="box_title">
                    {{ $headline->title }}
                    @if ($headline->link)
                    <span class="ml-1"><a href={{ $headline->link }}>🏠</a></span>
                    @endif
                    @if ($authority_user)
                    <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', $headline->id) }}">編集</a>
                    @endif
                </div>
                <div>{!! nl2br($headline->body) !!}</div>
            </div>
            @endif
            @foreach ($articles as $article)
            <span id={{ $article->introductory }}></span>
            <div class="box">
                <div class="box_title">
                    {{ $article->title }}
                    @if($article->link)
                    <span><a href={{ $article->link }}>🏠</a></span>
                    @endif
                </div>
                @if ($authority_user)
                <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    @if ($article->introductory == 'item2' && $authority_user)
                    <a class="btn btn-primary btn-sm" href="/articles/create?category=2">新規</a>
                    @endif
                    <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', $article->id) }}">編集</a>
                    @if(!in_array($article->introductory, ['item1', 'item2', 'item3']))
                    <button class="btn btn-danger btn-sm" type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('本当に削除しますか?')">
                        削除
                    </button>
                    @endif
                </form>
                @endif
                <div>{!! nl2br($article->body) !!}</div>
                @if ($article->introductory == 'item2' && isset($content_articles))
                @foreach ($content_articles as $content)
                <div class="content-box">
                    <p>{{ $content->title }}
                        @if ($content->link)
                        <span class="ml-1"><a href={{ $content->link }}>🏠</a></span>
                        @endif
                    <div>{!! nl2br($content->body) !!}</div>
                    </p>
                    <p>
                        @if ($authority_user)
                    <form action="{{ route('articles.destroy', $content->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-warning btn-sm"
                            href="{{ route('articles.edit', $content->id) }}">編集</a>
                        <button class="btn btn-danger btn-sm" type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('本当に削除しますか?')">削除</button>
                    </form>
                    @endif
                    </p>
                </div>
                @endforeach
                @endif
            </div>
            @endforeach
            @if (isset($contact_article))
            <span id="contact"></span>
            <div class="box">
                <div class="box_title">
                    {{ $contact_article->title }}
                    @if ($contact_article->link)
                    <span class="ml-1"><a href={{ $contact_article->link }}>🏠</a></span>
                    @endif
                    @if ($authority_user)
                    <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', $contact_article->id) }}">編集</a>
                    @endif
                </div>
                <div>{!! nl2br($contact_article->body) !!}</div>
                <br />
                <div class="content">
                    @include('articles.contact')
                </div>
            </div>
            @endif
            <div class="send" id="js-send">
                <p>送信中 お待ちください</p>
            </div>
            <div class="send-back" id="js-send-back">
            </div>
            @if (isset($info_articles))
            <span id=information></span>
            <div class="box">
                <div class="box_title">
                    お知らせ
                    @if ($authority_user)
                    <a class="btn btn-primary btn-sm" href="/articles/create?category=1">新規</a>
                    @endif
                </div>
                @foreach ($info_articles as $info)
                <div class="information_box">
                    <div class="information_box_title">
                        {{ $info->title }}
                        @if($info->link)
                        <span class="ml-1"><a href={{ $info->link }}>🏠</a></span>
                        @endif
                    </div>
                    <p>
                        投稿日：
                        {{ $info->created_at->format('Y年m月d日') }}
                        ({{ $class_func->week_dis($info->created_at->format('w')) }})
                        <br />
                        {!! nl2br($info->body) !!}<br />
                        @if ($info->link)
                        @endif
                    </p>
                    <p>
                        @if ($authority_user)
                    <form action="{{ route('articles.destroy', $info->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <a class="btn btn-warning btn-sm edit_button"
                            href="{{ route('articles.edit', $info->id) }}">編集</a>
                        <button class="btn btn-danger btn-sm" type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('本当に削除しますか?')">削除</button>
                    </form>
                    @endif
                    </p>
                </div>
                @endforeach
            </div>
            @endif
    </div>
    <script src="{{ asset('/js/article.js') }}"></script>
</body>
<footer></footer>
<style>
    .send {
        width: 90%;
        height: 50%;
        border: 1px solid #000;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgb(226, 225, 240);
        z-index: 9;
        display: none;
    }

    .send p {
        position: absolute;
        top: 50%;
        left: 50%;
        text-align: center;
        transform: translate(-50%, -120%);
        z-index: 10;
        font-size: 15px;
    }

    .send-back {
        width: 100%;
        height: 100%;
        border: 1px solid #000;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.55;
        background: black;
        z-index: 5;
        display: none;
    }

    .send.open {
        display: block;
    }

    .send-back.open {
        display: block;
    }

    @media screen and (min-width: 1100px) {
        .send p {
            font-size: 40px;
        }
    }
</style>