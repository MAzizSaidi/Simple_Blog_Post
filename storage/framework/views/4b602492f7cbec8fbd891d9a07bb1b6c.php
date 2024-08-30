<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="display-4 text-center mb-4">Profile</h1>

        <!-- Display the user's current avatar -->
        <div class="text-center mb-4">
            <?php if(isset($user->image)): ?>
                <img src="<?php echo e(asset($user->image->path)); ?>" alt="Avatar" class="img-thumbnail rounded-circle avatar shadow-lg" style="width: 150px; height: 150px;">
            <?php endif; ?>
        </div>

        <!-- Display user's name -->
        <div class="text-center mb-4">
            <h2 class="text-uppercase"><?php echo e($user->name); ?></h2>
        </div>

        <div class="text-center mb-5">
            <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-primary btn-lg mx-2">Edit Profile</a>
            <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-secondary btn-lg mx-2">Go to Posts!</a>
            <button id="commentBtn" class="btn btn-outline-primary btn-lg mx-2">Comment</button>
        </div>

        <div id="commentField" class="mb-5" style="display: none;">
            <form action="<?php echo e(route('users.comment.store')); ?>" method="POST" class="shadow-sm p-4 rounded bg-light">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3" placeholder="Write your comment here..."></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $user->commentsOn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="comment-block mb-4 p-4 border rounded bg-white shadow-sm">
                <div class="d-flex align-items-start mb-2">
                    <?php if($comment->user->image): ?>
                        <img src="<?php echo e(asset($comment->user->image->path)); ?>" class="img-thumbnail rounded-circle profile me-3 shadow" alt="User avatar" style="width: 50px; height: 50px;">
                    <?php endif; ?>
                    <div class="w-100">
                        <div class="d-flex justify-content-between mb-1">
                            <a href="<?php echo e(route('users.show', ['user' => $comment->user])); ?>" class="text-primary text-decoration-none">
                                <h6 class="mt-0 mb-1 font-weight-bold"><?php echo e($comment->user->name); ?></h6>
                            </a>
                            <div>
                                <?php $__env->startComponent('components.tag', ['tags' => $comment->tags]); ?> <?php echo $__env->renderComponent(); ?>
                            </div>
                        </div>
                        <p class="comment-content mb-1 text-secondary"><?php echo e($comment->content); ?></p>
                        <small class="text-muted">Added <?php echo e($comment->created_at->diffForHumans()); ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="alert alert-info text-center">No comments yet. Add your thoughts below.</div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('commentBtn').addEventListener('click', function() {
            this.style.display = 'none';
            document.getElementById('commentField').style.display = 'block';
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/User/show.blade.php ENDPATH**/ ?>