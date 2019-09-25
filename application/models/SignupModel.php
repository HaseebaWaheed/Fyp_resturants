<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SignupModel extends CI_Model {


    function signup_user($data){

        $user_id = $this->db->insert('users',$data);
        /*$this->db->select('*');
        $this->db->where("id",$this->db->insert_id());
        return $this->db->get('users')->row();*/
        return $this->db->insert_id();
    }
    function resturants($data1){

        $id = $this->db->insert('resturants',$data1);
        /*$this->db->select('*');
        $this->db->where("id",$this->db->insert_id());
        return $this->db->get('users')->row();*/
        return $this->db->insert_id();
    }
}