<div class="sidebar">
    <div class="logo-details mt-4">
        <div class="img_wrapper">
            <?php
                $system_light_logo = \App\Models\Setting::where('type', 'system_light_logo')->value('description');
                $system_fav_icon = \App\Models\Setting::where('type', 'system_fav_icon')->value('description');
            ?>
            <img class="logo-lg" height="34px" src="<?php echo e(get_system_logo_favicon($system_light_logo, 'light')); ?>"
                alt="" />
            <img class="logo-sm" height="34px" src="<?php echo e(get_system_logo_favicon($system_fav_icon, 'favicon')); ?>"
                alt="" />
        </div>
    </div>
    <div class="closeIcon">
        <span><i class="fas fa-close"></i></span>
    </div>
    <ul class="nav-links">
        <!-- sidebar title -->
        <li class="nav-links-li">
            <div class="iocn-link">
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-house-user"></i>
                    </div>
                    <span class="link_name custom_dashboard_color"><?php echo e(get_phrase('Dashboard')); ?> </span>
                </a>
            </div>
        </li>
        <!-- Sidebar menu -->

        <!-- Sidebar menu -->
        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.view.category' ||
                Route::currentRouteName() == 'admin.users' ||
                Route::currentRouteName() == 'admin.user.add' ||
                Route::currentRouteName() == 'admin.user.edit' ||
                Route::currentRouteName() == 'admin.users.accountActiveReq'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('User')); ?> </span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.users'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.users')); ?>"><?php echo e(get_phrase('Users')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.user.add'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.user.add')); ?>"><?php echo e(get_phrase('Create new user')); ?></a></li>
                <li class="user_req_notification_root">
                    <?php
                $pending_count = DB::table('account_active_requests')->where('status', 'pending')->count();
              ?>
            
            <?php if($pending_count > 0): ?>
                
                <a class="<?php if(Route::currentRouteName() == 'admin.users.accountActiveReq'): ?> Active <?php endif; ?>"
                href="<?php echo e(route('admin.users.accountActiveReq')); ?>"><?php echo e(get_phrase('Id Active Request')); ?></a>
                <span class="user_req_notification"><h5><?php echo e($pending_count); ?></h5></span>
            </li>
                
            <?php else: ?>
                <a class="<?php if(Route::currentRouteName() == 'admin.users.accountActiveReq'): ?> Active <?php endif; ?>"
                href="<?php echo e(route('admin.users.accountActiveReq')); ?>"><?php echo e(get_phrase('Account Active Request')); ?></a></li>
            <?php endif; ?>
            </ul>
        </li>

        <li class="nav-links-li <?php if(
                Route::currentRouteName() == 'admin.group' ||
                Route::currentRouteName() == 'admin.group.create'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Group')); ?> </span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.group'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.group')); ?>"><?php echo e(get_phrase('Groups')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.group.create'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.group.create')); ?>"><?php echo e(get_phrase('Create Group')); ?></a></li>
            </ul>
        </li>

        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.view.category' ||
                Route::currentRouteName() == 'admin.page' ||
                Route::currentRouteName() == 'admin.create.category' ||
                Route::currentRouteName() == 'admin.page.create' ||
                Route::currentRouteName() == 'admin.page.edit'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Page')); ?> </span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.page'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.page')); ?>"><?php echo e(get_phrase('Pages')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.page.create'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.page.create')); ?>"><?php echo e(get_phrase('Create Page')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.view.category'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.view.category')); ?>"><?php echo e(get_phrase('Category')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.create.category'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.create.category')); ?>"><?php echo e(get_phrase('Create Category')); ?></a></li>
            </ul>
        </li>

        

        
        <style>
            .sub-menu .span {
                height: 20px;
                width: 20px;
                display: inline-block;
                background: #e43434;
                text-align: center;
                border-radius: 50%;
                line-height: 20px;
                color: #fff;
                font-size: 11px;
                margin-left: 4px;
              }
          </style>
         
        
        <?php if(addon_status('paid_content') == 1): ?>
            <?php
               $list = App\Models\PaidContentPayout::where('status', false)->get();
            ?>
            <li class="nav-links-li <?php if(Route::currentRouteName() == 'author.list' ||
                    Route::currentRouteName() == 'admin.users' ||
                    Route::currentRouteName() == 'payout.report' ||
                    Route::currentRouteName() == 'pending.report'): ?> showMenu <?php endif; ?>">
                <div class="iocn-link">
                    <a href="#">
                        <div class="sidebar_icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <span class="link_name"><?php echo e(get_phrase('Paid Content')); ?> </span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                            <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                                d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                                fill="#fff" opacity="1" />
                        </svg>
                    </span>
                </div>
                <ul class="sub-menu">
                    <li><a class="<?php if(Route::currentRouteName() == 'author.list'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('author.list')); ?>"><?php echo e(get_phrase('Authors')); ?></a></li>
                    <li><a class="<?php if(Route::currentRouteName() == 'payout.report'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('payout.report')); ?>"><?php echo e(get_phrase('Payout report')); ?></a></li>
                    <li><a class="<?php if(Route::currentRouteName() == 'pending.report'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('pending.report')); ?>"><?php echo e(get_phrase('Pending report')); ?>

                            <?php if(count($list) > 0): ?>
                              <span class="span"><?php echo e(count($list)); ?></span>
                            <?php endif; ?>
                        </a></li>
                </ul>
            </li>
        <?php endif; ?>

        
        <?php if(addon_status('fundraiser') == 1): ?>
          <?php
              $list = App\Models\Fundraiser_payout::where('status', false)->get();
          ?>
            <li class="nav-links-li <?php if(Route::currentRouteName() == 'backend.fundraiser.report' ||
                    Route::currentRouteName() == 'backend.fundraiser.pending'): ?> showMenu <?php endif; ?>">
                <div class="iocn-link">
                    <a href="#">
                        <div class="sidebar_icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <span class="link_name"><?php echo e(get_phrase('Fundraiser')); ?> </span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773"
                            viewBox="0 0 4.743 7.773">
                            <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                                d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                                fill="#fff" opacity="1" />
                        </svg>
                    </span>
                </div>
                <ul class="sub-menu">
                    
                    <li><a class="<?php if(Route::currentRouteName() == 'backend.fundraiser.report'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('backend.fundraiser.report')); ?>"><?php echo e(get_phrase('Success payout')); ?></a>
                    </li>
                    <li><a class="<?php if(Route::currentRouteName() == 'backend.fundraiser.pending'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('backend.fundraiser.pending')); ?>"><?php echo e(get_phrase('Pending payout')); ?>

                            <?php if(count($list) > 0): ?>
                              <span class="span"><?php echo e(count($list)); ?></span>
                           <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-links-li  <?php if(Route::currentRouteName() == 'admin.blog' ||
                Route::currentRouteName() == 'admin.view.blog.category' ||
                Route::currentRouteName() == 'admin.create.blog.category' ||
                Route::currentRouteName() == 'admin.blog.create' ||
                Route::currentRouteName() == 'admin.blog.edit'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-blog"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Blog')); ?></span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.blog'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.blog')); ?>"><?php echo e(get_phrase('Blogs')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.blog.create'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.blog.create')); ?>"><?php echo e(get_phrase('Create Blog')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.view.blog.category'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.view.blog.category')); ?>"><?php echo e(get_phrase('Category')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.create.blog.category'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.create.blog.category')); ?>"><?php echo e(get_phrase('Create Category')); ?></a></li>
            </ul>
        </li>
        
        <li class="nav-links-li  <?php if(Route::currentRouteName() == 'admin.badge'): ?> showMenu  <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.1825 1.16051C11.5808 0.595046 12.4192 0.595047 12.8175 1.16051L13.8489 2.62463C14.1272 3.01962 14.648 3.15918 15.0865 2.95624L16.7118 2.20397C17.3395 1.91343 18.0655 2.33261 18.1277 3.02149L18.2889 4.80515C18.3324 5.28634 18.7137 5.66763 19.1948 5.71111L20.9785 5.87226C21.6674 5.9345 22.0866 6.66054 21.796 7.28825L21.0438 8.91352C20.8408 9.35198 20.9804 9.87284 21.3754 10.1511L22.8395 11.1825C23.405 11.5808 23.405 12.4192 22.8395 12.8175L21.3754 13.8489C20.9804 14.1272 20.8408 14.648 21.0438 15.0865L21.796 16.7118C22.0866 17.3395 21.6674 18.0655 20.9785 18.1277L19.1948 18.2889C18.7137 18.3324 18.3324 18.7137 18.2889 19.1948L18.1277 20.9785C18.0655 21.6674 17.3395 22.0866 16.7117 21.796L15.0865 21.0438C14.648 20.8408 14.1272 20.9804 13.8489 21.3754L12.8175 22.8395C12.4192 23.405 11.5808 23.405 11.1825 22.8395L10.1511 21.3754C9.87284 20.9804 9.35198 20.8408 8.91352 21.0438L7.28825 21.796C6.66054 22.0866 5.9345 21.6674 5.87226 20.9785L5.71111 19.1948C5.66763 18.7137 5.28634 18.3324 4.80515 18.2889L3.02149 18.1277C2.33261 18.0655 1.91343 17.3395 2.20397 16.7117L2.95624 15.0865C3.15918 14.648 3.01962 14.1272 2.62463 13.8489L1.16051 12.8175C0.595046 12.4192 0.595047 11.5808 1.16051 11.1825L2.62463 10.1511C3.01962 9.87284 3.15918 9.35198 2.95624 8.91352L2.20397 7.28825C1.91343 6.66054 2.33261 5.9345 3.02149 5.87226L4.80515 5.71111C5.28634 5.66763 5.66763 5.28634 5.71111 4.80515L5.87226 3.02149C5.9345 2.33261 6.66054 1.91343 7.28825 2.20397L8.91352 2.95624C9.35198 3.15918 9.87284 3.01962 10.1511 2.62463L11.1825 1.16051Z" fill="#fff"/>
                            <path d="M7.5 11.83L10.6629 14.9929L17 8.66705" stroke="white" stroke-width="1.67647" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Badge')); ?></span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                            
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.badge'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.badge')); ?>"><?php echo e(get_phrase('Badge')); ?></a></li>
            </ul>
        </li>
        
        <?php if(addon_status('job') == 1): ?>
          <?php
               $status = App\Models\Job::where('status', 0)->get();
            ?>
        <li class="nav-links-li  <?php if(Route::currentRouteName() == 'admin.job' ||
                Route::currentRouteName() == 'admin.view.job.category' ||
                Route::currentRouteName() == 'admin.pending.job' ||
                Route::currentRouteName() == 'admin.job.apply.all.list' ||
                Route::currentRouteName() == 'admin.create.job.category' ||
                Route::currentRouteName() == 'admin.job.create' ||
                Route::currentRouteName() == 'admin.job.edit' ||
                Route::currentRouteName() == 'admin.job.price.view'||
                Route::currentRouteName() == 'admin.job.payment.history'): ?>
                showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Job')); ?></span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.job'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.job')); ?>"><?php echo e(get_phrase('Job List')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.job.create'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.job.create')); ?>"><?php echo e(get_phrase('Create Job')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.pending.job'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('admin.pending.job')); ?>"><?php echo e(get_phrase('Pending Job')); ?>

                            <?php if(count($status) > 0): ?>
                            <span class="span"><?php echo e(count($status)); ?></span>
                          <?php endif; ?>
                        </a> 
                 </li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.job.apply.all.list'): ?> Active <?php endif; ?>"
                            href="<?php echo e(route('admin.job.apply.all.list')); ?>"><?php echo e(get_phrase('All Apply List')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.view.job.category'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.view.job.category')); ?>"><?php echo e(get_phrase('Category')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.create.job.category'): ?> Active <?php endif; ?>" href="<?php echo e(route('admin.create.job.category')); ?>"><?php echo e(get_phrase('Create Category')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.job.price.view'): ?> Active <?php endif; ?>" href="<?php echo e(route('admin.job.price.view')); ?>"><?php echo e(get_phrase('Job Price')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.job.payment.history'): ?> Active <?php endif; ?>" href="<?php echo e(route('admin.job.payment.history')); ?>"><?php echo e(get_phrase('Payment History')); ?></a></li>
            </ul>
        </li>
        <?php endif; ?>
        

        <li class="nav-links-li  <?php if(Route::currentRouteName() == 'admin.view.sponsor' || Route::currentRouteName() == 'admin.create.sponsor'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-rectangle-ad"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Sponsored Post')); ?></span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.view.sponsor'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.view.sponsor')); ?>"><?php echo e(get_phrase('Ads')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.create.sponsor'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.create.sponsor')); ?>"><?php echo e(get_phrase('Create Ad')); ?></a></li>
            </ul>
        </li>

        <!-- menu starts here -->
        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.reported.post.view'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a class="w-100" href="<?php echo e(route('admin.reported.post.view')); ?>">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <span class="link_name">
                        <?php echo e(get_phrase('Reported Post')); ?>

                    </span>
                </a>
            </div>
        </li>

        <!-- menu starts here -->
        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.payment_histories'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a class="w-100" href="<?php echo e(route('admin.payment_histories')); ?>">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <span class="link_name">
                        <?php echo e(get_phrase('Payment history')); ?>

                    </span>
                </a>
            </div>
        </li>

        <!-- addon table -->
        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.addon.manager'): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a class="w-100" href="<?php echo e(route('admin.addon.manager')); ?>">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-puzzle-piece"></i>
                    </div>
                    <span class="link_name">
                        <?php echo e(get_phrase('Addons')); ?>

                    </span>
                </a>
            </div>
        </li>

        <li class="nav-links-li <?php if(Route::currentRouteName() == 'admin.about.page.data.view' ||
                Route::currentRouteName() == 'admin.live-video.view' ||
                Route::currentRouteName() == 'admin.privacy.page.data.view' ||
                Route::currentRouteName() == 'admin.term.page.data.view' ||
                Route::currentRouteName() == 'admin.smtp.settings.view' ||
                Route::currentRouteName() == 'admin.system.settings.view' ||
                Route::currentRouteName() == 'admin.settings.payment' ||
                Route::currentRouteName() == 'admin.language.settings' ||
                Route::currentRouteName() == 'admin.about' ||
                Route::currentRouteName() == 'admin.zitsi-video.view' ||
                Route::currentRouteName() == 'admin.settings.amazon_s3' ||
                'admin.languages.edit.phrase' == Route::currentRouteName()): ?> showMenu <?php endif; ?>">
            <div class="iocn-link">
                <a href="#">
                    <div class="sidebar_icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <span class="link_name"><?php echo e(get_phrase('Settings')); ?></span>
                </a>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                        <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                            d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                            fill="#fff" opacity="1" />
                    </svg>
                </span>
            </div>
            <ul class="sub-menu">
                <li><a class="<?php if(Route::currentRouteName() == 'admin.system.settings.view'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.system.settings.view')); ?>"><?php echo e(get_phrase('System Setting')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.settings.amazon_s3'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.settings.amazon_s3')); ?>"><?php echo e(get_phrase('Amazon s3 settings')); ?> </a>
                </li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.about.page.data.view'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.about.page.data.view')); ?>"><?php echo e(get_phrase('Custom Pages')); ?> </a></li>

                

                <li><a class="<?php if(Route::currentRouteName() == 'admin.zitsi-video.view'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.zitsi-video.view')); ?>"><?php echo e(get_phrase('Zitsi Live Settings')); ?> </a></li>

                <li><a class="<?php if(Route::currentRouteName() == 'admin.settings.payment'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.settings.payment')); ?>"><?php echo e(get_phrase('Payment Setting')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.language.settings' ||
                        'admin.languages.edit.phrase' == Route::currentRouteName()): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.language.settings')); ?>"><?php echo e(get_phrase('Language Setting')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.smtp.settings.view'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.smtp.settings.view')); ?>"><?php echo e(get_phrase('SMTP Setting')); ?></a></li>
                <li><a class="<?php if(Route::currentRouteName() == 'admin.about'): ?> Active <?php endif; ?>"
                        href="<?php echo e(route('admin.about')); ?>"><?php echo e(get_phrase('About')); ?></a></li>
            </ul>
        </li>
    </ul>
</div>
<?php /**PATH /Applications/MAMP/htdocs/Sociopro_2.6/Sociopro/resources/views/backend/admin/sidebar.blade.php ENDPATH**/ ?>