<fieldset id="overview" class="step">
    <form id="gig-overview-form" action="" method="post"
          enctype="multipart/form-data" accept-charset="UTF-8">
        <div class="dashboard-box margin-top-0">
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
        <div class="gotonext margin-top-30 margin-bottom-30">
            <div class="clearfix">
                <div class="float-right">
                    <button type="submit" id="submit_gig_button" class="oval button next-btn" data-next="#pricing">Next</button>
                </div>
            </div>
        </div>
    </form>
</fieldset>
