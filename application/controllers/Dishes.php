<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
//  include("PostNewTarget.php");
include_once (dirname(__FILE__) . "/NewTarget.php");

 class Dishes extends CI_Controller {  

     private $globalPath;

      //functions  
      function index(){  

           $data["title"] = ' Dishes ' ;  
           $this->load->model('dish_model');
          
           // getting image from data base
           $data["model_pic"]=$this->dish_model->get_pic_name($this->session->userdata('menu_model_id'));
           $this->load->view('dish_view', $data);  
           
     }
      function fetch_model(){  
//echo '<pre>'; print_r($this->session->all_userdata());exit;

           $this->load->model("dish_model");  
           $fetch_data = $this->dish_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'/uploads/'.$row->dish_pic.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $row->name;  
                $sub_array[] = '<button type="button" name="detail" id="'.$row->id.'" class="btn btn-success btn-xs detail">Detail</button>';     
                
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>'; 
                $sub_array[] = '<button type="button" name="addModel" id="'.$row->id.'" class="btn btn-success btn-xs addModel">addModel</button>';     
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
          $user_data = $this->session->userdata('menu_model_id');
           if($_POST["operation"] == "Add")  
           {  
              $insert_data = array(  
                    'name'          =>     $this->input->post('name'),
                    'dish_pic'     => $this->make_cropped_image(),
                    'menu_id'      =>  $user_data,
                    'serving'     => $this->input->post('servings'),
                    'ingridients' => $this->input->post('ingridients'),
                    'price '     => $this->input->post('price')
               );  

               $this->load->model('dish_model');  
               $this->dish_model->insert_crud($insert_data);  
               
               echo 'Data Inserted';
               require_once(APPPATH.'controllers/NewTarget.php'); 

               $this->setTargetName($insert_data('name'));
               $this->setPath($globalPath);
               $this->executeQuery();
           }  

           if($_POST["operation"] == "Edit")  
           {  
               
                $updated_data = array(  
                     'name'          =>     $this->input->post('name'), 
                     'dish_pic'     => $this->make_cropped_image(),
                     'menu_id'      =>  $user_data,
                     'serving'     => $this->input->post('serving'),
                     'ingridients' => $this->input->post('ingridients'),
                     'price '     => $this->input->post('price')
                );  
                $this->load->model('dish_model');  
                $this->dish_model->update_crud($this->input->post("model_id"), $updated_data);  
                echo 'Data Updated';  
           }  
      }  

      function make_cropped_image(){

          if(isset($_POST["w"]) && isset($_POST["h"]) && isset($_POST["x"]) && isset($_POST["y"]) && isset($_POST["dish_source"]))
          {
               $dest_width = $_POST["w"];
               $dest_height = $_POST["h"];
               $x = $_POST["x"];
               $y = $_POST["y"];
               $loc = $_POST["dish_source"];
               $filename = basename($loc);
               $extension = strtolower(substr(strrchr($filename,"."),1));
               $img = file_get_contents($loc);
               list($src_width,$src_height) = getimagesize($loc);
               echo($src_width.' '.$src_height.' '.$dest_width.' '.$dest_height.' ');
               header("Content-type: image/<?php echo $extension?>");
               // echo $src;
               // $src = imagecreatefromstring($img);
               //echo $extension;
               //echo $src;
               // $extension = explode('.', $_FILES['dish_source']['name']);
               switch($extension)
               {
                    case 'gif':
                         $img = imagecreatefromgif($loc);
                         break;
                    case 'jpeg':
                         $img = imagecreatefromjpeg($loc);
                         break;
                    case 'jpg':
                         $img = imagecreatefromjpeg($loc);
                         break;
                    case 'png':
                         $img = imagecreatefrompng($loc);
                         break;
               }
               $new = imagecreatetruecolor($dest_width,$dest_height);
               if($extension == "gif" || $extension == "png")
               {
                    imagecolortransparent($new,imagecolorallocatealpha($new,0,0,0,127));
                    imagealphablending($new,false);
                    imagesavealpha($new,true);
               }
               imagecopyresampled($new,$img,0,0,$x,$y,$dest_width,$dest_height,$dest_width,$dest_height);
               $new_name = rand() . '.' . $extension;
               $destination = './uploads/' . $new_name;
               $globalPath=$destination;
               switch($extension)
               {
                    case 'gif':
                         imagegif($new,$destination);
                         break;
                    case 'jpeg':
                         imagejpeg($new,$destination);
                         break;
                    case 'jpg':
                         imagejpeg($new,$destination);
                         break;
                    case 'png':
                         imagepng($new,$destination);
                         break;
               }
               
               //move_uploaded_file($new,$destination);  
               echo $new_name;
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
           $this->load->model("dish_model");  
           $data = $this->dish_model->fetch_single_model($_POST["model_id"]);  
           foreach($data as $row)  
           {  
                $output['name'] = $row->name;  
                if($row->model_pic != '')  
                {  
                     $output['model_image'] = '<img src="'.base_url().'/uploads/'.$row->dish_pic.'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_model_image" value="'.$row->model_pic.'" />';  
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
           unlink('./uploads/'.$result[0]->dish_pic);
           //echo 'Data Deleted';  
           //echo json_encode($result[0]);
      }  
 }