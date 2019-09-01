<?php  
 class Model_model extends CI_Model  
 {  
          function get_models(){
                $this->db->select('*');
                $q = $this->db->get('models');
                return $q->result();
        }
        
        public function galleries($model_id){
            $this->db->where('model_id',$model_id);
            $this->db->select('*');
            $q = $this->db->get('galleries');
            return $q->result();
        }
      
        public function deleterecord($id){
            foreach($id as $p_id){
                $this->db->select('galleries.image');
                $this->db->from('galleries');
                $this->db->where('id', $p_id);
                $query = $this->db->get();
    
                if ( $query->num_rows() > 0 )
                {
                    $image = $query->row();
                   if(file_exists(FCPATH ."uploads/".$image->image)){
                    unlink( FCPATH ."uploads/".$image->image);
                    }
                $this->db->delete('galleries', array('id' => $p_id));
                $this->galleries($p_id);
                }
            }
        }
    
    }