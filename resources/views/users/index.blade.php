@extends('app')
@auth
	<div class="wrapper">
		<div class="pt-2">
			@if ($message = Session::get('success'))
				<p class="alert alert-success">
					{{ $message }}</p>
			@endif
			@if ($message = Session::get('danger'))
				<p class="alert alert-danger">{{ $message }}</p>
			@endif
		</div>
		<div class="center-block; fs-2 py-5">ユーザーリスト</div>
		<table class="table fs-5" style="margin:auto;">
			<th>名前</th>
			<th>メールアドレス</th>
			<th></th>
			@foreach ($users as $user)
				<tr>
					<td>
						{{ $user->name }}
					</td>
					<td>
						{{ $user->email }}
					</td>
					<td>
						<form style="display: inline-block;" method="POST" action="{{ route('users.destroy', $user->id) }}">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger" onclick="return confirm('本当に削除しますか?')">削除する</button>
						</form>
					</td>
				</tr>
			@endforeach
		</table>
		<div class="emails">
			<input type="hidden" value={{ $user_emails }} />
			<span class="btn btn-primary mt-2">全員のemailをコピーする</span>
		</div>
	</div>
@endauth
<style>
	.wrapper {
		width: 70%;
		margin: auto;
	}
</style>
