
<div class="message-box chat_control bg-white border radius-8">
    <?php if(!empty($reciver_data)): ?>
    <div class="modal-header d-flex bg-secondary">
       
        <div class="avatar d-flex">
            <a href="#" class="d-flex align-items-center">
                <div class="avatar avatar-lg me-2">
                    <img src="<?php echo e(get_user_image($reciver_data->photo,'optimized')); ?>" class="rounded-circle h-45" alt="">
                    <?php if($reciver_data->isOnline()): ?>
                        <span class="online-status active"></span>
                    <?php endif; ?>
                </div>
                <div class="name">
                    <h4 class="m-0 h6"><?php echo e($reciver_data->name); ?></h4>
                    <?php if($reciver_data->isOnline()): ?>
                        <small class="d-block"><?php echo e(get_phrase('Active now')); ?></small>   
                    <?php else: ?>
                        <small class="d-block"> <?php echo e(\Carbon\Carbon::parse($reciver_data->lastActive)->diffForHumans()); ?></small>   
                    <?php endif; ?>
                </div>
            </a>
        </div>
        <div class="chat-actions">
            <a class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="<?php echo e(route('user.profile.view',$reciver_data->id)); ?>"><i class="fa fa-user"></i>
                        <?php echo e(get_phrase('View Profile')); ?></a></li>
            </ul>

        </div>
    </div>
    <div class="modal-body">
        <div class="modal-inner" id="messageShowDiv">
            <div class="message-body" id="message_body">
                <?php echo $__env->make('frontend.chat.single-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

     <?php endif; ?>   
        
        <?php
            if(session()->has('product_ref_id')){
                $product_url =  url('/')."/product/view/".session('product_ref_id');
            }
        ?>
        
        <div class="mt-action"> 
            <?php if(!empty($reciver_data)): ?>
            <!-- Chat textarea -->
            <form class="ajaxForm" id="chatMessageFieldForm" action="<?php echo e(route('chat.save')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                 <div class="nm_footer d-flex">
                    
                    <div class="d-flex w-100 message_b">
                            <input type="hidden" name="reciver_id" value="<?php echo e($reciver_data->id); ?>" id="">
                            <?php if($product!=null): ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product); ?>" >
                            <?php endif; ?>
                            <input type="hidden" name="thumbsup" value="0" id="ChatthumbsUpInput">
                            <input type="text" class="form-control mb-sm-0 mb-3 ms-1 " name="message" id="ChatmessageField" value="<?php if(isset($product_url)&&$product_url!=null): ?> <?php echo e($product_url); ?> <?php endif; ?>" placeholder="Type a message">
                            
                            <button class="btn btn-primary send no-processing no-uploading" id="ChatsentButton"><i class="fa-solid fa-paper-plane"></i></button>
                            
                    </div>
                   
                 </div>
                <button type="reset" id="messageResetBox" class="visibility-hidden"><?php echo e(get_phrase('Reset')); ?></button>
                <div class="mt-footer">
                    <div class="input-images d-hidden  image-uploader_custom_css" id="messageFileUploder">
                    </div>
                    <a href="javascript:void(0)" id="messgeImageUploader"><img src="<?php echo e(asset('assets/frontend/images/image-a.png')); ?>" alt=""></a>
                    
                </div>
            </form>
            <!-- Button -->
            <?php
                Session::forget('product_ref_id')
            ?>
             
              <?php else: ?>
              <div style="width: 100%; height: 500px; display:flex; justify-content:center; align-items:center; font-size:20px;">
                 <p><?php echo e(get_phrase('No Conversion Start!')); ?></p>
              </div> 
              <?php endif; ?>
        </div>
      
    </div>
</div>



<?php $__env->startSection('custom_js_code_for_chat'); ?>

<script>
    "use strict";

    $("#ChatmessageField").emojioneArea({
            pickerPosition: "top"
        });
    
    
    $(document).ready(function(){
        //msg scrolling
        var elem = document.getElementById('messageShowDiv');
        elem.scrollTop = elem.scrollHeight;

          
        setInterval(ajaxCallForDataLoad, 4000);   
    });

    $('.input-images:not(.initialized)').imageUploader({
        imagesInputName:'multiple_files',
        extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
        mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
        label: 'Drag & Drop files here or click to browse'
    });

        // $('.emojionearea').keyup(function() {
        //     let value = $('emojionearea').val();
        //     let stringlength = value.length;
        //     if(stringlength > 0){
        //         $('#ChatsentButton').removeClass('d-none');
        //         $('#ChatthumbsUp').addClass('d-none');
        //         $('#ChatthumbsUpInput').val('0');
        //     }else{
        //         $('#ChatsentButton').addClass('d-none');
        //         $('#ChatthumbsUp').removeClass('d-none');
        //         $('#ChatthumbsUpInput').val('1');
        //     }
        // });


    // $(document).ready(function() {
    //     setTimeout(function() {
    //         $('#ChatmessageField').val('');
    //     }, 2000);
    // });






    //imagae upload 
    $( "#messgeImageUploader" ).click(function() {
        $('#ChatsentButton').removeClass('d-none');
        $('#ChatthumbsUp').addClass('d-none');
        $('#messageFileUploder').toggle();
      });




    function ajaxCallForDataLoad() {
        var currentURL = $(location).attr('href'); 
        var id = currentURL.substring(currentURL.lastIndexOf('/') + 1);
        $.ajax({
            type : 'get',
            url : '<?php echo e(URL::to('/chat/inbox/load/data/ajax/' )); ?>',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data:{'id':id},
            success:function(response){
                console.log(response);
                distributeServerResponse(response);
                if(response.content !==undefined){
                    var elem = document.getElementById('messageShowDiv');
                    elem.scrollTop = elem.scrollHeight;
                } 
            }
        });
    }


    function ajaxCallForReadData() {
        var currentURL = $(location).attr('href'); 
        var id = currentURL.substring(currentURL.lastIndexOf('/') + 1);
        $.ajax({
            type : 'get',
            url : '<?php echo e(URL::to('/chat/inbox/read/message/ajax/' )); ?>',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data:{'id':id},
            success:function(response){
                console.log(response);
            }
        });
    }

    //chat search 
    $("#chatSearch").keyup(function(){
        
        let value= $(this).val();
        $.ajax({
            type : 'get',
            url : '<?php echo e(URL::to('/chat/profile/search/')); ?>',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data:{'search':value},
            success:function(response){
                console.log(response);
                $('#chatFriendList').html(response);
            }
        });
    });

    $(document).ready(function() {
    $('#chatMessageFieldForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way
        
        var form = $(this);
        var formData = form.serialize(); // Serialize the form data

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            success: function(response) {
                // Clear the input field
                $('#ChatmessageField').val('');
                // Optionally, you can also reset the Emoji area if you’re using emojioneArea:
                $("#ChatmessageField").emojioneArea().data("emojioneArea").setText('');
                
                // Append the new message to the message body
                $('#message_body').append(response.message); // Assuming `response.message` contains the new message HTML
                
                setTimeout(() => {
                    var elem = document.getElementById('messageShowDiv');
                    elem.scrollTop = elem.scrollHeight;
                }, 500);
                // Scroll to the bottom of the message container
                
            },
            error: function(xhr, status, error) {
                console.log(error); // Handle any errors here
            }
        });
    });
});





</script>





<?php $__env->stopSection(); ?><?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/chat/chat.blade.php ENDPATH**/ ?>