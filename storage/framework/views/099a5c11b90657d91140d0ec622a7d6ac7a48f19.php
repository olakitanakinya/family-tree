<?php $__currentLoopData = $all_albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
if(isset($page_identifire)) {
    $identifires = $page_identifire; 
}
?>
    <div class="single-item-countable col-3 mt-2">
        <div class="card album-card new_album album-card">
            <div class="mb-2 position-relative">
                <a href="<?php echo e(route('album.details.list', ['album_id' => $album->id ,'identifire' => $identifires])); ?>"><img src="<?php echo e(get_album_thumbnail($album->id, 'optimized')); ?>" class="rounded img-fluid" alt=""></a>
            </div>
            <div class="card-details">
                <h6><a href="<?php echo e(route('album.details.list', ['album_id' => $album->id , 'identifire' => $identifires,])); ?>"><?php echo e($album->title); ?></a></h6>
                <span class="mute"><?php echo e(DB::table('album_images')->where('album_id', $album->id)->get()->count()); ?> <?php echo e(get_phrase('Items')); ?></span>
            </div>
        </div>
    </div> <!-- Card End -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/album_single.blade.php ENDPATH**/ ?>