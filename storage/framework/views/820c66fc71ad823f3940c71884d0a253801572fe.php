<aside class="sidebar">
    <div class="widget">
        <div class="chat-header mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="widget-title"><?php echo e(get_phrase('Chats')); ?> </h3>
                <div class="alter-link">
                    <a href="#"><i class="fas fa-message"></i></a>
                </div>
            </div>
            <form action="" class="search-form mb-8">
                <input class="bg-secondary rounded" type="search" id="chatSearch" placeholder="Search">
                <span><i class="fa fa-search"></i></span>
            </form>
        </div>
        <div class="contact-lists" id="chatFriendList">
            <?php if(!empty($reciver_data)): ?>
            <?php echo $__env->make('frontend.chat.single-chated', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
            <div style="height:400px"></div>
            <?php endif; ?>
        </div>
    </div>
</aside>



<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/chat/chated.blade.php ENDPATH**/ ?>