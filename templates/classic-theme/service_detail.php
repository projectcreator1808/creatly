<?php
overall_header(__("Post Project"));
?>
    <link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/css/gig_detail.css" rel="stylesheet"/>
    <link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/vendor/lightgallery-master/lightgallery.min.css" rel="stylesheet"/>

<div class="third-menu border-top">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
            <div class="col-lg-12 left">
                <ul>
                    <li class="nav-overview selected"><a href="#overview"><?php _e('Overview');?></a></li>
                    <li class="nav-description"><a href="#description"><?php _e('Description');?></a></li>
                    <li class="nav-aboutSeller"><a href="#aboutSeller"><?php _e('About The Seller');?></a></li>
                    <li class="nav-packagesTable"><a href="#packagesTable"><?php _e('Compare Packages');?></a></li>
                    <li class="nav-faq hidden"><a href="#faq"><?php _e('FAQ');?></a></li>
                    <li class="nav-reviews"><a href="#reviews"><?php _e('Reviews');?></a></li>
                    <li class="nav-recommendations"><a href="#recommendations"><?php _e('Recommendations');?></a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
<div class="main-page padding-top-30">
    <div class="container margin-bottom-50">
        <div class="row">
            <div class="col-xl-8 col-lg-8 content-right-offset left">
                <div class="margin-bottom-20">
                    <nav id="breadcrumbs" class="listing_job padding-bottom-10">
                        <ul>
                            <li><a href="<?php _esc($item_catlink)?>"><?php _esc($item_category)?></a></li>
                            <li><a href="<?php _esc($item_subcatlink)?>"><?php _esc($item_sub_category)?></a></li>
                        </ul>
                    </nav>
                    <h1 class="post-title"><?php _esc($item_title)?></h1>
                    <div id="overview" class="seller-overview d-flex align-items-center">
                        <div class="user-profile-image d-flex">
                            <label class="profile-pict" for="profile_image">
                                <img src="http://localhost/quicklancer/storage/profile/bylancer_5f895def38ada.jpeg" class="profile-pict-img img-fluid" alt="">
                            </label>
                            <div class="profile-name">
                                <a href="<?php _esc($item_ulink)?>" class="seller-link"><?php _esc($item_username)?></a>
                            </div>
                        </div>
                        <div class="user-info d-flex">
                            <?php _esc($gig_average_rating);?>
                            <?php if($order_in_queue){ ?>
                                <span class="orders-in-queue"><?php _esc($order_in_queue);?> <?php _e('Orders in Queue');?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--Gallary Div-->
                <div class="mainslider">
                    <div id="aniimated-thumbnials" class="slider-for slick-slider-single margin-bottom-5">
                        <?php
                        foreach($item_images as $image){
                            echo '<a href="'.$config['site_url'].'storage/products/'.$image.'">
                                <img class="img-fluid" src="'.$config['site_url'].'storage/products/'.$image.'" />
                            </a>';

                        }?>
                    </div>
                    <div class="slider-nav slick-slider-single">
                        <?php foreach($item_images as $image){
                            echo '<div class="item-slick">
                            <img class="img-fluid" src="'.$config['site_url'].'storage/products/thumb/'.$image.'" alt="'._esc($item_title,false).'">
                        </div>';

                        }?>
                    </div>
                </div>
                <!--Gallary Div-->
                <div class="single-page-section" id="description">
                    <h3 class="margin-bottom-25"><?php _e('About This Gig');?></h3>
                    <?php _esc($item_desc)?>
                </div>
                <div class="single-page-section" id="aboutSeller">
                    <h3 class="margin-bottom-25"><?php _e('About The Seller');?></h3>
                    <div class="boxed-list-item bid">
                        <div class="bids-avatar">
                            <div class="freelancer-avatar">
                                <div class="verified-badge"></div>
                                <a href="http://localhost/quicklancer/profile/bylancer">
                                    <img src="<?php _esc($config['site_url'])?>storage/profile/<?php _esc($item_uimage)?>" alt="Freelancer demo">
                                </a>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="item-content">
                            <h4>
                                <a href="<?php _esc($item_ulink)?>"><?php _esc($item_username)?></a>
                                <span><?php _esc($item_utagline)?></span>
                            </h4>
                            <div class="item-details margin-top-10">
                                <div class="star-rating" data-rating="<?php _esc($seller_rating); ?>"></div>
                                <div class="detail-item"><i class="icon-material-outline-date-range"></i> <?php _esc($item_ujoined)?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-package" id="packagesTable">
                    <h3 class="margin-bottom-25"><?php _e('Compare Packages');?></h3>
                    <table>
                        <tbody>
                        <tr class="package-type">
                            <th><?php _e('Package');?></th>
                            <td>
                                <p class="price"><?php _esc(price_format($basic_plan['price']))?> </p>
                                <b class="type"><?php _esc($basic_plan['name'])?></b>
                            </td>
                            <td>
                                <p class="price"><?php _esc(price_format($standard_plan['price']))?> </p>
                                <b class="type"><?php _esc($standard_plan['name'])?></b>
                            </td>
                            <td>
                                <p class="price"><?php _esc(price_format($premium_plan['price']))?> </p>
                                <b class="type"><?php _esc($premium_plan['name'])?></b>
                            </td>
                        </tr>
                        <tr class="description">
                            <th></th>
                            <td><?php _esc($basic_plan['description'])?> </td>
                            <td><?php _esc($standard_plan['description'])?> </td>
                            <td><?php _esc($premium_plan['description'])?> </td>
                        </tr>

                        <tr>
                            <th><?php _e('Revisions');?></th>
                            <td><?php _esc($basic_plan['revisions'])?> </td>
                            <td><?php _esc($standard_plan['revisions'])?> </td>
                            <td><?php _esc($premium_plan['revisions'])?> </td>
                        </tr>
                        <tr class="delivery-time">
                            <th><?php _e('Delivery Time');?></th>
                            <td>
                                <div class="delivery-radio-wrapper">
                                    <div class="radio">
                                        <input id="basic_delivery_time" name="basic_delivery_time" type="radio" checked>
                                        <label for="basic_delivery_time"><span class="radio-label"></span> <?php _esc($basic_plan['delivery_time'])?> <?php _e('days');?></label>
                                    </div>
                                    <br>
                                    <div class="radio hidden">
                                        <input id="basic_delivery_time-2" name="" type="radio">
                                        <label for="basic_delivery_time-2"><span class="radio-label"></span> 3 days<p class="faster-price">(+$4,818)</p></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <input id="standard_delivery_time-1" name="standard_delivery_time" type="radio" checked>
                                    <label for="standard_delivery_time-1"><span class="radio-label"></span> <?php _esc($standard_plan['delivery_time'])?> <?php _e('days');?></label>
                                </div>
                            </td>
                            <td>
                                <div class="radio">
                                    <input id="premium_delivery_time-1" name="premium_delivery_time" type="radio" checked>
                                    <label for="premium_delivery_time-1"><span class="radio-label"></span> <?php _esc($premium_plan['delivery_time'])?> <?php _e('days');?></label>
                                </div>
                            </td>
                        </tr>
                        <tr class="select-package">
                            <th><?php _e('Total');?></th>
                            <td>
                                <form method="post">
                                    <p class="price-label"><?php _esc(price_format($basic_plan['price']))?></p>
                                    <input type="hidden" name="order_service" value="basic">
                                    <button class="button ripple-effect" name="submit" type="submit"><?php _e('Select');?></button>
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <p class="price-label"><?php _esc(price_format($standard_plan['price']))?></p>
                                    <input type="hidden" name="order_service" value="standard">
                                    <button class="button ripple-effect" name="submit" type="submit"><?php _e('Select');?></button>
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <p class="price-label"><?php _esc(price_format($premium_plan['price']))?></p>
                                    <input type="hidden" name="order_service" value="premium">
                                    <button class="button ripple-effect" name="submit" type="submit"><?php _e('Select');?></button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="single-page-section hidden" id="faq">
                    <h3 class="margin-bottom-25"><?php _e('FAQ');?></h3>
                    <!-- Accordion -->
                    <div class="accordion js-accordion">

                        <!-- Accordion Item -->
                        <div class="accordion__item js-accordion-item">
                            <div class="accordion-header js-accordion-header">What do I need to get started?</div>

                            <!-- Accordtion Body -->
                            <div class="accordion-body js-accordion-body">

                                <!-- Accordion Content -->
                                <div class="accordion-body__contents">
                                    Globally incubate standards compliant channels before scalable benefits. Quickly disseminate superior deliverables whereas web-enabled applications. Quickly drive clicks-and-mortar catalysts for change.
                                </div>

                            </div>
                            <!-- Accordion Body / End -->
                        </div>
                        <!-- Accordion Item / End -->

                        <!-- Accordion Item -->
                        <div class="accordion__item js-accordion-item">
                            <div class="accordion-header js-accordion-header">What is Vector/Source file?</div>

                            <!-- Accordtion Body -->
                            <div class="accordion-body js-accordion-body">

                                <!-- Accordion Content -->
                                <div class="accordion-body__contents">
                                    Distinctively re-engineer revolutionary meta-services and premium architectures. Intrinsically incubate intuitive opportunities and real-time potentialities. Appropriately communicate one-to-one technology after plug-and-play networks.
                                </div>

                            </div>
                            <!-- Accordion Body / End -->
                        </div>
                        <!-- Accordion Item / End -->

                        <!-- Accordion Item -->
                        <div class="accordion__item js-accordion-item">
                            <div class="accordion-header js-accordion-header">Which package should I Select?</div>

                            <!-- Accordtion Body -->
                            <div class="accordion-body js-accordion-body">

                                <!-- Accordion Content -->
                                <div class="accordion-body__contents">
                                    Efficiently enable enabled sources and cost effective products. Completely synthesize principle-centered information after ethical communities. Efficiently innovate open-source infrastructures via inexpensive materials.
                                </div>

                            </div>
                            <!-- Accordion Body / End -->
                        </div>
                        <!-- Accordion Item / End -->

                    </div>
                    <!-- Accordion / End -->
                </div>
                <div class="boxed-list margin-bottom-60" id="reviews">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-thumb-up"></i> Rating</h3>
                    </div>
                    <!-- **** Start reviews **** -->
                    <div class="listings-container compact-list-layout starReviews">
                        <!-- Show current reviews -->
                        <ul class="show-reviews boxed-list-ul rating-list"><div class="loader" style="margin: 0 auto;"></div></ul>
                        <!-- This is where your product ID goes -->
                        <div id="review-productId" class="review-productId" data-review-type="gig" style="display: none"><?php _esc($item_id);?></div>

                        <script type="text/javascript">
                            var LANG_ADDREVIEWS     = "{LANG_ADDREVIEWS}";
                            var LANG_SUBMITREVIEWS  = "{LANG_SUBMITREVIEWS}";
                            var LANG_HOW_WOULD_RATE = "{LANG_HOW_WOULD_RATE}";
                            var LANG_REVIEWS        = "<?php _e("Reviews") ?>";
                            var LANG_YOURREVIEWS    = "{LANG_YOURREVIEWS}";
                            var LANG_ENTER_REVIEW   = "{LANG_ENTER_REVIEW}";
                            var LANG_STAR           = "{LANG_STAR}";
                        </script>
                        <!-- jQuery Form Validator -->
                        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.34/jquery.form-validator.min.js"></script>
                        <!-- jQuery Barrating plugin -->
                        <script src="<?php _esc($config['site_url']);?>plugins/starreviews/assets/js/jquery.barrating.js"></script>
                        <!-- jQuery starReviews -->
                        <script src="<?php _esc($config['site_url']);?>plugins/starreviews/assets/js/starReviews.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                /* Activate our reviews */
                                $().reviews('.starReviews');
                            });
                        </script>
                    </div>
                    <!-- **** End reviews **** -->

                    <!-- Pagination -->
                    <div class="clearfix"></div>
                    <div class="pagination-container margin-top-40 margin-bottom-10 d-none">
                        <nav class="pagination">
                            <ul>
                                <li><a href="#" class="ripple-effect current-page">1</a></li>
                                <li><a href="#" class="ripple-effect">2</a></li>
                                <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Pagination / End -->
                </div>
                <?php if($show_tag){?>
                <div class="single-page-section">
                    <h3><?php _e('Tags');?></h3>
                    <div class="task-tags">
                        <?php foreach ($item_tag as $tag){
                            $tagTrim = preg_replace("/[\s_]/", "-", trim($tag));
                            echo '<span><a href="' . url('SEARCH_SERVICES',false) . '?keywords=' . $tagTrim . '">'._esc($tagTrim,false).'</a></span>';
                        }?>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="col-lg-4 right">
                <div class="sticky">
                    <div class="tabs">
                        <div class="tabs-header">
                            <ul class="fit-width">
                                <li class="active"><a href="#basic" data-tab-id="basic"><?php _e('Basic');?></a></li>
                                <li class=""><a href="#standard" data-tab-id="standard"><?php _e('Standard');?></a></li>
                                <li class=""><a href="#premium" data-tab-id="premium"><?php _e('Premium');?></a></li>
                            </ul>
                            <div class="tab-hover" style="left: 0px; width: 89.9453px;"></div>
                        </div>
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab active" data-tab-id="basic">
                                <div class="header">
                                    <h3>
                                        <b class="title"><?php _esc($basic_plan['name'])?></b>
                                        <span class="price"><?php _esc(price_format($basic_plan['price']))?></span>
                                    </h3>
                                    <p><?php _esc($basic_plan['description'])?></p>
                                </div>
                                <article>
                                    <div class="d-flex">
                                        <b class="delivery"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php _esc($basic_plan['delivery_time'])?> <?php _e('Days Delivery');?></b>
                                        <b class="delivery margin-left-10"><i class="fa fa-refresh" aria-hidden="true"></i> <?php _esc($basic_plan['revisions'])?> <?php _e('Revisions');?></b>
                                    </div>

                                </article>
                                <div class="tab-footer">
                                    <form method="post">
                                        <input type="hidden" name="order_service" value="basic">
                                        <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" name="submit" type="submit"><i class="icon-feather-arrow-right"></i> <?php _e('Continue');?> (<?php _esc(price_format($basic_plan['price']))?>)</button>
                                        <a href="#packagesTable" class="btn-compare-packages tbody-6"><?php _e('Compare Packages');?></a>
                                    </form>
                                </div>
                            </div>
                            <div class="tab" data-tab-id="standard" style="display: none">
                                <div class="header">
                                    <h3>
                                        <b class="title"><?php _esc($standard_plan['name'])?></b>
                                        <span class="price"><?php _esc(price_format($standard_plan['price']))?></span>
                                    </h3>
                                    <p><?php _esc($standard_plan['description'])?></p>
                                </div>
                                <article>
                                    <div class="d-flex">
                                    <b class="delivery"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php _esc($standard_plan['delivery_time'])?> <?php _e('Days Delivery');?></b>
                                    <b class="delivery margin-left-10"><i class="fa fa-refresh" aria-hidden="true"></i> <?php _esc($standard_plan['revisions'])?> <?php _e('Revisions');?></b>
                                    </div>
                                </article>
                                <div class="tab-footer">
                                    <form method="post">
                                        <input type="hidden" name="order_service" value="standard">
                                        <button class="button margin-top-35 full-width" name="submit" type="submit"><i class="icon-feather-arrow-right"></i> <?php _e('Continue');?> (<?php _esc(price_format($standard_plan['price']))?>)</button>
                                        <a href="#packagesTable" class="btn-compare-packages tbody-6"><?php _e('Compare Packages');?></a>
                                    </form>
                                </div>
                            </div>
                            <div class="tab" data-tab-id="premium" style="display: none">
                                <div class="header">
                                    <h3>
                                        <b class="title"><?php _esc($premium_plan['name'])?></b>
                                        <span class="price"><?php _esc(price_format($premium_plan['price']))?></span>
                                    </h3>
                                    <p><?php _esc($premium_plan['description'])?></p>
                                </div>
                                <article>
                                    <div class="d-flex">
                                    <b class="delivery"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php _esc($premium_plan['delivery_time'])?> <?php _e('Days Delivery');?></b>
                                    <b class="delivery margin-left-10"><i class="fa fa-refresh" aria-hidden="true"></i> <?php _esc($premium_plan['revisions'])?> <?php _e('Revisions');?></b>
                                    </div>
                                </article>
                                <div class="tab-footer">
                                    <form method="post">
                                        <input type="hidden" name="order_service" value="premium">
                                        <button class="button margin-top-35 full-width" name="submit" type="submit"><i class="icon-feather-arrow-right"></i> <?php _e('Continue');?> (<?php _esc(price_format($premium_plan['price']))?>)</button>
                                        <a href="#packagesTable" class="btn-compare-packages tbody-6"><?php _e('Compare Packages');?></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if($is_login){
                        if($config['quickchat_socket_on_off'] == 'on' || $config['quickchat_ajax_on_off'] == 'on'){
                            echo '<div class="contact-seller-wrapper hide-under-768px"><a href="javascript:void(0);" 
                                            class="fit-button start_zechat"
                                        data-chatid="'._esc($item_uid,false).'_'._esc($item_id,false).'_gig"
                                        data-postid="'._esc($item_id,false).'"
                                        data-posttype="gig"
                                        data-userid="'._esc($item_uid,false).'"
                                        data-username="'._esc($item_username,false).'"
                                        data-fullname="'._esc($item_ufullname,false).'"
                                        data-userimage="'._esc($item_uimage,false).'"
                                        data-userstatus="'._esc("offline",false).'"
                                        data-posttitle="'._esc($item_title,false).'"
                                        data-posttype="gig"
                                        data-postlink="'._esc($item_link,false).'">
                                        <i class="icon-feather-message-circle"></i> '.__("Contact Seller").'</a></div>';

                            echo '<div class="contact-seller-wrapper show-under-768px"><a href="'._esc($quickchat_url,false).'" 
                                            class="fit-button"><i class="icon-feather-message-circle"></i>
                                             '.__("Contact Seller").'</a></div>';
                        }
                    }
                    ?>
                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget margin-top-30">

                        <?php if($usertype == 'employer'){ ?>
                            <h3><?php _e("Bookmark or Share") ?></h3>
                            <!-- Bookmark Button -->
                            <button class="bookmark-button fav-button margin-bottom-25 set-item-fav <?php if($item_favorite == '1') { echo 'added'; }?>" data-item-id="<?php _esc($item_id)?>" data-userid="<?php _esc($user_id)?>" data-post-type="gig" data-action="setFavAd">
                                <span class="bookmark-icon"></span>
                                <span class="fav-text"><?php _e("Bookmark") ?></span>
                                <span class="added-text"><?php _e("Saved") ?></span>
                            </button>
                        <?php }else{ ?>
                            <h3><?php _e("Share") ?></h3>
                        <?php } ?>
                        <!-- Copy URL -->
                        <div class="copy-url">
                            <input id="copy-url" type="text" value="" class="with-border">
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="<?php _e("Copy to Clipboard") ?>" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span><?php _e("Interesting?") ?> <strong><?php _e("Share It!") ?></strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="mailto:?subject=<?php _esc($item_title)?>&body=<?php _esc($item_link)?>" data-button-color="#dd4b39" title="<?php _e("Share on Email") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-envelope"></i></a></li>
                                    <li><a href="https://facebook.com/sharer/sharer.php?u=<?php _esc($item_link)?>" data-button-color="#3b5998" title="<?php _e("Share on Facebook") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/share?url=<?php _esc($item_link)?>&text=<?php _esc($item_title)?>" data-button-color="#1da1f2" title="<?php _e("Share on Twitter") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php _esc($item_link)?>" data-button-color="#0077b5" title="<?php _e("Share on LinkedIn") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="https://pinterest.com/pin/create/bookmarklet/?&url=<?php _esc($item_link)?>&description=<?php _esc($item_title)?>" data-button-color="#bd081c" title="<?php _e("Share on Pinterest") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
                                    <li><a href="https://web.whatsapp.com/send?text=<?php _esc($item_link)?>" data-button-color="#25d366" title="<?php _e("Share on WhatsApp") ?>" data-tippy-placement="top" rel="nofollow" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container margin-bottom-50" id="recommendations">
        <div class="single-page-section recommended">
            <h3><?php _e("People Who Viewed This Service Also Viewed") ?></h3>
            <div class="gig-slick-carousel recommended-slider">
                <?php foreach ($items as $item){ ?>
                    <div>
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
                                <h3><?php _esc($item['title'])?></h3>
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
</div>

    <script src="<?php _esc(TEMPLATE_URL);?>/service_fragments/vendor/lightgallery-master/lightgallery-all.min.js"></script>
    <script src="<?php _esc(TEMPLATE_URL);?>/service_fragments/js/custom.js"></script>

<?php overall_footer(); ?>