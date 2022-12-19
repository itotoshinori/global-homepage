<div class="modal fade" id="staticBackdrop{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
	tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">
					ユーザー編集
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="modal fade" action="{{ route('users.update', $user->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="modal-body">
					@if ($authority_user)
						<div class="has-text-weight-bold">名前:</div>
						<input class="form-control" type="text" required name="name" value="{{ $user->name }}">
						<div class="has-text-weight-bold">email:</div>
						<input class="form-control" type="text" required name="email" value="{{ $user->email }}">
						<div class="has-text-weight-bold">区分:</div>
						<select name="authority" class="form-control">
							@php $k=1 @endphp
							@foreach ($authorities as $authority)
								@if ($user->authority === $k)
									<option value={{ $k }} selected>{{ $authority }}</option>
								@else
									<option value={{ $k }}>{{ $authority }}</option>
								@endif
								@php $k=$k+1 @endphp
							@endforeach
						</select>
					@endif
					<div class="has-text-weight-bold">備考(ご自由にお使い下さい):</div>
					<input class="form-control" type="text" name="note" value="{{ $user->note }}">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
						閉じる
					</button>
					<button type="submit" class="btn btn-primary">保存</button>
				</div>
			</form>
		</div>
	</div>
</div>
