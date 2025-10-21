<!-- Profile Nav End -->
<div class="friends-tab radius-8 ct-tab bg-white p-20">
    
    
    <div class="photo-list">
        <h4 class="h6 mb-3"><?php echo e(get_phrase('Your videos')); ?></h4>
        <div class="flex-wrap" id="">
            <?php echo $__env->make('frontend.user.single_user.video_single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

</div> <!-- Friends Tab End --><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/videos.blade.php ENDPATH**/ ?>