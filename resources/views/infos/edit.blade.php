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
					</select>
				</div><br />
				<button type="submit" class="btn btn-primary update_button">更新</button>
				</form>
			</div>
		</div>
	</div>
</body>
