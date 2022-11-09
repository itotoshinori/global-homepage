@php
	use App\lib\My_func;
	$class_func = new My_func();
	$articles = $class_func->main_articles();
	$urls = $class_func->urls();
	$my_url = config('my-url.url');
	if ($my_url == 'http://localhost') {
	    $hp = 'http://';
	} else {
	    $hp = 'https://';
	}
	$url = $hp . $_SERVER['HTTP_HOST'];
@endphp


<!DOCTYPE html>
<html lang="ja">

<head>
	<title>株式会社グローバル</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<meta name="description" content="株式会社グローバル　東京都杉並区のソフトウェア開発会社です">
	<meta name="keywords" content="グローバル,宮島郁夫,国松勇次,宮坂栄一,伊藤利典,日本郵政グループ,手話言語化アプリ">
	<link rel="icon" type="image/png" href="/favicon.png">
	<meta charset="utf-8">
</head>

<body>
	<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
		<div class="container-fluid">
			<h4 style="color:white;">
				<span class="menu-title">メニュー</span>
			</h4>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
				aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav me-auto mb-5 mb-lg-0">
					<li class="nav-item ms-3">
						<h4>
							<a class="nav-link" href='/' style="color:white;">Home</a>
						</h4>
					</li>
					@foreach ($articles as $article)
						<li class="nav-item ms-3">
							<h4>
								@if ($article->id <= 5)
									<a class="nav-link" href={{ $url . '/' . $urls[$article->id] }} style="color:white;">{{ $article->title }}</a>
								@else
									<a class="nav-link" href="/articles/{{ $article->id }}" style="color:white;">{{ $article->title }}</a>
								@endif
							</h4>
						</li>
					@endforeach
					<li class="nav-item ms-3">
						<h4><a class="nav-link" href="/#info" style="color:white;">お知らせ</a></h4>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="company">
		<div class="company-box">
			<h4><a href="/" class="main_title">株式会社グローバル</a></h4>
			<p>
				東京都杉並区にあるＩＴ・ソフトウェア会社です。誠心誠意をモットーとしてシステム開発を請け負います。
			</p>
		</div>
	</div>
	<div class="container">
		@yield('content')
	</div>
</body>

</html>

<style>
	.container {
		width: 90%;
	}

	.company {
		background-color: #EEEEEE;
		padding: 10px;
	}

	.company-box {
		width: 100%;
		padding: 10px;
		margin: 2em 0;
		margin: 0 auto 0 auto;
	}

	.main_title {
		text-decoration: none;
		font-size: 25px;
		font-weight: bold;
		color: rgb(19, 1, 1);
	}

	.company-box p {
		margin: 0;
		padding: 0;
		font-size: 15px;
		color: rgb(19, 1, 1);
	}

	@media screen and (min-width:600px) {
		.container {
			width: 80%;
		}

		.menu-title {
			margin-left: 120px;
		}

		.company {
			padding-left: 5px;
		}

		.company-box {
			padding-left: 5px;
		}

		.company-box {
			width: 85%;
		}

		.company-box p {
			font-size: 20px;
		}
	}

	@media screen and (min-width:1025px) {
		.container {
			width: 60%;
		}
	}
</style>
