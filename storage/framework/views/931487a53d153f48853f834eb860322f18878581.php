<?php $user_info = Auth()->user() ?>

<div class="memories single-item-countable single-entry p-0">
    <div class="entry-inner p-0">
        <img src="<?php echo e(asset('assets/frontend/images/memories_background.png')); ?>" class="w-100" alt="memories-banner-area">
        <p class="text-center mb-0 pb-3 mt-2 px-5">
            <?php if($posts->count() > 0): ?>
                <?php echo e(get_phrase('We hope you enjoy revisiting and sharing your memories on Sociopro from the most recent moments to those from days gone by.')); ?>

            <?php else: ?>
                <span class="d-block"><?php echo e(get_phrase('No memories to view or share today.')); ?></span>
                <span class="d-block"><?php echo e(get_phrase("We'll notify you when there are some to reminisce about")); ?></span>
            <?php endif; ?>
        </p>
    </div>
</div>

<div id="memories_content">
    <?php echo $__env->make('frontend.main_content.posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php echo $__env->make('frontend.main_content.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/main_content/memories.blade.php ENDPATH**/ ?>