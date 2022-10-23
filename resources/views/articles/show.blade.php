@extends('app')
@extends('articles.layout')

@section('content')
	<div class="wrapper">
		<br />
		@if ($message = Session::get('success'))
			<p class="alert alert-success">
				{{ $message }}</p>
		@endif
		<div class="card mt-3 border border-secondary">
			<div class="fw-bolder fs-2 ml-5 mt-2">
				{{ $article->title }}
			</div>
			<div class="ml-5">
				@if ($article->category == 1)
					{{ $article->created_at->format('Y年m月d日') }}
					({{ $class_func->week_dis($article->created_at->format('w')) }})
				@endif
			</div>
			<div>
				<div style="padding:10px; font-size:20px;">
					<p>
						@if (isset($article->image_detail))
							<img src="/storage/images/{{ $article->image_detail }}" class="photo-box">
						@endif
						{!! nl2br($article->body) !!}</a>
						@if (isset($article->link))
							<p><a href={{ $article->link }} target="_blank">{{ $class_func->url_part($article->link) }}</a>
							</p>
						@endif
					</p>
					<form action="{{ route('articles.destroy', $article->id) }}" method="POST">
						@csrf
						@method('DELETE')
						<a href="/" style="font-size:20px;margin-right:10px;">Homeへ</a>
						@auth
							<a class="button is-success" href="{{ route('articles.edit', $article->id) }}">編集</a>
							<button class="btn btn-danger" type="submit" class="btn btn-danger"
								onclick="return confirm('本当に削除しますか?')">削除</button>
						@endauth
					</form>
				</div>
			</div>
		</div>
		@if ($article->id == 5)
			<div class="card mt-5 p-4 border border-secondary">
				@include('articles.adoption')
			</div>
		@endif
		@if ($article->id == 4)
			<div class="card mt-5 p-4 border border-secondary">
				@include('articles.contact')
			</div>
		@endif
	</div>
@endsection

<style>
	/* スマフォ　*/
	.wrapper {
		width: 100%;
		margin: auto;
	}

	.content {
		font-size: 30px;
		color: blueviolet;
		border-bottom: 3px dashed yellowgreen;
	}

	.photo-box {
		width: 100%;
		height: auto;
	}

	@media screen and (min-width:480px) {
		.wrapper {
			width: 90%;
			margin: auto;
		}

		.photo-box {
			float: left;
			padding: 0 15px 0 0;
			width: 350px;
			height: auto;
		}
	}

	@media screen and (min-width:1025px) {
		.wrapper {
			width: 80%;
			margin: auto;
		}
	}
</style>
