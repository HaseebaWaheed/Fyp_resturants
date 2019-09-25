<?php

function photoGallery($value)
{
    return "<a class='btn btn-primary btn-sm' href=".base_url("dashboard/gallery/{$value}")."><strong>Gallery</strong></a>";
}


function publish_action($xcrud) {
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function unpublish_action($xcrud) {
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud) {
// get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
// set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud) {
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud) {
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload') {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($xcrud) {
    if ($xcrud->get('primary') !== false) {
        $primary = (int) $xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item) {
            if ($item['officeCode'] == $primary && $key != 0) {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }
        foreach ($result as $key => $item) {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function movebottom($xcrud) {
    if ($xcrud->get('primary') !== false) {
        $primary = (int) $xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item) {
            if ($item['officeCode'] == $primary && $key != $count - 1) {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item) {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $xcrud) {
    $result = '';
    if ($value == '1') {
        $result = '<i class="fa fa-check" />' . 'OK';
    } elseif ($value == '2') {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud) {
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
            '" />';
}

function unset_val($postdata) {
    $postdata->del('Paid');
}

function format_phone($new_phone) {
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud) {
    var_dump($list);
}

// custom functions
function room_status($value, $fieldname, $primary, $row, $xcrud) {
    return $value = ($value == 0) ? 'Disabled' : 'Enabled';
}

function ota_other_fields($postdata, $xcrud) {

    // create directory for OTA with named OTAID to upload images in "assets/uploads"
    mkdir(IMAGE_UPLOAD_PATH . $postdata->get('ota_id'), 0777, true);
    // create thumbs directory in ota images folder
    mkdir(IMAGE_UPLOAD_PATH . $postdata->get('ota_id') . '/thumbs', 0777, true);

    $ci = & get_instance();
    $ci->load->model('Home_model');
    $check_package = $ci->Home->checkRecord('packages', ['id' => $postdata->get('package_name')]);

    $postdata->set('ota_registration.ota_id', $postdata->get('ota_registration.ota_id'));
    $postdata->set('remaining_package_calls', $check_package->calls);
    $today = date('Y-m-d H:i:s');
    $postdata->set('expired_at', date('Y-m-d H:i:s', strtotime($today . ' + ' . $check_package->days . ' days')));

    $is_enabled = ($postdata->get('status') == 'Active') ? 1 : 0;
    $postdata->set('is_enabled', $is_enabled);

    $remember_token = md5($postdata->get('email') . $postdata->get('full_name'));
    $postdata->set('remember_token', $remember_token);
}
function delete_all_products($primary, $xcrud) {
    $ci = & get_instance();
    $ci->db->delete('order_products', array('product_id' => $primary));
}
function delete_ota_data($primary, $xcrud) {

    $ci = & get_instance();

    // get OTA id to remove images dir
    $res = $ci->Home->getRecords('ota_registration', ['ota_id'], ['id' => $primary]);

    // remove ota's images folder from uploads
    rrmdir(IMAGE_UPLOAD_PATH . $res[0]->ota_id);

    $db = Xcrud_db::get_instance();
    $db->query('DELETE FROM suppliers WHERE ota_id = ' . $res[0]->ota_id);
    $db->query('DELETE FROM hotels WHERE user_id = ' . $primary);

    return true;
}
function delete_blog_image($primary, $xcrud) {

    $ci = & get_instance();
    $params = array(
        "ota_id"=>$ci->session->userdata('otadata')->ota_id,
        "id"=>$primary,
    );
    json_decode(server_request($params,SERVERNAME.'ota/delete_blog'));
    return false;
}

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function city_select2($value, $field, $priimary_key, $list, $xcrud) {

    return '<div class="input-prepend input-append">'
            . '<select class="form-control search-city xcrud-input" name="' . $xcrud->fieldname_encode('hotels.city') . '">'
            . '<option value="' . $list['hotels.city'] . '">' . $value . '</option>'
            . '</select>'
            . '</div>';
}

function add_hotel_city($postdata, $xcrud) {
    $postdata->set('hotels.city', $postdata->get('hotels.city'));
}

function hotel_city($postdata, $primary, $xcrud) {
    $postdata->set('hotels.city', $postdata->get('hotels.city'));
}
function invoice_url($value, $field, $priimary_key, $list, $xcrud)  {
   $value =  $list["super_booking.id"];
    if($list["modules.name"] == "hotels")
    {
        $module_name = "hotels";
    }else{
        $module_name = "flights";
    }
    $params = array('ota_id' => $_SESSION["otadata"]->ota_id );
    $result = json_decode(server_request($params, SERVERNAME . 'ota/domians'))->data;
    return "<a class='btn btn-primary  btn-block' target='_blank' href=".$result[0]->uri."://".$result[0]->domain."/$module_name/invoice/".$value."><strong>Invoice</strong></a>";
}

function generate_otaId($value, $field, $priimary_key, $list, $xcrud) {

    $id = (isset($value) && !empty($value)) ? $value : mt_rand(00000000, 99999999);
    return '<div class="input-prepend input-append">'
            . '<input class="form-control xcrud-input" name="' . $xcrud->fieldname_encode('ota_registration.ota_id') . '" value="' . $id . '">'
            . '</div>';
}

function image_thumb($value, $fieldname, $primary, $row, $xcrud) {

    $ci = & get_instance();
    $ota_id =  $ci->session->userdata('otadata')->ota_id;
    if(empty($value))
    {
        return '<img src="' .IMGURL  . "/default.png". '" />';

    }else{
        return '<img src="' .IMGURL . $ota_id . '/thumbs/' . $value . '" />';

    }
}

function delete_hotel_images($primary, $xcrud) {

    $ci = & get_instance();
    $images = $ci->Home->getRecords('hotel_images', ['image_url'], ['hotel_id' => $primary]);

    define('IMAGE_PATH', base_url('assets/uploads/'));
    foreach ($images as $img) {
        if (!empty($img->image_url) && is_dir(IMAGE_PATH) && file_exists(IMAGE_PATH . $img->image_url)) {
            @unlink(IMAGE_PATH . $img->image_url);
            @unlink(IMAGE_PATH . 'thumbs/' . $img->image_url);
        }
    }

    return true;
}

function delete_room_image($primary, $xcrud) {

    $ci = & get_instance();
    $images = $ci->Home->getRecords('rooms', ['image'], ['room_id' => $primary]);

    define('IMAGE_PATH', base_url('assets/uploads/'));
    foreach ($images as $img) {
        if (!empty($img->image) && is_dir(IMAGE_PATH) && file_exists(IMAGE_PATH . $img->image)) {
            @unlink(IMAGE_PATH . $img->image);
            @unlink(IMAGE_PATH . 'thumbs/' . $img->image);
        }
    }

    return true;
}
function refresh($primary, $xcrud)
{
    $params = array('ota_id' => $_SESSION["otadata"]->ota_id );
    $result = json_decode(server_request($params, SERVERNAME . 'ota/domians'));
    if(count($result->data) >= 5)
    {
        exit("maximum domians is 5.");
    }
}

function room_type_slug($postdata, $primary, $xcrud) {
    
    $postdata->set('slug', str_replace('---', '-', rspecial($postdata->get('type'), '-')));
}
function add_domain($postdata, $xcrud){

    addonDomain($postdata->get('domain'),$postdata->get('domain'));
}
function add_blog($postdata, $xcrud){

    $postdata->set("title",rspecial_char($postdata->get('title')));
    return $postdata;
}
function add_category($postdata, $xcrud){

    $postdata->set("category",rspecial_char($postdata->get('category')));
    return $postdata;
}
function domain_check($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = json_decode(file_get_contents(SERVERNAME . "global/checkdns?token=123&domain=" . $row["domains.domain"]));
    if(($result->check) ){
        return  "<a href='domain_verify/".$row["domains.domain"]."' class='btn btn-success btn-xs'>"."check"."</a>";
    }else{
        return  "<a href='domain_verify/".$row["domains.domain"]."' class='btn btn-danger btn-xs'>"."check"."</a>";
    }
}

// replace all special chracters to "-"
function rspecial($string, $rp = '') {
    $string = str_replace(' ', '-', $string);
    return preg_replace('/[^A-Za-z0-9\-]/', $rp, $string);
}
function rspecial_char($string, $rp = '') {
//    $string = str_replace(' ', ' ', $string);
     return preg_replace('/[^A-Za-z0-9\-]+/', ' ', $string);
;
}

function hotelGallery($value, $fieldname, $primary_key, $row, $xcrud){
  $CI =& get_instance();

//  $photocounts =  pt_HotelPhotosCount($primary_key);
  return "<a href=".base_url()."ota/hotels/gallery/".$value.">Upload</a>";
}

/*function image_thumb_hotel($value, $fieldname, $primary, $row, $xcrud) {

    $ota_id =  getOta()->ota_id;
    if(empty($value))
    {
        return '<img src="' .IMGURL  . "/default.png". '" />';

    }else{
        return '<img src="' .IMGURL . $ota_id . '/supplier/'.getSupplier()->supplier_id.'/thumbs/' . $value . '" />';

    }
}*/
