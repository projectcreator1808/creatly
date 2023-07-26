<?php
global $match;
if (!isset($match['params']['id'])) {
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit;
}

$post_id = $match['params']['id'];

if(checkloggedin()) {
    if(check_valid_seller($post_id)){
        $info = ORM::for_table($config['db']['pre'].'post')
            ->where(array(
                'id' => $post_id,
                'user_id' => $_SESSION['user']['id']
            ))
            ->find_one();
        if (!empty($info)) {
            $item_title         = $info['title'];
            $item_description   = $info['description'];
            $catid              = $info['category'];
            $subcatid           = $info['sub_category'];
            $item_image         = get_post_option($post_id,'images');
            $item_tag           = $info['tag'];
            $basic_plan_json    = json_decode(get_post_option($post_id, 'basic_pricing_plan'),true);
            $standard_plan_json = json_decode(get_post_option($post_id, 'standard_pricing_plan'),true);
            $premium_plan_json  = json_decode(get_post_option($post_id, 'premium_pricing_plan'),true);

            $maincat            = get_maincat_by_id($catid);
            $catName            = $maincat['cat_name'];
            $subcat             = get_subcat_by_id($subcatid);
            $subcatName         = $subcat['sub_cat_name'];

            $custom_fields = array();
            $custom_data = array();

            $customdata = ORM::for_table($config['db']['pre'].'custom_data')
                ->select_many('field_id','field_data')
                ->where(array(
                    'post_type' => 'gig',
                    'product_id' => $post_id
                ))
                ->find_many();

            foreach ($customdata as $array){
                $custom_fields[]    = $array['field_id'];
                $custom_data[]      = $array['field_data'];
            }

            $custom_fields = get_customFields_by_catid('gig', $catid, $subcatid,false, $custom_fields, $custom_data);

            foreach ($custom_fields as $key => $value) {
                if ($value['userent']) {
                    $custom_db_fields[$value['id']] = $value['title'];
                    $custom_db_data[$value['id']]   = str_replace(',', '&#44;', $value['default']);
                }
            }
            $imagesCount = 0;
            $maxImgLength = $config['max_image_upload'];
            $screen = "";
            if($item_image != "")
            {
                $screen = explode(',', $item_image);

                foreach ($screen as $value) {
                    //REMOVE SPACE FROM $VALUE ----
                    $value = trim($value);
                    if($imagesCount == 0)
                        $screen2[] = "'$value'";
                    else
                        $screen2[] = ",'$value'";
                    $imagesCount++;
                }
                $maxImgLength = 5 - $imagesCount;
                $screen = implode(' ', $screen2);
            }

            HtmlTemplate::display('service_edit', array(
                'item_id' => $post_id,
                'item_title' => $item_title,
                'item_desc' => $item_description,
                'item_images' => $screen,
                'imagesCount' => $imagesCount,
                'maxImgLength' => $maxImgLength,
                'item_tag' => $item_tag,
                'custom_fields' => $custom_fields,
                'showcustomfield' => (count($custom_fields) > 0) ? 1 : 0,
                'catid' => $catid,
                'subcatid' => (int)$subcatid,
                'category' => $catName,
                'subcategory' => $subcatName,
                'categories' => get_maincategory('gig',$catid),
                'subcategories' => get_subcat_of_maincat($catid,false,$subcatid),
                'basic_plan' => $basic_plan_json,
                'standard_plan' => $standard_plan_json,
                'premium_plan' => $premium_plan_json,
                'currency_sign' => $config['currency_sign'],
                'language_direction' => get_current_lang_direction()
            ));
            exit;
        }
    }
    else{
        error(__("Page Not Found"), __LINE__, __FILE__, 1);
        exit;
    }
}else{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit;
}