<div class="profile-cover ">
    <div class="profile-header" style="background-image: url('<?php echo e(get_group_cover_photo($group->banner,"coverphoto")); ?>')">
        <div class="cover-btn-group ">
            <?php if($group->user_id==auth()->user()->id): ?>
            <button onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.groups.edit-modal', 'group_id' => $group->id])); ?>', '<?php echo e(get_phrase('Edit Group')); ?>');" class="btn  edit-cover " data-bs-toggle="modal"
                data-bs-target="#edit-profile"><i class="fa fa-pen"></i><?php echo e(get_phrase('Edit Group')); ?></button>
            <?php endif; ?>
            <?php if($group->user_id==auth()->user()->id): ?>
                <button onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.groups.edit-cover-photo','group_id'=>$group->id])); ?>', '<?php echo e(get_phrase('Update your cover photo')); ?>');" class="edit-cover btn n_edit"><i class="fa fa-camera"></i><?php echo e(get_phrase('Edit Cover Photo')); ?></button>
            <?php endif; ?>
        </div>
      
    </div>
    <div class="profile-avatar d-flex align-items-center ml-14">
        
        <div class="avatar-details n_details">
            <div class="n_ava_details">

                <div class="hero_discus">
                    <h3 class="mb-1"><?php echo e($group->title); ?></h3>
                    <div class="img_hero">
                        <?php $joined = \App\Models\Group_member::where('group_id',$group->id)->where('is_accepted','1')->count(); ?>
                       
                        
                       
                        
                        <p><?php echo e($joined); ?> <?php echo e(get_phrase('Member')); ?><?php echo e($joined>1?"s":""); ?></p>
                    </div>
                </div>

                <span class="mute d-block text-white"><?php echo e($group->subtitle); ?></span>
                <span class="mute d-block text-white"><?php echo e($group->privacy); ?></span>
               
            </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#newGroup" class="btn common_btn invite_btn"><i class="fa-solid fa-plus"></i><?php echo e(get_phrase('Invite')); ?></a>
        </div>
    </div>
</div>





<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/groups/cover-photo.blade.php ENDPATH**/ ?>