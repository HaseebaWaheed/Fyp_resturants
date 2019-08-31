<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SignupModel extends CI_Model {


    function signup_user($data){

        $user_id = $this->db->insert('users',$data);
        /*$this->db->select('*');
        $this->db->where("id",$this->db->insert_id());
        return $this->db->get('users')->row();*/

        return $this->db->insert_id();
    }

}