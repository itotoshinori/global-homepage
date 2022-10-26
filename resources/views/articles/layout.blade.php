@php
	use App\lib\My_func;
	$class_func = new My_func();
	$articles = $class_func->main_articles();
	$i = 0;
@endphp


<!DOCTYPE html>
<html lang="ja">

<head>
	<title>グローバル</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>

<body>
	<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
		<div class="container-fluid container-sm">
			<h4 style="text-decoration: none; color:white;">株式会社グローバル</h4>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
				aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav me-auto mb-5 mb-lg-0">
					<li class="nav-item ms-3">
						<h4><a class="nav-link" href="/" style="color:white;">Home</a></h4>
					</li>
					@foreach ($articles as $article)
						<li class="nav-item ms-3">
							<h4><a class="nav-link" href="/articles/{{ $article->id }}" style="color:white;">{{ $article->title }}</a></h4>
						</li>
					@endforeach
					<li class="nav-item ms-3">
						<h4><a class="nav-link" href="/articles/#info" style="color:white;">お知らせ</a></h4>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-sm">
		@yield('content')
	</div>
</body>

</html>

<style>
	.container {
		width: 70%;
	}
</style>
