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
				<div class="content-title">お知らせ編集</div>
				<div class="content-main">
					<form method="POST" action="{{ route('infos.update', $info->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						@include('infos.form')
				</div>
				<div class="md-group">
					<label for="category" class="form-content">カテゴリー（必須　通常はお知らせ）</label>
					<select name="category" class="form-control">
						@php $i=1 @endphp
						@foreach ($categories as $category)
							@if (old('category') === $i)
								<option value={{ $i }} selected>{{ $category }}</option>
							@elseif($info->category === $i)
								<option value={{ $i }} selected>{{ $category }}</option>
							@elseif($i === 1)
								<option value={{ $i }} selected>{{ $category }}</option>
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
							{{ old('auth') == '1' ? 'checked' : '' }}>
						<label for="auth3" class="form-check-label">管理者のみ</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="auth" class="form-check-input" id="auth3" value="0"
							{{ old('auth') == '0' ? 'checked' : '' }} checked>
						<label for="auth3" class="form-check-label">送付しない</label>
					</div><br /><br />
					<label for="mail_send">コメント</label><br />
					<div class="form-check form-check-inline">
						<input type="radio" name="replay" class="form-check-input" id="replay1" value="1"
							{{ $info->replay == '1' ? 'checked' : '' }} {{ old('replay') == '1' ? 'checked' : '' }}>
						<label for="replay1" class="form-check-label">管理者全員に返信</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="replay" class="form-check-input" id="replay2" value="2"
							{{ $info->replay == '2' ? 'checked' : '' }} {{ old('replay') == '2' ? 'checked' : '' }}>
						<label for="replay2" class="form-check-label">投稿者のみに返信</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="replay" class="form-check-input" id="replay3" value="3"
							{{ $info->replay == '3' ? 'checked' : '' }} {{ old('replay') == '3' ? 'checked' : '' }}>
						<label for="replay3" class="form-check-label">コメント欄非表示</label>
					</div><br /><br />
					<input type="checkbox" name="content_dis">
					<label for="content_dis">メールに本文を表示させる</label>
				</div><br />
				<button type="submit" class="btn btn-primary update_button">更新</button>
				</form>
			</div>
		</div>
	</div>
</body>
