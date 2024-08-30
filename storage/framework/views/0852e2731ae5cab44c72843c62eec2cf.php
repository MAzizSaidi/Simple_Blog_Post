<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card d-flex flex-column align-items-center">
                    <div class="card-header w-100 text-center"><?php echo e(__('Dashboard')); ?></div>
                    <div class="card-body text-center">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php elseif(session('danger')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(session('danger')); ?>

                            </div>
                        <?php endif; ?>
                        <p><?php echo e(__('You are logged in!')); ?></p>
                    </div>
                    <div class="card-footer w-100 text-center">
                        <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-secondary">Go to Posts!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/home.blade.php ENDPATH**/ ?>