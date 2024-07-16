    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ isset($post) ? 'Edit Blog Post' : 'Create a New Blog Post' }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}">
                            @csrf
                            @if(isset($post))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" required value="{{ old('title', $post->title ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" name="content" id="content" rows="5" required>{{ old('content', $post->content ?? '') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">
                                {{ isset($post) ? 'Update' : 'Create' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
