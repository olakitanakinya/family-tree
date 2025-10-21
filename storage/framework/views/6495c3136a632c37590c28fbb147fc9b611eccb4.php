<?php
use App\Models\Follower;
if(isset($page_identifire)) {
    $identifires = $page_identifire; 
}else{
    $identifires = 'user'; 
}

?>
<?php if($user_data->id!=auth()->user()->id): ?>
<div class="widget page-widget ac_control_we">
    <div class="user_ac">
        <?php
            $user_id = $user_data->id;
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
        

            <?php if($friend>0): ?>
                <?php if($friendAccepted->count()>0 && $friendAccepted->value('is_accepted') == 1): ?>
                    <a href="#" class="btn common_btn ac_btn" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group"></i> <?php echo e(get_phrase('Friend')); ?> </a>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <li><a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_data->id); ?>')" class="dropdown-item custom_unfrind_button"> <i class="fa-solid fa-user-xmark"></i> <?php echo e(get_phrase('Unfriend')); ?></a></li>

                        <?php if($user_data->id != auth()->user()->id): ?>
                        <?php
                            $follow = \App\Models\Follower::where('user_id', auth()->user()->id)
                                ->where('follow_id', $user_data->id)
                                ->count();
                        ?>
                    
                        <li>
                            <?php if($follow > 0): ?>
                                <a href="javascript:void(0)" class="dropdown-item custom_unfrind_button" 
                                    onclick="ajaxAction('<?php echo e(route('user.unfollow', ['id' => $user_data->id])); ?>')"><i class="fa-solid fa-square-xmark"></i> <?php echo e(get_phrase('Unfollow')); ?></a>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="dropdown-item custom_unfrind_button"
                                    onclick="ajaxAction('<?php echo e(route('user.follow', ['id' => $user_data->id])); ?>')"><i class="fa-regular fa-calendar-plus"></i> <?php echo e(get_phrase('Follow')); ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                    


                    </ul>
                    <a href="<?php echo e(route('chat',$user_data->id)); ?>" class="btn common_btn ac_btn"><i class="fa-solid fa-message"></i> <?php echo e(get_phrase('Message')); ?></a>
                <?php else: ?>
                    <form class="ajaxForm" action="<?php echo e(route('profile.accept_friend_request')); ?>" method="post">
                        <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.unfriend',$user_data->id); ?>')" class="btn common_btn px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Cancle Friend Request')); ?>"><i class="fa-solid fa-xmark"></i> <?php echo e(get_phrase('Cancel')); ?></a>
	            		<?php echo csrf_field(); ?>
	            		<input type="hidden" name="user_id" value="<?php echo e($user_data->id); ?>">

	                	
                            <?php if($friendAccepted->value('requester') == auth()->user()->id): ?>
                                <button type="button" class="btn common_btn_2 px-4 no-processing no-uploading" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Friend request')); ?>">
                                    <?php echo e(get_phrase('Requested')); ?>

                                </button>
                            <?php else: ?>
                                <button type="submit" id="friendRequestConfirmBtn<?php echo e($user_data->id); ?>" class="btn common_btn px-4 no-processing no-uploading" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Accept Friend Request')); ?>">
                                    <?php echo e(get_phrase('Accept')); ?>

                                </button>
                            <?php endif; ?>

	                	<button type="button" id="friendRequestAcceptedBtn<?php echo e($user_data->id); ?>" class="btn common_btn d-hidden ac_btn  px-4" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(get_phrase('Accepted')); ?>"><?php echo e(get_phrase('Accepted')); ?></button>
                    </form>
                <?php endif; ?>
            <?php else: ?>   
                <a href="javascript:void(0)" onclick="ajaxAction('<?php echo route('user.friend',$user_data->id); ?>')" class="btn common_btn ac_btn"><i class="fa-solid fa-plus"></i> <?php echo e(get_phrase('Add Friend')); ?> </a>
            <?php endif; ?>
        
    </div>
</div>
<?php endif; ?>

<?php 
$media_files = DB::table('media_files')->where('user_id', $user_data->id)
                    ->whereNull('story_id')
                    ->whereNull('page_id')
                    ->whereNull('chat_id')
                    ->whereNull('product_id')
                    ->whereNull('group_id')
                    ->take(9)->orderBy('id', 'desc')->get(); 
