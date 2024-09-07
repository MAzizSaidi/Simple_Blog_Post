<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(isset($post) ? 'Edit Blog Post' : 'Create a New Blog Post'); ?></h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo e(isset($post) ? route('posts.update', $post->id) : route('posts.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($post)): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required value="<?php echo e(old('title', $post->title ?? '')); ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="5" required><?php echo e(old('content', $post->content ?? '')); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="thumbnail" id="inputGroupFile02" onchange="previewImage(event)">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <!-- Image preview -->
                            <div class="text-center mt-2">
                                <img id="imagePreview" src="#" alt="Image preview" class="img-fluid rounded-circle" style="display: none; width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">
                            <?php echo e(isset($post) ? 'Update' : 'Create'); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];
        const preview = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

<?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/BlogPost/form/BlogPostForm.blade.php ENDPATH**/ ?>