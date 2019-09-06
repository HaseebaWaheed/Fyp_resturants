<?php  
 class Dish_models extends CI_Model  
 {  
      var $table = "models";  
      var $select_column = array("id", "name", "model_pic");  
      var $order_column = array(null, "name", null);  
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
      function make_datatables(){  
           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
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
           $this->db->insert('models', $data);  
      }  
      function fetch_single_model($model_id)  
      {  
           $this->db->where("id", $model_id);  
           $query=$this->db->get('models');  
           return $query->result();  
      }  
      function update_crud($model_id, $data)  
      {  
           $this->db->where("id", $model_id);  
           $this->db->update("models", $data);  
      }  
      function delete_single_model($model_id)  
      {  
           $result = $this->fetch_single_model($model_id);
           $this->db->where("id", $model_id);  
           $this->db->delete("models");  
           //DELETE FROM models WHERE id = '$model_id'  
           return $result;
      }  
 }  