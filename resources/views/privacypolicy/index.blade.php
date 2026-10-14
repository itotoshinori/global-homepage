@extends('privacypolicy.layouts')

@section('title', 'プライバシーポリシー - 株式会社グローバル')

@section('content')
<h1 class="text-center mb-4 fs-3 fw-bold">{{ $privacy_policy->title }}</h1>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="privacy-content text-break" style="white-space: pre-line; line-height: 1.8;">
    {{ $privacy_policy->content }}
</div>
@auth
<div class="text-end mt-4 pt-3 border-top">
    <a href="{{ route('privacypolicy.edit', $privacy_policy->id) }}" class="btn btn-primary px-4">
        編集
    </a>
</div>
@endauth
@endsection