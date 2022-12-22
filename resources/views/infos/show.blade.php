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
						<div><a href={{ $info->link }} target="_blank">{{ $class_func->url_part($info->link) }}</a>
						</div>
					@endif
					@if (isset($info->image))
						<br />
						<form action="{{ route('infos.download', $info->id) }}" method="POST">
							@csrf
							@method('POST')
							<label style="font-size:15px;">▼クリックしてダウンロード</label><br />
							<button class="btn btn-secondary" type="submit"
								onclick="return confirm('本当にダウンロードしますか?')">{{ $info->image_file_name }}</button>
						</form>
					@endif
					<div>投稿日：{{ $info->created_at->format('Y年m月d日') }}</div>
					<br />
					<div>
						@if ($info->replay <= 2)
							<div class="form-group contact-form">
								<label for="textarea1">お問合せはこちらから</label>
								<form method="POST" action="{{ route('infos.send_mail', $info->id) }}" enctype="multipart/form-data">
									@csrf
									@method('POST')
									<textarea name="message" class="form-control" required></textarea>
									<button class="btn btn-primary" style="margin-top:4px; width:120px;" type="submit" class="btn btn-danger"
										onclick="return confirm('本当に送信しますか?')">メール送信</button>
								</form>
							</div>
						@endif
						<div style="margin: 5px 0 10px 0;">
							<button onclick="location.href='/internal/infos'" class="btn btn-success" style="width:100px;">トップへ</button>
							<button onclick="javascript:history.back()" class="btn btn-info" style="width:100px;">前に戻る</button>
						</div>
						<form action="{{ route('infos.destroy', $info) }}" method="POST">
							@csrf
							@method('DELETE')
							@if ($authority_user)
								<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top"
									title={{ $info->reader }}>
									閲覧数：{{ $reader_count }}
								</button>
								<a class="btn btn-secondary" href="{{ route('infos.edit', $info->id) }}" style="width:100px;">編集</a>
								<button class="btn btn-danger" type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか?')"
									style="width:100px;">削除</button>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<style>
	.content-body {
		font-size: 16px;
		padding: 10px;
	}

	@media screen and (min-width: 480px) {
		.content-body {
			font-size: 17px;
		}

		.contact-form {
			width: 70%;
		}
	}
</style>
<script>
	$('#contact-dis').on('click', function() {
		$('.contact-form').css('display', 'block');
	});
</script>
