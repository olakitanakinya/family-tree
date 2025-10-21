<?php
    
    $media_files = \App\Models\Media_files::where('user_id', Auth()->user()->id)
        ->whereNull('story_id')
        ->whereNull('product_id')
        ->whereNull('page_id')
        ->whereNull('group_id')
        ->whereNull('chat_id')
        ->take(9)
        ->orderBy('id', 'desc')
        ->get();
    
?>

<aside class="sidebar">
   
    <div class="widget" id="my-profile-info">

        <h4 class="widget-title"><?php echo e(get_phrase('Intro')); ?></h4>

        <div class="my-about mb-8  mt-8">
            <?php echo script_checker($user_info->about) ?>
        </div>
        <?php if(isset($type) && $type == 'my_account'): ?>
            <button onclick="toggleBio(this, '.edit-bio-form')"
                class="edit-bio-btn btn common_btn w-100 mb-14"><?php echo e(get_phrase('Edit Bio')); ?></button>
        <?php endif; ?>

        <form class="ajaxForm d-hidden edit-bio-form" action="<?php echo e(route('profile.about', ['action_type' => 'update'])); ?>"
            method="post">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <textarea name="about" class="form-control"><?php echo e($user_info->about); ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn common_btn w-100 mb-8"><?php echo e(get_phrase('Save Bio')); ?></button>
            </div>
        </form>

        <?php echo $__env->make('frontend.profile.my_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="widget">
        <div class="n_pro_con d-flex">
            <h4 class="widget-title"><?php echo e(get_phrase('Photo')); ?>/<?php echo e(get_phrase('Video')); ?></h4>
            <a href="<?php echo e(route('profile.photos')); ?>" ><?php echo e(get_phrase('See All')); ?></a>
        </div>
        <div id="sidebarPhotoAndVideos" class="row row-cols-3 row-cols-md-5 row-cols-lg-2 row-cols-xl-3 g-1 mt-3">
            <?php echo $__env->make('frontend.profile.sidebar_photos_and_videos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    
    </div>
    <!--  Widget End -->
    <div class="widget friend-widget">
        <?php
            $friends = DB::table('friendships')
                ->where(function ($query) {
                    $query->where('accepter', Auth()->user()->id)->orWhere('requester', Auth()->user()->id);
                })
                ->where('is_accepted', 1)
                ->orderBy('friendships.importance', 'desc');
        ?>
        <div class="n_pro_con d-flex align-items-start">
            <div class="widget-header">
                <h4 class="widget-title"><?php echo e(get_phrase('Friends')); ?></h4>
                <span class='f-text'><?php echo e($friends->get()->count()); ?> <?php echo e(get_phrase('Friends')); ?></span>
            </div>
            <a href="<?php echo e(route('profile.friends')); ?>" ><?php echo e(get_phrase('See All')); ?></a
            href="<?php echo e(route('profile.friends')); ?>">

        </div>

        <div class="f_image_g row-cols-3 g-1 mt-8">
            <?php $__currentLoopData = $friends->take(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($friend->requester == Auth()->user()->id): ?>
                    <?php
                        $friends_user_data = DB::table('users')
                            ->where('id', $friend->accepter)
                            ->first();
                    ?>
                <?php else: ?>
                    <?php
                        $friends_user_data = DB::table('users')
                            ->where('id', $friend->requester)
                            ->first();
                    ?>
                <?php endif; ?>
                <?php if(isset($friends_user_data->id)): ?>
                    <div class="image_div">
                        <a href="<?php echo e(route('user.profile.view', $friends_user_data->id)); ?>" class="friend d-block n_friend">
                            <img width="100%" src="<?php echo e(get_user_image($friends_user_data->photo, 'optimized')); ?>"
                                alt="">
                            <h6 class="small"><?php echo e($friends_user_data->name); ?></h6>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
    </div>
    <!--  Widget End -->

    <!--  Widget End -->
</aside>
<!--  Sidebar End -->
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/profile/profile_info.blade.php ENDPATH**/ ?>