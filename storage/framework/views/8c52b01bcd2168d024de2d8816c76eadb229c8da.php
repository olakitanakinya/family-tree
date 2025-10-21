
   
<?php $__env->startSection('content'); ?>
<?php if(isset($error) && $error != "") { ?>
  <div class="row ins-seven">
    <div class="col-md-8 col-md-offset-2">
      <div class="alert alert-danger">
        <strong><?php echo e($error); ?></strong>
      </div>
    </div>
  </div>
<?php } ?>
<div class="row justify-content-center ins-two">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body px-4">
        <div class="panel panel-default ins-three" data-collapsed="0">
          <!-- panel body -->
          <div class="panel-body ins-four">
            <p class="ins-four">
              <?php echo e(__('Provide your codecanyon')); ?> <strong><?php echo e(__('purchase code')); ?></strong>
            </p>
            <br>
            <div class="row">
              <div class="col-md-12">
                <form method="POST" enctype="multipart/form-data" class="d-block ajaxForm" action="<?php echo e(route('install.validate')); ?>">
                  <?php echo csrf_field(); ?> 
                  <div class="form-group">
                    <label class="control-label"><?php echo e(__('Purchase Code')); ?></label>
                      <input type="text" class="form-control eForm-control" name="purchase_code" placeholder="Product's Purchase Code"
                        required autofocus autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label"></label>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Continue')); ?></button>
                  </div>
                </form>
                <br>
                <p>
                  <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">
                    <strong><?php echo e(__('Where to get my purchase code ?')); ?></strong>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('install.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/fadcmkvb/familytree.fadcgroup.org/resources/views/install/step2.blade.php ENDPATH**/ ?>