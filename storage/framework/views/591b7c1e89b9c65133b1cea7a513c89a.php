<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">



                <div class="card"
                      <?php if(isset($post->image)): ?>
                          style="background-image: url('<?php echo e(asset($post->image->path)); ?>');"
                    <?php endif; ?>>
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start">


                    <div>
                            <h5><?php echo e($post->title); ?></h5>
                            <small style="color: white;">Posted on <?php echo e($post->created_at->format('M d, Y')); ?></small>
                        <?php if((new \Carbon\Carbon())->diffInSeconds($post->created_at) <= 10): ?>
                                <?php $__env->startComponent('components.badge'); ?>
                                    Just added <?php echo e($post->created_at->diffForHumans()); ?>

                                <?php echo $__env->renderComponent(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 mt-md-0">
                            <?php $__env->startComponent('components.badge', ['conter' => $conter]); ?><?php echo $__env->renderComponent(); ?>
                            <?php $__env->startComponent('components.tag', ['tags' => $post->tags]); ?> <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if(!isset($post->images->path)): ?>
                            <p class="card-text"><?php echo e($post->content); ?></p>

                        <?php endif; ?>
                    </div>

                    <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $post)): ?>
                                <a href="<?php echo e(route('posts.edit', $post)); ?>" class="btn btn-warning mb-2 mb-md-0">Update</a>
                            <?php endif; ?>
                            <?php if($post->trashed()): ?>
                                <p class="mt-4">This post is actually deleted. Do you want to restore it?</p>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restore', $post)): ?>
                                    <form action="<?php echo e(route('posts.restore', $post)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-info mb-2 mb-md-0">Restore</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $post)): ?>
                                <form action="<?php echo e(route('posts.destroy', $post)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger mb-2 mb-md-0">Delete</button>
                                </form>
                            <?php endif; ?>
                            <button id="commentBtn" class="btn btn-primary mb-2 mb-md-0">Comment</button>
                            <div id="commentField" style="display: none;">
                                <form action="<?php echo e(route('comments.store')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="blog_post_id" value="<?php echo e($post->id); ?>">
                                    <div class="form-group mt-2">
                                        <textarea class="form-control" name="content" rows="3" placeholder="Write your comment here..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-secondary">Back to Blog</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5>Comments</h5>
                        <?php $__empty_1 = true; $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="comment-block mb-3 p-3 border rounded bg-light">
                                <div class="d-flex align-items-start mb-2">
                                    <?php if($comment->user->image): ?>
                                        <img src="<?php echo e(asset($comment->user->image->path)); ?>" class="img-thumbnail rounded-circle profile me-3" alt="User avatar" style="width: 50px; height: 50px;">
                                    <?php endif; ?>
                                    <div>
                                        <a href="<?php echo e(route('users.show', ['user' => $comment->user])); ?>" class="fancy-link text-decoration-none">
                                            <h6 class="mt-0 mb-1"><?php echo e($comment->user->name); ?></h6>
                                        </a>
                                        <p class="comment-content mb-1" style="color: black;"><?php echo e($comment->content); ?></p>
                                        <small class="text-muted">Added <?php echo e($comment->created_at->diffForHumans()); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <small style="color: black;">No comments yet. Add your thoughts below.</small>
                        <?php endif; ?>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('commentBtn').addEventListener('click', function() {
            this.style.display = 'none';
            document.getElementById('commentField').style.display = 'block';
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/BlogPost/index.blade.php ENDPATH**/ ?>