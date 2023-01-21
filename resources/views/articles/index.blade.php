@extends('app')
@extends('articles.layout')
@section('content')
	@if ($authority_user)
		<h2>
			<a href="{{ route('articles.create', ['main_content' => true]) }}">主項目新規作成</a>
		</h2>
	@endif
	@if ($message = Session::get('success'))
		<p class="alert alert-success">
			{{ $message }}</p>
	@endif
	@if ($message = Session::get('danger'))
		<p class="alert alert-danger mt-2">{{ $message }}</p>
	@endif
	<div class="menu-card-wrapper">
		@foreach ($articles as $article)
			<div class="menu-card">
				<div class="menu-card-inner">
					<div class="photo_height">
						@if ($article->id <= 5)
							<a href={{ $urls[$article->id] }}>
							@else
								<a href={{ route('articles.show', $article->id) }}>
						@endif
						@if ($article->image)
							<img class="menu-image" src="/storage/images/{{ $article->image }}">
						@else
							<img class="menu-image" src="https://thumb.photo-ac.com/92/921d6392ee6cd207962aeedc4fc1f639_t.jpeg">
						@endif
						</a>
					</div>
					<div class="menu-text">
						<div>
							<form action="{{ route('articles.destroy', $article->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<div>
									<span class="menu-title mb-2">
										@if ($article->id <= 5)
											<a class="article_title" href={{ $urls[$article->id] }}>
											@else
												<a href={{ route('articles.show', $article->id) }}>
										@endif
										{{ $article->title }}
										</a>
									</span>
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
					@if ($authority_user)
						<span class="fs-4 ml-5"><a href="{{ route('articles.create') }}">新規作成</a></span>
					@endif
				</div>
				<div class="menu-text">
					@foreach ($info_articles as $info)
						<div>
							<span class="badge bg-warning text-dark">{{ $class_func->dis_new($info->created_at) }}</span>
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
		padding-left: 2px;
	}

	.menu-card {
		width: 100%;
		margin-top: 10px;
	}

	.menu-card-inner {
		padding: 0;
		border-radius: 7px;
		border-color: black;
		box-shadow: 1px 1px 4px #d2d4d6;
		text-align: center;
		height: 310px;
	}

	.menu-image {
		width: 100%;
		height: 260px;
		border-radius: 5px;
	}

	.menu-title {
		font-size: 30px;
		text-align: left;
		padding: 0 10px 0 2px;
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
		width: 100%;
	}

	.article_title {
		text-decoration: none;
		font-size: 25px;
	}

	@media screen and (min-width:600px) {
		.menu-card {
			width: 70%;
			margin-top: 35px;
		}

		.photo_height {
			height: 260px;
		}
	}

	@media screen and (min-width:800px) {
		.menu-card {
			width: 30%;
			margin-top: 35px;
			margin-right: 20px;
		}
	}

	@media screen and (min-width:1400px) {
		.menu-card {
			width: 33%;
			margin-top: 20px;
			margin-right: 0px;
		}

		.menu-card-inner {
			margin: 0 15px;
			width: 400px;
			height: 310px;
		}
	}
</style>
