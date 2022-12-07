@extends('app')
@auth
	<header>
		<meta charset="utf-8" />
		<title>株式会社グローバル</title>
		<link rel="stylesheet" href="{{ asset('/css/info.css') }}">
	</header>

	<body>
		<div class="wrapper-1">
			<h2 class="main-title">株式会社グローバル</h2>
			@include('infos.side')
			<div id="content">
				<div class="inner">
					<div class="content-title">{{ $info->title }}</div>
					<div class="content-body">
						{!! nl2br($info->body) !!}<br />
						@if (isset($info->link))
							<p><a href={{ $info->link }} target="_blank">{{ $class_func->url_part($info->link) }}</a>
							</p>
						@endif
						<div>投稿日：{{ $info->created_at->format('Y年m月d日') }}</div>
						<form action="" method="POST">
							@csrf
							@method('DELETE')
							<a class="button is-success" href="{{ route('infos.index') }}" style="margin-right:20px;">トップへ</a>
							<a class="btn btn-warning" href="{{ route('infos.edit', $info->id) }}">編集</a>
							<button class="btn btn-danger" type="submit" class="btn btn-danger"
								onclick="return confirm('本当に削除しますか?')">削除</button>
						</form>
						@if (isset($info->image))
							<form action="{{ route('infos.download', $info->id) }}" method="POST">
								@csrf
								@method('POST')
								<button class="btn btn-secondary" type="submit"
									onclick="return confirm('本当にダウンロードしますか?')">添付ファイルのダウンロード</button>
							</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</body>
@endauth
