<?php
overall_header(__("Post Service"));
$lang_direction = get_current_lang_direction();
?>
<link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/css/service.css" rel="stylesheet"/>
<style>
    .quickgig-pricing .quick-gig-pricing-section {
        margin-bottom: 52px;
    }
    .quickgig-pricing .quick-gig-pricing-section>header {
        font-weight: 600;
        padding-top: 12px;
        padding-bottom: 16px;
    }
    .quickgig-pricing .quick-gig-pricing-section .quick-gig-pricing-container {
        position: relative;
    }
    .quickgig-pricing .quick-gig-pricing-section table {
        table-layout: fixed;
        width: 100%;
    }
    .quickgig-pricing .quick-gig-pricing-section .first-table-col {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        background-color: #fafafa;
        position: relative;
        padding: 10px 15px;
        font-size: 13px;
    }
    .quickgig-pricing .quick-gig-pricing-table .first-table-col {
        border-bottom: none;
    }
    .quickgig-pricing .quick-gig-pricing-section table th {
        background-color: rgb(245, 245, 245);
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 600;
        padding: 20px 16px;
    }
    .quickgig-pricing .quick-gig-pricing-section table td,
    .quickgig-pricing .quick-gig-pricing-section table th {
        text-align: left;
        border-width: 1px;
        border-style: solid;
        border-color: rgb(218, 219, 221);
        border-image: initial;
    }
    .quickgig-pricing .quick-gig-pricing-section table th {
        text-transform: uppercase;
        font-weight: 600;
    }
    .quickgig-pricing .quick-gig-pricing-section table td,
    .quickgig-pricing .quick-gig-pricing-section table th {
        text-align: left;
        border: 1px solid #dadbdd;
    }
    .quickgig-pricing .quick-gig-pricing-table td.first-table-col {
        border-top: none;
    }
    @media screen and (max-width:600px){
        .quickgig-pricing .quick-gig-pricing-table td.first-table-col {
            display: none;
        }
    }
    .quickgig-pricing .quick-gig-pricing-section table td:not(.first-table-col) {
        position: relative;
        vertical-align: middle;
    }
    .quickgig-pricing .quick-gig-pricing-section table td {
        background-color: #fff;
    }
    .quickgig-pricing .submit-field {
        margin: 0;
    }
    .quickgig-pricing .quick-gig-pricing-section table td .fit-input, .quickgig-pricing .quick-gig-pricing-section table td textarea {
        font-size: 13px;
    }

    .submit-field .price-description-input {
        height: 124px;
    }
    .submit-field .price-title-input {
        height: 70px;
    }
    .submit-field .price-title-input, .submit-field .price-description-input {
        min-height: auto;
        padding: 5px;
        margin: 0;
        resize: none;
        width: 100%;
        padding-right: 24px;
        border: none;
    }
    .submit-field .price-title-input:focus~.edit-icon, .submit-field .price-description-input:focus~.edit-icon {
        display: none;
    }
    .submit-field .edit-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 12px;
        height: 12px;
        color: rgb(197, 198, 201);
    }
    .submit-field.field-error .edit-icon {
        display: none;
    }
    .pricing-error {
        position: absolute;
        top: 4px;
        right: 4px;
        z-index: 1;
        display: none;
    }
    .pricing-error i {
        width: 14px;
        height: 14px;
        color: rgb(247, 64, 64);
    }
    .quickgig-pricing .bootstrap-select.btn-group button {
        box-shadow: none;
    }
    /*Tooltips*/
    .quickgig-pricing .quick-gig-pricing-section .pricing-education {
        -webkit-transition: all .3s ease 0s;
        -o-transition: all .3s ease 0s;
        transition: all .3s ease 0s;
    }
    .quickgig-pricing .pricing-education .education-tooltip {
        top: 188px;
    }
    .quickgig-pricing .quick-gig-pricing-section .quick-gig-pricing-container:hover~.pricing-education{
        visibility:hidden;opacity:0
    }
    .quickgig-pricing table tr:hover .table-tooltip-on-hover {
        visibility: visible;
        opacity: 1;
    }
    .quickgig-pricing table tr .table-tooltip-on-hover {
        position: absolute;
        right: 0;
        z-index: 1;
        -webkit-transition: all .3s ease 0;
        -o-transition: all .3s ease 0;
        transition: all .3s ease 0;
        visibility: hidden;
        opacity: 0;
    }
    .quickgig-pricing .pkg-title-education,
    .quickgig-pricing .pkg-description-education,
    .quickgig-pricing .pkg-duration-education,
    .quickgig-pricing .pkg-pricing-factor-education {
        right: -612px!important;
        top: 0;
    }
    .quickgig-pricing .education-tooltip {
        background-color: #ecfcff;
        border-radius: 3px;
        width: 250px;
        position: absolute;
        right: 0;
        top: 0;
        -webkit-transform: translateX(calc(100% + 20px));
        transform: translateX(calc(100% + 20px));
        padding: 20px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        font-weight: 400;
        font-size: 12px;
        line-height: 18px;
        border: 1px solid #afedf7;
        color: #222325;
    }
    .quickgig-pricing .education-tooltip>p {
        font-size: 11px;
        font-weight: 400;
        line-height: 16px;
        margin-bottom: 5px;
    }

    .box-shadow-z4 {
        box-shadow: 0 0.266px 1.13052px rgb(0 0 0 / 7%), 0 0.89345px 3.79717px rgb(0 0 0 / 10%), 0 5px 17px rgb(0 0 0 / 17%);
    }
    .quickgig-pricing .education-tooltip:after, .quickgig-pricing .education-tooltip:before {
        content: "";
        display: block;
        position: absolute;
        right: 100%;
        width: 0;
        height: 0;
        border-style: solid;
        z-index: 1;
    }
    .quickgig-pricing .education-tooltip:before {
        top: 9px;
        border-color: transparent #afedf7 transparent transparent;
        border-width: 9.7px;
    }
    .quickgig-pricing .education-tooltip:after {
        top: 10.4px;
        border-color: transparent #ecfcff transparent transparent;
        border-width: 8px;
    }
    .quickgig-pricing .education-tooltip>header {
        margin-bottom: 12px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
    }
    .quickgig-pricing .education-tooltip .icn-lightbulb-wrapper {
        background-color: #3ad0e6;
        position: absolute;
        -webkit-transform: translateY(-40px);
        transform: translateY(-40px);
        height: 37px;
        width: 37px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-item-align: center;
        align-self: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        border-radius: 50%;
    }
    .quickgig-pricing .education-tooltip .icn-lightbulb-wrapper .fa {
        font-size: 24px;
        color: #fff;
    }
    .quickgig-pricing .education-tooltip>header>h6 {
        margin-top: 8px;
        font-weight: 600;
        color: #222325;
    }
    .quickgig-pricing .education-tooltip ul{
        margin-left: 20px;
        list-style-type: disc;
    }
    .quickgig-pricing .education-tooltip ul>li{
        margin-bottom: 5px;
    }
    .tbody-5 {
        font-size: 16px;
        line-height: 24px;
    }
