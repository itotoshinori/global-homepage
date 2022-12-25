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
<div class="md-form form-content">
	<div>タイトル（必須　30文字以下） </div>
	<input type="text" id="title" name="title" required class="form-control" placeholder="タイトル"
		value="{{ $info->title ?? old('title') }}">
</div>
<div class="form-group form-content">
	<label>本文（必須）</label>
	<textarea name="body" required class="form-control" rows="5" placeholder="本文">{{ $info->body ?? old('body') }}</textarea>
</div>
<div class="md-form form-content">
	<label>リンク</label>
	<input type="url" name="link" class="form-control" placeholder="https://"
		value="{{ $info->link ?? old('link') }}">
</div><br />
<div class="md-form photo-selection form-content">
	<div>添付ファイル</div>
	<input type="file" name="image" id="file" accept=".png, .jpg, .jpeg, .pdf, .doc, .xls, .xlsx, .zip, lzh">
	<div>画像・PDF・ワード・エクセル・圧縮ファイルの添付可能</div>
	<div>3MB以下のサイズでお願いします</div>
	<div>添付ファイル名に_や-など特殊な文字をファイル名にするとアップロードできないことがあります。簡潔で短いファイル名でお願いします。</div><br />
</div>
