@extends('articles.layout')

@section('content')
	<title>記事投稿</title>
	<h1>編集画面</h1>
	<form method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		@include('articles.form')

		<input type="hidden" name="category" value={{ $article->category ? $article->category : 0 }} />
		<button type="submit" class="btn btn-primary" onclick="return confirm('本当に更新しますか?')">更新</button>
		<button type="button" class="btn btn-danger" onclick="history.back()">戻る</button>
	</form>
@endsection