?>
<aside class="sidebar ">
    <div class="widget intro-widget">
        <h4><?php echo e(get_phrase('Intro')); ?></h4>

        <div class="my-about">
            <?php echo e(nl2br($user_data->about)); ?>

        </div>

        <form class="ajaxForm d-hidden edit-bio-form" action="<?php echo e(route('profile.about', ['action_type' => 'update'])); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <textarea name="about" class="form-control"><?php echo e($user_info->about); ?></textarea>
            </div>
            <div class="mb-3">
                    <button type="submit" class="btn common_btn w-100"><?php echo e(get_phrase('Save Bio')); ?></button>
            </div>
        </form>
    </div>
    <div class="widget" id="my-profile-info">
        <h4 class="widget-title mb-14"><?php echo e(get_phrase('Info')); ?></h4>
        <ul>
            <li>
                <i class="fa fa-briefcase"></i> <span>
                <strong><?php echo e($user_data->job); ?></strong></span>
            </li>
            <li>
                <i class="fa-solid fa-graduation-cap"></i>
                <span><?php echo e(get_phrase('Stadied at')); ?> <strong><?php echo e($user_data->studied_at); ?></strong></span>
            </li>
            <li>
                <i class="fa-solid fa-location-dot"></i>
                <span><?php echo e(get_phrase('From')); ?> <strong><?php echo e($user_data->address); ?></strong></span>
            </li>
            <li>
                <i class="fa-solid fa-user"></i>
                <span><strong class="text-capitalize"><?php echo e(get_phrase($user_data->gender)); ?></strong></span>
            </li>
            <li>
                <i class="fa-solid fa-clock"></i>
                <span><?php echo e(get_phrase('Joined')); ?> <strong><?php echo e(date_formatter($user_data->created_at, 1)); ?></strong></span>
            </li>
        </ul>
    </div>
    <div class="widget">
        <h4 class="widget-title"><?php echo e(get_phrase('Photo')); ?>/<?php echo e(get_phrase('Video')); ?></h4>
        <div id="sidebarPhotoAndVideos" class="row row-cols-3 g-1 mt-3">
            <?php $__currentLoopData = $media_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media_file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($media_file->file_type == 'video'): ?>
                        <div class="single-item-countable col">
                            <a href="<?php echo e(route('single.post',$media_file->post_id)); ?>">
                                <video muted controlsList="nodownload" class="img-thumbnail w-100 user_info_custom_height">
                                    <source src="<?php echo e(get_post_video($media_file->file_name)); ?>" type="">
                                </video>
                            </a>
                        </div>
                <?php else: ?>
                    <div class="single-item-countable col"><a href="<?php echo e(route('single.post',$media_file->post_id)); ?>"><img class="img-thumbnail w-100 user_info_custom_height"  src="<?php echo e(get_post_image($media_file->file_name, 'optimized')); ?>" alt=""></a></li></div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <a href="<?php echo e(route('user.photos',[$user_data->id , 'identifire' => $identifires])); ?>" class="btn common_btn mt-3 d-block mx-auto"><?php echo e(get_phrase('See More')); ?></a>
    </div>
    <!--  Widget End -->
    <div class="widget friend-widget">
        <?php
            $friends = DB::table('friendships')->where(function ($query) use ($user_data) {
            $query->where('accepter', $user_data->id)
                ->orWhere('requester', $user_data->id);
            })
            ->where('is_accepted', 1)
            ->orderBy('friendships.importance', 'desc');
        ?>
        <div
            class="widget-header mb-3 d-flex justify-content-between align-items-center">
            <h4 class="widget-title"><?php echo e(get_phrase('Friends')); ?></h4>
            <span><?php echo e($friends->get()->count()); ?> <?php echo e(get_phrase('Friends')); ?></span>
        </div>

        <div class="row row-cols-3 g-1 mt-3">
            <?php $__currentLoopData = $friends->take(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($friend->requester == $user_data->id): ?>
                    <?php $friends_user_data = DB::table('users')->where('id', $friend->accepter)->first(); ?>
                <?php else: ?>
                    <?php $friends_user_data = DB::table('users')->where('id', $friend->requester)->first(); ?>
                <?php endif; ?>

                <div class="col">
                    <a href="<?php echo e(route('user.profile.view',$friends_user_data->id)); ?>" class="friend d-block">
                        <img width="100%" class="h-90" src="<?php echo e(get_user_image($friends_user_data->photo, 'optimized')); ?>" alt="">
                        <h6 class="small"><?php echo e($friends_user_data->name); ?></h6>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <a href="<?php echo e(route('user.friends',$user_data->id)); ?>" class="btn common_btn mt-3 d-block mx-auto"><?php echo e(get_phrase('See More')); ?></a>
    </div>
    <!--  Widget End -->
   
    <!--  Widget End -->
</aside><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/user/single_user/user_info.blade.php ENDPATH**/ ?>