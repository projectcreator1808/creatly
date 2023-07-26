<?php
require_once '../includes.php';
require_once ROOTPATH . '/includes/lib/GoogleTranslate.php';
$filePath = '';
if(isset($_GET['file'])){
    $info = ORM::for_table($config['db']['pre'].'languages')
        ->select('code')
        ->where('file_name', $_GET['file'])
        ->find_one();
    $lang_code = $info['code'];

    $filePath = ROOTPATH.'/includes/lang/lang_'.$_GET['file'].'.php';
}else{
    $filePath = ROOTPATH.'/includes/lang/lang_english.php';
}
$new_lang = array();
if(file_exists($filePath)){
    $lang = array();
    include($filePath);
    $new_lang = $lang;
}
else{
    echo '<script>window.location="404.php"</script>';
    exit;
}

function change_config_file_settings($filePath, $newSettings,$lang)
{
    // Update $fileSettings with any new values
    $fileSettings = array_merge($lang, $newSettings);
    ksort($fileSettings);
    // Build the new file as a string
    $newFileStr = "<?php\n";
    foreach ($fileSettings as $name => $val) {
        // Using var_export() allows you to set complex values such as arrays and also
        // ensures types will be correct
        $newFileStr .= '$lang["'.$name.'"] = "' . $val .'"'. ";\n";
    }
    // Closing tag intentionally omitted, you can add one if you want

    // Write it back to the file
    file_put_contents($filePath, $newFileStr);

}


if(isset($_POST['refresh'])) {
    if (!check_allow()) {
        ?>
        <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#sa-title').trigger('click');
            });
        </script>
        <?php

    } else {

        $english_lang = array();
        $lang = array();
        if(file_exists(ROOTPATH.'/includes/lang/lang_english.php'))
            include(ROOTPATH.'/includes/lang/lang_english.php');
        $english_lang = $lang;
        $array_diff=array_diff_key($english_lang,$new_lang);


        $source = 'en';
        $target = $lang_code;

        $trans = new GoogleTranslate();
        $newLangArray = array();
        foreach ($array_diff as $key => $value)
        {
            $result = $trans->translate($source, $target, $value);
            $newLangArray[$key] = $result;
        }

        fopen($filePath, "w");
        change_config_file_settings($filePath, $newLangArray,$new_lang);

        transfer($_SERVER['REQUEST_URI'],'Refresh Successfully');
        exit;
    }
}



/*Array
(
    [Banner advertise] => إعلان بانر
[Confirmation ID does not exist or has already been used] => معرف التأكيد غير موجود أو تم استخدامه بالفعل
[Direct Message] => رسالة مباشرة
[Direct message] => رسالة مباشرة
[Edit Company] => تحرير الشركة
[Insufficient fund withdrawal amount must be lower than your wallet.] => يجب أن يكون مبلغ السحب غير الكافي أقل من محفظتك.
[Login to view] => تسجيل الدخول للعرض
[Mollie accepts payments in Euro only.] => تقبل Mollie المدفوعات باليورو فقط.
[New] => جديد
[Please get in touch and our expert support team will answer all your questions.] => يرجى التواصل معنا وسيقوم فريق دعم الخبراء لدينا بالإجابة على جميع أسئلتك.
[Thank you] => شكرًا لك
[Thank you for reporting this violation.] => شكرا لك على الإبلاغ عن هذا الانتهاك.
[We are sorry, the page you requested cannot be found. You can go back to] => نحن آسفون ، الصفحة التي طلبتها لا يمكن العثور عليها. يمكنك العودة إلى
[You need to login first to view this page.] => تحتاج إلى تسجيل الدخول أولا لعرض هذه الصفحة.
[You will be charge from your wallet amount.] => سوف يتم تحصيل رسوم من مبلغ محفظتك.
[Your review could not be saved! Please Login for write review.] => لا يمكن حفظ رأيك! الرجاء تسجيل الدخول لمراجعة الكتابة.
[Your review could not be saved! Try it again later.] => لا يمكن حفظ رأيك! حاول مرة أخرى لاحقًا.
[Your review has been saved.] => تم حفظ رأيك.
)*/
?>

