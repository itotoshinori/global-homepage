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
    /*タブ切り替え全体のスタイル*/
    .tabs {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        margin: 10px auto 10px auto;
    }

    .tab_item_pc {
        display: none;
        /* または、適切な表示スタイル */
    }

    /*タブのスタイル*/
    .tab_item {
        background-color: hsla(193, 94%, 49%, 0.948);
        border: 0.5px solid rgb(248, 243, 234);
        /* 境界線を黒の実線に変更 */
        line-height: 50px;
        font-size: 16px;
        text-align: center;
        color: whitesmoke;
        display: block;
        float: left;
        text-align: center;
        font-weight: bold;
        transition: all 0.2s ease;
    }

    .tab_item:hover {
        opacity: 0.75;
    }

    /*ラジオボタンを全て消す*/
    input[name="tab_item"] {
        display: none;
    }


    /*タブ切り替えの中身のスタイル*/
    .tab_content {
        display: none;
        padding: 10px 15px 5px 15px;
        clear: both;
        overflow: hidden;
    }

    /*選択されているタブのスタイルを変える*/
    .tabs input:checked+.tab_item {
        background-color: #1509ed;
        color: #fff;
    }

    /*選択されているタブのコンテンツのみを表示*/
    #all:checked~#all_content,
    #company:checked~#company_content,
    #corporate:checked~#corporate_content,
    #company:checked~#company_content,
    #information:checked~#information_content,
    #contact:checked~#contact_content,
    #item1:checked~#item1_content,
    #item2:checked~#item2_content,
    #item3:checked~#item3_content,
    #item4:checked~#item4_content,
    #item5:checked~#item5_content,
    #item6:checked~#item6_content,
    #item7:checked~#item7_content {
        display: block;
    }

    @media screen and (min-width: 500px) {
        .tabs {
            width: 90%;
        }
    }

    @media screen and (min-width: 1100px) {
        .tabs {
            width: 70%;
        }
    }
</style>