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
			@include('infos.title')
			@include('infos.side')
			<div id="content">
				<div class="inner">
					<div class="content-title">
						<span style="margin-right:20px;">お知らせ</span>
						@if ($authority_user)
							<a href="/internal/infos?alldis=1">サイドを含め全表示</a>
						@endif
					</div>
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
					<div class="content-title">
						<span style="margin-right:20px;">社員一覧</span>
						@if ($authority_user)
							<a href="/internal/infos?alluserdis=1">退職者も含め全表示</a>
						@endif
					</div>
					<label class="form-label" for="address" style="margin-top:10px; margin-left:10px;">メール送信用フォーム</label>
					<input class="form-control iputAddress" type="text" value="" id="emailList" readonly />
					<button style="background-color: wheat; margin: 2px 0 10px 0">
						<span id="mail_address"><a href="mailto:">メーラー</a></span>
					</button>
					<button onclick="copyEmail()" class="btn btn-primary">コピー</button>
					<button onclick="allSelect()" class="btn btn-primary">全選択</button>
					<button onclick="location.reload()" class="btn btn-warning">リセット</button>
					<div id="userCount" style="display:none;">{{ $user_count }}</div>
					<table class="table table-striped">
						@php
							$i = 0;
						@endphp
						<th width="10px;">選</th>
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
										@if ($authority_user && $user->authority == 1)
											<span class="text-warning">管</span>
										@endif
										@if ($user->registration == false)
											<span class="text-danger">退</span>
										@endif
										{{ $user->name }}
									</div>
								</td>
								<td>
									<span id="email{{ $i }}">{{ $user->email }}</span>
								</td>
								<div>
									<!-- Modal -->
									@include('infos.user_modal')
								</div>
							</tr>
						@endforeach
					</table>
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
		var allCount = $("#userCount").text();
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
