<div class="d-flex flex-wrap ">
    @foreach($tags as $tag)
        <a href="{{ route('posts.tag.index', ['tag' => $tag]) }}" class="badge text-bg-success me-1 mb-2"> {{ __($tag->name)}}</a>
    @endforeach
</div>
