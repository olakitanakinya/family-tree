<?php $__currentLoopData = $all_videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="single-item-countable single-photo">
        <video muted controlsList="nodownload" controls class=" w-100" src="<?php echo e(get_post_video($video->file_name)); ?>"></video>
        
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/video_single.blade.php ENDPATH**/ ?>