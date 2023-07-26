<?php

/**
 * ---------- SIMPLE UPLOAD ----------
 * we create an instance of the class, giving as argument the PHP object
 * corresponding to the file field from the form
 * All the uploads are accessible from the PHP object $_FILES
 * set variables
 * @param $field_name
 * @param $target_dir
 * @return array
 */
function quick_file_upload($field_name, $target_dir){
    $result = array();
    if(isset($_FILES[$field_name])){
        $handle = new Verot\Upload\Upload($_FILES[$field_name]);
        $handle->allowed = array('image/*');
        $handle->file_new_name_body = rand();
        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploaded) {
            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->process('/home/www/storage/');
            $handle->process($target_dir);

            if ($handle->processed) {
                $result['success'] = true;
                $result['file_name'] = $handle->file_dst_name;
            } else {
                $result['success'] = false;
                $result['error'] = $handle->error;
            }
            // we delete the temporary files
            $handle-> clean();
            return $result;
        } else {
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            $result['success'] = false;
            $result['error'] = $handle->error;
            return $result;
        }
    }

    $result['success'] = false;
    $result['error'] = "File not submitted";
    return $result;
}

$dir_path = ROOTPATH . "/storage/tmp/";
$var = quick_file_upload('my_field',$dir_path);

print_r($var);

?>
<fieldset>
    <legend>Simple upload</legend>
    <p>Pick up a file to upload, and press "upload" </p>
    <form name="form1" enctype="multipart/form-data" method="post" action="#" />
    <p><input type="file" size="32" name="my_field" value="" /></p>
    <p class="button"><input type="hidden" name="action" value="simple" />
        <input type="submit" name="Submit" value="upload" /></p>
    </form>
</fieldset>
