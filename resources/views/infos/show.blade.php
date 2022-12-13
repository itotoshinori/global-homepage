@extends('app')

<header>
	<meta charset="utf-8" />
	<title>株式会社グローバル</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="{{ asset('/css/info.css') }}">
	<link rel="stylesheet" href="{{ secure_asset('/css/info.css') }}">
</header>

<body>
	@if ($message = Session::get('success'))
		<p class="alert alert-success">
			{{ $message }}</p>
	@endif
	@if ($message = Session::get('danger'))
		<p class="alert alert-danger mt-2">{{ $message }}</p>
	@endif
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
					<div>投稿日：{{ $info->created_at->format('Y年m月d日') }}</div>
					<div>
						<div style="margin-bottom:10px;">
							<button onclick="location.href='/internal/infos'" class="btn btn-success" style="width:100px;">トップへ</button>
							<button onclick="javascript:history.back()" class="btn btn-primary" style="width:100px;">前に戻る</button>
							<button class="btn btn-warning" id="contact-dis" style="width:100px;">お問合せ</button>
						</div>
						<div class="form-group contact-form">
							<label for="textarea1">お問合せはこちらから</label>
							<form method="POST" action="{{ route('infos.send_mail', $info->id) }}" enctype="multipart/form-data">
								@csrf
								@method('POST')
								<textarea name="message" class="form-control" required></textarea>
								<button class="btn btn-primary" style="margin-top:4px;" type="submit" class="btn btn-danger"
									onclick="return confirm('本当に送信しますか?')">送信</button>
							</form>
						</div>
						<form action="{{ route('infos.destroy', $info) }}" method="POST">
							@csrf
							@method('DELETE')
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
</body>
<style>
	.contact-form {
		display: none;
	}
</style>
<script>
	$('#contact-dis').on('click', function() {
		$('.contact-form').css('display', 'block');
	});
</script>
