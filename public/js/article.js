$('#btn1').on('click', function (event) {
    if ($("#name").val() == "") {
        alert("お名前が空です");
        event.preventDefault(); // 送信処理を停止
        return false;
    }

    // メールアドレスの取得
    var email = $('#email').val();

    // 空欄チェック
    if (email == "") {
        alert("メールアドレスが空です");
        event.preventDefault(); // 送信処理を停止
        return false;
    }

    // メールアドレス形式のバリデーション
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("正しいメールアドレスを入力してください");
        event.preventDefault(); // 送信処理を停止
        return false;
    }

    // 番号のチェック
    if ($("#img_num").val() == "") {
        alert("番号を入力してください");
        event.preventDefault(); // 送信処理を停止
        return false;
    }

    // 本文のチェック
    if ($("#message").val() == "") {
        alert("本文を入力してください");
        event.preventDefault(); // 送信処理を停止
        return false;
    }

    // ボタンを非表示にする
    $('#btn1').hide();

    // 送信中メッセージを表示する
    $('#sendingMessage').show();
});