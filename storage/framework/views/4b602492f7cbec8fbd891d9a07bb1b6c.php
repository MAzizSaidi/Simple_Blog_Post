<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Profile</h1>

        <!-- Display the user's current avatar -->
        <div class="mb-4">

            <?php if(isset($user->image)): ?>
                <img src="<?php echo e(asset($user->image->path)); ?>" alt="Avatar" class="img-thumbnail rounded-circle avatar">
                
            <?php endif; ?>

        </div>

        <!-- Display user's name -->
        <div class="mb-3">
            <h2><?php echo e($user->name); ?></h2>
        </div>

        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-primary">Edit Profile</a>
        <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-secondary">Go to Posts!</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/User/show.blade.php ENDPATH**/ ?>