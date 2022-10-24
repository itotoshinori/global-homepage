<form method="POST" action="{{ route('contact.send') }}" enctype="multipart/form-data">
	@csrf
	@method('POST')
	<div class="md-form">
		<label>
			<h5>会社名及びお名前 <span class="essential">※</span></h5>
		</label>
		<input type="text" name="name" required class="form-control mb-4" style="border-color: black;">
	</div>
	<div class="md-form">
		<label>
			<h5>メールアドレス <span class="essential">※</span></h5>
		</label>
		<input type="email" name="email" required class="form-control mb-4" style="border-color: black;">
	</div>
	<div class="md-form">
		<label>
			<h5>電話番号</h5>
		</label>
		<input type="text" name="tel" class="form-control mb-4" style="border-color: black;">
	</div>
	<div class="md-form">
		<label>
			<h5>右の番号を入力して下さい <span id="comment_num">{{ $randam_num }}</span>
		</label>
		<span class="essential ml-2">※</span></h5>
		</label>
		<input type="text" id="btn2" class="form-control mb-4" style="border-color: black;" required>
	</div>
	<div class="form-group">
		<label>
			<h5>お問合せ内容　<span class="essential">※</span></h5>
		</label>
		<textarea name="message" required class="form-control" rows="8" style="border-color: black;"></textarea>
		<button type="submit" id="btn1" class="btn btn-secondary mt-4">メール送信</button>
	</div>
</form>

<style>
	.essential {
		color: red;
	}
</style>
