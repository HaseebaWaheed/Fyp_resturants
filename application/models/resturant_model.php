<?php  
 class Resturant_model extends CI_Model  
 {  
      var $table = "resturants";  
      var $select_column = array("id", 'name','user_id');  
      var $order_column = array(null, null,null);  
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
          // $r_id=$this->session->userdata("r_id");
           //$this->db->where('r_id',$r_id);
           //$this->db->select("*");  
           //$this->db->from($this->table);  
           $query = $this->db->get();  
           //echo($query->result());
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
           $this->db->insert('resturants', $data);  
      }  
      function fetch_single_model($resturant_id)  
      {  
           $this->db->where("id", $resturant_id);  
           $query=$this->db->get('resturants');  
           return $query->result();  
      }  
      function update_crud($resturant_id, $data)  
      {  
           $this->db->where("id", $resturant_id);  
           $this->db->update('resturants', $data);  
      }  
      function delete_single_model($resturant_id)  
      {  
           $result = $this->fetch_single_model($resturant_id);
           $this->db->where("id", $resturant_id);  
           $this->db->delete('resturants');  
           //DELETE FROM models WHERE id = '$resturant_id'  
           return $result;
      }  
 }  