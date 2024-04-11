<form method="POST" action="{{ route('contact.send') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="md-form">
        <label>
            <h6>会社名及びお名前 <span class="essential">※</span></h6>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control mb-4" style="border-color: black;" required>
    </div>
    <div class="md-form">
        <label>
            <h6>メールアドレス <span class="essential">※</span></h6>
        </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="md-form">
        <label>
            <h6>電話番号</h6>
        </label>
        <input type="text" name="tel" value="{{ old('tel') }}" class="form-control mb-4" style="border-color: black;">
    </div>
    <div class="md-form">
        <label>
            <h6>右の番号を入力して下さい
                <span class="text-danger mr-2"><img src="https://global-software.jp/storage/images/{{$file_list['file']}}" width="60" height="20"></span>
                <span class="essential ml-2">※{{$errors->first()}}</span>
            </h6>
        </label>
        <input type="text" name="img_num" id="img_num" value="{{ old('img_num') }}" class="form-control mb-4" style="border-color: black;" required>
    </div>
    <div class="form-group">
        <label>
            <h6>お問合せ内容　<span class="essential">※</span></h6>
        </label>
        <textarea name="message" id="message" required class="form-control" rows="8" style="border-color: black;">{{ old('message') }}</textarea>
        <input type="hidden" name="random_number" id="random_number" value="{{$random_number}}" class="form-control mb-4" style="border-color: black;">
        <button type="submit" id="btn1" class="btn btn-secondary mt-4">メール送信</button>
    </div>
</form>

<style>
    .essential {
        color: red;
    }

</style>
