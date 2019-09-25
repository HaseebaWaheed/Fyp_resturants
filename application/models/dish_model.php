<?php  
 class Dish_model extends CI_Model  
 {  
      var $table = "dishes";  
      var $select_column = array("id", 'name',"dish_pic","menu_id","serving","ingridients","price");  
      var $order_column = array("id","name","dish_pic","menu_id",null,null,null );  
      function make_query()  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);  
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("name", $_POST["search"]["value"]);  
                 
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           }  
      }
      // this function returns the image name to 
      function get_pic_name($id){
           $this->db->select("menu_pic");
           $this->db->from("menu_card");
           $this->db->where("id",$id);
           $query = $this->db->get();
          //  echo ($query->num_rows());
           foreach ($query->result_array() as $key) {
                # code...
                return $key["menu_pic"];
           }
          //  exit;


      }

      function make_datatables(){  
         // print_r($this->session->all_userdata());
          //print_r($this->session->userdata); 

           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $menu_id=$this->session->userdata("menu_model_id");
           $this->db->where('menu_id',$menu_id);
           $query = $this->db->get();  
           return $query->result();   
      }  
      function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }  
      function insert_crud($data)  
      {  
           $this->db->insert('dishes', $data);  
      }  
      function fetch_single_model($model_id)  
      {  
          $this->db->where("id", $model_id);  
           $query=$this->db->get('menu_card');  
           return $query->result();
      }  
      function update_crud($model_id, $data)  
      {  
           $this->db->where("id", $model_id);  
           $this->db->update('dishes', $data);  
      }  
      function delete_single_model($model_id)  
      {  
           $result = $this->fetch_single_model($model_id);
           $this->db->where("id", $model_id);  
           $this->db->delete('dishes');  
           //DELETE FROM models WHERE id = '$model_id'  
           return $result;
      }  
 }  