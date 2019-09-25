<?php


class Resturants extends CI_Controller
{
    function index(){  
        $data["title"] = 'Resturants' ;  
        $this->load->view('resturants', $data);  
   }  
   function fetch_model(){ 
        $this->load->model("resturant_model");  
        $fetch_data = $this->resturant_model->make_datatables();  
        $data = array();  
        foreach($fetch_data as $row)  
        {  
             $sub_array = array();  
             $sub_array[] = $row->name;
             $sub_array[] = '<button type="button" name="dishes" id="'.$row->id.'" class="btn btn-warning btn-xs dishes">Dishes</button>';  
             $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>';  
             $data[] = $sub_array;  
        }  
        $output = array(  
             "draw"                  =>     intval($_POST["draw"]),  
             "recordsTotal"          =>      $this->resturant_model->get_all_data(),  
            // "recordsFiltered"       =>     $this->resturant_model->get_filtered_data(),  
             "data"                  =>     $data  
        );  
        echo json_encode($output);  
   }  
   function delete_resturant()  
   {  
        $this->load->model("resturant_model");  
        print_r($_POST["resturant_id"]);
        $result = $this->resturant_model->delete_single_model($_POST["resturant_id"]);  
        //unlink('./uploads/'.$result[0]->menu_pic);
        echo 'Data Deleted';  
        //echo json_encode($result[0]);
   }  
}