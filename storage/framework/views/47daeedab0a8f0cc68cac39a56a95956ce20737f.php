
<?php 
   $blockfriend = \App\Models\BlockUser::where('user_id', auth()->user()->id)->get();
?>
    
    <?php $__currentLoopData = $blockfriend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php 
        $userInfo = \App\Models\User::where('id', $friend->block_user)->first();
    ?>
    <div class="col-lg-6">
        <div class="single-item-countable d-flex friend-item align-items-center justify-content-between mb-3">
            <div class="n_request_control">
                <div class="d-flex align-items-center w-100">
                    <!-- Avatar -->
                    <div class="avatar">
                        <a href=""><img class="avatar-img rounded-circle user_image_show_on_modal" src="<?php echo e(get_user_image($userInfo->photo, 'optimized')); ?>" alt="" height="40" width="40"></a>
                    </div>
                    <div class="avatar-info ms-2">
                        <h6><a href=""><?php echo e($userInfo->name); ?></a></h6>
                    </div>
                </div>
                <div class="post-controls dropdown dotted">
                    <a class="dropdown-toggle" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo e(route('unblock_user',$friend->id)); ?>"><?php echo e(get_phrase('Unblock')); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/profile/block_friend.blade.php ENDPATH**/ ?>