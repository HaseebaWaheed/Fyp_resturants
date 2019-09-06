<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Dishes extends CI_Controller {  
      //functions  
      function index(){  
           $data["title"] = 'Upload Menu Card' ;  
           $this->load->view('model_view', $data);  
      }  
      function fetch_model(){  
           $this->load->model("dish_models");  
           $fetch_data = $this->dish_models->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'/uploads/'.$row->model_pic.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $row->name;  
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>';  
                $sub_array[] = '<input type="hidden" name="operation" value="Edit"/>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->dish_models->get_all_data(),  
                "recordsFiltered"     =>     $this->dish_models->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
      function model_action(){  
           if($_POST["operation"] == "Add")  
           {  
                $insert_data = array(  
                     'name'          =>     $this->input->post('name'),  
                     'model_pic'         =>     $this->upload_image()  
                );  
                $this->load->model('dish_models');  
                $this->dish_models->insert_crud($insert_data);  
                echo 'Data Inserted';  
           }  
           if($_POST["operation"] == "Edit")  
           {  
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
                     'model_pic'         =>     $model_image  
                );  
                $this->load->model('dish_models');  
                $this->dish_models->update_crud($this->input->post("model_id"), $updated_data);  
                echo 'Data Updated';  
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
           $this->load->model("dish_models");  
           $data = $this->dish_models->fetch_single_model($_POST["model_id"]);  
           foreach($data as $row)  
           {  
                $output['name'] = $row->name;  
                if($row->model_pic != '')  
                {  
                     $output['model_image'] = '<img src="'.base_url().'/uploads/'.$row->model_pic.'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_model_image" value="'.$row->model_pic.'" />';  
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
           $this->load->model("dish_models");  
           $result = $this->dish_models->delete_single_model($_POST["model_id"]);  
           unlink('./uploads/'.$result[0]->model_pic);
           //echo 'Data Deleted';  
           //echo json_encode($result[0]);
      }  
 }