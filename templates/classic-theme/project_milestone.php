<?php
overall_header(__("Milestones"));
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
                <h3><?php _e("Milestones") ?></h3>
                <span class="margin-top-7"><?php _e("for") ?> <a href="<?php url("PROJECT") ?>/<?php _esc($project_id)?>"><?php _esc($project_name)?></a></span>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                        <li><?php _e("Milestones") ?></li>
                    </ul>
                </nav>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box">
                        <!-- Content Start -->
                        <div class="headline">
                            <h3><i class="icon-material-baseline-notifications-none"></i> <?php _e("Milestones") ?>
                                <?php
                                if($project_status == "open")
                                    echo '<div class="dashboard-status-button green">'.__("Open").'</div>';
                                if($project_status == "pending_for_approval")
                                    echo '<div class="dashboard-status-button yellow">'.__("Pending For Approval").'</div>';
                                if($project_status == "under_development") {
                                    if ($usertype == "employer" && count($milestones) && (array_values($milestones))[0]['request_id'] != 0) {
                                        echo '<div class="dashboard-status-button blue" data-tippy title="You have 3 days accept or deny " data-tippy-placement = "top">'.__("Under Development").'</div>';
                                    }
                                    else {
                                        echo '<div class="dashboard-status-button blue">'.__("Under Development").'</div>';
                                    }
                                }
                                if($project_status == "dispute")
                                    echo '<div class="dashboard-status-button yellow">'.__("Dispute").'</div>';
                                if($project_status == "deliver")
                                    echo '<div class="dashboard-status-button blue">'.__("Delivered").'</div>';
                                if($project_status == "reject_request")
                                    echo '<div class="dashboard-status-button red" data-tippy title="You have 3 days to accept or deny request otherwise order will be completed" data-tippy-placement = "top">'.__("Reject request").'</div>';
                                if($project_status == "rejected")
                                    echo '<div class="dashboard-status-button red">'.__("Rejected").'</div>';
                                if($project_status == "split_request")
                                    echo '<div class="dashboard-status-button blue" data-tippy title="You have 3 days to accept or deny split request otherwise order will be completed with a split" data-tippy-placement = "top">'.__("Split request").'</div>';
                                if($project_status == "completed") {
                                    $_status = __("Completed");
                                    if ($split_percent) {
                                        $_status .= ' ' .  __("split") . ' ' . $split_percent . '%';
                                    }
                                    echo '<div class="dashboard-status-button green">'.$_status.'</div>';
                                }
                                if($project_status == "final_review_pending")
                                    echo '<div class="dashboard-status-button yellow">'.__("Final Review Pending").'</div>';
                                if($project_status == "closed")
                                    echo '<div class="dashboard-status-button red">'.__("Closed").'</div>';
                                if($project_status == "incomplete")
                                    echo '<div class="dashboard-status-button red">'.__("Incomplete").'</div>';
                                ?>
                            </h3>

                            <?php if($usertype == "employer" && count($milestones) == 0){ ?>
                            <a href="#small-dialog-1" class="popup-with-zoom-anim button ripple-effect"><i class="icon-feather-plus"></i> <?php _e("Create Milestone") ?></a>
                            <?php } ?>
                        </div>
                        <div class="content">
                            <div class="content with-padding">
                                <div class="margin-bottom-20">
                                    <div class="fun-facts-container">
                                        <div class="fun-fact" data-fun-fact-color="#36bd78">
                                            <div class="fun-fact-text">
                                                <span><?php _e("Balance") ?> <?php _esc($config['currency_sign'])?></span>
                                                <h4><?php _esc($balance)?></h4>
                                            </div>
                                            <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
                                        </div>
                                        <div class="fun-fact" data-fun-fact-color="#b81b7f">
                                            <div class="fun-fact-text">
                                                <span><?php _e("Price") ?> <?php _esc($config['currency_sign'])?></span>
                                                <h4><?php _esc($amount)?></h4>
                                            </div>
                                            <div class="fun-fact-icon"><i class="icon-material-outline-business-center"></i></div>
                                        </div>
                                        <div class="fun-fact" data-fun-fact-color="#efa80f">
                                            <div class="fun-fact-text">
                                                <span><?php _e("Paid") ?> <?php _esc($config['currency_sign'])?></span>
                                                <h4><?php _esc($epaid)?></h4>
                                            </div>
                                            <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                                        </div>


                                    </div>

                                    <table class="basic-table dashboard-box-list d-none">
                                        <tr>
                                            <td><?php _e("Total Milestone Amount") ?> : </td><td><?php _esc($config['currency_sign'])?><?php _esc($total_ea)?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e("Pending Milestone") ?> : </td><td><?php _esc($config['currency_sign'])?><?php _esc($epanding)?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e("Remaining Amount") ?> : </td><td><?php _esc($config['currency_sign'])?><?php _esc($remainning_amount)?></td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="basic-table dashboard-box-list" id="js-table-list">

                                    <tbody>
                                    <tr>
                                        <th><?php _e("Description") ?></th>
                                        <th><?php _e("Amount") ?></th>
                                        <th><?php _e("Status") ?></th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    <?php foreach ($milestones as $milestone){ ?>
                                        <tr class="ajax-item-listing" data-item-id="<?php _esc($milestone['id'])?>">
                                            <td data-label="<?php _e("Description") ?>"><?php _esc($milestone['title'])?>
                                                <br><small><?php _esc($milestone['start_date'])?></small>
                                            </td>
                                            <td data-label="<?php _e("Amount") ?>"><?php _esc($config['currency_sign'])?><?php _esc($milestone['amount'])?></td>
                                            <td data-label="<?php _e("Status") ?>">
                                                <?php
                                                if($milestone['request_id'] == 0)
                                                {
                                                    echo '<span class="dashboard-status-button green">'.__("Funded in milestone").'</span>';
                                                }
                                                elseif($milestone['request_id'] == 1)
                                                {
                                                    if ($milestone['status'] == 'dispute') {
                                                        echo '<span class="dashboard-status-button yellow">'.__("Dispute").'</span>';
                                                    }
                                                    else if ($milestone['status'] == 'deliver') {
                                                        echo '<span class="dashboard-status-button blue" data-tippy title="You have 3 days to Release or Dispute" data-tippy-placement = "top">'.__("Delivered").'</span>';
                                                    }
                                                    else if ($milestone['status'] == 'reject_employer' || $milestone['status'] == 'reject_freelancer') {
                                                        echo '<span class="dashboard-status-button red" data-tippy title="You have 3 days to accept or deny request otherwise order will be completed" data-tippy-placement = "top">'.__("Reject request").'</span>';
                                                    }
                                                    else if ($milestone['status'] == 'split_employer' || $milestone['status'] == 'split_freelancer') {
                                                        echo '<span class="dashboard-status-button blue" data-tippy title="You have 3 days to accept or deny split request otherwise order will be completed with a split" data-tippy-placement = "top">'.__("Split request").' '.$milestone['split_percent'].'%</span>';
                                                    }
                                                    else if ($milestone['status'] == 'request') {
                                                        if ($usertype == "employer") {
                                                            echo '<div class="dashboard-status-button blue" data-tippy title="You have 3 days accept or deny " data-tippy-placement = "top">'.__("Under Development").'</div>';
                                                        }
                                                        else {
                                                            echo '<span class="dashboard-status-button blue">'.__("Under Development").'</span>';
                                                        }
                                                    }
                                                    else {
                                                        echo '<span class="dashboard-status-button yellow">'.__("Request for release").'</span>';
                                                    }
                                                }
                                                elseif($milestone['request_id'] == 2)
                                                {
                                                    if ($milestone['status'] != 'rejected') {
                                                        $_status = __("Released");
                                                        if ($milestone['status'] == 'paid_splited' && $milestone['split_percent']) {
                                                            $_status .= ' ' .  __("split") . ' ' . $milestone['split_percent'] . '%';
                                                        }
                                                        echo '<span class="dashboard-status-button blue">'.$_status.'</span>';
                                                    }
                                                    else {
                                                        echo '<span class="dashboard-status-button red">'.__("Rejected").'</span>';
                                                    }
                                                }
                                                elseif($milestone['request_id'] == 3)
                                                {
                                                    echo '<span class="dashboard-status-button red">'.__("Request for release").'</span>';
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php
                                                if($milestone['request_id'] == "2"){
                                                    if ($milestone['status'] != 'rejected') {
                                                        echo '<a href="#" class="button ripple-effect"><i class="icon-feather-file-text"></i> '.__("Paid").'</a>';
                                                    }
                                                }else{
                                                    if($usertype == "employer"){
                                                        if (!in_array($milestone['status'], ['reject_employer', 'reject_freelancer','split_employer', 'split_freelancer'])) {
                                                            if ($milestone['status'] != 'dispute' && $milestone['request_id'] == "1") {
                                                                echo '<a href="#" data-ajax-action="release_milestone" data-alert-message="'.__("Are you sure you want to accept.").'" class="button green ripple-effect item-ajax-button"><i class="icon-feather-check"></i> '.__("Release").'</a>';
                                                                echo '<a href="#" data-ajax-action="dispute_milestone" data-alert-message="'.__("Are you sure you want open dispute.").'" class="button yellow ripple-effect item-ajax-button">'.__("Dispute").'</a>';
                                                                echo '<a href="#small-dialog-2" class="popup-with-zoom-anim button blue ripple-effect split_milestone_button">'.__("Split").'</a>';
                                                            }

                                                            echo '<a href="#" data-ajax-action="reject_milestone" data-alert-message="'.__("Are you sure you want reject milestone.").'" class="button red ripple-effect item-ajax-button">'.__("Reject").'</a>';
                                                        }
                                                        else if ($milestone['status'] == 'reject_freelancer') {
                                                            echo '<a href="#" data-ajax-action="accept_reject_milestone" data-alert-message="'.__("Are you sure you want confirm reject.").'" class="button green ripple-effect item-ajax-button">'.__("Accept").'</a>';
                                                            echo '<a href="#" data-ajax-action="deny_reject_milestone" data-alert-message="'.__("Are you sure you want deny reject.").'" class="button red ripple-effect item-ajax-button">'.__("Deny").'</a>';
                                                        }
                                                        else if ($milestone['status'] == 'split_freelancer') {
                                                            echo '<a href="#" data-ajax-action="accept_split_milestone" data-alert-message="'.__("Are you sure you want confirm split.").'" class="button green ripple-effect item-ajax-button">'.__("Accept").'</a>';
                                                            echo '<a href="#" data-ajax-action="deny_split_milestone" data-alert-message="'.__("Are you sure you want deny split.").'" class="button red ripple-effect item-ajax-button">'.__("Deny").'</a>';
                                                        }
                                                    }else{
                                                        if($milestone['request_id'] != "1"){
                                                            echo '<a href="#" data-ajax-action="request_release_milestone" data-alert-message="'.__("Are you sure you want to accept.").'" class="button dark ripple-effect item-ajax-button"><i class="icon-feather-check"></i> '.__("Request for release").'</a>';
                                                            echo '<a href="#small-dialog-3" class="popup-with-zoom-anim button blue ripple-effect request_split_milestone_button">'.__("Split").'</a>';
                                                        }
                                                        else if (!in_array($milestone['status'], ['reject_employer', 'reject_freelancer','split_employer', 'split_freelancer', 'dispute'])) {
                                                            echo '<a href="#" data-ajax-action="request_dispute_milestone" data-alert-message="'.__("Are you sure you want open dispute.").'" class="button yellow ripple-effect item-ajax-button">'.__("Dispute").'</a>';
                                                            echo '<a href="#small-dialog-3" class="popup-with-zoom-anim button blue ripple-effect request_split_milestone_button">'.__("Split").'</a>';
                                                        }
                                                        else if ($milestone['status'] == 'reject_employer') {
                                                            echo '<a href="#" data-ajax-action="request_accept_reject_milestone" data-alert-message="'.__("Are you sure you want confirm reject.").'" class="button green ripple-effect item-ajax-button">'.__("Accept").'</a>';
                                                            echo '<a href="#" data-ajax-action="request_deny_reject_milestone" data-alert-message="'.__("Are you sure you want deny reject.").'" class="button red ripple-effect item-ajax-button">'.__("Deny").'</a>';
                                                        }
                                                        else if ($milestone['status'] == 'split_employer') {
                                                            echo '<a href="#" data-ajax-action="request_accept_split_milestone" data-alert-message="'.__("Are you sure you want confirm split.").'" class="button green ripple-effect item-ajax-button">'.__("Accept").'</a>';
                                                            echo '<a href="#" data-ajax-action="request_deny_split_milestone" data-alert-message="'.__("Are you sure you want deny split.").'" class="button red ripple-effect item-ajax-button">'.__("Deny").'</a>';
                                                        }
                                                        else if ($milestone['status'] == 'dispute') {
                                                            echo '<a href="#" data-ajax-action="request_deliver_milestone" data-alert-message="'.__("Are you sure you want to accept.").'" class="button purple ripple-effect item-ajax-button"><i class="icon-feather-check"></i> '.__("Deliver").'</a>';
                                                        }
                                                        // else if ($milestone['status'] != 'dispute') {
                                                        //     echo '<a href="#" data-ajax-action="request_dispute_milestone" data-alert-message="'.__("Are you sure you want open dispute.").'" class="button yellow ripple-effect item-ajax-button">'.__("Dispute").'</a>';
                                                        //     echo '<a href="#small-dialog-3" class="popup-with-zoom-anim button blue ripple-effect request_split_milestone_button">'.__("Split").'</a>';
                                                        // }

                                                        
                                                        // echo '<a href="#" data-ajax-action="cancel_milestone" data-alert-message="'.__("Are you sure you want to accept.").'" class="button gray ripple-effect ico item-ajax-button" data-tippy-placement="top" title="'.__("Cancel").'"><i class="pe-7s-close"></i></a>';

                                                        if (!in_array($milestone['status'], ['reject_employer', 'reject_freelancer','split_employer', 'split_freelancer'])) {
                                                            echo '<a href="#" data-ajax-action="request_reject_milestone" data-alert-message="'.__("Are you sure you want reject milestone.").'" class="button red ripple-effect item-ajax-button">'.__("Reject").'</a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } 
                                    if(!$totalitem){
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center"><?php _e("No result found.") ?></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Content End -->
                    </div>
                </div>
            </div>
            <!-- Row / End -->

<!-- Milestone Create Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab1"><?php _e("Create Milestone") ?></a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <form id="create-milestone-form" method="post" action="#">
                    <div class="welcome-text">
                        <h3><?php _e("Milestones") ?> <?php _e("for") ?> <?php _esc($project_name)?></h3>
                    </div>
                    <div id="create-milestone-status" class="notification error" style="display:none"></div>

                    <input name="title" value="" type="text" placeholder="Milestone Description"/>

                    <input name="amount" value="" type="text" placeholder="<?php _e("Amount in") ?> <?php _esc($config['currency_code'])?>"/>
                    <?php
                    if($usertype == "employer"){
                        echo '<p class="help-message">'.__("Site comission fee").' '._esc($employer_commission,false).'%</p>';
                    }else{
                        echo '<p class="help-message">'.__("Site comission fee").' '._esc($freelancer_commission,false).'%</p>';
                    }
                    ?>
                    <input type="hidden" value="<?php _esc($project_id)?>" name="id"/>
                    <div class="radio">
                        <input id="radio-1" name="radio" type="radio" required>
                        <label for="radio-1"><span class="radio-label"></span> <?php _e("I have read and agree to the Terms and Conditions") ?></label>
                    </div>
                    <!-- Button -->
                    <button id="create-milestone-button" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit"> <?php _e("Accept") ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Milestone Create Popup / End -->

<div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab2"><?php _e("Split Milestone") ?></a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <form id="split-milestone-form" method="post" action="#">
                    <div class="welcome-text">
                        <h3><?php _e("Split milestone") ?></h3>
                    </div>
                    <div id="split-milestone-status" class="notification error" style="display:none"></div>

                    <input name="split_percent" value="" type="number" placeholder="<?php _e("Split percent") ?>" min = "10" max = "99"/>
                    <input type="hidden" value="0" name="id"/>
                    <div class="radio">
                        <input id="radio-1" name="radio" type="radio" required>
                        <label for="radio-1"><span class="radio-label"></span> <?php _e("I have read and agree to the Terms and Conditions") ?></label>
                    </div>
                    <!-- Button -->
                    <button id="split-milestone-button" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit"> <?php _e("Accept") ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="small-dialog-3" class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab3"><?php _e("Split Milestone") ?></a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <form id="request-split-milestone-form" method="post" action="#">
                    <div class="welcome-text">
                        <h3><?php _e("Split milestone") ?></h3>
                    </div>
                    <div id="request-split-milestone-status" class="notification error" style="display:none"></div>

                    <input name="split_percent" value="" type="number" placeholder="<?php _e("Split percent") ?>" min = "10" max = "99"/>
                    <input type="hidden" value="0" name="id"/>
                    <div class="radio">
                        <input id="radio-1" name="radio" type="radio" required>
                        <label for="radio-1"><span class="radio-label"></span> <?php _e("I have read and agree to the Terms and Conditions") ?></label>
                    </div>
                    <!-- Button -->
                    <button id="request-split-milestone-button" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit"> <?php _e("Accept") ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include_once TEMPLATE_PATH.'/overall_footer_dashboard.php'; ?>