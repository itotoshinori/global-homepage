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
	<label>タイトル（必須　全角２０文字以下） </label>
	<input type="text" name="title" class="form-control" value="{{ $article->title ?? old('title') }}">
</div>
<div class="form-group">
	<label>本文（必須）</label>
	<textarea name="body" required class="form-control" rows="10" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
<div class="md-form">
	<label>リンク</label>
	<input type="url" name="link" class="form-control" placeholder="https://"
		value="{{ $article->link ?? old('link') }}">
</div><br />
