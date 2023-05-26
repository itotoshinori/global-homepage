<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>
		@yield('title')
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
<style>
	body {
		margin-bottom: 80px;
	}
</style>
<script>
	$(function() {
		$("#btn1").on("click", function() {
			let num = $("#btn2").val()
			let comment_num = $("#comment_num").text();
			if (num != comment_num) {
				alert("正しい数字を入力してください！")
				return false;
			} else {
				$("#js-send").addClass("open");
			}
		});
	});
	$(".emails span").on("click", function() {
		// コピーするテキストを選択
		$(".emails input").select();
		// 選択したテキストをクリップボードにコピーする
		document.execCommand("Copy");
		// コピーを通知する
		alert("全員のemailをコピーできました。BCCに貼るなどして連絡用にご活用下さい。");
	});
</script>