<!-- Page JS Plugins CSS -->

<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4><?php echo ucfirst($_GET['file']); ?> Language file</h4>
                <div class="pull-right">
                    <form method="post">
                        <a href="languages.php" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-mail-reply"></i> Back</a>

                        <button type="submit" name="refresh" id="refresh_list" class="btn btn-warning waves-effect waves-light m-r-10"><i class="fa fa-refresh"></i> Refresh File</button>
                    </form>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">

                            <div class="table-responsive" id="js-table-list">

                                <table id="ajax_datatable" class="table table-vcenter table-hover font-14" data-tablesaw-mode="stack" data-plugin="animateList" data-animate="fade" data-child="tr">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Key (English)</th>
                                        <th>Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;

                                    foreach ($new_lang as $key => $value)
                                    {
                                        $id = $count;
                                        ?>
                                        <tr>

                                            <td><?php echo $id; ?></td>
                                            <td><?php echo $key; ?></td>
                                            <td>
                                                <form method="post" name="f1" id="f1">

                                                    <span class="langtitle_<?php echo $id; ?>"><?php echo $value; ?></span>

                                                    <br>

                                                    <div style="display: none;" data-id="<?php echo $id; ?>">
                                                        <input name="newlang_key" type="hidden" value="<?php echo $key; ?>">
                                                        <input name="langfile_name" type="hidden" value="<?php echo $_GET['file']; ?>">
                                                        <input name="newlang_value" type="text" value="<?php echo $value; ?>" id="<?php echo $id; ?>" style="width: 100%">
                                                        <button type="button" class="btn btn-xs btn-success savebutton"> <i class="ion-edit"></i> Save</button>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-warning cancelbutton"> <i class="ion-close"></i> Cancel</a>
                                                    </div>

                                                    <button type="button" class="btn btn-xs btn-success editbutton"> <i class="ion-edit"></i> Edit this content</button>

                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
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


<?php include("../footer.php"); ?>


<script>
    $(function()
    {
        // Init page helpers (Table Tools helper)
        App.initHelpers('table-tools');
    });
</script>
<script>

    jQuery(function($) {
        $("#refresh_list").on('click',function(){
            $('#refresh_list').addClass('bookme-progress');
        });
        $('#js-table-list').on('click', '.editbutton', function(e) {
            var $item = $(this).siblings('div');
            var id = $item.data('id');
            $item.show();
            $(this).hide();
            $('.langtitle_'+id).hide();
        });
        $('#js-table-list').on('click', '.cancelbutton', function(e) {
            var $item = $(this).closest('div');
            var id = $item.data('id');
            $item.hide();
            $('.editbutton').show();
            $('.langtitle_'+id).show();
        });

        $('#js-table-list').on('click', '.savebutton', function(e) {
            var $item = $(this).closest('div');
            var id = $item.data('id');

            var key = $item.find("input[name='newlang_key']").val();
            var file_name = $item.find("input[name='langfile_name']").val();
            var value = $item.find("input[name='newlang_value']").val();
            var action = 'editLanguageFile';
            var data = { action: action, key: key, value: value, file_name: file_name };

            jQuery('.savebutton').addClass('bookme-progress');

            $.post(ajaxurl+'?action='+action, data, function(response) {
                // Remove Ads item from DOM.
                if(response != 0) {
                    $item.hide();
                    $('.editbutton').show();
                    $('.langtitle_'+id).html(value).show();
                    alertify.success("Success! variable edited.");
                }else{
                    alertify.error("Problem in edit, Please try again.");
                }
                jQuery('.savebutton').removeClass('bookme-progress');
            });
        });
    });

</script>
</body>

</html>

