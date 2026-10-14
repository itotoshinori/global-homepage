@extends('privacypolicy.layouts')

@section('title', 'プライバシーポリシー - 株式会社グローバル')

@section('content')

<h2 class="text-center mb-4 fs-3 fw-bold">{{$privacy_policy->title}}編集</h2>
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form method="POST" action="{{ route('privacypolicy.update', $privacy_policy->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">タイトル(30文字以内)</label>
        <input type="text" class="form-control" name="title" value="{{old('title',$privacy_policy->title)}}">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">本文</label>
        <textarea class="form-control" name="content" rows="50">{{old('content',$privacy_policy->content)}}</textarea>
    </div>
    <!-- 更新ボタン-->
    <div class="d-flex justify-content-end align-items-center mt-4 gap-3 pt-3 border-top">
        <a href="{{ route('privacypolicy.index') }}" class="btn btn-secondary  px-4">
            キャンセル
        </a>
        <button type="submit" class="btn btn-success px-5 fw-bold">
            更新する
        </button>
    </div>
</form>

@endsection