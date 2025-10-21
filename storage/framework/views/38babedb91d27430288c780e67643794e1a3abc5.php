
            <div class="widget ng_widget">
                <div class="w_btn">
                    <button class="btn common_btn d-block w-100" onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.groups.create'])); ?>', '<?php echo e(get_phrase(' Create New Group')); ?>');" data-bs-toggle="modal"
                        data-bs-target="#newGroup"><i class="fa fa-plus-circle"></i><?php echo e(get_phrase(' Create New Group')); ?></button>
                 </div>
                <div class="gr-search">
                    <h3 class="h6"><?php echo e(get_phrase('Groups')); ?></h3>
                    <form action="<?php echo e(route('search.group')); ?>" class="ag_form">
                        <input type="text" class="bg-secondary form-control rounded" name="search" value="<?php if(isset($_GET['search'])): ?> <?php echo e($_GET['search']); ?> <?php endif; ?>" placeholder="Search Group">
                        <span class="i fa fa-search"></span>
                    </form>
                </div>
           
            <div class="group-widget">
                <h3 class="widget-title"><?php echo e(get_phrase('Group you Manage')); ?></h3>
                    <?php $__currentLoopData = $managegroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $managegroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-center mt-3">
                            <div class="widget-img">
                                <img src="<?php echo e(get_group_logo($managegroup->logo,'logo')); ?>" alt="" class="img-fluid img-radisu">
                            </div>
                            <div class="widget-info">
                                <h6><a href="<?php echo e(route('single.group',$managegroup->id)); ?>"><?php echo e($managegroup->title); ?></a></h6>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($managegroups)>8): ?>
                        <a href="<?php echo e(route('group.user.created')); ?>" class="btn btn-primary mt-3 d-block w-100"><?php echo e(get_phrase('See All')); ?></a>
                    <?php endif; ?>
            </div> <!-- Widget End -->
            <div class=" group-widget join_wid">
                <h3 class="widget-title"><?php echo e(get_phrase('Group you Joined')); ?></h3>
                    <?php $__currentLoopData = $joinedgroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joinedgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-center mt-3">
                            <div class="widget-img">
                                <img src="<?php echo e(get_group_logo($joinedgroup->getGroup->logo,'logo')); ?>" alt="" class="img-fluid img-radisu">
                            </div>
                            <div class="widget-info">
                                <h6><a href="<?php echo e(route('single.group',$joinedgroup->group_id)); ?>"> <?php echo e($joinedgroup->getGroup->title); ?> </a></h6>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($joinedgroups)>8): ?>
                        <a href="<?php echo e(route('group.user.joined')); ?>" class="btn common_btn mt-3 d-block w-100"><?php echo e(get_phrase('See All')); ?></a>
                    <?php endif; ?>
            </div> <!-- Widget End -->
            </div> <!-- Widget End -->
           
 <!-- Group Sidebar End --><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/groups/right-sidebar.blade.php ENDPATH**/ ?>