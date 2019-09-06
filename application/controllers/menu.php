<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Menu extends CI_Controller {  
      //functions  
      function index(){  
           $data["title"] = 'Upload Menu Card' ;  
           $this->load->view('menu_view', $data);  
      }  
      function fetch_model(){  
           $this->load->model("menu_model");  
           $fetch_data = $this->menu_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'/uploads/'.$row->menu_pic.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $row->name;  
                $sub_array[] = '<button type="button" name="dishes" id="'.$row->id.'" class="btn btn-warning btn-xs dishes">Dishes</button>';  
                $sub_array[] = '<button type="button" name="crop" id="'.$row->id.'" class="btn btn-warning btn-xs crop">Crop</button>';  
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>';  
                $sub_array[] = '<input type="hidden" name="operation" value="Edit"/>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->menu_model->get_all_data(),  
                "recordsFiltered"     =>     $this->menu_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
      function model_action(){  

       // echo '<pre>'; print_r($this->session->all_userdata());exit;

          $user_data = $this->session->userdata('r_id');
           if($_POST["operation"] == "Add" )  
           {  
                $insert_data = array(  
                     'name'          =>     $this->input->post('name'),  
                     'menu_pic'         =>     $this->upload_image() ,
                     'r_id'             =>      $user_data
                );  
                $this->load->model('menu_model');  
                $this->menu_model->insert_crud($insert_data);  
                echo 'Data Inserted';  
           }  
           if($_POST["operation"] == "Edit")  
           {  
            $user_data = $this->session->userdata('r_id');
                $model_image = '';  
                if($_FILES["model_image"]["name"] != '')  
                {  
                     $model_image = $this->upload_image();  
                }  
                else  
                {  
                     $model_image = $this->input->post("hidden_model_image");  
                }  
                $updated_data = array(  
                     'name'          =>     $this->input->post('name'), 
                     'menu_pic'         =>     $model_image  ,
                     'r_id'             =>      $user_data
                );  
                $this->load->model('menu_model');  
                $this->menu_model->update_crud($this->input->post("model_id"), $updated_data);  
                echo 'Data Updated';  
           }  
           if($_POST["operation"] == "Crop")  
           {
               $this->menu_model->fetch_single_model()  ;
   
           }
      }  
      function upload_image()  
      {  
           if(isset($_FILES["model_image"]))  
           {  
                $extension = explode('.', $_FILES['model_image']['name']);  
                $new_name = rand() . '.' . $extension[1];  
                $destination = './uploads/' . $new_name;
                move_uploaded_file($_FILES['model_image']['tmp_name'], $destination);  
                return $new_name;  
           }
           else 
           {
               die("error in image upload");
           }  
      }  
      function fetch_single_model()  
      {  
           $output = array();  
           $this->load->model("menu_model");  
           $data = $this->menu_model->fetch_single_model($_POST["model_id"]);  
           foreach($data as $row)  
           {  
                $output['name'] = $row->name;  
                if($row->menu_pic != '')  
                {  
                     $output['model_image'] = '<img src="'.base_url().'/uploads/'.$row->menu_pic.'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_model_image" value="'.$row->menu_pic.'" />';  
                }  
                else  
                {  
                     $output['model_image'] = '<input type="hidden" name="hidden_model_image" value="" />';  
                }  
           }  
           echo json_encode($output);  
      }  
      function delete_single_model()  
      {  
           $this->load->model("menu_model");  
           $result = $this->menu_model->delete_single_model($_POST["model_id"]);  
           unlink('./uploads/'.$result[0]->menu_pic);
           //echo 'Data Deleted';  
           //echo json_encode($result[0]);
      }  
 }