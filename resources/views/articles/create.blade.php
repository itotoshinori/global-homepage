<title>記事投稿</title>
@extends('articles.layout')

@section('content')
	<h1>新規作成画面</h1>
	<form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
		@csrf
		@method('POST')
		@include('articles.form')
		@if ($main)
			<input type="hidden" name="category" value="0" />
		@else
			<input type="hidden" name="category" value="1" />
		@endif
		<button type="submit" class="btn btn-primary">投稿する</button>
	</form>
@endsection
