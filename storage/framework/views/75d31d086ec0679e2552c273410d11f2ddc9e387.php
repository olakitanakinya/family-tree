<?php $__currentLoopData = $all_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <a href="<?php echo e(route('single.post',$photo->post_id)); ?>">
    <div class="user_profil single-item-countable single-photo">
        <img src="<?php echo e(get_post_image($photo->file_name)); ?>" alt="">
    </div>
   </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/photo_single.blade.php ENDPATH**/ ?>