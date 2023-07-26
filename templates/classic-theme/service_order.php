<?php
overall_header(__("Orders"));
?>
    <!-- Dashboard Container -->
    <div class="dashboard-container">

<?php include_once TEMPLATE_PATH.'/dashboard_sidebar.php'; ?>

    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
    <div class="dashboard-content-inner" >

    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3><?php _e("Service Orders") ?></h3>
        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                <li><?php _e("Orders") ?></li>
            </ul>
        </nav>
    </div>

    <!-- Row -->
    <div class="row">
        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box">
                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-assignment"></i> <?php _e("Service Orders") ?></h3>
                    <form method="get" action="" class="d-flex" id="form_search">
                        <div class="margin-right-10">
                            <select class="with-border padding-top-0 padding-bottom-0 margin-bottom-0" name="status" id="project_status">
                                <option value=""><?php _e("Status") ?></option>
                                <option value="all"><?php _e("All") ?></option>
                                <option value="progress"><?php _e("Progress") ?></option>
                                <option value="completed"><?php _e("Completed") ?></option>
                                <option value="cancelled"><?php _e("Cancelled") ?></option>
                                <option value="incomplete"><?php _e("Incomplete") ?></option>
                            </select>
                        </div>
                    </form>
                </div>
                <!-- Content Start -->
                <div class="content">
                    <ul class="dashboard-box-list" id="js-table-list">
                        <?php foreach($items as $item){ ?>
                        <ul class="dashboard-box-list">
                            <li class="ajax-item-listing" data-item-id="<?php _esc($item['id'])?>">
                                <!-- Job Listing -->
                                <div class="job-listing width-adjustment">
                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Logo -->
                                        <a href="<?php _esc($item['link'])?>" class="job-listing-company-logo">
                                            <img src="<?php _esc($config['site_url'])?>storage/products/<?php _esc($item['image'])?>" alt="<?php _esc($item['title'])?>">
                                        </a>
                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">
                                                <a href="<?php _esc($item['link'])?>"><?php _esc($item['title'])?></a>
                                                <?php
                                                if($item['status'] == "progress")
                                                    echo '<div class="dashboard-status-button green">'.__("Progress").'</div>';
                                                if($item['status'] == "completed")
                                                    echo '<div class="dashboard-status-button green">'.__("Completed").'</div>';
                                                if($item['status'] == "cancelled")
                                                    echo '<div class="dashboard-status-button red" data-tippy-placement="top" title="'._esc($item['cancel_reason'],false).'"><i class="la la-info-circle"></i> '.__("Cancelled").'</div>';
                                                if($item['status'] == "incomplete")
                                                    echo '<div class="dashboard-status-button red">'.__("Incomplete").'</div>';
                                                ?>
                                            </h3>
                                            <?php
                                            if($item['rated'] == "0"){
                                                if($item['rating'] != '0.0' || $item['rating'] != '0'){
                                            echo '<div class="star-rating margin-bottom-5" data-tippy-placement="top" title="'._esc($item['comments'],false).'" data-rating="'._esc($item['rating'],false).'"></div><br>';
                                                }
                                            }
                                            ?>
                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li><i class="la la-clock-o"></i> <?php _e("Order by") ?> <a href="<?php url("PROFILE") ?>/<?php _esc($item['buyer_username'])?>"><?php _esc($item['buyer_name'])?></a></li>
                                                    <li><i class="la la-clock-o"></i> <?php _e("Order on") ?> <?php _esc($item['created_at'])?></li>
                                                    <li><i class="la la-calendar-times-o"></i> <?php _e("Delivery on") ?> <?php _esc($item['end_date'])?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="dashboard-task-info margin-bottom-5">
                                    <li><strong><?php _esc($item['amount'])?></strong><span><?php _e("Amount") ?></span></li>
                                    <li><strong><?php _esc($item['plan_name'])?></strong><span><?php _e("Plan") ?></span></li>
                                </ul>
                                <!-- Buttons -->

                                <div class="buttons-to-right always-visible">
                                    <?php
                                    if($item['rated'] == "1"){
                                        echo '<a href="#final-review" class="write_rating button ripple-effect" 
                                            data-project-id="'._esc($item['id'],false).'" 
                                            data-project-title="'._esc($item['title'],false).'">
                                            <i class="icon-material-outline-thumb-up"></i> '.__("Leave a Review").'</a>';
                                    }

                                    if($usertype == "employer" && $item['buyer_id'] == $user_id && $item['status'] == 'progress'){
                                        ?>
                                        <a href="#" data-ajax-action="mark_completed_service" data-alert-message="Are you sure you want to accept service completed." class="button green ripple-effect item-ajax-button"><i class="icon-material-outline-check"></i> <?php _e("Mark as completed") ?></a>
                                    <?php } ?>
                                    <?php
                                    if($usertype == "user" && $item['status'] == 'progress'){
                                        echo '<a href="#small-dialog-1" class="cancel_order button gray ripple-effect"><i class="icon-close"></i> '.__("Cancel").'</a>';
                                     } ?>

                                </div>
                            </li>
                            <?php } ?>
                            <?php if(!$totalitem){ ?>
                                <li class="ajax-item-listing">
                                    <!-- Project Listing -->
                                    <div class="job-listing width-adjustment">
                                        <!-- Project Listing Details -->
                                        <div class="job-listing-details">
                                            <?php _e("No result found.") ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                </div>
                <!-- Content End -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Pagination -->
                    <div class="pagination-container margin-top-20">
                        <nav class="pagination">
                            <ul>
                                <?php
                                foreach($pages as $page) {
                                    if ($page['current'] == 0){
                                        ?>
                                        <li><a href="<?php _esc($page['link'])?>"><?php _esc($page['title'])?></a></li>
                                    <?php }else{
                                        ?>
                                        <li><a href="#" class="current-page"><?php _esc($page['title'])?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row / End -->
        <!-- Cancel Service Popup
                    ================================================== -->
        <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog">

            <!--Tabs -->
            <div class="sign-in-form">

                <ul class="popup-tabs-nav">
                    <li><a href="#tab1"><?php _e("Cancel Order") ?></a></li>
                </ul>

                <div class="popup-tabs-container">

                    <!-- Tab -->
                    <div class="popup-tab-content" id="tab">
                        <form id="cancel-order-form" method="post" action="#">

                            <div id="cancel-order-status" class="notification error" style="display:none"></div>
                            <!-- Welcome Text -->
                            <div class="welcome-text">
                                <h3><?php _e("Cancel Order") ?> #<span class="order_id_text"></span></h3>
                            </div>

                            <div class="submit-field">
                                <h5><?php _e("Cancel Reason") ?> *</h5>
                                <textarea cols="30" rows="3" class="with-border cancel_reason" name="cancel_reason" required=""></textarea>
                            </div>

                            <input name="order_id" class="order_id" value="" type="hidden"/>

                            <!-- Button -->
                            <button id="cancel-order-button" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit"> <?php _e("Submit") ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Cancel Service Popup / End -->

        <!-- Leave a Review for Freelancer Popup
            ================================================== -->
        <div id="final-review" class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog">
            <!--Tabs -->
            <div class="sign-in-form">

                <ul class="popup-tabs-nav"></ul>
                <div class="popup-tabs-container">
                    <!-- Tab -->
                    <div class="popup-tab-content" id="tab2">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h3><?php _e("Leave a Review") ?></h3>
                            <div><?php _e("Rate for the project") ?> <span id="project_link"></span> </div>
                        </div>
                        <div id="rating-status" class="notification error" style="display:none"></div>
                        <!-- Form -->
                        <form method="post" id="leave-review-form" action="">
                            <?php
                            if($usertype == 'employer'){
                                ?>

                                <div class="feedback-yes-no">
                                    <strong><?php _e("Was this delivered on time?") ?></strong>
                                    <div class="radio">
                                        <input id="radio-3" name="on_time" type="radio" value="yes" checked required>
                                        <label for="radio-3"><span class="radio-label"></span> <?php _e("Yes") ?></label>
                                    </div>

                                    <div class="radio">
                                        <input id="radio-4" name="on_time" type="radio" value="no" required>
                                        <label for="radio-4"><span class="radio-label"></span> <?php _e("No") ?></label>
                                    </div>
                                </div>

                                <div class="feedback-yes-no">
                                    <strong><?php _e("I recommend this freelancer.?") ?></strong>
                                    <div class="radio">
                                        <input id="radio-5" name="recommendation" type="radio" value="yes" checked required>
                                        <label for="radio-5"><span class="radio-label"></span> <?php _e("Yes") ?></label>
                                    </div>

                                    <div class="radio">
                                        <input id="radio-6" name="recommendation" type="radio" value="no" required>
                                        <label for="radio-6"><span class="radio-label"></span> <?php _e("No") ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="feedback-yes-no">
                                <strong><?php _e("Your Rating") ?></strong>
                                <div class="leave-rating">
                                    <input type="radio" name="rating" id="rating-radio-1" value="5" checked required>
                                    <label for="rating-radio-1" class="icon-material-outline-star"></label>
                                    <input type="radio" name="rating" id="rating-radio-2" value="4" required>
                                    <label for="rating-radio-2" class="icon-material-outline-star"></label>
                                    <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                                    <label for="rating-radio-3" class="icon-material-outline-star"></label>
                                    <input type="radio" name="rating" id="rating-radio-4" value="2" required>
                                    <label for="rating-radio-4" class="icon-material-outline-star"></label>
                                    <input type="radio" name="rating" id="rating-radio-5" value="1" required>
                                    <label for="rating-radio-5" class="icon-material-outline-star"></label>
                                </div><div class="clearfix"></div>
                            </div>

                            <textarea class="with-border" placeholder="<?php _e("Comment") ?>" name="message" id="message" cols="7" required></textarea>
                            <input name="project_id" id="project_id" value="" type="hidden"/>
                            <input name="post_type" id="post_type" value="gig" type="hidden"/>
                            <!-- Button -->
                            <button id="submit_button" class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><?php _e("Leave a Review") ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Leave a Review Popup / End -->

        <script>
            $(document).on('change', "#project_status" ,function(e){
                $('#form_search').submit();
            });

            <!-- Cancel Service Ajax -->
            $(document).on('click', ".cancel_order" ,function(e){
                e.stopPropagation();
                e.preventDefault();

                var $item = $(this).closest('.ajax-item-listing');
                var order_id = $item.data('item-id');
                $('.order_id').val(order_id);
                $('.order_id_text').html(order_id);
                $.magnificPopup.open({
                    items: {
                        src: '#small-dialog-1',
                        type: 'inline',
                        fixedContentPos: false,
                        fixedBgPos: true,
                        overflowY: 'auto',
                        closeBtnInside: true,
                        preloader: false,
                        midClick: true,
                        removalDelay: 300,
                        mainClass: 'my-mfp-zoom-in'
                    }
                });
            });

            $(document).on('click', ".write_rating" ,function(e){
                e.stopPropagation();
                e.preventDefault();

                var project_id = $(this).data('project-id'),
                    project_title = $(this).data('project-title');
                $('#project_id').val(project_id);
                $('#project_title').text(project_title);

                var project_link = "<a href='<?php url("SERVICE",false)?>/"+project_id+"'>"+project_title+"</a>"
                $('#project_link').html(project_link);
                $.magnificPopup.open({
                    items: {
                        src: '#final-review',
                        type: 'inline',
                        fixedContentPos: false,
                        fixedBgPos: true,
                        overflowY: 'auto',
                        closeBtnInside: true,
                        preloader: false,
                        midClick: true,
                        removalDelay: 300,
                        mainClass: 'my-mfp-zoom-in'
                    }
                });
            });
            $("#leave-review-form").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                var action = 'write_rating';
                $('#submit_button').addClass('button-progress').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: ajaxurl+'?action='+action,
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if(response.success){
                            $("#rating-status").addClass('success').removeClass('error').html('<p>'+response.message+'</p>').slideDown();
                            location.reload();
                        }
                        else {
                            $("#rating-status").removeClass('success').addClass('error').html('<p>'+response.message+'</p>').slideDown();
                        }
                        $('#submit_button').removeClass('button-progress').prop('disabled', false);
                    }
                });
                return false;
            });
        </script>

        <?php include_once TEMPLATE_PATH.'/overall_footer_dashboard.php'; ?>
