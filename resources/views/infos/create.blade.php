@extends('app')
@auth
	<header>
		<meta charset="utf-8" />
		<title>株式会社グローバル</title>
	</header>

	<body>
		<div class="wrapper-1">
			@include('infos.title')
			@include('infos.side')
			<div id="content">
				<div class="inner">
					<div class="content-title">お知らせ登録</div>
					<div class="content-main">
						<form method="POST" action="{{ route('infos.store') }}" enctype="multipart/form-data">
							@csrf
							@method('POST')
							@include('infos.form')
							<div class="md-group">
								<label for="category" class="form-content">カテゴリー（必須　通常はお知らせ）</label>
								<select name="category" class="form-control">
									@php $i=1 @endphp
									@foreach ($categories as $category)
										@if (old('category') == $i)
											<option value={{ $i }} selected>{{ $category }}</option>
										@elseif($i == 1)
											<option value=1 selected>{{ $category }}</option>
										@else
											<option value={{ $i }}>{{ $category }}</option>
										@endif
										@php $i=$i+1 @endphp
									@endforeach
								</select><br />
								<label for="mail_send">通知メール</label><br />
								<div class="form-check form-check-inline">
									<input type="radio" name="auth" class="form-check-input" id="auth1" value="3"
										{{ old('auth') == '3' ? 'checked' : '' }}>
									<label for="auth1" class="form-check-label">在籍者全員</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="radio" name="auth" class="form-check-input" id="auth2" value="2"
										{{ old('auth') == '2' ? 'checked' : '' }}>
									<label for="auth2" class="form-check-label">正社員のみ</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="radio" name="auth" class="form-check-input" id="auth3" value="1"
										{{ old('auth') == '1' ? 'checked' : '' }} checked>
									<label for="auth3" class="form-check-label">管理者のみ</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="radio" name="auth" class="form-check-input" id="auth3" value="0"
										{{ old('auth') == '0' ? 'checked' : '' }}>
									<label for="auth3" class="form-check-label">送付しない</label>
								</div><br /><br />
								<input type="checkbox" name="replay">
								<label for="content_dis">コメントを管理者全員に返信</label><br /><br />
								<input type="checkbox" name="content_dis">
								<label for="content_dis">メールに本文を表示させる</label>
								<br /><br />
							</div>
							<button type="submit" class="btn btn-primary">投稿する</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
@endauth
<style>
	.wrapper-1 {
		width: 98%;
		margin: auto;
	}

	#content {
		width: 95%;
		background-color: #f6f3e8;
		border-radius: 5px;
		margin-bottom: 100px;
	}

	.content-title {
		padding: 7px 15px;
		font-weight: bold;
		color: #e3e3e2;
		background: #104375;
		border-top: 1px #cccacb solid;
		border-right: 1px #cccacb solid;
		border-radius: 5px;
	}

	.main-title {
		margin: 20px 10px;
	}

	.content-main {
		padding: 0 5px;
		font-size: 20px;
	}

	.inner {
		font-size: 20px;
	}

	#content ul {
		margin: 10px 0 0.5em 0;
		padding: 0;
	}

	#content a {
		text-decoration: none
	}

	.iputAddress {
		margin-bottom: 10px;
	}

	@media screen and (min-width:1200px) {
		.wrapper-1 {
			width: 65%;
			margin: auto;
		}

		#content {
			float: right;
			width: 75%;
			margin-right: 15px;
			background-color: #f6f3e8;
			border-radius: 5px;
		}

		.content-main {
			padding: 0 5px;
			font-size: 20px;
		}

		#content li {
			padding: 0 0 0 4px;
			list-style: none;
			font-size: 20px;
		}
	}

	#footer {
		padding-top: 20px;
		font-size: 12px;
		height: 100px;
		clear: both;
		text-align: center;
		color: #444;
	}

	#footer a {
		color: #444;
	}
</style>
