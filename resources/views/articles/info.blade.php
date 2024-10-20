@foreach ($info_articles as $info)
<div class="card mb-3">
    <div class="card-header">
        <h6>{{ $info->title }}</h6>
        @if($info->link)
        <span class="ml-1"><a href={{ $info->link }}>🏠</a></span>
        @endif
    </div>
    <div class="card-body">
        <div>
            投稿日：
            {{ $info->created_at->format('Y年m月d日') }}
            ({{ $class_func->week_dis($info->created_at->format('w')) }})
        </div>
        {!! nl2br($info->body) !!}
    </div>
    @if ($authority_user)
    <form action="{{ route('articles.destroy', $info->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <span style="margin-left: 5px;">
            <a class="btn btn-warning btn-sm edit_button"
                href="{{ route('articles.edit', $info->id) }}">編集</a>
            <button class="btn btn-danger btn-sm" type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('本当に削除しますか?')">削除</button>
        </span>
    </form>
    @endif
</div>
@endforeach