</style>
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

<div class="quickform-multisteps hidden">
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
            <button type="button" class="naked-button co-blue text-bold"><?php _e("Save") ?></button>
            <span class="sep">|</span>
            <button type="button" class="naked-button co-blue text-bold"><?php _e("Save &amp; Preview") ?></button>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-md-12">
                <!-- multistep form -->
                <div id="post_error" class="margin-top-30"></div>
                <div class="payment-confirmation-page dashboard-box margin-top-0 padding-top-0 margin-bottom-50"
                     style="display: none">
                    <div class="headline">
                        <h3><?php _e("Success") ?></h3>
                    </div>
                    <div class="content with-padding padding-bottom-10">
                        <i class="la la-check-circle"></i>

                        <h2 class="margin-top-30"><?php _e("Success") ?></h2>

                        <p><?php _e("Your gig successfully uploaded. Please wait for approval. Thanks") ?></p>
                    </div>
                </div>
                <form id="gig-overview-form" action="" method="post"
                      enctype="multipart/form-data" accept-charset="UTF-8" data-action="save_gig_overview">
                    <!--Overview Fragment-->
                    <div class="dashboard-box margin-top-30">
                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-briefcase"></i><?php _e("Gig overview") ?></h3>
                        </div>
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="submit-field">
                                        <div class="form-group text-center margin-bottom-30">
                                            <a href="#categoryModal" id="choose-category"
                                               class="button popup-with-zoom-anim"><i class="icon-feather-check-circle"></i>
                                                &nbsp;<?php _e("Choose Category") ?></a>
                                        </div>
                                        <div class="form-group selected-product" id="change-category-btn"
                                             style='display: none'>
                                            <ul class="select-category list-inline">
                                                <li id="main-category-text"></li>
                                                <li id="sub-category-text"></li>
                                                <li class="active"><a href="#categoryModal" class="popup-with-zoom-anim"><i
                                                                class="icon-feather-edit"></i> <?php _e("Edit") ?></a></li>
                                            </ul>

                                            <input type="hidden" id="input-maincatid" name="catid" value="">
                                            <input type="hidden" id="input-subcatid" name="subcatid" value="">
                                        </div>
                                    </div>

                                    <div class="submit-field">
                                        <h5><?php _e("Gig title") ?> *</h5>
                                        <p><?php _e("As your Gig storefront, your title is the most important place to include keywords that buyers would likely use to search for a service like yours.") ?></p>
                                        <input type="text" class="with-border" name="title">
                                    </div>

                                    <div class="submit-field">
                                        <h5><?php _e("Gig summary") ?> *</h5>
                                        <p><?php _e("Briefly explain what sets you and your gig apart.") ?> *</p>
                                        <textarea cols="30" rows="5" class="with-border text-editor" name="content"></textarea>
                                    </div>

                                    <div id="ResponseCustomFields">
                                        <?php
                                        foreach ($custom_fields as $customfield){
                                            if($customfield['type']=="text-field"){
                                                echo '<div class="submit-field">
                                                    <h5>'._esc($customfield['title'],false).'</h5>
                                                        '._esc($customfield['textbox'],false).'
                                                    </div>';
                                            }
                                            if($customfield['type']=="textarea"){
                                                echo '<div class="submit-field">
                                                        <h5>'._esc($customfield['title'],false).'</h5>
                                                        '._esc($customfield['textarea'],false).'
                                                    </div>';
                                            }
                                            if($customfield['type']=="radio-buttons"){
                                                echo '<div class="submit-field">
                                                        <h5>'._esc($customfield['title'],false).'</h5>
                                                        '._esc($customfield['radio'],false).'
                                                    </div>';
                                            }
                                            if($customfield['type']=="drop-down"){
                                                echo '<div class="submit-field">
                                                        <h5>'._esc($customfield['title'],false).'</h5>
                                                        <select class="selectpicker with-border quick-custom-field" 
                                                        name="custom['._esc($customfield["id"],false).']"
                                                        data-name="'._esc($customfield["id"],false).'" 
                                                        data-req="'._esc($customfield["required"],false).'">
                                                            <option value="" selected>'.__("Select").' '._esc($customfield["title"],false).'</option>
                                                            '._esc($customfield["selectbox"],false).'
                                                        </select>
                                                        <div class="quick-error">'.__("This field is required.").'</div>
                                                    </div>';
                                            }
                                            if($customfield['type']=="checkboxes"){
                                                echo '<div class="submit-field">
                                                        <h5>'._esc($customfield['title'],false).'</h5>
                                                        '._esc($customfield['checkbox'],false).'
                                                    </div>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="submit-field" id="quickad-photo-field">
                                        <h5><?php _e("Gig Gallery") ?> *</h5>
                                        <div id="item_screen" orakuploader="on"></div>
                                    </div>

                                    <?php if($config['post_tags_mode'] == "1"){ ?>
                                        <div class="submit-field form-group">
                                            <h5><?php _e("Search tags") ?></h5>
                                            <p><?php _e("Enter search terms you feel your buyers will use when looking for your service.") ?></p>
                                            <input class="with-border" type="text" name="tags">
                                            <small><?php _e("Enter the tags separated by commas.") ?></small>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Overview Fragment-->
                    <!--Pricing Fragment-->
                    <div class="dashboard-box margin-top-20">
                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-briefcase"></i><?php _e("Scope & Pricing") ?></h3>
                        </div>
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="quickgig-pricing">
                                        <section class="quick-gig-pricing-section">
                                            <header>
                                                <span><?php _e("Packages") ?></span>
                                            </header>
                                            <div class="quick-gig-pricing-container">
                                                <table class="quick-gig-pricing-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="first-table-col"></th>
                                                        <th><?php _e("Basic") ?></th>
                                                        <th><?php _e("Standard") ?></th>
                                                        <th><?php _e("Premium") ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="first-table-col">
                                                            <section class="pkg-title-education table-tooltip-on-hover">
                                                                <div class="education-tooltip box-shadow-z4">
                                                                    <header>
                                                                        <div class="icn-lightbulb-wrapper">
                                                                            <i class="fa fa-lightbulb-o"></i>
                                                                        </div>
                                                                        <h6 class="tbody-5"><?php _e("Title") ?></h6>
                                                                    </header>
                                                                    <ul>
                                                                        <li><?php _e("Give your package a catchy title, which describes what it includes.") ?></li>
                                                                        <li>
                                                                            <b><?php _e("For example") ?>:</b> <?php _e("2D or 3D cover, Print-Ready Version") ?>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </section>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-title-input quick-custom-field" name="basic_plan_title" data-req="1" maxlength="35" placeholder="<?php _e('Name your package')?>"><?php _e('Basic')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-title-input quick-custom-field" data-req="1" name="standard_plan_title" maxlength="35" placeholder="<?php _e('Name your package')?>"><?php _e('Standard')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-title-input quick-custom-field" data-req="1" name="premium_plan_title" maxlength="35" placeholder="<?php _e('Name your package')?>"><?php _e('Premium')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="first-table-col">
                                                            <section class="pkg-description-education table-tooltip-on-hover">
                                                                <div class="education-tooltip box-shadow-z4">
                                                                    <header>
                                                                        <div class="icn-lightbulb-wrapper">
                                                                            <i class="fa fa-lightbulb-o"></i>
                                                                        </div>
                                                                        <h6 class="tbody-5"><?php _e('Description')?></h6>
                                                                    </header>
                                                                    <ul>
                                                                        <li><?php _e('Summarize what this package offers buyers, and why you included these items in your package.')?></li>
                                                                        <li><?php _e('You can use maximum 100 chars.')?></li>
                                                                    </ul>
                                                                    <p>
                                                                        <b><?php _e('For example')?>:</b> <?php _e('This (Full Logo Design) package includes a standard logo design with 4 revisions and the source file.')?>
                                                                    </p>
                                                                </div>
                                                            </section>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-description-input quick-custom-field" data-req="1" name="basic_plan_desc" maxlength="100" placeholder="<?php _e('Describe the details of your offering')?>"><?php _e('Basic')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-description-input quick-custom-field" data-req="1" name="standard_plan_desc" maxlength="100" placeholder="<?php _e('Describe the details of your offering')?>"><?php _e('Standard')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                                <textarea class="price-description-input quick-custom-field" data-req="1" name="premium_plan_desc" maxlength="100" placeholder="<?php _e('Describe the details of your offering')?>"><?php _e('Premium')?></textarea>
                                                                <span class="edit-icon"><i class="fa fa-pencil"></i></span>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="first-table-col">
                                                            <section class="pkg-duration-education table-tooltip-on-hover">
                                                                <div class="education-tooltip box-shadow-z4">
                                                                    <header>
                                                                        <div class="icn-lightbulb-wrapper">
                                                                            <i class="fa fa-lightbulb-o"></i>
                                                                        </div>
                                                                        <h6 class="tbody-5"><?php _e('Delivery Time')?></h6>
                                                                    </header>
                                                                    <ul>
                                                                        <li><?php _e('Delivery Time is the amount of time you have to work on the package, starting from when a buyer places the order.')?></li>
                                                                        <li><?php _e('Set a delivery time that makes sense for you, based on the combined time it takes you to create every part of the package.')?></li>
                                                                    </ul>
                                                                </div>
                                                            </section>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="basic_plan_delivery_time" data-req="1">
                                                                <option value="" selected><?php _e('Basic Delivery Time')?></option>
                                                                <option value="1">1 <?php _e('day delivery')?></option>
                                                                <option value="2">2 <?php _e('days delivery')?></option>
                                                                <option value="3">3 <?php _e('days delivery')?></option>
                                                                <option value="4">4 <?php _e('days delivery')?></option>
                                                                <option value="5">5 <?php _e('days delivery')?></option>
                                                                <option value="6">6 <?php _e('days delivery')?></option>
                                                                <option value="7">7 <?php _e('days delivery')?></option>
                                                                <option value="10">10 <?php _e('days delivery')?></option>
                                                                <option value="14">14 <?php _e('days delivery')?></option>
                                                                <option value="21">21 <?php _e('days delivery')?></option>
                                                                <option value="30">30 <?php _e('days delivery')?></option>
                                                                <option value="45">45 <?php _e('days delivery')?></option>
                                                                <option value="60">60 <?php _e('days delivery')?></option>
                                                                <option value="90">90 <?php _e('days delivery')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="standard_plan_delivery_time" data-req="1">
                                                                <option value="" selected><?php _e('Standard Delivery Time')?></option>
                                                                <option value="1">1 <?php _e('day delivery')?></option>
                                                                <option value="2">2 <?php _e('days delivery')?></option>
                                                                <option value="3">3 <?php _e('days delivery')?></option>
                                                                <option value="4">4 <?php _e('days delivery')?></option>
                                                                <option value="5">5 <?php _e('days delivery')?></option>
                                                                <option value="6">6 <?php _e('days delivery')?></option>
                                                                <option value="7">7 <?php _e('days delivery')?></option>
                                                                <option value="10">10 <?php _e('days delivery')?></option>
                                                                <option value="14">14 <?php _e('days delivery')?></option>
                                                                <option value="21">21 <?php _e('days delivery')?></option>
                                                                <option value="30">30 <?php _e('days delivery')?></option>
                                                                <option value="45">45 <?php _e('days delivery')?></option>
                                                                <option value="60">60 <?php _e('days delivery')?></option>
                                                                <option value="90">90 <?php _e('days delivery')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="premium_plan_delivery_time" data-req="1">
                                                                <option value="" selected><?php _e('Premium Delivery Time')?></option>
                                                                <option value="1">1 <?php _e('day delivery')?></option>
                                                                <option value="2">2 <?php _e('days delivery')?></option>
                                                                <option value="3">3 <?php _e('days delivery')?></option>
                                                                <option value="4">4 <?php _e('days delivery')?></option>
                                                                <option value="5">5 <?php _e('days delivery')?></option>
                                                                <option value="6">6 <?php _e('days delivery')?></option>
                                                                <option value="7">7 <?php _e('days delivery')?></option>
                                                                <option value="10">10 <?php _e('days delivery')?></option>
                                                                <option value="14">14 <?php _e('days delivery')?></option>
                                                                <option value="21">21 <?php _e('days delivery')?></option>
                                                                <option value="30">30 <?php _e('days delivery')?></option>
                                                                <option value="45">45 <?php _e('days delivery')?></option>
                                                                <option value="60">60 <?php _e('days delivery')?></option>
                                                                <option value="90">90 <?php _e('days delivery')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="packages-pricing-factors">
                                                    <tbody>
                                                    <tr>
                                                        <td class="first-table-col"><?php _e('Revisions')?> <section class="pkg-pricing-factor-education table-tooltip-on-hover">
                                                                <div class="education-tooltip box-shadow-z4">
                                                                    <header>
                                                                        <div class="icn-lightbulb-wrapper">
                                                                            <i class="fa fa-lightbulb-o"></i>
                                                                        </div>
                                                                        <h6 class="tbody-5"><?php _e('Revisions')?></h6>
                                                                    </header>
                                                                    <p><?php _e('Set the price for an additional revision.')?></p>
                                                                </div>
                                                            </section>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="basic_plan_revisions" data-req="1">
                                                                <option value="" selected><?php _e('For Basic Plan')?></option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="10">10</option>
                                                                <option value="unlimited"><?php _e('Unlimited')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="standard_plan_revisions" data-req="1">
                                                                <option value="" selected><?php _e('For Standard Plan')?></option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="10">10</option>
                                                                <option value="unlimited"><?php _e('Unlimited')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field">
                                                            <select class="selectpicker quick-custom-field" name="premium_plan_revisions" data-req="1">
                                                                <option value="" selected><?php _e('For Premium Plan')?></option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="10">10</option>
                                                                <option value="unlimited"><?php _e('Unlimited')?></option>
                                                            </select>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                                <table class="packages-prices">
                                                    <tbody>
                                                    <tr>
                                                        <td class="first-table-col"><?php _e('Price')?></td>
                                                        <td>
                                                            <div class="submit-field input-container">
                                                                <input class="margin-bottom-0 quick-custom-field" type="number" placeholder="<?php _e('Price')?>" name="basic_plan_price" data-req="1">
                                                                <i class="icon"><?php _esc($config['currency_sign']);?></i>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field input-container">
                                                                <input class="margin-bottom-0 quick-custom-field" type="number" placeholder="<?php _e('Price')?>" name="standard_plan_price" data-req="1">
                                                                <i class="icon"><?php _esc($config['currency_sign']);?></i>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="submit-field input-container">
                                                                <input class="margin-bottom-0 quick-custom-field" type="number" placeholder="<?php _e('Price')?>" name="premium_plan_price" data-req="1">
                                                                <i class="icon"><?php _esc($config['currency_sign']);?></i>
                                                                <div class="pricing-error quick-error">
                                                                    <i class="fa fa-info-circle" data-tippy-placement="top" title="<?php _e('Required')?>"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <section class="pricing-education">
                                                <div class="education-tooltip box-shadow-z4">
                                                    <header>
                                                        <div class="icn-lightbulb-wrapper">
                                                            <i class="fa fa-lightbulb-o"></i>
                                                        </div>
                                                        <h6 class="tbody-5"><?php _e('Set your packages')?></h6>
                                                    </header>
                                                    <ul>
                                                        <li><?php _e('Set the prices for your 3 packages.')?></li>
                                                        <li><?php _e('Select the elements you want to include in each offer.')?></li>
                                                        <li><?php _e('Add Extras to increase your order value.')?></li>
                                                    </ul>
                                                </div>
                                            </section>
                                        </section>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Pricing Fragment-->
                    <div class="gotonext margin-top-30 margin-bottom-30">
                        <div class="clearfix">
                            <div class="float-right">
                                <button type="submit" id="submit_gig_button" class="oval button"><?php _e('Publish Gig')?></button>
                            </div>
                        </div>
                    </div>
                </form>
                <script type="text/javascript" src="<?php _esc(TEMPLATE_URL);?>/service_fragments/js/plugins.js"></script>
                <script type="text/javascript" src="<?php _esc(TEMPLATE_URL);?>/service_fragments/js/core.js"></script>
                <script type="text/javascript" src="<?php _esc(TEMPLATE_URL);?>/service_fragments/js/faq.js"></script>
                <!-- multistep form -->

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