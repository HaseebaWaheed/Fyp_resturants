<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginModel extends CI_Model {

    function getUser_admin($email,$password){

        $this->db->select('*');
        $this->db->where("email",$email);
        $response = $this->db->get('admin_login')->row();
      // print_r($response);
       //print_r(password_hash($password, PASSWORD_DEFAULT));
        if(!empty($response))
        {
            if(password_verify($password, $response->password))
            {
                //echo "ddd";die;
                return true;
            }else{
                //echo "xxx";die;
                return false;
            }
        }
        return false;
    }

    function getUser_user($email,$password){

        $this->db->select('*');
        $this->db->where("email",$email);
        $response = $this->db->get('users')->row();
       //print_r($response);
       //print_r(password_hash($password, PASSWORD_DEFAULT));
        if(!empty($response))
        {
            if(password_verify($password, $response->password))
            {
                //echo "ddd";die;
                return true;
            }else{
                //echo "xxx";die;
                return false;
            }
        }
        return false;
    }
 }