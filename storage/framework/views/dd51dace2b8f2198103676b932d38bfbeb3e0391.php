<?php
    if(isset($page_identifire)) {
        $identifires = $page_identifire; 
    }else{
        $identifires = 'user'; 
    }
    if($user_data->gender == 'female'){
        $gender = 'her';
    }else{
        $gender = 'his';
    }

    $pronoun = ($gender == 'his') ? 'he' : 'she';

    $friendship = DB::table('friendships')->where('accepter', $user_data->id)->first();

    $friends = json_decode(auth()->user()->friends);

    $desiredData = $user_data->id; 
    $isDataFound = in_array($desiredData, $friends ?? []);



?>
<div class="profile-wrap">
    <div class="profile-cover bg-white radius-8">
        <div class="profile-header" style="background-image: url('<?php echo e(get_cover_photo($user_data->cover_photo)); ?>');">
        </div>
       <div class="n_profile_tab">
             <div class="n_main_tab">
                <div class="profile-avatar d-flex align-items-center">
                    <div class="avatar avatar-xl"><img class="rounded-circle" src="<?php echo e(get_user_image($user_data->photo, 'optimized')); ?>" alt=""></div>
                    <div class="avatar-details">
                        <h3 class="n_font"><?php echo e($user_data->name); ?> </h3>
                    </div>
                </div>
             </div>

            <nav class="profile-nav">
                <ul class="nav align-items-center justify-content-start">
                    <li class="nav-item <?php if(Route::currentRouteName() == 'user.profile.view'): ?> active <?php endif; ?>"><a href="<?php echo e(route('user.profile.view',$user_data->id)); ?>" class="nav-link"><?php echo e(get_phrase('Timeline')); ?></a></li>
                    <li class="nav-item <?php if(Route::currentRouteName() == 'user.friends'): ?> active <?php endif; ?>"><a href="<?php echo e(route('user.friends',$user_data->id)); ?>" class="nav-link"><?php echo e(get_phrase('Friends')); ?></a></li>
                    <li class="nav-item <?php if(Route::currentRouteName() == 'user.photos' && isset($identifires)): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('user.photos', [$user_data->id , 'identifire' => $identifires])); ?>" class="nav-link"><?php echo e(get_phrase('Photo')); ?></a>
                    </li>
                    
                    <li class="nav-item <?php if(Route::currentRouteName() == 'user.videos'): ?> active <?php endif; ?>"><a href="<?php echo e(route('user.videos',$user_data->id)); ?>" class="nav-link"><?php echo e(get_phrase('Video')); ?></a></li>
                </ul>
            </nav>          
       </div>
    </div>

    <?php if(empty($user_data->profile_status) || $user_data->profile_status == 'unlock' || auth()->user()->id == $user_data->id): ?>
        <div class="row gx-3 mt-3">
            <div class="col-lg-12 col-sm-12">
                <?php if(Route::currentRouteName() == 'user.friends'): ?>
                    <?php echo $__env->make('frontend.user.single_user.friends', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(Route::currentRouteName() == 'user.photos'  && isset($identifires)): ?>
                    <?php echo $__env->make('frontend.user.single_user.photos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(Route::currentRouteName() == 'user.videos'): ?>
                    <?php echo $__env->make('frontend.user.single_user.videos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <?php if($user_data->id == auth()->user()->id): ?>
                        <?php echo $__env->make('frontend.main_content.create_post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <div id="user-timeline-posts">
                        <?php echo $__env->make('frontend.main_content.posts',['type'=>'user_post'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif($isDataFound): ?>
        <div class="row gx-3 mt-3">
            <div class="col-lg-12 col-sm-12">
                <?php if(Route::currentRouteName() == 'user.friends'): ?>
                    <?php echo $__env->make('frontend.user.single_user.friends', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(Route::currentRouteName() == 'user.photos'  && isset($identifires)): ?>
                    <?php echo $__env->make('frontend.user.single_user.photos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(Route::currentRouteName() == 'user.videos'): ?>
                    <?php echo $__env->make('frontend.user.single_user.videos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <?php if($user_data->id == auth()->user()->id): ?>
                        <?php echo $__env->make('frontend.main_content.create_post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <div id="user-timeline-posts">
                        <?php echo $__env->make('frontend.main_content.posts',['type'=>'user_post'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="widget page-widget ac_control_we mt-3">
            <div class="user_ac">  
                <a href="javascript:void(0)" class="btn common_btn ac_btn">
                    <i class="fa-solid fa-shield"></i> <?php echo e($user_data->name); ?>

                    <?php echo e(get_phrase('locked '.$gender.' profile ')); ?><br> 
                    <span><?php echo e(get_phrase('Only '.$gender.' friends can see what '.$pronoun.' shares on '.$gender.' profile.')); ?></span>
                </a>
            </div>
        </div>
        <h3 class="lock_no_post_h3"><?php echo e(get_phrase('No posts available')); ?></h3>
    <?php endif; ?>
</div>

<?php echo $__env->make('frontend.main_content.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/user_view.blade.php ENDPATH**/ ?>