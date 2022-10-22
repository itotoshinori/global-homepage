@extends('app')
@extends('articles.layout')

@section('content')
	@auth
		<h2>
			<a href="{{ route('articles.create', ['main_content' => true]) }}">主項目新規作成</a>
			<a href="{{ route('articles.create') }}">お知らせ新規作成</a>
		</h2>
	@endauth
	<div class="menu-card-wrapper">
		@foreach ($articles as $article)
			<div class="menu-card">
				<div class="menu-card-inner">
					<div class="photo_height">
						@if ($article->image)
							<img class="menu-image" src="/storage/images/{{ $article->image }}">
						@else
							<img class="menu-image" src="https://thumb.photo-ac.com/92/921d6392ee6cd207962aeedc4fc1f639_t.jpeg">
						@endif
					</div>
					<div class="menu-title mb-2">
						{{ $article->title }}
					</div>
					<div class="menu-text">
						<div>
							<form action="{{ route('articles.destroy', $article->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<div>
									<span class="mr-2">
										<a class="button is-primary" style="text-decoration: none;" href="{{ route('articles.show', $article->id) }}">
											詳細へ
										</a>
									</span>
									@auth
										<a class="button is-success" href="{{ route('articles.edit', $article->id) }}">編集</a>
										<button class="btn btn-danger" type="submit" class="btn btn-danger"
											onclick="return confirm('本当に削除しますか?')">削除</button>
									@endauth
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		<div class="menu-card">
			<div class="menu-card-inner">
				<div class="menu-title mb-2" id="info">
					お知らせ
				</div>
				<div class="menu-text">
					@foreach ($info_articles as $info)
						<div>
							<span class="badge bg-warning text-dark">{{ $class_func->dis_new($article->created_at) }}</span>
							<a href="{{ route('articles.show', $info->id) }}" class="link-success">{{ $info->title }}</a>
						</div>
					@endforeach
				</div>
				<div class="ml-5 mr-5">{{ $info_articles->links() }}</div>
			</div>
		</div>
	</div>
@endsection

<style>
	.text-date {
		text-align: left;
		padding-left: 10px;
	}

	.menu-card {
		width: 90%;
		margin-top: 35px;
	}

	.menu-card-inner {
		padding: 0;
		border-radius: 7px;
		border-color: black;
		box-shadow: 1px 1px 4px #d2d4d6;
		text-align: center;
		height: 350px;
	}

	.menu-image {
		width: 100%;
		height: 250px;
		border-radius: 5px;
	}

	.menu-title {
		font-size: 30px;
		text-align: left;
		padding: 0 10px 0 10px;
		font-weight: bold;
	}

	.menu-text {
		text-align: left;
		font-size: 20px;
		padding: 0 10px 0 10px;
	}

	.menu-card-wrapper {
		display: flex;
		flex-wrap: wrap;
	}

	@media screen and (min-width:600px) {
		.menu-card {
			width: 75%;
			margin-top: 35px;
		}

		.photo_height {
			height: 270px;
		}
	}

	@media screen and (min-width:1025px) {
		.menu-card {
			width: 33%;
			margin-top: 35px;
		}

		.menu-card-inner {
			padding: 0;
			border-radius: 7px;
			border-color: black;
			box-shadow: 1px 1px 4px #d2d4d6;
			text-align: center;
			margin: 0 15px;
			width: 400px;
			height: 370px;
		}
	}
</style>
