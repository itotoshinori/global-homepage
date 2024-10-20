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
    @if ($message = Session::get('success'))
    <div class="alert alert-primary">{{ $message }}</div>
    @endif
    @if ($message = Session::get('danger'))
    <p class="alert alert-danger">{{ $message }}</p>
    @endif
    <div class="tabs">
        <!-- 新しい一行のボックス -->
        <div class="p-3  bg-secondary text-white">
            <div>
                <span class="fs-3">株式会社グローバル</span>
                @if ($authority_user && ($article_count) < ($article_max))
                    <a href="/articles/create?category=4" class="btn btn-primary text-white">項目新規</a>
                    （あと{{ $article_max - $article_count  }}項目追加可能）
                    @elseif ($authority_user && $article_count >= $article_max)
                    <span>(項目の追加はできません)</span>
                    @endif
            </div>
            <div>〒166-0004 東京都杉並区阿佐谷南1-14-20</div>
            <div>ファーストビル阿佐谷</div>
            <div>
                TEL 03-3292-5461 FAX 03-5929-8730
            </div>
        </div>
        <input id="all" type="radio" name="tab_item" checked>
        <label class="tab_item" for="all">トップ</label>
        @foreach($articles as $article)
        <input id={{$article->introductory}} type="radio" name="tab_item">
        <label class="tab_item" for={{$article->introductory}}>{{$article->title}}</label>
        @endforeach
        <div class="tab_content" id="all_content">
            @include('articles.top')
        </div>
        @foreach($articles as $article)
        <div class="tab_content" id={{$article->introductory}}_content>
            @include('articles.content')
            @if($article->introductory =="contact")
            @include('articles.contact')
            @endif
            <div class="mt-2">
                @if($article->introductory =="information" && $authority_user)
                <div class="mt-2 mb-2">
                    <a href="/articles/create?category=2" class="btn btn-primary btn-sm text-white">お知らせ新規</a>
                </div>
                @endif
                @if($article->introductory =="information")
                @include('articles.info')
                @endif
            </div>
        </div>
        @endforeach
        <div class="p-3  bg-secondary text-white">
            <div>
                <span class="fs-3">株式会社グローバル</span>
            </div>
            <div>〒166-0004 東京都杉並区阿佐谷南1-14-20</div>
            <div>ファーストビル阿佐谷</div>
            <div>
                TEL 03-3292-5461 FAX 03-5929-8730
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/article.js') }}"></script>
</body>
<script>
    $(document).ready(function() {
        var width = $(window).width();

        // 画面幅が768px未満ならスマートフォンと判断
        if (width < 768) {
            // スマートフォンのスタイル
            $('label.tab_item').css('width', 'calc(100% / {{ ($line_count) / 2 }})');
        } else {
            // PCのスタイル
            $('label.tab_item').css('width', 'calc(100% / {{ ($line_count) }})');
        }
    });
</script>
<style>

</style>