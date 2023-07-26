<fieldset id="description" class="step">
    <div class="dashboard-box margin-top-0">
        <!-- Headline -->
        <div class="headline">
            <h3><i class="icon-feather-briefcase"></i><?php _e("Description & FAQ") ?></h3>
        </div>
        <div class="content with-padding padding-bottom-10">
            <div class="row">
                <div class="col-xl-12">
                    <div class="gig-upcrate-app margin-bottom-30">
                        <div class="description-wrapper">
                            <div class="education-tooltip box-shadow-z4">
                                <header><div class="icn-lightbulb-wrapper"><i class="fa fa-lightbulb-o"></i></div><h6 class="tbody-5">Write Your Description &amp; FAQ</h6></header>
                                <ul><li>Include the most important information for your Gig.</li><li>Add frequently asked questions and answers to the most commonly asked questions.</li></ul>
                            </div>
                            <div class="submit-field">
                                <h5><?php _e("Gig summary") ?> *</h5>
                                <h5><?php _e("Briefly explain what sets you and your gig apart.") ?> *</h5>
                                <textarea cols="30" rows="5" class="with-border text-editor" name="content"></textarea>
                            </div>
                        </div>

                        <div class="faq-wrapper">
                            <div class="education-tooltip box-shadow-z4">
                                <header><div class="icn-lightbulb-wrapper"><i class="fa fa-lightbulb-o"></i></div><h6 class="tbody-5">What are FAQs?</h6></header>
                                <p>Here you can add answers to the most commonly asked questions. Your FAQs will be displayed in your Gig page.</p>
                                <div class="faq-examples">
                                    <span class="example-title">for example:</span>
                                    <p><b>Question:</b> Can you provide a British accent?</p>
                                    <p><b>Answer:</b> Of course, I lived in England for 3 years! That won't be a problem.</p>
                                </div>
                            </div>

                            <header class="faq-header">
                                <h3>Frequently Asked Questions</h3>
                                <button type="button" id="add-faq-btn" class="naked-button add-faq co-green">
                                    <b>+ Add FAQ</b>
                                </button>
                            </header>

                            <p class="sub-title">Add Questions &amp; Answers for Your Buyers.</p>
                            <div id="add-faq-form">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <input name="title" class="form-control" type="text" placeholder="Add a Question">

                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <textarea name="answer" placeholder="Add an Answer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <input name="id" value="66" type="hidden">

                                        <button type="button" class="button ripple-effect">Save</button>
                                        <button class="button gray ripple-effect-dark" id="faq-cancel-btn" type="reset">Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div id="quickad-tbs">

                                <!-- Accordion -->
                                <div class="accordion js-accordion">

                                    <!-- Accordion Item -->
                                    <div class="accordion__item js-accordion-item">
                                        <div class="accordion-header js-accordion-header">What do I need to get started?</div>

                                        <!-- Accordtion Body -->
                                        <div class="accordion-body js-accordion-body">

                                            <!-- Accordion Content -->
                                            <div class="accordion-body__contents">
                                                <form method="post" id="66">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="title_66">Question</label>
                                                                <input name="title" value="What do I need to get started?" id="title_66" class="form-control" type="text">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="answer">Answer</label>
                                                                <textarea name="answer" id="answer">It was never as easy as placing the order on my gig. You will be asked few basis questions like your logo company name, slogan, color etc after you place the order.</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer text-right">
                                                        <input name="id" value="66" type="hidden">

                                                        <button type="button" class="button ripple-effect">Save</button>
                                                        <button class="button gray ripple-effect-dark js-reset" type="reset">Reset
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <!-- Accordion Body / End -->
                                    </div>
                                    <!-- Accordion Item / End -->


                                    <!-- Accordion Item -->
                                    <div class="accordion__item js-accordion-item">
                                        <div class="accordion-header js-accordion-header">Panel 2</div>

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

                                <div class="quick-detail-list-items hidden">
                                    <div class="d-flex">
                                        <div class="quick-details">
                                            <h6 class="quick-title">What do I need to get started?</h6>
                                            <p class="quick-description">It was never as easy as placing the order on my gig. You will be asked few basis questions like your logo company name, slogan, color etc after you place the order.</p>
                                        </div>
                                        <div id="questions-0" class="quick-action-buttons">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gotonext margin-top-30 margin-bottom-30">
        <div class="clearfix">
            <div class="float-right">
                <a href="javascript:void(0)" class="oval back-btn" data-back="#pricing">Back</a>
                <a href="javascript:void(0)" class="oval fluid button next-btn" data-next="#requirements">Next</a>
            </div>
        </div>
    </div>
</fieldset>