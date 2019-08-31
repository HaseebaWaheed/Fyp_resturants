<?php
/**
 * Created by PhpStorm.
 * User: qasimhussain
 * Date: 8/3/18
 * Time: 12:21 AM
 */

class MY_Controller extends CI_Controller
{

    private $userdata;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->userdata= $this->session->userdata('check_login');
        if(empty($this->userdata)){
            redirect("/login");
        }
    }
//    function getOTAdata(){
//        return $this->otadata;
//    }
}
class MY_API_Controller extends CI_Controller
{

    private $userdata;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
    }
}