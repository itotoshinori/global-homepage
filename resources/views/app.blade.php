<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <title>
        @yield('title')
    </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
<script>
    $(function() {
        $("#btn1").on("click", function() {
            let num = $("#input_num").val();
            let name = $("#name").val();
            let email = $("#email").val();
            let img_num = $("#img_num").val();
            let message = $("#message").val();
            if (email && name && img_num && message) {
                $("#js-send").addClass("open");
                $("#js-send-back").addClass("open");
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