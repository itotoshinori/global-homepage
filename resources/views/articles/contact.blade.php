<form method="POST" action="{{ route('contact.send') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="md-form mt-2">
        <label>
            <div>会社名及びお名前 <span class="text-danger">※</span></div>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="md-form">
        <label>
            <div>メールアドレス<span class="text-danger">※</span></div>
        </label>
        <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="md-form">
        <label>
            <div>電話番号</div>
        </label>
        <input type="text" name="tel" value="{{ old('tel') }}" class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="md-form">
        <label>
            <div>右の番号を入力して下さい <span class="text-danger"><span class="text-danger mr-2"><img src="https://global-software.jp/storage/images/{{$file_list['file']}}" width="60" height="20"></span>※</span></div>
        </label>
        <input type="text" name="img_num" id="img_num" value="{{ old('img_num') }}" class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="form-group">
        <label>
            <div>お問合せ内容<span class="text-danger ml-2">※</span></div>
        </label>
        <textarea name="message" id="message" class="form-control" rows="8" style="border-color: black;">{{ old('message') }}</textarea>
        <input type="hidden" name="random_number" id="random_number" value="{{$random_number}}" class="form-control mb-4" style="border-color: black;">
        <button type="submit" id="btn1" class="btn btn-secondary mt-4">メール送信</button>
        <span id="sendingMessage" class="mt-4" style="display: none;">送信中...</span>
    </div>
</form>

<script>
    $('#btn1').on('click', function(event) {
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
</script>