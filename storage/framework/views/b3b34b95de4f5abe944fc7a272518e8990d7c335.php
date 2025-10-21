<?php $__currentLoopData = $friendships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friendship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($friendship->requester == $user_data->id): ?>
        <?php $friends_user_data = DB::table('users')->where('id', $friendship->accepter)->first(); ?>
    <?php else: ?>
        <?php $friends_user_data = DB::table('users')->where('id', $friendship->requester)->first(); ?>
    <?php endif; ?>

    <?php
    $number_of_friend_friends = json_decode($friends_user_data->friends);
    $number_of_my_friends = json_decode($user_info->friends);

    if(!is_array($number_of_friend_friends)) $number_of_friend_friends = array();
    if(!is_array($number_of_my_friends)) $number_of_my_friends = array();
    
    $number_of_mutual_friends = count(array_intersect($number_of_friend_friends, $number_of_my_friends));
    ?>
    <div class="single-item-countable d-flex friend-item align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center w-100">
            <!-- Avatar -->
            <div class="avatar">
                <a href="#!"><img class="avatar-img rounded-circle user_image_show_on_modal" src="<?php echo e(get_user_image($friends_user_data->photo, 'optimized')); ?>" alt="" ></a>
            </div>
            <div class="avatar-info ms-2">
                <h6 class="mb-1"><a href="<?php echo e(route('user.profile.view',$friends_user_data->id)); ?>"><?php echo e($friends_user_data->name); ?></a></h6>
                <div class="activity-time small-text text-muted"><?php echo e($number_of_mutual_friends); ?> <?php echo e(get_phrase('Mutual Friends')); ?></div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/friends_single_data.blade.php ENDPATH**/ ?>