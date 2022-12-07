@extends('app')
@auth
	<header>
		<meta charset="utf-8" />
		<title>株式会社グローバル 社内ホームページ</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
		<!-- JSファイル読み込み -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
		</script>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="{{ asset('/css/info.css') }}">
	</header>

	<body>
		@if ($message = Session::get('success'))
			<p class="alert alert-success">
				{{ $message }}</p>
		@endif
		@if ($message = Session::get('danger'))
			<p class="alert alert-danger mt-2">{{ $message }}</p>
		@endif
		<div class="wrapper-1">
			<h3 class="main-title">株式会社グローバル</h3>
			@include('infos.side')
			<div id="content">
				<div class="inner">
					<div class="content-title">お知らせ</div>
					<div class="content-main">
						<table>
							@foreach ($infos as $info)
								<tr style="font-size:18px;">
									<td style="font-size:18px; white-space: nowrap;" valign="top">
										{{ $info->created_at->format('Y年m月d日') }}
									</td>
									<td> <a href="{{ route('infos.show', $info->id) }}">{{ $info->title }}</a></td>
								</tr>
							@endforeach
						</table>
						<span style="margin:3px 0 3px 0;">{{ $infos->links() }}</span>
					</div>
					<div class="content-title">社員一覧</div>
					<label class="form-label" for="address" style="margin-top:10px; margin-left:10px;">メール送信用フォーム</label>
					<input class="form-control iputAddress" type="text" value="" id="emailList" readonly />
					<button style="background-color: wheat; margin: 2px 0 10px 0">
						<span id="mail_address"><a href="mailto:">メーラー</a></span>
					</button>
					<button onclick="copyEmail()" class="btn btn-primary">コピー</button>
					<button onclick="allSelect()" class="btn btn-primary">全選択</button>
					<button onclick="location.reload()" class="btn btn-warning">リセット</button>
					<table class="table table-striped">
						@php
							$i = 0;
						@endphp
						<th><span style="white-space: nowrap;">選択</span></th>
						<th>名前</th>
						<th>email</th>
						@foreach ($users as $user)
							@php
								$i = $i + 1;
							@endphp
							<tr>
								<td>
									<userList id="list" data-id={{ $i }}>
										<span id="id{{ $i }}">◯</span>
									</userlist>
								</td>
								<td>
									<div class="name_text" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $user->id }}">
										{{ $user->name }}
									</div>
								</td>
								<td><span id="email{{ $i }}">{{ $user->email }}</span></td>
								<div>
									<!-- Modal -->
									<div class="modal fade" id="staticBackdrop{{ $user->id }}" data-bs-backdrop="static"
										data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="staticBackdropLabel">
														ユーザー編集
													</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form class="column is-8 is-offset-2" action="{{ route('users.update', $user->id) }}" method="POST">
													@csrf
													@method('PUT')
													<div class="modal-body">
														<div class="has-text-weight-bold">名前:</div>
														<input class="form-control" type="text" name="name" value="{{ $user->name }}">
														<div class="has-text-weight-bold">email:</div>
														<input class="form-control" type="text" name="email" value="{{ $user->email }}">
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
								</div>
							</tr>
						@endforeach
					</table>
					<span id="allCount" style="display:none;">{{ $i }}</span>
				</div>
			</div>
			<div id="footer"></div>
		</div>
	</body>
@endauth
<script>
	$(function() {
		$("userList").click(function() {
			var id = $(this).data("id");
			var email = $("#email" + id).text();
			addAddress(id, email);
		});
	});

	function copyEmail() {
		var text = $("#emailList").val();
		if (!text) {
			alert("対象がありません");
			return;
		}
		// コピーする媒体となるテキストエリアを生成
		var clipboard = $("<textarea></textarea>");
		clipboard.text(text);
		// body直下に一時的に挿入
		$("body").append(clipboard);
		// 選択状態にする
		clipboard.select();
		// WebExtension APIのブラウザ拡張の仕組みを呼び出しクリップボードにコピー
		document.execCommand("copy");
		// 不要なテキストエリアを削除
		clipboard.remove();
		// 通知
		alert("クリップボードにコピーしました");
	};

	function allSelect() {
		$("#emailList").val("");
		var allCount = $("#allCount").text();
		for (let id = 1; id <= allCount; id++) {
			$("#id" + id).text("◯");
			var email = $("#email" + id).text();
			addAddress(id, email);
		}
	}

	function addAddress(id, email) {
		var emailList = $("#emailList").val();
		if ($("#id" + id).text() === "◯") {
			emailList = emailList + email + ",";
			$("#id" + id).text("◉");
		} else {
			emailList = emailList.replace(email + ",", "");
			$("#id" + id).text("◯");
		}
		$("#emailList").val(emailList);
		$("#mail_address a").attr("href", "mailto:" + emailList);
	}
</script>
