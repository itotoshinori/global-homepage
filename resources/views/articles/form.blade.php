@extends('app')
@if ($errors->any())
	<div style="color:brown">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
<div class="md-form">
	<label>タイトル</label>
	<input type="text" name="title" class="form-control" value="{{ $article->title ?? old('title') }}">
</div>
<div class="form-group">
	<label>本文</label>
	<textarea name="body" required class="form-control" rows="5" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
<div class="md-form">
	<label>リンク</label>
	<input type="url" name="link" class="form-control" value="{{ $article->link ?? old('link') }}">
</div><br />
@if ($main)
	<div class="md-form">
		<label>Home画面に表示の写真</label><br />
		<input type="file" name="image" id="file" accept="image/*">
	</div><br />
@endif
<div class="md-form">
	<label>詳細画面に表示の写真</label><br />
	<input type="file" name="image_detail" id="file" accept="image/*">
</div><br />
