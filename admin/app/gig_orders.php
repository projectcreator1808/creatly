<?php
require_once('../includes.php');
$url = 'gig_orders.php';
$status = isset($_GET['status'])? $_GET['status']: '';
if($status){
    $url = 'gig_orders.php?status='.$status;
    $title = ucfirst($status);
}
?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="../assets/js/plugins/datatables/jquery.dataTables.min.css" />
<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4>Gig Orders</h4>
                <div class="pull-right">
                    <a href="<?php _esc(ADMINURL);?>global/setting.php#project_setting" class="btn btn-success waves-effect waves-light m-r-10">Gig setting</a>
                </div>
            </div>
            <div class="card-block">
                <div id="js-table-list">
                    <table class="js-table-checkable table table-vcenter table-hover" id="ajax_datatable" data-jsonfile="<?php echo $url; ?>">
                        <thead>
                        <tr>
                            <th>Details & Code</th>
                            <th class="hidden-xs hidden-sm">Seller Name</th>
                            <th class="hidden-xs hidden-sm sortingNone" style="width:100px">Amount</th>
                            <th class="hidden-xs hidden-sm sortingNone" style="width:100px">Plan Name</th>
                            <th class="hidden-xs hidden-sm sortingNone" style="width:100px">Created</th>
                            <th class="hidden-xs hidden-sm" style="width:100px">Delivery Date</th>
                            <th class="hidden-xs hidden-sm" style="width:100px">Status</th>
                        </tr>
                        </thead>
                        <tbody id="ajax-services">

                        </tbody>
                    </table>
                </div>


            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
        <!-- End Partial Table -->

    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>

<!-- Site Action -->
<div class="site-action">
    <button type="button" class="site-action-toggle btn-raised btn btn-warning btn-floating" style="visibility: hidden;">
        <i class="back-icon ion-android-close animation-scale-up" aria-hidden="true"></i>
    </button>
    <div class="site-action-buttons">
        <button type="button" data-ajax-response="deletemarked" data-ajax-action="deleteProject"
                class="btn-raised btn btn-danger btn-floating animation-slide-bottom">
            <i class="icon ion-android-delete" aria-hidden="true"></i>
        </button>
    </div>
</div>
<!-- End Site Action -->

<?php include("../footer.php"); ?>

<script>
    $(function()
    {
        // Init page helpers (Table Tools helper)
        App.initHelpers('table-tools');

        // Init page helpers (BS Notify Plugin)
        App.initHelpers('notify');
    });
</script>
</body>

</html>

