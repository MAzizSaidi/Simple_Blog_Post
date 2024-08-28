<div class="d-flex flex-wrap ">
    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('posts.tag.index', ['tag' => $tag])); ?>" class="badge text-bg-success me-1 mb-2"> <?php echo e($tag->name); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views\Components\tag.blade.php ENDPATH**/ ?>