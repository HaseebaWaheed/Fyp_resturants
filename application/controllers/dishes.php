<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Dishes extends CI_Controller {  
      //functions  
      function index(){  

          $this->session->set_userdata("menu_id",$this->input->post("model_id"));
           $data["title"] = ' Dishes ' ;  
           
           $this->load->view('dish_view', $data);  
          // echo '<pre>'; print_r($this->session->all_userdata());exit;
      //$temp = json_decode(data);
        //   echo $temp;
        if(isset($_POST['model_id'])){   
        $id = $this->input->post("model_id");
          //echo '<pre>'; print_r($this->session->all_userdata());exit;
          echo json_encode($this->session->all_userdata());
          }
          else{
               foreach ($_POST as $key => $value) {
                    # code...
                    echo($value);
               }
               exit;
          }  
     }
      function fetch_model(){  
           $this->load->model("dish_model");  
           $fetch_data = $this->dish_model->make_datatables();  
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
                "recordsTotal"          =>      $this->dish_model->get_all_data(),  
                "recordsFiltered"     =>     $this->dish_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
      function model_action(){ 
 
           if($_POST["operation"] == "Add")  
           {  


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
                $this->load->model('dish_model');  
                $this->dish_model->update_crud($this->input->post("model_id"), $updated_data);  
                echo 'Data Updated';  
           }  
      }  
      
      function fetch_single_model()  
      {  
           $output = array();  
           $this->load->model("dish_model");  
           $data = $this->dish_model->fetch_single_model($_POST["model_id"]);  
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
           $this->load->model("dish_model");  
           $result = $this->dish_model->delete_single_model($_POST["model_id"]);  
           unlink('./uploads/'.$result[0]->model_pic);
           //echo 'Data Deleted';  
           //echo json_encode($result[0]);
      }  
 }