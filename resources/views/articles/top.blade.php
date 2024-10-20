<div class="mt-3 mb-3">
    <h5>{{$article_top->body}}</h5>
    @if ($authority_user)
    <div><a class="mt-2 btn btn-warning" href="{{ route('articles.edit', $article_top->id) }}">編集</a></div>
    @endif
</div>
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mt-2 mb-2">新着情報</h6>
    </div>
    <div class="card-body">
        <div>■{{ $info_new->title }}</div>
        <div>
            {{ $info_new->created_at->format('Y年m月d日') }}
            ({{ $class_func->week_dis($info_new->created_at->format('w')) }})
            @if($info_new->link)
            <span class="ml-1"><a href={{ $info_new->link }}>🏠</a></span>
            @endif
        </div>
        <div>{!! nl2br($info_new->body) !!}</div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <div>
            <h6>{{ $article_business->title }}</h6>
            @if( $article_business->link )
            <span class="ml-1"><a href={{ $article_business->link }}>🏠</a></span>
            @endif
        </div>
    </div>
    <div class="card-body">
        {!! nl2br($article_business->body) !!}
        @if ($authority_user)
        <div><a class="mt-2  btn btn-warning" href="{{ route('articles.edit', $article_business->id) }}">編集</a></div>
        @endif
    </div>
</div>