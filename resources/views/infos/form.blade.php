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
	<div>タイトル（必須　全角２０文字以下） </div>
	<input type="text" name="title" required class="form-control" placeholder="タイトル"
		value="{{ $info->title ?? old('title') }}">
</div>
<div class="form-group">
	<label>本文（必須）</label>
	<textarea name="body" required class="form-control" rows="5" placeholder="本文">{{ $info->body ?? old('body') }}</textarea>
</div>
<div class="md-form">
	<label>リンク</label>
	<input type="url" name="link" class="form-control" placeholder="https://"
		value="{{ $info->link ?? old('link') }}">
</div><br />
<div class="md-form photo-selection">
	<div>添付ファイル</div>
	<input type="file" name="image" id="file" accept=".png, .jpg, .jpeg, .pdf, .doc">
	<div>画像・PDF・ワード ファイルの添付可能</div>
	<div>3MB以下のサイズでお願いします</div>
	<div>添付ファイル名に_はつけないで下さい</div>
</div><br />
