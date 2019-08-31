<?php
/**
 *
 * Created by PhpStorm.
 * User: qasimhussain
 * Date: 9/19/18
 * Time: 11:36 AM
 */

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('xcrud');
        define('XCRUD_UPLOAD_PATH', '../../uploads/');
        $this->load->model('Gallery');
        $this->load->model('model_models'); 
    }
    
    public function index()
    {
        $xcrud = Xcrud::get_instance();
        $xcrud->table('models');
        $xcrud->unset_title();
        $xcrud->columns(array("image","name"));
        $xcrud->change_type('image','image','',array('width'=>300,'path'=>'../../uploads')); // resize dashboard_admin image
        $result = $xcrud->render();
        $data['data'] = $result;
        $data['title'] = 'models';
        $data['view'] = '/xview';
        $this->load->view('dashboard_admin', $data);
    }
    
    public function models()
    {

        $xcrud = Xcrud::get_instance();
        $xcrud->table('models');
        $xcrud->unset_title();
        $xcrud->unset_remove();
        $xcrud->relation('id', 'name');
        $xcrud->change_type('image','image','',array('width'=>300,'path'=>'../../uploads')); // resize dashboard_admin 
        $xcrud->columns(array('id','image','name',));
        $xcrud->column_callback('id', 'photoGallery');
        $xcrud->label(array('id' => 'Gallery'));
        $result = $xcrud->render();
        $data['data'] = $result;
        $data['title'] = 'models';
        $data['view'] = '/xview';
        $this->load->view('dashboard_admin', $data);
    }

    public function gallery($model_id)
    {
        $data['id'] = $model_id;
        $data['gallerey'] = $this->model_models->galleries($model_id);
        
        $this->load->view('gallery',$data);
    }

    public function gallery_upload($model_id){
        $this->load->helper('gallery');
        $response = getImageBinary("file");
        if ($response["status"] == "fail")
        {
            $result = array(
                "status" => "fail",
                "errors" => $response["errors"]
            );
        }
        else
        {
            $binaryImage = $response["data"];
            $decodedImage = base64_decode($binaryImage);
            $image_data = getimagesizefromstring($decodedImage);
            // Generate uuid
            $milliseconds = round(microtime(true) * 1000);
            $name = $milliseconds.image_type_to_extension($image_data[2]);

            // Save image.
            try {
               
                $gallery = new Gallery();
                $gallery->setImage($name);
                $gallery->setModuleId($model_id);
                $gallery->savegallery();

                // Save image into directory
                file_put_contents("uploads/{$name}", base64_decode($binaryImage));

                $status = "success";
                $message = "successfully uploaded";
            } catch (Exception $e) {
                $status = "success";
                $message = $e->getMessage();
            }

            $result = array(
                "status" => $status,
                "message" => $message
            );
        }
        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($result));
    }

    public function gallery_delete(){
        $id = $this->input->post('image_ids');
        $this->model_models->deleterecord($id);
    }
   

}