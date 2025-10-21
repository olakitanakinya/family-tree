<div class="row rightSideBarToggler d-hidden">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body text-end">
                <button class="btn" onclick="toggleRightSideBar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<aside class="sidebar mt-0 sidebarToggle d-hidden" id="sidebarToggle">
    <?php if(Route::currentRouteName() == 'timeline' ||
            Route::currentRouteName() == 'pages' ||
            Route::currentRouteName() == 'allproducts' ||
            Route::currentRouteName() == 'filter.product' ||
            Route::currentRouteName() == 'userproduct' ||
            Route::currentRouteName() == 'single.product' ||
            Route::currentRouteName() == 'videos' ||
            Route::currentRouteName() == 'shorts' ||
            Route::currentRouteName() == 'save.all.view' ||
            Route::currentRouteName() == 'event' ||
            Route::currentRouteName() == 'userevent' ||
            Route::currentRouteName() == 'event' ||
            Route::currentRouteName() == 'blogs' ||
            Route::currentRouteName() == 'category.blog' ||
            Route::currentRouteName() == 'myblog' ||
            Route::currentRouteName() == 'notifications' ||
            Route::currentRouteName() == 'general.timeline' ||
            Route::currentRouteName() == 'page.view' ||
            Route::currentRouteName() == 'memories' ||
            Route::currentRouteName() == 'badge' || 
            Route::currentRouteName() == 'badge.info' ||
            Route::currentRouteName() == 'fundraiser.index' ||
            Route::currentRouteName() == 'fundraiser.category' ||
            Route::currentRouteName() == 'fundraiser.myactivity' ||
            Route::currentRouteName() == 'fundraiser.donor' ||
            Route::currentRouteName() == 'fundraiser.payment' ||
            Route::currentRouteName() == 'fundraiser.create'||
            Route::currentRouteName() == 'fundraiser.edit' || 
            Route::currentRouteName() == 'fundraiser.search' ||
            Route::currentRouteName() == 'creator.payout'||
            Route::currentRouteName() == 'jobs' || 
            Route::currentRouteName() == 'job.myjob' || 
            Route::currentRouteName() == 'job.save.view' || 
            Route::currentRouteName() == 'job.apply.all.list' || 
            Route::currentRouteName() == 'job.my.apply.list' || 
            Route::currentRouteName() == 'job.single.details' ||
            Route::currentRouteName() == 'job.payment.history' ||
            Route::currentRouteName() == 'create.job' || 
            Route::currentRouteName() == 'job.edit'|| 
            Route::currentRouteName() == 'about.view'|| 
            Route::currentRouteName() == 'policy.view'||
            Route::currentRouteName() == 'single.post' ||
            Route::currentRouteName() == 'album.details.list'||
            Route::currentRouteName() == 'create.blog'||
            Route::currentRouteName() == 'search' ||
            Route::currentRouteName() == 'search.people' ||
            Route::currentRouteName() == 'search.post' ||
            Route::currentRouteName() == 'search.video' || 
            Route::currentRouteName() == 'search.product' ||
            Route::currentRouteName() == 'search.group.specific' ||
            Route::currentRouteName() == 'search.page' ||
            Route::currentRouteName() == 'search.event' ||
            Route::currentRouteName() == 'job.apply.form'||
            Route::currentRouteName() == 'search.type'||
            Route::currentRouteName() == 'product.saved'||
            Route::currentRouteName() == 'ai_image.image_generator'
              
            ): ?>
        <div class="widget">
            <div class="d-flex align-items-center">
                <?php

                    $tz = auth()->user()->timezone;
                    if (!empty($tz)) {
                        $timestamp = time();
                        $dt = new DateTime('now', new DateTimeZone($tz)); //first argument "must" be a string
                        $dt->setTimestamp($timestamp);
                        $current_hour = $dt->format('H');
                    } else {
                        $current_hour = date('H', time());
                    }
                ?>

                <?php if($current_hour >= 5 && $current_hour < 12): ?>
                    <img class="img-fluid" src="<?php echo e(asset('assets/frontend/images/sun.svg')); ?>" height="30px"
                        width="30px" alt="">
                <?php elseif($current_hour >= 12 && $current_hour < 17): ?>
                    <img class="img-fluid" src="<?php echo e(asset('storage/images/cloud-sun.png')); ?>" alt="">
                    
                <?php else: ?>
                  <img class="img-fluid" src="<?php echo e(asset('assets/frontend/images/moon2.png')); ?>" height="30px"
                width="30px" alt="">
                <?php endif; ?>
                <h3 class="h6 ms-2"><?php echo e(get_phrase('Hi')); ?>, <?php echo e(Auth()->user()->name); ?>

                    <?php if($current_hour >= 5 && $current_hour < 12): ?>
                        <span class="d-block text-primary"><?php echo e(get_phrase('Good Morning')); ?>!</span>
                    <?php elseif($current_hour >= 12 && $current_hour < 17): ?>
                        <span class="d-block text-primary"><?php echo e(get_phrase('Good Afternoon')); ?>!</span>
                    <?php else: ?>
                        <span class="d-block text-primary"><?php echo e(get_phrase('Good Evening')); ?>!</span>
                    <?php endif; ?>
                </h3>
            </div>
        </div> <!-- Widget End -->
        <div class="widget sponser_widget">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="widget-title"><?php echo e(get_phrase('Sponsored')); ?> </h3>

            </div>
            <div class="sponsors">
                <?php

                    $sponsorPost = \App\Models\Sponsor::orderBy('id', 'desc')

                        ->where(function ($query) {
                            $query->where('start_date', '<', date('Y-m-d H:i:s'))->orWhere(function ($query) {
                                $query->where('start_date', '=', date('Y-m-d H:i:s'))->whereTime('start_date', '<=', date('Y-m-d H:i:s'));
                            });
                        })
                        ->where(function ($query) {
                            $query->where('end_date', '>', date('Y-m-d H:i:s'))->orWhere(function ($query) {
                                $query->where('end_date', '=', date('Y-m-d H:i:s'))->whereTime('end_date', '>=', date('Y-m-d H:i:s'));
                            });
                        })
                        ->where('status', 1)
                        ->limit('6')
                        ->get();
                ?>
                <?php $__currentLoopData = $sponsorPost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a target="_blank" href="<?php echo e($sponsor->ext_url); ?>">
                        <div class="sponsor d-flex d-md-block d-xl-flex  mb-1 text-lg-center text-xl-start">
                            <img src="<?php echo e(get_sponsor_image($sponsor->image, 'thumbnail')); ?>"
                                class="sponsor_post_image_size " alt="">
                            <div class="sponsor-txt ms-2 ">
                                <h6><?php echo e(ellipsis($sponsor->name, 30)); ?></h6>
                                <p class="ellipsis-line-3 pe-2 text-dark">
                                    <?php echo e(ellipsis(strip_tags($sponsor->description, 100))); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div> <!-- Widget End -->
        <div class="widget">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="widget-title"><?php echo e(get_phrase('Active users')); ?> </h3>
                <div class="d-flex align-items-center widget-controls">

                </div>
            </div>
            <div class="contact-lists side_contact mt-3">
                <?php
                    $friends = \App\Models\Friendships::where(function ($query) {
                        $query->where('accepter', auth()->user()->id)->orWhere('requester', auth()->user()->id);
                    })
                        ->where('is_accepted', 1)
                        ->get();
                 // Block User Each Other
                $blockedByUser = DB::table('block_users')->where('user_id', auth()->user()->id)->pluck('block_user')->toArray();
                $blockedByOthers = DB::table('block_users')->where('block_user', auth()->user()->id)->pluck('user_id')->toArray();
                ?>
                <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                //  User Block
                if (in_array($friend->accepter, $blockedByUser)) {
                        continue;
                    }
                    if (in_array($friend->requester, $blockedByOthers)) {
                        continue;
                    }
                
                ?>
                    <?php if($friend->requester == auth()->user()->id): ?>
                        
                        <?php if(!empty($friend->getFriendAccepter) && $friend->getFriendAccepter->isOnline()): ?>
                            <?php if($friend->getFriendAccepter->id != auth()->user()->id): ?>
                                <div class="single-contact d-flex align-items-center justify-content-between">
                                    <div class="avatar d-flex">
                                        <a href="<?php echo e(route('chat', $friend->getFriendAccepter->id)); ?>"
                                            class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <img src="<?php echo e(get_user_image($friend->getFriendAccepter->photo, 'optimized')); ?>"
                                                    class="rounded-circle w-45px" alt="">
                                                <span class="online-status active"></span>
                                            </div>
                                            <h4><?php echo e($friend->getFriendAccepter->name); ?></h4>
                                        </a>
                                    </div>
                                    <div class="login-time">

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($friend->getFriend->isOnline()): ?>
                            <?php if($friend->getFriend->id != auth()->user()->id): ?>
                                <div class="single-contact d-flex align-items-center justify-content-between">
                                    <div class="avatar d-flex">
                                        <a href="<?php echo e(route('chat', $friend->getFriend->id)); ?>"
                                            class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <img src="<?php echo e(get_user_image($friend->getFriend->photo, 'optimized')); ?>"
                                                    class="rounded-circle w-45px h-45" alt="">
                                                <span class="online-status active"></span>
                                            </div>
                                            <h4><?php echo e($friend->getFriend->name); ?></h4>
                                        </a>
                                    </div>
                                    <div class="login-time">

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div> <!-- Widget End -->
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'profile' ||
            Route::currentRouteName() == 'profile.photos' ||
            Route::currentRouteName() == 'profile.videos' ||
            Route::currentRouteName() == 'profile.friends'): ?>
        <?php echo $__env->make('frontend.profile.profile_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'groups' || Route::currentRouteName() == 'search.group'): ?>
        <?php echo $__env->make('frontend.groups.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'single.group' ||
            Route::currentRouteName() == 'group.people.info' ||
            Route::currentRouteName() == 'group.event.view' ||
            Route::currentRouteName() == 'single.group.photos' ||
            Route::currentRouteName() == 'all.people.group.view'): ?>
        <?php echo $__env->make('frontend.groups.bio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'single.page' ||
            Route::currentRouteName() == 'single.page.photos' ||
            Route::currentRouteName() == 'page.videos'): ?>
        <?php echo $__env->make('frontend.pages.bio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'single.event'): ?>
        <aside class="sidebar  event_side border-none">
            <div class="widget guest">
                <a href="<?php echo e(url()->previous()); ?>" class="btn common_btn mb-12"> <i class="fa-solid fa-left-long"></i>  <?php echo e(get_phrase('Back')); ?></a>
                <div class="d-flex justify-content-between">
                    <h3 class="widget-title"><?php echo e(get_phrase('Guests')); ?></h3>
                    <a href="javascript:void(0)"
                        onclick="showCustomModal('<?php echo e(route('load_modal_content', ['view_path' => 'frontend.events.view-all', 'event_id' => $event->id])); ?>', '<?php echo e(get_phrase('All Going And Interested User')); ?>');"
                        data-bs-toggle="modal" data-bs-target="#viewAll"
                        class="fw-bold text-primary"><?php echo e(get_phrase('View All')); ?></a>
                </div>
                <div class="d-flex gt_control justify-content-center  mt-3">
                    <div class="going">
                        <?php
                            $directly_going_data = json_decode($event->going_users_id) != null ? count(json_decode($event->going_users_id)) : '0';
                            $invite_going_data = $invited_friend_going;
                            $total = $directly_going_data + $invite_going_data;
                        ?>
                        <span class="rounded-2"><?php echo e($total); ?> </span>
                        Going
                    </div>
                    <div class="going">
                        <span
                            class="rounded-2"><?php echo e(json_decode($event->interested_users_id) != null ? count(json_decode($event->interested_users_id)) : '0'); ?></span>
                        Interested
                    </div>
                </div>
            </div> <!-- Widget End -->
            <div class="widget">
                <h3 class="widget-title"><?php echo e(get_phrase('Go With Friends')); ?></h3>
                <div class="gr-search">
                    <form action="#">
                        <input type="text" class="bg-secondary rounded" id="myInputSearch"
                            onkeyup="mySearchFunction()" placeholder="Search">
                        <span class="i fa fa-search"></span>
                    </form>
                </div>

                <div class="invite-wrap nw_wrap overflow-auto mt-3">
                    <table id="myTable" class="w-100">
                        <tbody class="searchTbody">
                            <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php $invited_friend_id = $friend->requester==auth()->user()->id ? $friend->accepter:$friend->requester; ?>
                                
                                <?php
                                    $inviteablefrienddetails = DB::table('users')
                                        ->where('id', $invited_friend_id)
                                        ->first();
                                ?>
                                
                                <?php
                                    $invite_details = DB::table('invites')
                                        ->where('invite_reciver_id', $invited_friend_id)
                                        ->where('event_id', $event->id)
                                        ->first();
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-between s-invite">
                                            <div class="ava-img d-flex align-items-center">
                                                <a
                                                    href="<?php echo e(route('user.profile.view', $inviteablefrienddetails->id)); ?>"><img
                                                        width="40" class="user-round h-33"
                                                        src="<?php echo e(get_user_image($inviteablefrienddetails->photo, 'optimized')); ?>"
                                                        alt=""></a>
                                                <h3 class="h6 mb-0"><a
                                                        href="<?php echo e(route('user.profile.view', $inviteablefrienddetails->id)); ?>"><?php echo e(ellipsis($inviteablefrienddetails->name, 20)); ?></a>
                                                </h3>
                                            </div>
                                            <div class="invite_button_css">
                                                <?php if(
                                                    !empty($invite_details) &&
                                                        $invite_details->invite_reciver_id == $invited_friend_id &&
                                                        $invite_details->is_accepted != '1'): ?>
                                                    <button class="btn common_btn_2 px-1 py-0 me-1 text-primary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="<?php echo e(get_phrase('Invited')); ?>"> Invited</button>
                                                <?php elseif(
                                                    !empty($invite_details) &&
                                                        $invite_details->invite_reciver_id == $invited_friend_id &&
                                                        $invite_details->is_accepted == '1'): ?>
                                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="<?php echo e(get_phrase('Going')); ?>"
                                                        class="btn px-1 py-0 me-1 text-success"> <i
                                                            class="far fa-calendar-check"></i> </button>
                                                <?php else: ?>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="<?php echo e(get_phrase('Send invitations')); ?>"
                                                        href="javascript:void(0)"
                                                        onclick="ajaxAction('<?php echo route('event.invite', ['invited_friend_id' => $invited_friend_id, 'requester_id' => auth()->user()->id, 'event_id' => $event->id]); ?>')"
                                                        class="btn common_btn px-1 py-0 me-1">invite</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- Widget End -->

            <div class="widget p-event-widget">
                <h3 class="widget-title mb-3"><?php echo e(get_phrase('Popular Events')); ?></h3>
                <?php $index=1;
               
               
                
                ?>
                <?php $__currentLoopData = $popularevents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $popularevent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class=" ">
                        <div class="popular-event e_popular m_product m_event event-card">
                            <a href="<?php echo e(route('single.event', $popularevent['id'])); ?>"><img class="img-fluid w-100" src="<?php echo e(viewImage('event', $popularevent['banner'], 'thumbnail')); ?>" alt="">
                                <div class="event-date n_date">
                                    <?php $date = explode("-",$popularevent['event_date']); ?>
                                    <p class="eve_t_text">
                                        <?php echo e(date('M', strtotime($popularevent['event_date']))); ?>

                                    </p>
                                    <span><?php echo e($date['2']); ?></span>
                                </div>
                            </a>
                           
                            <div class="event-text og_event_text ">
                                <small class="event-meta"><?php echo e(date('D', strtotime($popularevent['event_date']))); ?>, at
                                    <?php echo e($popularevent['event_time']); ?>

                                  </small>
                            </div>
                            <div class="pp-info p-20">
                                <small class="mute e_location">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_16_74" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                            width="20" height="20">
                                            <rect width="20" height="20" fill="#D9D9D9" />
                                        </mask>
                                        <g mask="url(#mask0_16_74)">
                                            <path
                                                d="M10.0026 16.1248C11.697 14.5693 12.954 13.1561 13.7734 11.8853C14.5929 10.6144 15.0026 9.48595 15.0026 8.49984C15.0026 6.98595 14.52 5.74637 13.5547 4.78109C12.5894 3.81581 11.4054 3.33317 10.0026 3.33317C8.59983 3.33317 7.4158 3.81581 6.45052 4.78109C5.48524 5.74637 5.0026 6.98595 5.0026 8.49984C5.0026 9.48595 5.41233 10.6144 6.23177 11.8853C7.05121 13.1561 8.30816 14.5693 10.0026 16.1248ZM10.0026 17.7707C9.80816 17.7707 9.61371 17.736 9.41927 17.6665C9.22483 17.5971 9.05121 17.4929 8.89844 17.354C7.99566 16.5207 7.19705 15.7082 6.5026 14.9165C5.80816 14.1248 5.2283 13.3575 4.76302 12.6144C4.29774 11.8714 3.94358 11.1561 3.70052 10.4686C3.45747 9.78109 3.33594 9.12484 3.33594 8.49984C3.33594 6.4165 4.00608 4.75678 5.34635 3.52067C6.68663 2.28456 8.23871 1.6665 10.0026 1.6665C11.7665 1.6665 13.3186 2.28456 14.6589 3.52067C15.9991 4.75678 16.6693 6.4165 16.6693 8.49984C16.6693 9.12484 16.5477 9.78109 16.3047 10.4686C16.0616 11.1561 15.7075 11.8714 15.2422 12.6144C14.7769 13.3575 14.197 14.1248 13.5026 14.9165C12.8082 15.7082 12.0095 16.5207 11.1068 17.354C10.954 17.4929 10.7804 17.5971 10.5859 17.6665C10.3915 17.736 10.197 17.7707 10.0026 17.7707ZM10.0026 9.99984C10.4609 9.99984 10.8533 9.83664 11.1797 9.51025C11.5061 9.18387 11.6693 8.7915 11.6693 8.33317C11.6693 7.87484 11.5061 7.48248 11.1797 7.15609C10.8533 6.8297 10.4609 6.6665 10.0026 6.6665C9.54427 6.6665 9.15191 6.8297 8.82552 7.15609C8.49913 7.48248 8.33594 7.87484 8.33594 8.33317C8.33594 8.7915 8.49913 9.18387 8.82552 9.51025C9.15191 9.83664 9.54427 9.99984 10.0026 9.99984Z"
                                                fill="#767676" />
                                        </g>
                                    </svg>
                                    <?php echo e($popularevent['location']); ?></small>
                                <h6><a href="<?php echo e(route('single.event', $popularevent['id'])); ?>">
                                        <?php echo e(ellipsis($popularevent['title'], 50)); ?></a></h6>
                                <div class="d-flex mt-1">
                                    <a href="<?php echo e(route('user.profile.view', $popularevent['user_id'])); ?>"><img
                                            src="<?php echo e(get_user_image($popularevent['photo'], 'optimized')); ?>"
                                            width="30" class="cicle user-round h-33" alt=""></a>
                                    <div class="ava-info ms-2">
                                        <h3 class="h6 mb-0"><a href="<?php echo e(route('user.profile.view', $popularevent['user_id'])); ?>"><?php echo e($popularevent['post_user']); ?></a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Event Widget End -->
                    <?php
                        if ($index == '5') {
                            break;
                        } else {
                            $index++;
                        }
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div><!-- Widget End -->
        </aside>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'single.blog'): ?>
        <aside class="sidebar">
            <div class="widget recent-posts blog_searchs">
                <div class=" search-widget mb-14">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="widget-title"><?php echo e(get_phrase('Search')); ?></h3>
                        <a href="<?php echo e(route('blogs')); ?>" class="btn common_btn"> <i class="fa-solid fa-left-long"></i>  <?php echo e(get_phrase('Back')); ?></a>
                    </div>
                    <form action="#" class="search-form">
                        <input class="bg-secondary" type="search" id="searchblogfield" placeholder="Search">
                        <span><i class="fa fa-search"></i></span>
                    </form>
                </div>
                <h3 class="widget-title mb-12"><?php echo e(get_phrase('Recent Post')); ?></h3>
                <div class="posts-wrap" id="searchblogviewsection">
                    <?php $__currentLoopData = $recent_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="post-entry d-flex mb-8">
                            <div class="post-thumb"><img class="img-fluid rounded"
                                    src="<?php echo e(get_blog_image($post->thumbnail, 'thumbnail')); ?>" alt="Recent Post">
                            </div>
                            <div class="post-txt ms-2">
                                <h3 class="mb-0"><a class="ellipsis-line-2"
                                        href="<?php echo e(route('single.blog', $post->id)); ?>"><?php echo e($post->title); ?></a></h3>
                                <div class="post-meta border-none">
                                    <span class="date-meta"><a
                                            href="#"><?php echo e($post->created_at->format('d-M-Y')); ?></a></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div> <!-- Recent Post Widget End -->
            <div class="widget tag-widget">
                <h3 class="widget-title mb-3"><?php echo e(get_phrase('Categories')); ?></h3>
                <div class="tags">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('category.blog', $category->id)); ?>"
                            class=" <?php if($post->category_id == $category->id): ?> active <?php endif; ?>"><?php echo e($category->name); ?>

                            (<?php echo e(DB::table('blogs')->where('category_id', $category->id)->get()->count()); ?>)
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </aside>
    <?php endif; ?>
    <?php if(Route::currentRouteName() == 'user.profile.view' ||
            Route::currentRouteName() == 'user.friends' ||
            Route::currentRouteName() == 'user.photos' ||
            Route::currentRouteName() == 'user.videos'): ?>
        <?php echo $__env->make('frontend.user.single_user.user_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    
    <?php if(addon_status('paid_content') == 1): ?>
        <?php if(Route::currentRouteName() == 'paid.content' ||
                Route::currentRouteName() == 'creator.timeline' ||
                Route::currentRouteName() == 'creator' ||
                Route::currentRouteName() == 'settings' ||
                Route::currentRouteName() == 'creator.subscribers' ||
                Route::currentRouteName() == 'creator.package' ||
                Route::currentRouteName() == 'post.type'): ?>
            <div class="sidebar">
                <div class="widget paid_sidebar">
                    <?php
                        $creator = DB::table('paid_content_creators')
                            ->where('user_id', auth()->user()->id)
                            ->first();
                        $social_media = json_decode($creator->social_accounts);
                    ?>

                    <h4 class="widget-title"><?php echo e(get_phrase('Intro')); ?></h4>
                    <p class="intro_text mb-8 mt-8">
                        <?php echo e($creator->description); ?>

                    </p>

                    <div class="mt-8 mb-8 creator-boi h-auto">
                        <h4 class="widget-title"><?php echo e(get_phrase('Creator Bio')); ?></h4>
                        <p class="intro_text "><?php echo e($creator->bio); ?></p>
                    </div>

                    
                    <a href="<?php echo e(route('settings')); ?>" class="page-s-btn"><?php echo e(get_phrase('Edit bio')); ?></a>

                    <h4 class="widget-title pt-30 pb-20"><?php echo e(get_phrase('Membership')); ?></h4>
                    <div class="member-img">
                        <img src="<?php echo e(asset('assets/frontend/paid-content/images/new/Notification-icon.png')); ?>"
                            alt="" />
                    </div>
                    
                    
                    <h4 class="widget-title pt-30 pb-20">
                        <?php echo e(get_phrase('Social profiles')); ?>

                    </h4>
                    <ul class="social-links">

                        <li>
                            <a href="<?php if($social_media->facebook == ''): ?> javascript: void(0);
                                <?php else: ?> <?php echo e($social_media->facebook); ?> <?php endif; ?>"
                                target="_blank">
                                <i class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="<?php if($social_media->twitter == ''): ?> javascript: void(0);
                                <?php else: ?> <?php echo e($social_media->twitter); ?> <?php endif; ?>"
                                target="_blank">
                                <i class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="<?php if($social_media->instagram == ''): ?> javascript: void(0);
                                <?php else: ?> <?php echo e($social_media->instagram); ?> <?php endif; ?>"
                                target="_blank">
                                <i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="<?php if($social_media->linkedin == ''): ?> javascript: void(0);
                                <?php else: ?> <?php echo e($social_media->linkedin); ?> <?php endif; ?>"
                                target="_blank">
                                <i class="fa-brands fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>
    
    <?php if(Route::currentRouteName() == 'fundraiser.profile'): ?>
        <div class="fundraiser-progress-area border-none p-20 bg-white radius-8 mb-12">
           
            <div class="fund-progress-title d-flex justify-content-between">
                <h3 class="text_14"><?php echo e(get_phrase('Fundraiser Progress')); ?></h3>
                <a href="<?php echo e(url()->previous()); ?>" class="btn back_btns common_btn"><i class="fa-solid fa-left-long me-2"></i><?php echo e(get_phrase('Back')); ?></a>
            </div>
            <div class="fund-progress-wrap d-flex flex-wrap align-items-center">
                <div class="fund-single-progress">
                    <h3 class="text_22"><?php echo e($donate); ?></h3>
                    <p class="pera_text"><?php echo e(get_phrase('Donated')); ?></p>
                </div>
                <div class="fund-single-progress">
                    <?php
                        $invite = json_decode($fundraiser->invited);
                    ?>
                    <?php if($invite != ''): ?>
                        <h3 class="text_22"><?php echo e(count($invite)); ?></h3>
                    <?php else: ?>
                        <h3 class="text_22">0</h3>
                    <?php endif; ?>

                    <p class="pera_text"><?php echo e(get_phrase('Invited')); ?></p>
                </div>
                <div class="fund-single-progress">
                    <?php
                     if ($sharecount !== null) {
                         $s_count = \App\Models\Post_share::where('post_id', $sharecount->post_id)->get()->count();
                        } else {
                            $s_count = 0; 
                        }
                    ?>
                    <h3 class="text_22"><?php echo e($s_count); ?></h3>
                    <p class="pera_text"><?php echo e(get_phrase('Shared')); ?></p>
                </div>
            </div>
        </div>

        <!-- Invite Friend -->
        <?php if($friendships->count() > 0): ?>
            <div class="friend-invite-area fund_side border-none bg-white p-20 radius-8 mb-12 pb-0">
                <ul class="friend-invite-wrap custom_invited_card">

                    
                    
                    <?php 
                        $blockedByUser = DB::table('block_users')->where('user_id', auth()->user()->id)->pluck('block_user')->toArray();
                    ?>
                    <?php $__currentLoopData = $friendships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friendship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                        <?php if($friendship->requester == $user_info->id): ?>
                            <?php
                                $friends_user_data = DB::table('users')
                                    ->where('id', $friendship->accepter)
                                    ->first();
                            ?>
                        <?php else: ?>
                            <?php
                                $friends_user_data = DB::table('users')
                                    ->where('id', $friendship->requester)
                                    ->first();
                            ?>
                        <?php endif; ?>

                        <?php 
                        //  User Block
                        if (in_array($friends_user_data->id, $blockedByUser)) {
                                continue;
                            }
                        
                        ?>

                        
                        <?php
                            $invite_details = DB::table('invites')
                                ->where('invite_reciver_id', $friends_user_data->id)
                                ->where('fundraiser_id', $fundraiser->id)
                                ->first();
                        ?>

                        <?php
                            $number_of_friend_friends = json_decode($friends_user_data->friends);
                            $number_of_my_friends = json_decode($user_info->friends);
                            
                            if (!is_array($number_of_friend_friends)) {
                                $number_of_friend_friends = [];
                            }
                            if (!is_array($number_of_my_friends)) {
                                $number_of_my_friends = [];
                            }
                            
                            if ($friends_user_data->id == auth()->user()->id) {
                                continue;
                            }
                            
                        $number_of_mutual_friends = count(array_intersect($number_of_friend_friends, $number_of_my_friends)); ?>
                        <div
                            class="single-item-countable d-flex friend-item align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center w-100">
                                <!-- Avatar -->
                                <div class="avatar">
                                    <a href="<?php echo e(route('user.profile.view', $friends_user_data->id)); ?>"><img
                                            class="avatar-img rounded-circle user_image_show_on_modal"
                                            src="<?php echo e(get_user_image($friends_user_data->photo, 'optimized')); ?>"
                                            alt="" height="40" width="40"></a>
                                </div>
                                <div class="avatar-info ms-2">
                                    <h6 class="mb-1"><a
                                            href="<?php echo e(route('user.profile.view', $friends_user_data->id)); ?>"><?php echo e($friends_user_data->name); ?></a>
                                    </h6>
                                    <div class="activity-time small-text text-muted">
                                        <?php echo e($number_of_mutual_friends); ?>

                                        <?php echo e(get_phrase('Mutual Friends')); ?></div>
                                </div>
                            </div>
                            <div class="invite_button_css">
                                <?php if(
                                    !empty($invite_details) &&
                                        $invite_details->invite_reciver_id == $friends_user_data->id &&
                                        $invite_details->is_accepted != '1'): ?>
                                    <button class=" btn_invited"><?php echo e(get_phrase('Invited')); ?></button>
                                <?php elseif(
                                    !empty($invite_details) &&
                                        $invite_details->invite_reciver_id == $friends_user_data->id &&
                                        $invite_details->is_accepted == '1'): ?>
                                    <button class=" btn_invited"><?php echo e(get_phrase('Invited')); ?></button>
                                <?php else: ?>
                                    <a class="btn_2"
                                        href="<?php echo e(route('fundraiser.invited', ['invited_friend_id' => $friends_user_data->id, 'requester_id' => auth()->user()->id, 'fundraiser_id' => $fundraiser->id])); ?>"><?php echo e(get_phrase('Invite')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    

                </ul>
                <div class="see-all-btn">
                    <?php if($friendships->count() > 2): ?>
                        <?php if(Route::currentRouteName() != 'fundraiser.friend'): ?>
                            <a
                                href="<?php echo e(route('fundraiser.friend', ['type' => 'seeAll', 'id' => $campaign->id])); ?>">
                                <?php echo e(get_phrase('See all friends')); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="created-owner-area border-none bg-white p-20 radius-8 mb-12">
            <h3 class="text_22"><?php echo e(get_phrase('Created by')); ?></h3>
            <div class="d-flex align-items-center justify-content-between">
                <div class="friend-name-img d-flex align-items-center">
                    <div class="friend-img">
                        <a href="<?php echo e(route('user.profile.view', $user_data->id)); ?>"><img src="<?php echo e(get_user_image($campaign->user_id, 'optimized')); ?>"
                                alt="friend-img"></a>
                    </div>
                    <div class="friend-name">
                        <a href="<?php echo e(route('user.profile.view', $user_data->id)); ?>" class="text_15"><?php echo e($campaign->name); ?></a>
                    </div>
                </div>
                <?php if($user_data->id != auth()->user()->id): ?>
                    <a href="<?php echo e(route('chat', $user_data->id)); ?>" class="btn text_12 common_btn"><?php echo e(get_phrase('Contact')); ?></a>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>



    <?php endif; ?>

</aside>

<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/frontend/right_sidebar.blade.php ENDPATH**/ ?>