<?php 
$mutualFriendsData = [];
foreach($friendships as $friendship) {
    if($friendship->requester == $user_info->id) {
        $friends_user_data = DB::table('users')->where('id', $friendship->accepter)->first();
    } else {
        $friends_user_data = DB::table('users')->where('id', $friendship->requester)->first();
    }

    // Decode the JSON object as associative arrays and get the keys
    $number_of_friend_friends = array_keys(json_decode($friends_user_data->friends, true));
    $number_of_my_friends = array_keys(json_decode($user_info->friends, true));

    // Find the intersection of the two arrays
    $mutual_friends = array_intersect($number_of_friend_friends, $number_of_my_friends);
    foreach($mutual_friends as $set){
        array_push($mutualFriendsData, $set);
    }
}


// Block User Each Other
$blockedByUser = DB::table('block_users')->where('user_id', auth()->user()->id)->pluck('block_user')->toArray();
$blockedByOthers = DB::table('block_users')->where('block_user', auth()->user()->id)->pluck('user_id')->toArray();

//Save_post

$user = Auth()->user();
    $savedPostsJson = $user->save_post;
    $save_posts = collect(json_decode($savedPostsJson, true)); 

?>


<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loopIndex => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!empty($post->location)): ?>
        <?php
            $total_comment_main_comments = DB::table('comments')
                ->where('comments.is_type', 'post')
                ->where('comments.id_of_type', $post->post_id)
                ->where('comments.parent_id', 0)
                ->get()
                ->count();
            $total_comment_sub_comments = DB::table('comments')
                ->where('comments.is_type', 'post')
                ->where('comments.id_of_type', $post->post_id)
                ->where('comments.parent_id', '>', 0)
                ->get()
                ->count();
            $total_comments = $total_comment_main_comments + $total_comment_sub_comments;

            $comments = DB::table('comments')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->where('comments.is_type', 'post')
                ->where('comments.id_of_type', $post->post_id)
                ->where('comments.parent_id', 0)
                ->select('comments.*', 'users.name', 'users.photo')
                ->orderBy('comment_id', 'DESC')
                ->take(1)
                ->get();

            $tagged_user_ids = json_decode($post->tagged_user_ids);



        // New Feature Code

                $user_id = $post->user_id;
                $friend = \App\Models\Friendships::where(function($query) use ($user_id){
                    $query->where('requester', auth()->user()->id);
                    $query->where('accepter', $user_id);
                })
                ->orWhere(function($query) use ($user_id) {
                    $query->where('accepter', auth()->user()->id);
                    $query->where('requester', $user_id);
                })
                ->count();

                $friendAccepted = \App\Models\Friendships::where(function($query) use ($user_id){
                    $query->where('requester', auth()->user()->id);
                    $query->where('accepter', $user_id);
                })
                ->orWhere(function($query) use ($user_id) {
                    $query->where('accepter', auth()->user()->id);
                    $query->where('requester', $user_id);
                })

        ?>
        <?php
        $user_reacts = json_decode($post->user_reacts, true); 
        
        //  User Block
        if (in_array($post->user_id, $blockedByUser)) {
                continue;
            }
            if (in_array($post->user_id, $blockedByOthers)) {
                continue;
            }
        ?>
        <?php if($post->post_type != 'fundraiser'): ?>
        <div class="single-item-countable single-entry" id="postIdentification<?php echo e($post->post_id); ?>">
            <div class="entry-inner">
                <?php if($post->publisher == 'memory'): ?>
                    <?php
                        $explode_data = explode('/', $post->description);
                        $shared_id = end($explode_data);
                    

                        $post_date_by_memory = DB::table('posts')
                            ->where('post_id', $shared_id)
                            ->value('created_at');
                        $time_passed = round((time() - $post_date_by_memory) / 31536000);
                    ?>
                    <div class="entry-header memories-header">
                        <small class="d-block w-100 text-center text-muted mb-3">
                            <?php echo e(ucfirst(get_phrase('on ____ ____ ____ ago', [date('M d Y,', $post_date_by_memory), $time_passed, $time_passed > 1 ? 'years' : 'year']))); ?>

                        </small>
                    </div>
                <?php endif; ?>

                <?php if(isset($has_memories)): ?>
                    <?php
                    
                    
                    $time_passed = round((time() - $post->created_at) / 31536000); ?>
                    <div class="entry-header memories-header">
                        <small class="meta-time text-muted text-center w-100 d-block">
                            <?php echo e(get_phrase('On this day')); ?>

                            <?php echo e(date('M d, Y', $post->created_at)); ?>

                        </small>
                        <h3 class="mb-3 pb-3  text-center text-muted">
                            <?php echo e(get_phrase('You have a memory ____ ____ ago', [$time_passed, $time_passed > 1 ? 'years' : 'year'])); ?>

                        </h3>
                    </div>
                <?php endif; ?>

                <div class="entry-header d-flex justify-content-between">
                    <div class="ava-info d-flex align-items-center">
                    
                        <?php if(isset($type) && $type == 'page'): ?>
                            <div class="flex-shrink-0">
                                <img src="<?php echo e(get_page_logo($post->logo, 'logo')); ?>"
                                    class="rounded-circle user_image_show_on_modal" alt="...">
                            </div>
                        <?php elseif(isset($type) && $type == 'group'): ?>
                            <div class="eUserFeature">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo e(get_user_image($post->photo, 'optimized')); ?>"
                                        class="rounded-circle user_image_show_on_modal" alt="...">
                                </div>

                                 
                                <?php if(Auth()->user()->id != $post->user_id): ?>
                                <div class="hoverFeature">
                                    <div class="h_top">
                                        <div class="h_eImage">
                                            <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>">
                                        </div> 
                                        <div class="h_right_text">
                                            <h4><a href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->getUser->name); ?></a> </h4>
                                            <ul>
                                                    <li class="d-flex">
                                                        <i class="fas fa-user-friends"></i>
                                                        <?php
                                                        $number_of_my_friends = json_decode($user_info->friends, true);
                                                        $my_data = DB::table('users')->where('id', $post->getUser->id)->first();
                                                        $my_fr = json_decode($my_data->friends, true);
                                                        $mutual_fr = count(array_intersect($number_of_my_friends, $my_fr));
                                                        ?>
                                                        <p><?php echo e($mutual_fr); ?> <?php echo e(get_phrase('Mutual friend')); ?></p>
                                                    </li>
                                                    <li class="d-flex">
                                                        <i class="fa-solid fa-house-user"></i>
                                                        <p><?php echo e(get_phrase('Lives in')); ?> <strong><?php echo e($post->getUser->address); ?></strong> </p>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if($friend>0): ?>
                                            <?php if($friendAccepted->count()>0 && $friendAccepted->value('is_accepted') == 1): ?>
                                                <ul class="d-flex eHfooter">
                                                    <li>
                                                        <a href="#" class="btn common_btn ac_btn" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group"></i> <?php echo e(get_phrase('Friend')); ?> </a>
                                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <li><a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="dropdown-item custom_unfrind_button"> <i class="fa-solid fa-xmark"></i><?php echo e(get_phrase('Unfriend')); ?></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                    </li>
                                                    <li class="eDrops">
                                                        <div class="dropdown">
                                                            <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="showCustomModal('<?php echo route('block_user', $post->post_id); ?>', 'Block')"><?php echo e(get_phrase('Block')); ?></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php else: ?>
                                                <ul  class="d-flex eHfooter">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="btn common_btn ac_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Cancle Friend Request')); ?>"><i class="fa-solid fa-xmark"></i> <?php echo e(get_phrase('Cancel')); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                    </li>
                                                </ul>
                                            <?php endif; ?>
                                    <?php else: ?>   
                                        <ul class="d-flex eHfooter">
                                            <li> <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.friend',$post->user_id); ?>')" class="btn common_btn ac_btn"><i class="fa-solid fa-plus"></i> <?php echo e(get_phrase('Add Friend')); ?> </a></li>
                                            <li>  <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a></li>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            

                            </div>

                        <?php elseif(isset($type) && $type == 'video'): ?>
                            <div class="entry-header d-flex justify-content-between">
                                <div class="ava-info d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo e(get_user_image($post->photo, 'optimized')); ?>"
                                            class="rounded rounded-circle user_image_show_on_modal" alt="...">

                                    </div>
                                    <div class="ava-desc ms-2">
                                        <h3 class="mb-0"><?php echo e($post->name); ?></h3>
                                        <small class="meta-time text-muted"><?php echo e(date('M d ', strtotime($post->created_at))); ?>

                                            at <?php echo e(date('H:i A', strtotime($post->created_at))); ?></small>
                                        <?php if($post->privacy == 'public'): ?>
                                            <span class="meta-privacy text-muted"><i
                                                    class="fa-solid fa-earth-americas"></i></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="post-controls dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#"><img
                                                    src="<?php echo e(asset('assets/frontend/images/save.png')); ?>" alt="">
                                                <?php echo e(get_phrase('Save Video')); ?></a></li>
                                        <li><a class="dropdown-item" href="#"><img
                                                    src="<?php echo e(asset('assets/frontend/images/link.png')); ?>"
                                                    alt=""><?php echo e(get_phrase('Copy Link')); ?></a></li>
                                        <li><a class="dropdown-item" href="#"><img
                                                    src="<?php echo e(asset('assets/frontend/images/report.png')); ?>"
                                                    alt=""><?php echo e(get_phrase('Report')); ?> </a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php elseif(isset($type) && $type == 'user_post'): ?>
                        
                            <div class="eUserFeature">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>"
                                        class="rounded-circle user_image_show_on_modal" alt="...">
                                </div>
                                 
                                <?php if(Auth()->user()->id != $post->user_id): ?>
                                    <div class="hoverFeature">
                                        <div class="h_top">
                                            <div class="h_eImage">
                                                <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>">
                                            </div> 
                                            <div class="h_right_text">
                                                <h4><a href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->getUser->name); ?></a> </h4>
                                                <ul>
                                                        <li class="d-flex">
                                                            <i class="fas fa-user-friends"></i>
                                                            <?php
                                                            $number_of_my_friends = json_decode($user_info->friends, true);
                                                            $my_data = DB::table('users')->where('id', $post->getUser->id)->first();
                                                            $my_fr = json_decode($my_data->friends, true);
                                                            $mutual_fr = count(array_intersect($number_of_my_friends, $my_fr));
                                                            ?>
                                                            <p><?php echo e($mutual_fr); ?> <?php echo e(get_phrase('Mutual friend')); ?></p>
                                                        </li>
                                                        <li class="d-flex">
                                                            <i class="fa-solid fa-house-user"></i>
                                                            <p><?php echo e(get_phrase('Lives in')); ?> <strong><?php echo e($post->getUser->address); ?></strong> </p>
                                                        </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php if($friend>0): ?>
                                                <?php if($friendAccepted->count()>0 && $friendAccepted->value('is_accepted') == 1): ?>
                                                    <ul class="d-flex eHfooter">
                                                        <li>
                                                            <a href="#" class="btn common_btn ac_btn" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group"></i> <?php echo e(get_phrase('Friend')); ?> </a>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li><a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="dropdown-item custom_unfrind_button"> <i class="fa-solid fa-xmark"></i><?php echo e(get_phrase('Unfriend')); ?></a></li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                        </li>
                                                        <li class="eDrops">
                                                            <div class="dropdown">
                                                                <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="showCustomModal('<?php echo route('block_user', $post->post_id); ?>', 'Block')"><?php echo e(get_phrase('Block')); ?></a></li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                <?php else: ?>
                                                    <ul  class="d-flex eHfooter">
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="btn common_btn ac_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Cancle Friend Request')); ?>"><i class="fa-solid fa-xmark"></i> <?php echo e(get_phrase('Cancel')); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                        </li>
                                                    </ul>
                                                <?php endif; ?>
                                        <?php else: ?>   
                                            <ul class="d-flex eHfooter">
                                                <li> <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.friend',$post->user_id); ?>')" class="btn common_btn ac_btn"><i class="fa-solid fa-plus"></i> <?php echo e(get_phrase('Add Friend')); ?> </a></li>
                                                <li>  <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a></li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                        <?php elseif(isset($type) && $type == 'paid_content'): ?>
                        <div class="eUserFeature">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>"
                                        class="rounded-circle user_image_show_on_modal" alt="...">
                                </div>
                                 
                                <?php if(Auth()->user()->id != $post->user_id): ?>
                                    <div class="hoverFeature">
                                        <div class="h_top">
                                            <div class="h_eImage">
                                                <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>">
                                            </div> 
                                            <div class="h_right_text">
                                                <h4><a href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->getUser->name); ?></a> </h4>
                                                <ul>
                                                        <li class="d-flex">
                                                            <i class="fas fa-user-friends"></i>
                                                            <?php
                                                            $number_of_my_friends = json_decode($user_info->friends, true);
                                                            $my_data = DB::table('users')->where('id', $post->getUser->id)->first();
                                                            $my_fr = json_decode($my_data->friends, true);
                                                            $mutual_fr = count(array_intersect($number_of_my_friends, $my_fr));
                                                            ?>
                                                            <p><?php echo e($mutual_fr); ?> <?php echo e(get_phrase('Mutual friend')); ?></p>
                                                        </li>
                                                        <li class="d-flex">
                                                            <i class="fa-solid fa-house-user"></i>
                                                            <p><?php echo e(get_phrase('Lives in')); ?> <strong><?php echo e($post->getUser->address); ?></strong> </p>
                                                        </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php if($friend>0): ?>
                                                <?php if($friendAccepted->count()>0 && $friendAccepted->value('is_accepted') == 1): ?>
                                                    <ul class="d-flex eHfooter">
                                                        <li>
                                                            <a href="#" class="btn common_btn ac_btn" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group"></i> <?php echo e(get_phrase('Friend')); ?> </a>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li><a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="dropdown-item custom_unfrind_button"> <i class="fa-solid fa-xmark"></i><?php echo e(get_phrase('Unfriend')); ?></a></li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                        </li>
                                                        <li class="eDrops">
                                                            <div class="dropdown">
                                                                <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="showCustomModal('<?php echo route('block_user', $post->post_id); ?>', 'Block')"><?php echo e(get_phrase('Block')); ?></a></li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                <?php else: ?>
                                                    <ul  class="d-flex eHfooter">
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="btn common_btn ac_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Cancle Friend Request')); ?>"><i class="fa-solid fa-xmark"></i> <?php echo e(get_phrase('Cancel')); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                        </li>
                                                    </ul>
                                                <?php endif; ?>
                                        <?php else: ?>   
                                            <ul class="d-flex eHfooter">
                                                <li> <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.friend',$post->user_id); ?>')" class="btn common_btn ac_btn"><i class="fa-solid fa-plus"></i> <?php echo e(get_phrase('Add Friend')); ?> </a></li>
                                                <li>  <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a></li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                        <?php elseif($has_memories): ?>
                            <div class="flex-shrink-0">
                                <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>"
                                    class="rounded-circle user_image_show_on_modal" alt="...">
                            </div>
                        <?php else: ?>
                            <div class="flex-shrink-0">
                                <img src="<?php echo e(get_user_image($post->id, 'optimized')); ?>"
                                    class="rounded-circle user_image_show_on_modal" alt="...">
                            </div>
                        <?php endif; ?>
                        <div class="ava-desc ms-2">
                            <h3 class="mb-0">
                                <?php if(isset($type) && $type == 'page'): ?>
                                    <a class="text-black ms-0"
                                        href="<?php echo e(route('single.page', $post->id)); ?>"><?php echo e($post->title); ?></a>
                                <?php elseif(isset($type) && $type == 'group'): ?>
                                    <a class="text-black ms-0"
                                        href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->name); ?></a>
                                <?php else: ?>
                            
                                <?php
                                
                                $currentDate = \Carbon\Carbon::now();
                                $badge = \App\Models\Badge::where('user_id', $post->user_id)
                                    ->whereDate('start_date', '<=', $currentDate)
                                    ->whereDate('end_date', '>=', $currentDate)
                                    ->first();
                                ?>
                                <div class="eUserFeature">
                                    <a class="text-black ms-0 badge"  href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->getUser->name); ?>

                                        <?php if($badge?->status == '1' && $badge->start_date <= now() && $badge->end_date >= now()): ?>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.1825 1.16051C11.5808 0.595046 12.4192 0.595047 12.8175 1.16051L13.8489 2.62463C14.1272 3.01962 14.648 3.15918 15.0865 2.95624L16.7118 2.20397C17.3395 1.91343 18.0655 2.33261 18.1277 3.02149L18.2889 4.80515C18.3324 5.28634 18.7137 5.66763 19.1948 5.71111L20.9785 5.87226C21.6674 5.9345 22.0866 6.66054 21.796 7.28825L21.0438 8.91352C20.8408 9.35198 20.9804 9.87284 21.3754 10.1511L22.8395 11.1825C23.405 11.5808 23.405 12.4192 22.8395 12.8175L21.3754 13.8489C20.9804 14.1272 20.8408 14.648 21.0438 15.0865L21.796 16.7118C22.0866 17.3395 21.6674 18.0655 20.9785 18.1277L19.1948 18.2889C18.7137 18.3324 18.3324 18.7137 18.2889 19.1948L18.1277 20.9785C18.0655 21.6674 17.3395 22.0866 16.7117 21.796L15.0865 21.0438C14.648 20.8408 14.1272 20.9804 13.8489 21.3754L12.8175 22.8395C12.4192 23.405 11.5808 23.405 11.1825 22.8395L10.1511 21.3754C9.87284 20.9804 9.35198 20.8408 8.91352 21.0438L7.28825 21.796C6.66054 22.0866 5.9345 21.6674 5.87226 20.9785L5.71111 19.1948C5.66763 18.7137 5.28634 18.3324 4.80515 18.2889L3.02149 18.1277C2.33261 18.0655 1.91343 17.3395 2.20397 16.7117L2.95624 15.0865C3.15918 14.648 3.01962 14.1272 2.62463 13.8489L1.16051 12.8175C0.595046 12.4192 0.595047 11.5808 1.16051 11.1825L2.62463 10.1511C3.01962 9.87284 3.15918 9.35198 2.95624 8.91352L2.20397 7.28825C1.91343 6.66054 2.33261 5.9345 3.02149 5.87226L4.80515 5.71111C5.28634 5.66763 5.66763 5.28634 5.71111 4.80515L5.87226 3.02149C5.9345 2.33261 6.66054 1.91343 7.28825 2.20397L8.91352 2.95624C9.35198 3.15918 9.87284 3.01962 10.1511 2.62463L11.1825 1.16051Z" fill="#329CE8"/>
                                            <path d="M7.5 11.83L10.6629 14.9929L17 8.66705" stroke="white" stroke-width="1.67647" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <?php else: ?>
                                        
                                        <?php endif; ?>
                                        <?php if($post->user_id != auth()->user()->id): ?>
                                            <?php
                                                $follow = \App\Models\Follower::where('user_id', auth()->user()->id)
                                                    ->where('follow_id', $post->user_id)
                                                    ->count();
                                            ?>
                                            <?php if($follow > 0): ?>
                                                <a href="javascript:void(0)"
                                                    onclick="ajaxAction('<?php echo route('user.unfollow', $post->user_id); ?>')"><?php echo e(get_phrase('Unfollow')); ?></a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)"
                                                    onclick="ajaxAction('<?php echo route('user.follow', $post->user_id); ?>')"><?php echo e(get_phrase('Follow')); ?></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                     
                                <?php if(Auth()->user()->id != $post->user_id): ?>
                                <div class="hoverFeature el_list">
                                    <div class="h_top">
                                        <div class="h_eImage">
                                            <img src="<?php echo e(get_user_image($post->user_id, 'optimized')); ?>">
                                        </div> 
                                        <div class="h_right_text">
                                            <h4><a href="<?php echo e(route('user.profile.view', $post->user_id)); ?>"><?php echo e($post->getUser->name); ?></a> </h4>
                                            <ul class="el_shift">
                                                    <li class="d-flex">
                                                        <i class="fas fa-user-friends"></i>
                                                        <?php
                                                        $number_of_my_friends = json_decode($user_info->friends, true);
                                                        $my_data = DB::table('users')->where('id', $post->getUser->id)->first();
                                                        $my_fr = json_decode($my_data->friends, true);
                                                        $mutual_fr = count(array_intersect($number_of_my_friends, $my_fr));
                                                        ?>
                                                        <p><?php echo e($mutual_fr); ?> <?php echo e(get_phrase('Mutual friend')); ?></p>
                                                    </li>
                                                    <li class="d-flex">
                                                        <i class="fa-solid fa-house-user"></i>
                                                        <p><?php echo e(get_phrase('Lives in')); ?> <strong><?php echo e($post->getUser->address); ?></strong> </p>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if($friend>0): ?>
                                            <?php if($friendAccepted->count()>0 && $friendAccepted->value('is_accepted') == 1): ?>
                                                <ul class="d-flex eHfooter">
                                                    <li>
                                                        <a href="#" class="btn common_btn ac_btn" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group"></i> <?php echo e(get_phrase('Friend')); ?> </a>
                                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <li><a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="dropdown-item custom_unfrind_button"> <i class="fa-solid fa-xmark"></i><?php echo e(get_phrase('Unfriend')); ?></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                    </li>
                                                    <li class="eDrops">
                                                        <div class="dropdown">
                                                            <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="showCustomModal('<?php echo route('block_user', $post->post_id); ?>', 'Block')"><?php echo e(get_phrase('Block')); ?></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            
                                            <?php else: ?>
                                                <ul  class="d-flex eHfooter">
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_id); ?>')" class="btn common_btn ac_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Cancle Friend Request')); ?>"><i class="fa-solid fa-xmark"></i> <?php echo e(get_phrase('Cancel')); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                                                    </li>
                                                </ul>
                                            <?php endif; ?>
                                    <?php else: ?>   
                                        <ul class="d-flex eHfooter">
                                            <li> <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.friend',$post->user_id); ?>')" class="btn common_btn ac_btn"><i class="fa-solid fa-plus"></i> <?php echo e(get_phrase('Add Friend')); ?> </a></li>
                                            <li>  <a href="<?php echo e(route('chat',$post->user_id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a></li>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                            
                                <?php endif; ?>
                                <!-- Check tagged users -->

                                <?php if($post->post_type == 'cover_photo'): ?>
                                    <small class="text-muted"><?php echo e(get_phrase('has changed cover photo')); ?></small>
                                <?php endif; ?>

                                <?php if($post->post_type == 'share'): ?>
                                    <?php if($post->publisher == 'memory'): ?>
                                        <small class="text-muted"><?php echo e(get_phrase('shared a memory')); ?></small>
                                    <?php else: ?>
                                        <small class="text-muted"><?php echo e(get_phrase('shared post')); ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if($post->post_type == 'live_streaming'): ?>
                                    <?php
                                        $live_description = json_decode($post->description, true);
                                    ?>
                                    <?php if(is_array($live_description) && $live_description['live_video_ended'] == 'yes'): ?>
                                        <small
                                            class="text-muted"><?php echo e(get_phrase('was on live ____', [date_formatter($post->created_at, 3)])); ?></small>
                                    <?php else: ?>
                                        <small class="text-muted"><?php echo e(get_phrase('is live now')); ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(count($tagged_user_ids) > 0 || $post->activity_id > 0): ?>
                                    <small class="text-muted">-</small>

                                    <!-- Feeling and activity -->
                                    <?php if($post->activity_id > 0): ?>
                                        <?php
                                            $feeling_and_activities = DB::table('feeling_and_activities')
                                                ->where('feeling_and_activity_id', $post->activity_id)
                                                ->first();
                                        ?>
                                        <?php if($feeling_and_activities->type == 'activity'): ?>
                                            <?php echo e($feeling_and_activities->title); ?>

                                        <?php else: ?>
                                            <spam class="text-muted"><?php echo e(get_phrase('feeling')); ?></spam>
                                            <b> <?php echo e($feeling_and_activities->title); ?> </b>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(count($tagged_user_ids) > 0): ?>
                                        <small class="text-muted"><?php echo e(get_phrase('with')); ?></small>
                                        <?php $__currentLoopData = $tagged_user_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tagged_user_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <small class="text-muted"><?php
                                                if ($key > 0) {
                                                    echo ',';
                                                }
                                            ?></small>
                                            <a class="text-black"
                                                href="<?php echo e(route('profile')); ?>"><?php echo e(DB::table('users')->where('id', $tagged_user_id)->value('name')); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(!empty($post->location)): ?>
                                    <small class="text-muted"><?php echo e(get_phrase('in')); ?></small> <a
                                        href="https://www.google.com/maps/place/<?php echo e($post->location); ?>"
                                        target="_blanck"><?php echo e($post->location); ?></a>
                                <?php endif; ?>
                            </h3>
                            <small class="meta-time text-muted"><?php echo e(date_formatter($post->created_at, 2)); ?></small>

                            <?php if($post->privacy == 'public'): ?>
                                <span class="meta-privacy text-muted" title="<?php echo e(ucfirst(get_phrase($post->privacy))); ?>"><i
                                        class="fa-solid fa-earth-americas"></i></span>
                            <?php elseif($post->privacy == 'private'): ?>
                                <span class="meta-privacy text-muted" title="<?php echo e(ucfirst(get_phrase($post->privacy))); ?>"><i
                                        class="fa-solid fa-user"></i></span>
                            <?php else: ?>
                                <span class="meta-privacy text-muted" title="<?php echo e(ucfirst(get_phrase($post->privacy))); ?>"><i
                                        class="fa-solid fa-users"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="post-controls dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu post_dots" aria-labelledby="navbarDropdown">
                            <input type="hidden" id="copy_post_<?php echo e($post->post_id); ?>"
                                value="<?php echo e(route('single.post', $post->post_id)); ?>">
                                
                                <li>
                                    <?php if($save_posts->contains($post->post_id)): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('unsave_post', ['id' => $post->post_id])); ?>">
                                            <i class="fa-solid fa-bookmark"></i> <?php echo e(get_phrase('Unsave Post')); ?>

                                        </a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="<?php echo e(route('save_post', ['id' => $post->post_id])); ?>">
                                            <i class="fa-regular fa-bookmark"></i> <?php echo e(get_phrase('Save Post')); ?>

                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0)" value="copy"
                                        onclick="copyToClipboard('copy_post_<?php echo e($post->post_id); ?>')"><img
                                            src="<?php echo e(asset('storage/images/link.png')); ?>"
                                            alt=""><?php echo e(get_phrase('Copy Link')); ?></a></li>
                            <?php if($post->user_id == auth()->user()->id): ?>
                                <?php if($post->post_type != 'live_streaming' && $post->location == ''): ?>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="showCustomModal('<?php echo route('edit_post_form', $post->post_id); ?>', '<?php echo e(get_phrase('Edit post')); ?>', 'lg')">
                                            <i class="fa-solid fa-pencil"></i> <?php echo e(get_phrase('Edit')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)"
                                        onclick="confirmAction('<?php echo route('post.delete', ['post_id' => $post->post_id]); ?>', true)"> <i
                                            class="fa-solid fa-trash-can"></i> <?php echo e(get_phrase('Delete')); ?></a>
                                </li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.main_content.create_report', 'post_id' => $post->post_id])); ?>', '<?php echo e(get_phrase('Report Post')); ?>');"
                                    data-bs-toggle="modal" data-bs-target="#createEvent"><img
                                        src="<?php echo e(asset('storage/images/report.png')); ?>"
                                        alt=""><?php echo e(get_phrase('Report')); ?>

                                </a></li>
                        </ul>
                    </div>
                </div>

                <!-- START POST VIEW -->
            
                <div class="entry-content pt-2">
                    <!-- post description -->

                    <?php if(
                        $post->post_type == 'general' ||
                            $post->post_type == 'profile_picture' ||
                            $post->post_type == 'cover_photo' ||
                            $post->post_type == 'paid_content'): ?>
                        <?php if(isset($subscription)): ?>
                            <?php if($subscription == 0): ?>
                                <?php if($post->privacy == 'friends'): ?>
                                    <?php $visibility = 'locked'; ?>
                                <?php else: ?>
                                    <?php $visibility = 'unlocked'; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php $visibility = 'unlocked'; ?>
                            <?php endif; ?>

                            <?php if($visibility == 'locked'): ?>
                                <?php
                                    $media = DB::table('media_files')
                                        ->where('post_id', $post->post_id)
                                        ->get();

                                    $cover_pic = DB::table('paid_content_creators')
                                        ->where('user_id', $post->user_id)
                                        ->value('cover_photo');
                                ?>
                                <?php if($media->count() == 0): ?>
                                    <?php echo $__env->make('frontend.paid_content.enable_lock_section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php else: ?>
                                    <?php echo script_checker($post->description); ?>
                                    <?php echo $__env->make('frontend.paid_content.enable_lock_section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo script_checker($post->description); ?>
                                <?php echo $__env->make('frontend.main_content.media_type_post_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php else: ?>
                        
                            <?php 
                            $description = $post->description;
                            $pattern = '/\bhttps?:\/\/\S+\b/';
                            $preg = preg_match($pattern, $description, $matches); 
                            ?>
                            <?php if($preg && !str_contains($matches[0] , request()->getHttpHost())): ?> 
                                <?php echo $post->description; ?>

                                <?php echo $__env->make('frontend.main_content.url_content', ['url' => $matches[0]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                                <?php echo $post->description; ?>

                                <?php echo $__env->make('frontend.main_content.media_type_post_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        
                        <?php endif; ?>

                    

                        <?php if(!empty($post->location)): ?>
                            <?php echo $__env->make('frontend.main_content.location_type_post_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                
                    <?php elseif($post->post_type == 'share' || $post->post_type == 'memory'): ?> 
                        <div class="py-1">
                            <div class="text-quote">
                                <?php if(\Illuminate\Support\Str::contains($post->description, 'http', 'https')): ?>
                                    <?php
                                        $explode_data = explode('/', $post->description);
                                        $shared_id = end($explode_data);
                                    

                                    ?>
                                    
                                    <iframe src="<?php echo e($post->description); ?>?shared=yes" onload="resizeIframe(this)"
                                        scrolling="no" class="w-100" frameborder="0"></iframe>
                                    <a class="ellipsis-line-1 ellipsis-line-2"
                                        href="<?php echo e($post->description); ?>"><?php echo e($post->description); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif($post->post_type == 'fundraisers'): ?>
                        <?php 
                            if(isset($post->publisher_id)){
                                $fundShare = \App\Models\Fundraiser::where('id', $post->publisher_id)->first();
                                $user_info = \App\Models\Users::where('id', $fundShare->user_id)->first();
                            }
                        ?>  
                        <div class="py-1">
                            <div class="text-quote image">
                                <?php if(isset($fundShare->cover_photo)): ?>
                                <a class="ellipsis-line-1 ellipsis-line-2" href="<?php echo e(route('fundraiser.profile', $fundShare->id)); ?>">
                                    <img src="<?php echo e(asset('assets/frontend/images/campaign/' . $fundShare->cover_photo)); ?>"
                                                class="card-img-top" alt="blog">
                                            <div class="fundraiser-text">
                                                <img src="<?php echo e(get_user_image($user_info->id, 'optimized')); ?>"
                                                class="rounded-circle user_image_show_on_modal" alt="...">
                                                <div class="fund-information">
                                                    <p><?php echo e($user_info->name); ?>'s <?php echo e(get_phrase('Campaign link')); ?></p>
                                                    <span><?php echo e($fundShare->title); ?></span>
                                                </div>
                                            </div>
                                            </a>
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('storage/blog/coverphoto/default/default.jpg')); ?>" class="card-img-top" alt="blog">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif($post->post_type == 'live_streaming'): ?>
                        <?php echo $__env->make('frontend.main_content.live_streaming_type_post_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
            
            </div>
            <!-- Comment Start -->
            <div class="user-comments s_comment d-hidden bg-white" id="user-comments-<?php echo e($post->post_id); ?>">

                <ul class="comment-wrap p-3 pt-0 pb-0 list-unstyled" id="comments<?php echo e($post->post_id); ?>">
                    <?php echo $__env->make('frontend.main_content.comments', [
                        'comments' => $comments,
                        'post_id' => $post->post_id,
                        'type' => 'post',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </ul>

                <?php if($comments->count() < $total_comments): ?>
                    <a class="btn view_btn_text p-3 pt-0"
                        onclick="loadMoreComments(this, <?php echo e($post->post_id); ?>, 0, <?php echo e($total_comments); ?>,'post')"><?php echo e(get_phrase('View more')); ?></a>
                <?php endif; ?>
                <div class="comment-form d-flex pb-3">
                    <img src="<?php echo e(get_user_image(Auth()->user()->photo, 'optimized')); ?>" alt=""
                        class="rounded-circle img-fluid h-39" width="40px">
                    <form action="javascript:void(0)" class="w-100 ms-2" method="post">
                        <input class="form-control py-3"
                            onkeypress="postComment(this, 0, <?php echo e($post->post_id); ?>, 0,'post');" rows="1"
                            placeholder="Write Comments">
                    </form>
                </div>
            </div>
        </div><!--  Single Entry End -->
        <?php endif; ?>
        <?php if(isset($search) && !empty($search)): ?>
            <?php if($loopIndex == 2): ?>
            <?php break; ?>
        <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo $__env->make('frontend.initialize', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/profile/checkins_list.blade.php ENDPATH**/ ?>