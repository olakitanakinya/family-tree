<!-- Profile Nav End -->
<div class="friends-tab ct-tab album_tab  bg-white radius-8 p-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-photo-tab"
                data-bs-toggle="tab" data-bs-target="#profile-photo" type="button"
                role="tab" aria-controls="profile-photo" aria-selected="true"><?php echo e(get_phrase('Photos')); ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-album-tab" data-bs-toggle="tab"
                data-bs-target="#profile-album" type="button" role="tab"
                aria-controls="profile-album" aria-selected="false"><?php echo e(get_phrase('Album')); ?></button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile-photo" role="tabpanel"
            aria-labelledby="profile-photo-tab">
            <div class="photo-list mt-3">
                <div class="flex-wrap" id="">
                    <?php echo $__env->make('frontend.user.single_user.photo_single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div> <!-- Tab Pane End -->
        <div class="tab-pane fade" id="profile-album" role="tabpanel" aria-labelledby="profile-tab">
            
            <?php echo $__env->make('frontend.user.single_user.album_single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div><!-- Tab Pane End -->

    </div> <!-- Tab Content End -->
</div> <!-- Friends Tab End --><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/photos.blade.php ENDPATH**/ ?>