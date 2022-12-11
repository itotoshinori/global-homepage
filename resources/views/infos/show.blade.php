@extends('app')

<header>
	<meta charset="utf-8" />
	<title>株式会社グローバル</title>
	<link rel="stylesheet" href="{{ asset('/css/info.css') }}">
</header>

<body>
	<div class="wrapper-1">
		@include('infos.title')
		@include('infos.side')
		<div id="content">
			<div class="inner">
				<div class="content-title">{{ $info->title }}</div>
				<div class="content-body">
					{!! nl2br($class_func->a_tag_change($info->body)) !!}<br />
					@if (isset($info->link))
						<p><a href={{ $info->link }} target="_blank">{{ $class_func->url_part($info->link) }}</a>
						</p>
					@endif
					<br />
					<div>投稿日：{{ $info->created_at->format('Y年m月d日') }}</div>
					<div>
						<form action="{{ route('infos.destroy', $info) }}" method="POST">
							@csrf
							@method('DELETE')
							<a href="javascript:history.back()" style="margin-right:10px;">戻る</a>
							<a
								href="mailto:{{ $info->user->email }}?subject={{ $info->title }}について-ホームページから問合せ-&body={{ $info->user->name }} 殿"
								style="margin-left:5px;">お問合せ</a>
							@if ($authority_user)
								<a class="btn btn-warning" href="{{ route('infos.edit', $info->id) }}">編集</a>
								<button class="btn btn-danger" type="submit" class="btn btn-danger"
									onclick="return confirm('本当に削除しますか?')">削除</button>
							@endif
						</form>
						@if (isset($info->image))
							<form action="{{ route('infos.download', $info->id) }}" method="POST">
								@csrf
								@method('POST')
								<label style="font-size:15px;">▼クリックしてダウンロード</label><br />
								<button class="btn btn-secondary" type="submit"
									onclick="return confirm('本当にダウンロードしますか?')">{{ $info->image_file_name }}</button>
							</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
<style>

</style>
