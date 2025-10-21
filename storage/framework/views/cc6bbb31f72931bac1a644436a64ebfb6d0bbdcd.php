<div class="text-center">
    <img width="200px" src="<?php echo e(asset('storage/images/map-pin.jpeg')); ?>"><br>
    <a class="location-post me-auto ms-auto" href="https://www.google.com/maps/place/<?php echo e($post->location); ?>" target="_blanck">
        <img src="<?php echo e(asset('storage/images/location.png')); ?>">
        <span><?php echo e($post->location); ?></span>
        <hr>
        <small><?php echo DB::table('posts')->where('location', $post->location)->get()->count() ?> <?php echo e(get_phrase('visits')); ?></small>
    </a>
</div> <?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/main_content/location_type_post_view.blade.php ENDPATH**/ ?>