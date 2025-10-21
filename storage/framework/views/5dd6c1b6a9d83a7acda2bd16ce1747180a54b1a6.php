
<?php
  $site_footer = \App\Models\Setting::where('type','system_footer')->value('description');
  $site_footer_url = \App\Models\Setting::where('type','system_footer_link')->value('description');
?>
 <!-- Start Footer -->
 <div class="copyright-text">
   <p><?php echo e(date('Y')); ?> &copy;  <a href="<?php echo e($site_footer_url); ?>"><span><?php echo e(get_phrase('By ____', [$site_footer])); ?></span></a></p>
 </div>
 <!-- End Footer --><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/backend/footer.blade.php ENDPATH**/ ?>