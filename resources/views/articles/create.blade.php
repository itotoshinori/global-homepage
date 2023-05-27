<title>記事投稿</title>
@extends('articles.layout')

@section('content')
	<h1>新規作成画面</h1>
	<form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
		@csrf
		@method('POST')
		@include('articles.form')
		@if ($category)
			<input type="hidden" name="category" value={{ $category }} />
		@else
			<input type="hidden" name="category" value="0" />
		@endif
		<button type="submit" class="btn btn-primary">投稿</button>
		<button type="button" class="btn btn-danger" id="js-open" onclick="history.back()">戻る</button>
	</form>
@endsection
