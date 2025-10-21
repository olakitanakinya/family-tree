<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/nice-select.css')); ?>">
<form class="ajaxForm  ng_form_entry" action="<?php echo e(route('page.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="#"><?php echo e(get_phrase('Page Name')); ?></label>
        <input type="text" class="border-0 bg-secondary" name="name" required placeholder="Enter your page Name">
    </div>
   
    <div class="form-group">
        <label for="#"><?php echo e(get_phrase('Page BIO')); ?></label>
        <textarea  name="description" class="border-0 bg-secondary content" id="description" rows="5" placeholder="Description"></textarea>
    </div>
   
    <div class="form-group">
        <label for="#"><?php echo e(get_phrase('Profile Photo')); ?></label>
        <input type="file" name="image" class="border-0 bg-secondary" id="image" class="form-control">
    </div>
    <div class="form-group gt_groups">
        <label for="#" ><?php echo e(get_phrase('Page Category')); ?></label>
        <select name="category" id="category" class="form-control select border-0 bg-secondary" required>
            <option value=""><?php echo e(get_phrase('Select Category')); ?></option>
            <?php $__currentLoopData = \App\Models\Pagecategory::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <button type="submit" class="w-100 mt-12 btn common_btn"><?php echo e(get_phrase('Create Page')); ?></button>
</form>


<?php echo $__env->make('frontend.initialize', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('assets/frontend/js/jquery.nice-select.min.js')); ?>"></script>
<script>
    $('document').ready(function(){
        $(".select").niceSelect();
    });
</script><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/pages/create_page.blade.php ENDPATH**/ ?>