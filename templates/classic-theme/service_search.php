<?php
overall_header($pagetitle);
?>
    <!-- Search
    ================================================== -->

    <form method="get" action="<?php url("SEARCH_SERVICES") ?>" name="locationForm" id="ListingForm">
        <div id="titlebar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2><?php _e("We found") ?> <?php _esc($adsfound) ?> <?php _e("Services") ?></h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="listing_job">
                            <ul>
                                <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                                <li><a href="<?php url("SEARCH_SERVICES") ?>"><?php _e("Services") ?></a></li>
                                <?php
                                if($maincategory != ""){
                                    echo '<li>'._esc($maincategory,false).'</li>';
                                }
                                if($subcategory != ""){
                                    echo '<li>'._esc($subcategory,false).'</li>';
                                }
                                if($maincategory == "" && $subcategory == ""){
                                    echo '<li>'.__("All Categories").'</li>';
                                }
                                ?>
                            </ul>
                        </nav>
                        <div class="intro-banner-search-form listing-page margin-top-30">
                            <!-- Search Field -->
                            <div class="intro-search-field">
                                <div class="dropdown category-dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <span class="change-text"><?php _e("Select") ?> <?php _e("Category") ?></span><i class="fa fa-navicon"></i>
                                    </a>
                                    <?php _esc($cat_dropdown) ?>
                                </div>
                            </div>
                            <div class="intro-search-field">
                                <input id="keywords" type="text" name="keywords" placeholder="<?php _e("Service Title or Keywords") ?>" value="<?php _esc($keywords) ?>">
                            </div>
                            <div class="intro-search-button">
                                <input type="hidden" id="input-maincat" name="cat" value="<?php _esc($maincat) ?>"/>
                                <input type="hidden" id="input-subcat" name="subcat" value="<?php _esc($subcat) ?>"/>
                                <input type="hidden" id="input-filter" name="filter" value="<?php _esc($filter) ?>"/>
                                <input type="hidden" id="input-sort" name="sort" value="<?php _esc($sort) ?>"/>
                                <input type="hidden" id="input-order" name="order" value="<?php _esc($order) ?>"/>
                                <button class="button ripple-effect"><?php _e("Search") ?></button>
                            </div>
                        </div>
                        <div class="hide-under-768px margin-top-20">
                            <ul class="categories-list">
                                <?php foreach ($subcatlist as $sub_c){
                                    echo '<li><a href="'._esc($sub_c['service_link'],false).'">'._esc($sub_c['name'],false).'</a></li>';
                                }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content
        ================================================== -->
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <!-- Enable Filters Button -->
                    <div class="filter-button-container">
                        <button href="javascript:void(0);" type="button" class="enable-filters-button">
                            <i class="enable-filters-button-icon"></i>
                            <span class="show-text"><?php _e("Advanced Search") ?></span>
                            <span class="hide-text"><?php _e("Advanced Search") ?></span>
                        </button>
                    </div>
                    <div class="sidebar-container search-sidebar">

                        <?php
                        foreach ($customfields as $customfield){
                            if($customfield['type']=="text-field"){
                                echo '<div class="sidebar-widget">
                                <h3 class="label-title">'._esc($customfield['title'],false).'</h3>
                                '._esc($customfield['textbox'],false).'
                            </div>';
                            }
                            if($customfield['type']=="textarea"){
                                echo '<div class="sidebar-widget">
                                <h3 class="label-title">'._esc($customfield['title'],false).'</h3>
                                '._esc($customfield['textarea'],false).'
                            </div>';
                            }
                            if($customfield['type']=="radio-buttons"){
                                echo '<div class="sidebar-widget">
                                <h3 class="label-title">'._esc($customfield['title'],false).'</h3>
                                '._esc($customfield['radio'],false).'
                            </div>';
                            }
                            if($customfield['type']=="drop-down"){
                                echo '<div class="sidebar-widget">
                                <h3 class="label-title">'._esc($customfield['title'],false).'</h3>
                                <select class="selectpicker with-border" name="custom['._esc($customfield["id"],false).']">
                                    <option value="" selected>'.__("Select").' '._esc($customfield["title"],false).'</option>
                                    '._esc($customfield["selectbox"],false).'
                                </select>
                            </div>';
                            }
                            if($customfield['type']=="checkboxes"){
                                echo '<div class="sidebar-widget">
                                <h3 class="label-title">'._esc($customfield['title'],false).'</h3>
                                '._esc($customfield['checkbox'],false).'
                            </div>';
                            }
                        }
                        ?>
                        <div class="sidebar-widget">
                            <h3><?php _e("Budget") ?></h3>
                            <div class="range-widget">
                                <div class="range-inputs">
                                    <input type="text" placeholder="<?php _e("Min") ?>" name="range1" value="<?php _esc($range1) ?>">
                                    <input type="text" placeholder="<?php _e("Max") ?>" name="range2" value="<?php _esc($range2) ?>">
                                </div>
                                <button type="submit" class="button"><i class="icon-feather-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <button class="button full-width ripple-effect"><?php _e("Advanced Search") ?></button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 content-left-offset">

                    <h3 class="page-title"><?php _e("Search Results") ?></h3>

                    <div class="notify-box margin-top-15">

                        <span class="font-weight-600"><?php _esc($adsfound) ?> <?php _e("Services Found") ?></span>

                        <div class="sort-by">
                            <span><?php _e("Sort by:") ?></span>
                            <select class="selectpicker hide-tick" id="sort-filter">
                                <option data-filter-type="sort" data-filter-val="id" data-order="desc"><?php _e("Newest") ?></option>
                                <option data-filter-type="sort" data-filter-val="title" data-order="desc"><?php _e("Name") ?></option>
                                <option data-filter-type="sort" data-filter-val="date" data-order="desc"><?php _e("Date") ?></option>
                            </select>
                        </div>
                    </div>
                    <link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/css/gig_detail.css" rel="stylesheet"/>

                    <!-- Tasks Container -->
                    <div class="recommended margin-top-35">
                        <div class="container">
                            <div class="row">
                                <?php foreach ($items as $item){ ?>
                                    <div class="col-4">

                                        <a href="<?php _esc($item['link'])?>">
                                            <img class="img-fluid" src="<?php _esc($config['site_url'])?>storage/products/<?php _esc($item['image'])?>" alt="<?php _esc($item['title'])?>">
                                        </a>
                                        <div class="inner-slider">
                                            <div class="inner-wrapper">
                                                <div class="d-flex align-items-center">
                                                    <span class="seller-image">
                                                        <img class="img-fluid" src="<?php _esc($config['site_url'])?>storage/profile/<?php _esc($item['user_image'])?>" alt='<?php _esc($item['username'])?>' />
                                                    </span>
                                                    <span class="seller-name">
                                                        <a href="<?php url("PROFILE") ?>/<?php _esc($item['username'])?>"><?php _esc($item['fullname'])?></a>
                                                        <span class="level hint--top level-one-seller"><?php _esc($item['username'])?></span>
                                                    </span>
                                                </div>
                                                <h3><a href="<?php _esc($item['link'])?>"><?php _esc($item['title'])?></a></h3>
                                                <div class="content-info">
                                                    <div class="rating-wrapper">
                                                        <span class="gig-rating">
                                                            <?php _esc($item['rating']);?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="footer">
                                                    <?php if($usertype == 'employer') { ?>
                                                        <i class="fa fa-heart set-item-fav <?php if($item['favorite'] == '1') { echo 'added'; }?>" data-item-id="<?php _esc($item['id'])?>" data-userid="<?php _esc($user_id)?>" data-post-type="gig" data-action="setFavAd"></i>
                                                    <?php }?>
                                                    <div class="price">
                                                        <a href="#">
                                                            <?php _e('Starting At')?> <span> <?php _esc($item['price'])?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                    <!-- Tasks Container / End -->


                    <!-- Pagination -->
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Pagination -->
                            <div class="pagination-container margin-top-60 margin-bottom-60">
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
                    <!-- Pagination / End -->

                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">

        $('#sort-filter').on('change', function (e) {
            var $item = $(this).find(':selected');
            var filtertype = $item.data('filter-type');
            var filterval = $item.data('filter-val');
            $('#input-' + filtertype).val(filterval);
            $('#input-order').val($item.data('order'));
            $('#ListingForm').submit();
        });

        var getMaincatId = '<?php _esc($maincat) ?>';
        var getSubcatId = '<?php _esc($subcat) ?>';

        $(window).bind("load", function () {
            if (getMaincatId != "") {
                $('li a[data-cat-type="maincat"][data-ajax-id="' + getMaincatId + '"]').trigger('click');
            } else if (getSubcatId != "") {
                $('li ul li a[data-cat-type="subcat"][data-ajax-id="' + getSubcatId + '"]').trigger('click');
            } else {
                $('li a[data-cat-type="all"]').trigger('click');
            }
        });
    </script>
<?php overall_footer(); ?>