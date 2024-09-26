<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1><?php echo e(__('Update Profile')); ?></h1>

        <form action="<?php echo e(route('users.update', $user)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <!-- Avatar Upload -->
                <div class="col-md-4 mb-4">
                    <!-- Display the user's current avatar -->
                    <div class="mb-3">

                        <img id="avatarPreview" src="<?php echo e($user->image ? asset($user->image->path) : '#'); ?>" alt="Avatar" class="img-thumbnail avatar" >

                    </div>
                    <!-- Avatar upload field -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label"><?php echo e(__('Change Avatar')); ?></label>
                        <input type="file" class="form-control" id="avatar" name="avatar" onchange="previewImage(event)">
                        <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Name Field -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label"><?php echo e(__('Name')); ?></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>

                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Update Profile')); ?></button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const preview = document.getElementById('avatarPreview');

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views/User/update.blade.php ENDPATH**/ ?>