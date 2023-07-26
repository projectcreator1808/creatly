<?php
overall_header(__("My Services"));
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
                <h3><?php _e("My Services") ?></h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                        <li><?php _e("My Services") ?></li>
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
                            <h3><i class="icon-material-outline-assignment"></i> <?php _e("My Services") ?></h3>
                            <form method="get" action="" class="d-flex" id="form_search">
                                <div class="margin-right-10">
                                    <select class="with-border padding-top-0 padding-bottom-0 margin-bottom-0" name="status" id="project_status">
                                        <option value=""><?php _e("Status") ?></option>
                                        <option value="active"><?php _e("Ongoing") ?></option>
                                        <option value="completed"><?php _e("Completed") ?></option>
                                        <option value="cancelled"><?php _e("Cancelled") ?></option>
                                        <option value="incomplete"><?php _e("Incomplete") ?></option>
                                    </select>
                                </div>
                                <div class="input-with-icon">
                                    <input class="with-border margin-bottom-0" name="keywords" value="<?php _esc($keywords)?>" type="text" placeholder="<?php _e("Search") ?>...">
                                    <i class="icon-feather-search"></i>
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
                                        <div class="job-listing">

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
                                                        if($item['status'] == "active")
                                                            echo '<div class="dashboard-status-button green">'.__("Ongoing").'</div>';

                                                        if($item['status'] == "completed")
                                                            echo '<div class="dashboard-status-button green">'.__("Completed").'</div>';
                                                        if($item['status'] == "cancelled")
                                                            echo '<div class="dashboard-status-button red">'.__("Cancelled").'</div>';
                                                        if($item['status'] == "incomplete")
                                                            echo '<div class="dashboard-status-button red">'.__("Incomplete").'</div>';
                                                        ?>
                                                    </h3>

                                                    <!-- Job Listing Footer -->
                                                    <div class="job-listing-footer">
                                                        <ul>
                                                            <li><i class="icon-material-outline-archive"></i> <?php _e("Sales") ?> <?php _esc($item['all_order'])?></li>
                                                            <li><i class="icon-feather-eye"></i> <?php _e("Views") ?> <?php _esc($item['views'])?></li>
                                                            <li><i class="icon-material-outline-date-range"></i> <?php _e("Posted on") ?> <?php _esc($item['created_at'])?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="buttons-to-right always-visible">
                                            <?php if($item['pending_order'] != '0'){ ?>
                                            <a href="<?php url("SERVICE_ORDERS") ?>" class="button ripple-effect"><i class="icon-material-outline-shopping-cart"></i> <?php _e("Manage Orders") ?>
                                                <span class="button-info"><?php _esc($item['pending_order'])?></span>
                                            </a>
                                            <?php } ?>
                                            <a href="<?php url("EDIT_SERVICE") ?>/<?php _esc($item['id'])?>" class="button gray ripple-effect ico" title="<?php _e("Edit") ?>" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                            <a href="#" class="button gray ripple-effect ico" title="<?php _e("Remove") ?>" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
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

            <script>
                $(document).on('change', "#project_status" ,function(e){
                    $('#form_search').submit();
                });
            </script>
            <?php include_once TEMPLATE_PATH.'/overall_footer_dashboard.php'; ?>

