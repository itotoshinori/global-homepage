<h5 class="mt-2 mb-2">
    {{$article->title}}
    @if($article->link)
    <span class="ml-1"><a href={{ $article->link }}>🏠</a></span>
    @endif
</h5>
{!! nl2br($article->body) !!}
<form action="{{ route('articles.destroy', $article->id) }}" method="POST">
    @csrf
    @method('DELETE')
    @if($authority_user)
    <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', $article->id) }}">編集</a>
    @endif
    @if($article->category == 4 && $authority_user)
    <button class="btn btn-danger btn-sm ml-2" type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('本当に削除しますか?')">
        削除
    </button>
    @endif
</form>