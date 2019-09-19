<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Dish_Model_Controller extends CI_Controller {  
      //functions  
      function index(){  
           $data["title"] = 'Upload Dish Model' ;  
           $this->load->view('dish_model_view', $data);  
      }  
      function fetch_model(){  
           $this->load->model("dish_model_model");  
           $fetch_data = $this->dish_model_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'/uploads/'.$row->menu_pic.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $row->name;  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>';  
                $sub_array[] = '<input type="text" name="operation" value="Edit"/>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->dish_model_model->get_all_data(),  
                "recordsFiltered"     =>     $this->dish_model_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
      function model_action(){  
           $user_data = $this->session->userdata('dish_id');
           if($_POST["operation"] == "Add" )  
           { 
                $insert_data = array(  
                     'name'          =>     $this->input->post('name'),  
                     'menu_pic'         =>     $this->upload_image() ,
                     'dish_id'             =>      $user_data
                );  
                $this->load->model('dish_model_model');  
                $this->dish_model_model->insert_crud($insert_data);  
                echo 'Data Inserted';  
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
           $this->load->model("dish_model_model");  
           $data = $this->dish_model_model->fetch_single_model($_POST["model_id"]);  
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
           $this->load->model("dish_model_model");  
           $result = $this->dish_model_model->delete_single_model($_POST["model_id"]);  
           unlink('./uploads/'.$result[0]->model);
           //echo 'Data Deleted';  
           //echo json_encode($result[0]);
      }  
}