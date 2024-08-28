<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="text-center mb-4 col-12">
                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-success">Add Blog</a>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" style="width: 25rem;">

                    <div class="card-body">
                        <h5 class="card-title">Most Commented Blogpost !</h5>
                        <p class="card-text">Discover the most talked-about blog posts that are capturing everyone's attention.</p>
                    </div>

                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $mostCommented; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item mb-2">
                               <p><?php echo e($post->title); ?></p>
                                <small class="text-muted"><?php echo e($post->comments_count); ?> Comments </small>
                                <a href="<?php echo e(route('posts.show', ['post' => $post->id])); ?>" class="btn btn-primary btn-sm float-end">View</a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card mt-4" style="width: 25rem;">

                            <div class="card-body">
                                <h5 class="card-title">Most Active Users ! </h5>
                                <p class="card-text">Discover the most active users that are capturing everyone's attention.</p>
                            </div>

                            <div class="list-group list-group-flush">
                                <?php $__currentLoopData = $activeUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item mb-2">
                                        <p><?php echo e($user->name); ?></p>
                                        <small class="text-muted float-end"><?php echo e($user->blogpost_count); ?> Blogs </small>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
              </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card mt-4" style="width: 25rem;">

                            <div class="card-body">
                                <h5 class="card-title">Most Active Users Last Two Months ! </h5>
                                <p class="card-text">Discover the most active users that are capturing everyone's attention in the last 2 months.</p>
                            </div>

                            <div class="list-group list-group-flush">
                                <?php $__currentLoopData = $MostActiveUserLastMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item mb-2">
                                        <p><?php echo e($user->name); ?></p>
                                        <small class="text-muted float-end"><?php echo e($user->blogpost_count); ?> Blogs </small>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
            <div class="col-md-8">
                <div class="row">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <?php if($post->trashed()): ?>
                                        <del>
                                    <?php endif; ?>
                                    <h5 class="card-title"><?php echo e($post->title); ?></h5>
                                                <?php if($post->tags->count()): ?>
                                                <?php $__env->startComponent('components.tag',['tags' => $post->tags]); ?> <?php echo $__env->renderComponent(); ?>
                                                <?php endif; ?>
                                        <?php if($post->trashed()): ?>
                                            </del>
                                        <?php endif; ?>
                                    <p class="card-text"><?php echo e($post->content); ?></p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">

                                    <small class="text-muted">Posted on <?php echo e($post->created_at->format('M d, Y')); ?></small>

                                    <small class="text-muted"> By
                                        <a href="<?php echo e(route('users.show',$post->user)); ?>"> <?php echo e($post->user->name); ?></a>
                                    </small>

                                    <?php if($post->comments_count): ?>
                                        <small class="text-muted"> <?php echo e($post->comments_count); ?> Comments </small>
                                    <?php else: ?>

                                        <small class="text-muted"> No Comments Yet </small>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-primary btn-sm ml-auto">View</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views\BlogPost\fetch.blade.php ENDPATH**/ ?>