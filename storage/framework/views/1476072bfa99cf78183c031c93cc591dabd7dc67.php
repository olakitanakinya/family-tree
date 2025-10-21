<?php if(isset($post_react) && $post_react == true): ?>
<div class="post-react d-flex align-items-center">
    <?php $unique_values = array_unique($user_reacts); ?>
    <ul class="react-icons">
        <?php $__currentLoopData = $unique_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_react): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($user_react == 'like'): ?>
                
                <li class="like-color h-22"><svg width="20" class="me-0" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.30176 16.8208L9.52422 19.0208C9.94003 19.3874 10.8756 19.5708 11.4993 19.5708H15.4494C16.6968 19.5708 18.0482 18.7458 18.36 17.6458L20.8548 10.9541C21.3746 9.67076 20.439 8.57076 18.8798 8.57076H14.7217C14.098 8.57076 13.5783 8.11243 13.6822 7.47076L14.202 4.53743C14.4099 3.71243 13.7862 2.79576 12.8506 2.52076C12.019 2.24576 10.9795 2.61243 10.5637 3.16243L6.30176 8.7541" fill="#5431EF"/>
                    <path d="M1 17.1838V7.81618C1 6.47794 1.48 6 2.6 6H3.4C4.52 6 5 6.47794 5 7.81618V17.1838C5 18.5221 4.52 19 3.4 19H2.6C1.48 19 1 18.5221 1 17.1838Z" fill="#5431EF"/>
                    </svg></li>
            <?php endif; ?>

            <?php if($user_react == 'love'): ?>
                <li><img class="w-22px" src="<?php echo e(asset('storage/images/love.svg')); ?>" alt=""></li>
            <?php endif; ?>

            <?php if($user_react == 'sad'): ?>
                <li><img class="w-17px" src="<?php echo e(asset('storage/images/sad.svg')); ?>" alt=""></li>
            <?php endif; ?>

            <?php if($user_react == 'angry'): ?>
                <li><img class="w-17px" src="<?php echo e(asset('storage/images/angry.svg')); ?>" alt=""></li>
            <?php endif; ?>

            <?php if($user_react == 'haha'): ?>
                <li><img class="w-17px" src="<?php echo e(asset('storage/images/haha.svg')); ?>" alt=""></li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php if(count($user_reacts) > 0): ?>
        <span class="react-count"><?php echo e(count($user_reacts)); ?></span>
    <?php else: ?>
        <span class="react-count">0 <?php echo e(get_phrase('Like')); ?></span>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if(isset($ajax_call) && $ajax_call): ?>
    <!--hr tag will be split by js to show different sections-->
    <hr>
<?php endif; ?>

<?php if(isset($my_react) && $my_react == true): ?>
    <?php if(array_key_exists($user_info->id, $user_reacts)): ?>
        <?php if($user_reacts[$user_info->id] == 'like'): ?>
            <div class="like-color">
                
                <svg width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.30176 16.8208L9.52422 19.0208C9.94003 19.3874 10.8756 19.5708 11.4993 19.5708H15.4494C16.6968 19.5708 18.0482 18.7458 18.36 17.6458L20.8548 10.9541C21.3746 9.67076 20.439 8.57076 18.8798 8.57076H14.7217C14.098 8.57076 13.5783 8.11243 13.6822 7.47076L14.202 4.53743C14.4099 3.71243 13.7862 2.79576 12.8506 2.52076C12.019 2.24576 10.9795 2.61243 10.5637 3.16243L6.30176 8.7541" fill="#5431EF"/>
                    <path d="M1 17.1838V7.81618C1 6.47794 1.48 6 2.6 6H3.4C4.52 6 5 6.47794 5 7.81618V17.1838C5 18.5221 4.52 19 3.4 19H2.6C1.48 19 1 18.5221 1 17.1838Z" fill="#5431EF"/>
                    </svg>
                    
                    
                <?php echo e(get_phrase('Liked')); ?>

            </div>
        <?php endif; ?>

        <?php if($user_reacts[$user_info->id] == 'love'): ?>
            <div class="love-color">
                <img class="w-22px mt--4px" src="<?php echo e(asset('storage/images/love.svg')); ?>" alt="">
                <?php echo e(get_phrase('Loved')); ?>

            </div>
        <?php endif; ?>

        <?php if($user_reacts[$user_info->id] == 'haha'): ?>
            <div class="sad-color">
                <img class="w-17px mt--4px" src="<?php echo e(asset('storage/images/haha.svg')); ?>" alt="">
                <?php echo e(get_phrase('Haha')); ?>

            </div>
        <?php endif; ?>

        <?php if($user_reacts[$user_info->id] == 'angry'): ?>
            <div class="angry-color">
                <img class="w-17px mt--4px" src="<?php echo e(asset('storage/images/angry.svg')); ?>" alt="">
                <?php echo e(get_phrase('Angry')); ?>

            </div>
        <?php endif; ?>

        <?php if($user_reacts[$user_info->id] == 'sad'): ?>
            <div class="sad-color">
                <img class="w-17px mt--4px" src="<?php echo e(asset('storage/images/sad.svg')); ?>" alt="">
                Sad
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if(isset($type)&&$type=="shorts"): ?>
            <div><i class="fa fa-thumbs-up <?php if(isset($type)&&$type=="shorts"): ?> shorts-icon-size <?php endif; ?>"></i></div>
        <?php else: ?>
            <div>
                <img class="w-17px mt--6px" src="<?php echo e(asset('storage/images/like2.svg')); ?>" alt="">
             <?php if(isset($type)&&$type=="shorts"): ?>  <?php else: ?> <?php echo e(get_phrase('Like')); ?> <?php endif; ?> </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/main_content/post_reacts.blade.php ENDPATH**/ ?>