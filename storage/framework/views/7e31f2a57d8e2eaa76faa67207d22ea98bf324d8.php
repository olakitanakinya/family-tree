
 
<div class="mypage-wrap ns_page" id="pagedata">
   
    <?php $__currentLoopData = $mypages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mypage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="smp-item d-flex align-items-center justify-content-between single-item-countable" id="page-<?php echo e($mypage->id); ?>" >
           <div class="d-flex align-items-center">
                <a href="<?php echo e(route('single.page',$mypage->id)); ?>">
                    <img src="<?php echo e(get_page_logo($mypage->logo, 'logo')); ?>" class="rounded-8px h-80" width="90px" alt="">
                </a>
                <div class="smp-info">
                    <a href="<?php echo e(route('single.page',$mypage->id)); ?>"> <h4 class="h6"><?php echo e(ellipsis($mypage->title,25)); ?></h4> </a>
                    <?php
                        $likecount = \App\Models\Page_like::where('page_id',$mypage->id)->count();
                    ?>
                    <a href="<?php echo e(route('single.page',$mypage->id)); ?>"><span><i class="fa fa-thumbs-up"></i><?php echo e($likecount); ?> <?php echo e(get_phrase('People like this')); ?></span></a>
                </div>
           </div>
            <div class="post-controls dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <?php if($mypage->user_id==auth()->user()->id): ?>
                            <a  onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.pages.edit-modal', 'page_id' => $mypage->id])); ?>', '<?php echo e(get_phrase('Edit Page')); ?>');" class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                data-bs-target="#edit-profile"><?php echo e(get_phrase('Edit')); ?></a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</div>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/pages/single-page.blade.php ENDPATH**/ ?>