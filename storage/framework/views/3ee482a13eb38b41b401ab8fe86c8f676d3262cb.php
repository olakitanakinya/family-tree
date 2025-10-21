

<h4 class="widget-title mb-8"><?php echo e(get_phrase('Info')); ?></h4>
<ul>
    <li class="d-flex">
        <i class="fa fa-briefcase"></i> <span>
        <?php echo e($user_info->job); ?></span>
    </li>
    <li class="d-flex">
        <i class="fa-solid fa-graduation-cap"></i>
        <span><?php echo e(get_phrase('Studied at')); ?> <?php echo e($user_info->studied_at); ?></span>
    </li>
    <li class="d-flex">
        <i class="fa-solid fa-location-dot"></i>
        <span><?php echo e(get_phrase('From')); ?> <?php echo e($user_info->address); ?></span>
    </li>
    <li class="d-flex">
        <i class="fa-solid fa-user"></i>
        <span class="text-capitalize"><?php echo e(get_phrase($user_info->gender)); ?></span>
    </li>
    <li class="d-flex">
        <i class="fa-solid fa-clock"></i>
        <span><?php echo e(get_phrase('Joined')); ?> <?php echo e(date_formatter($user_info->created_at, 1)); ?></span>
    </li>
</ul>
<button onclick="showCustomModal('<?php echo route('profile.my_info', ['action_type' => 'edit']); ?>', '<?php echo e(get_phrase('Edit info')); ?>')" class="btn common_btn w-100 mt-8"><?php echo e(get_phrase('Edit Info')); ?></button>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/profile/my_info.blade.php ENDPATH**/ ?>