<div class="row" id="postMediaSection<?php echo e($post->post_id); ?>">
    <div class="col-12">
        <?php
            $media_files = DB::table('media_files')
                ->where('post_id', $post->post_id)
                ->get();
        ?>
        <?php $media_files_count = count($media_files); ?>
        <div class="photoGallery  visibility-hidden <?php if($media_files_count == 1): ?> initialized mt-12 <?php endif; ?>">
            <!-- break after loaded 5 images -->
            <?php $more_unloaded_images = $media_files_count - 5; ?>
            <?php $__currentLoopData = $media_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $media_file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                    if ($key == 5) {
                        break;
                    }
                ?>

                <?php if($media_file->file_type == 'video'): ?>
                <?php $s3_keys = get_settings('amazon_s3', 'object'); ?>
                    <?php if(File::exists('public/storage/post/videos/' . $media_file->file_name) || $s3_keys->active == 1): ?>
                        <?php if($media_files_count > 1): ?>
                            <a class="position-relative"
                                onclick="showCustomModal('<?php echo e(route('preview_post', ['post_id' => $post->post_id, 'file_name' => $media_file->file_name])); ?>', '<?php echo e(get_phrase('Preview')); ?>', 'xxl')"
                                href="javascript:void(0)">
                        <?php endif; ?>

                        <video muted controlsList="nodownload"
                            class="plyr-js w-100 rounded video-thumb <?php if($media_files_count > 1): ?> initialized <?php endif; ?>"
                            onplay="pauseOtherVideos(this)">
                            <source src="<?php echo e(get_post_video($media_file->file_name)); ?>" type="">
                        </video>

                        <?php if($more_unloaded_images > 0 && $key == 4): ?>
                            <div class="more_image_overlap"><span><i class="fa-solid fa-plus"></i>
                                    <?php echo e($more_unloaded_images); ?></span></div>
                        <?php endif; ?>

                        <?php if($media_files_count > 1): ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="picture text-center">
                        <a onclick="showCustomModal('<?php echo e(route('preview_post', ['post_id' => $post->post_id, 'file_name' => $media_file->file_name])); ?>', '<?php echo e(get_phrase('Preview')); ?>', 'xxl')"
                            href="javascript:void(0)">

                            <?php if($more_unloaded_images > 0 && $key == 4): ?>
                                <?php $opacity = 'opacity-7'; ?>
                                <div class="more_image_overlap"><span><i class="fa-solid fa-plus"></i>
                                        <?php echo e($more_unloaded_images); ?></span></div>
                            <?php else: ?>
                                <?php $opacity = ''; ?>
                            <?php endif; ?>
                            <?php if(!isset($post_albums) ): ?>            
                            <img src="<?php echo e(get_post_image($media_file->file_name)); ?>"
                                class="w-100 h-100 <?php if($media_files_count == 1): ?> single-image-ration <?php endif; ?> <?php echo e($opacity); ?>"
                                alt="">
                             <?php endif; ?>   
                        </a>
                    </div>
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/main_content/media_type_post_view.blade.php ENDPATH**/ ?>