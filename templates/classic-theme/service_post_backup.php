<?php
overall_header(__("Post Project"));
$lang_direction = get_current_lang_direction();
?>
    <link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/css/gig.css" rel="stylesheet"/>

    <!-- Select Category Modal -->
    <div class="zoom-anim-dialog mfp-hide popup-dialog big-dialog" id="categoryModal">
        <div class="popup-tab-content padding-0 tg-thememodal tg-categorymodal">
            <div class="tg-thememodaldialog">
                <div class="tg-thememodalcontent">
                    <div class="tg-title">
                        <strong><?php _e("Select") ?> <?php _e("Category") ?></strong>
                    </div>
                    <div id="tg-dbcategoriesslider"
                         class="tg-dbcategoriesslider tg-categories owl-carousel select-category post-option">
                        <?php foreach ($category as $cat){ ?>
                            <div class="tg-category <?php _esc($cat['selected'])?>" data-ajax-catid="<?php _esc($cat['id'])?>"
                                 data-ajax-action="getsubcatbyidList" data-cat-name="<?php _esc($cat['name'])?>"
                                 data-sub-cat="<?php _esc($cat['sub_cat'])?>">
                                <div class="tg-categoryholder">
                                    <div class="margin-bottom-10">
                                        <?php
                                        if($cat['picture'] == ""){
                                            echo '<i class="'._esc($cat['icon'],false).'"></i>';
                                        }else{
                                            echo '<img src="'._esc($cat['picture'],false).'" alt="'._esc($cat['name'],false).'"/>';
                                        }
                                        ?>
                                    </div>
                                    <h3><a href="javascript:void()"><?php _esc($cat['name'])?></a></h3>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <ul class="tg-subcategories" style="display: none">
                        <li>
                            <div class="tg-title">
                                <strong><?php _e("Select") ?> <?php _e("Sub Category") ?></strong>

                                <div id="sub-category-loader" style="visibility:hidden"></div>
                            </div>
                            <div class=" tg-verticalscrollbar tg-dashboardscrollbar">
                                <ul id="sub_category">

                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Select Category Modal -->

    <div class="quickform-multisteps">
        <div class="top-navbar-container">
            <nav class="quick-breadcrumbs top-navbar wizard quick-breadcrumbs-progress">
                <ul id="progressbar">
                    <li class="overview active">
                        <span class="quick-breadcrumbs-icon quick-breadcrumbs-icon-highlighted">
                            <span class="quick-icon" style="width: 14px; height: 14px; fill: rgb(255, 255, 255);">
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path
                                            d="M13.6202 2.6083L5.4001 10.8284L2.37973 7.80805C2.23329 7.66161 1.99585 7.66161 1.84939 7.80805L0.96551 8.69193C0.819073 8.83836 0.819073 9.0758 0.96551 9.22227L5.13492 13.3917C5.28135 13.5381 5.51879 13.5381 5.66526 13.3917L15.0344 4.02252C15.1809 3.87608 15.1809 3.63865 15.0344 3.49218L14.1505 2.6083C14.0041 2.46186 13.7667 2.46186 13.6202 2.6083Z"></path></svg>
                            </span>
                        </span>
                        <span class="quick-crumb quick-crumb-previous">
                            <span class="crumb-content">Overview
                                <div class="floating-border"></div>
                            </span>
                        </span>
                        <span class="quick-icon quick-breadcrumbs-separator" style="width: 12px; height: 12px;">
                            <svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
                        </span>
                    </li>
                    <li class="pricing">
                        <span class="quick-breadcrumbs-icon quick-breadcrumbs-icon-highlighted">2</span>
                        <span class="quick-crumb current quick-crumb-current"><span class="crumb-content">Pricing
                                <div class="floating-border"></div>
                            </span>
                        </span>
                        <span class="quick-icon quick-breadcrumbs-separator" style="width: 12px; height: 12px;"><svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg></span>
                    </li>
                    <li class="description">
                        <span class="quick-breadcrumbs-icon">3</span>
                        <span class="quick-crumb disabled quick-crumb-next">
                            <span class="crumb-content" title="Complete the current step before moving on">Description &amp; FAQ
                                <div class="floating-border"></div>
                            </span>
                        </span>
                        <span class="quick-icon quick-breadcrumbs-separator" style="width: 12px; height: 12px;">
                            <svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
                        </span>
                    </li>
                    <li class="requirements">
                        <span class="quick-breadcrumbs-icon">4</span>
                        <span class="quick-crumb disabled quick-crumb-next">
                            <span class="crumb-content" title="Complete the current step before moving on">Requirements
                                <div class="floating-border"></div>
                            </span>
                        </span>
                        <span class="quick-icon quick-breadcrumbs-separator" style="width: 12px; height: 12px;">
                            <svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
                        </span>
                    </li>
                    <li class="gallary"><span class="quick-breadcrumbs-icon">5</span>
                        <span class="quick-crumb disabled quick-crumb-next">
                            <span class="crumb-content" title="Complete the current step before moving on">Gallery
                                <div class="floating-border"></div>
                            </span>
                        </span>
                        <span class="quick-icon quick-breadcrumbs-separator" style="width: 12px; height: 12px;">
                            <svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
                        </span>
                    </li>
                    <li class="publish">
                        <span class="quick-breadcrumbs-icon">6</span><span
                                class="quick-crumb disabled quick-crumb-next">
                            <span class="crumb-content" title="Complete the current step before moving on">Publish
                                <div class="floating-border"></div>
                            </span>
                        </span>
                    </li>
                </ul>
            </nav>
            <div class="save-btn-container save-and-preview">
                <button type="button" class="naked-button co-blue text-bold">Save</button>
                <span class="sep">|</span>
                <button type="button" class="naked-button co-blue text-bold">Save &amp; Preview</button>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-md-12">
                    <!-- multistep form -->
                    <div id="post_error"></div>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/overview.fragment.php'; ?>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/pricing.fragment.php'; ?>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/description.fragment.php'; ?>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/requirements.fragment.php'; ?>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/gallary.fragment.php'; ?>
                    <?php require_once TEMPLATE_PATH.'/service_fragments/publish.fragment.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ajaxurl = "<?php _esc($config['app_url'])?>user-ajax.php";
        var lang_edit_cat = "<i class='icon-feather-check-circle'></i> &nbsp;<?php _e("Edit Category") ?>";
    </script>
    <link href="<?php _esc(TEMPLATE_URL);?>/css/category-modal.css" type="text/css" rel="stylesheet">
    <link href="<?php _esc(TEMPLATE_URL);?>/css/owl.post.carousel.css" type="text/css" rel="stylesheet">
    <script src="<?php _esc(TEMPLATE_URL);?>/js/owl.carousel-category.min.js"></script>
    <link href="<?php _esc(TEMPLATE_URL);?>/css/select2.min.css" rel="stylesheet"/>
    <script src="<?php _esc(TEMPLATE_URL);?>/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/js/i18n/<?php _esc($config['lang_code']) ?>.js"></script>
    <!-- orakuploader -->
    <link type="text/css" href="<?php _esc($config['site_url']);?>plugins/orakuploader/orakuploader.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php _esc($config['site_url']);?>plugins/orakuploader/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php _esc($config['site_url']);?>plugins/orakuploader/orakuploader.js"></script>
<?php if($lang_direction == 'rtl') { ?>
    <link type="text/css" href="<?php _esc($config['site_url']);?>plugins/orakuploader/orakuploader-rtl.css" rel="stylesheet"/>
<?php } ?>
    <script>
        var watermark_image = '';
        var max_image_upload = '<?php _esc($config['max_image_upload']);?>';
        var LANG_UPLOAD_IMAGES = "<?php _e("Upload images");?>";
        var LANG_MAIN_IMAGE = "<?php _e("Main Image");?>";
        var siteurl = '<?php _esc($config['site_url']);?>';
        $(document).ready(function(){
            // -------------------------------------------------------------
            //  Intialize orakuploader
            // -------------------------------------------------------------
            $('#item_screen').orakuploader({
                site_url :  siteurl,
                orakuploader_path : 'plugins/orakuploader/',
                orakuploader_main_path : 'storage/products',
                orakuploader_thumbnail_path : 'storage/products/thumb',
                orakuploader_add_image : siteurl+'plugins/orakuploader/images/add.svg',
                orakuploader_watermark : watermark_image,
                orakuploader_add_label : LANG_UPLOAD_IMAGES,
                orakuploader_use_main : true,
                orakuploader_use_sortable : true,
                orakuploader_use_dragndrop : true,
                orakuploader_use_rotation: true,
                orakuploader_resize_to : 800,
                orakuploader_thumbnail_size  : 250,
                orakuploader_maximum_uploads : max_image_upload,
                orakuploader_max_exceeded : max_image_upload,
                orakuploader_hide_on_exceed : true,
                orakuploader_main_changed    : function (filename) {
                    $("#mainlabel-images").remove();
                    $("div").find("[filename='" + filename + "']").append("<div id='mainlabel-images' class='maintext'>"+LANG_MAIN_IMAGE+"</div>");
                },
                orakuploader_max_exceeded : function() {
                    alert("You exceeded the max. limit of "+max_image_upload+" images.");
                }
            });
        });
    </script>
<?php overall_footer(); ?>