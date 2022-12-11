@extends('app')
@php
	use App\lib\My_func;
	$class_func = new My_func();
	$menus = $class_func->info_menus();
	$links = $class_func->info_links();
	$managements = $class_func->info_managements();
@endphp

<div id="left">
	<div class="side-title">メニュー</div>
	<div class="side">
		<span class="side-content"><a href="{{ route('infos.index') }}">トップ</a></span>
		@foreach ($menus as $menu)
			@if ($menu->link)
				<span class="side-content"><a href={{ $menu->link }}>{{ $menu->title }}</a></span>
			@else
				<span class="side-content"><a href="{{ route('infos.show', $menu->id) }}">{{ $menu->title }}</a></span>
			@endif
		@endforeach
	</div>
	<div class="side-title">リンク</div>
	<div class="side">
		@foreach ($links as $link)
			@if ($link->link)
				<span class="side-content"><a href={{ $link->link }}>{{ $link->title }}</a></span>
			@else
				<span class="side-content"><a href="{{ route('infos.show', $link->id) }}">{{ $link->title }}</a></span>
			@endif
		@endforeach
	</div>
	@if ($authority_user)
		<div class="side-title">管理者メニュー</div>
		<div class="side">
			<span class="side-content"><a href="/internal/infos/create">お知らせ登録</a></span>
			@foreach ($managements as $management)
				@if ($management->link)
					<span class="side-content"><a href={{ $management->link }}>{{ $management->title }}</a></span>
				@else
					<span class="side-content"><a
							href="{{ route('infos.show', $management->id) }}">{{ $management->title }}</a></span>
				@endif
			@endforeach
		</div>
	@endif
</div>
<style>
	#left {
		color: #676767;
		font-size: 13px;
		width: 95%;
	}

	.side-title {
		padding: 7px 15px;
		font-weight: bold;
		font-size: 20px;
		color: #e3e3e2;
		background: #003366;
		border-top: 1px #cccacb solid;
		border-right: 1px #cccacb solid;
		border-radius: 5px 5px 0 0;
	}

	.side {
		background-color: #fcfcfc;
		line-height: 170%;
		padding: 1px;
		margin: 0 0 10px 0;
		border-bottom: 1px #cccacb solid;
		border-right: 1px #cccacb solid;
		border-left: 1px #cccacb solid;
		border-radius: 0 0 5px 5px;
	}

	.side ul {
		padding: 0;
	}

	.side-content {
		list-style: none;
		font-size: 20px;
		margin-top: 10px;
		padding-right: 10px;
		white-space: nowrap;
	}

	.side a {
		text-decoration: none;
	}

	@media screen and (min-width:1200px) {
		#left {
			color: #676767;
			font-size: 13px;
			width: 23%;
			float: left;
		}

		.side-content {
			padding: 0 0 0 4px;
			list-style: none;
			font-size: 20px;
			margin-bottom: 10px;
			display: block;
		}
	}

	blockquote {
		border: 1px solid #ccc;
		padding: 5px;
		margin: 10px;
	}
</style>
