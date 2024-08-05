<div class="d-flex flex-wrap ">
    @foreach($tags as $tag)
        <span class="badge text-bg-success me-1 mb-2">{{ $tag->name }}</span>
    @endforeach
</div>
