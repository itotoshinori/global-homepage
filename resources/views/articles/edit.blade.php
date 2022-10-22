@extends('articles.layout')

@section('content')
	<title>記事投稿</title>
	<h1>編集画面</h1>
	<form method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		@include('articles.form')
		<input type="hidden" name="category" value={{ $article->category }} />
		<div>
			@if ($article->image)
				<input type="checkbox" name="image_del">
				<label for="image_del">Home画像ファイルを削除する</label>
			@endif
			@if ($article->image_detail)
				<input type="checkbox" name="image_detail_del">
				<label for="image_detail_del">詳細の画像ファイルを削除する</label>
			@endif
		</div><br />
		<button type="submit" class="btn btn-primary" onclick="return confirm('本当に更新しますか?')">更新する</button>
	</form>
@endsection
