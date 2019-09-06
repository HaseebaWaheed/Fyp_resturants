<?php


class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('upload');
       /* $userType = $this->session->userdata('type');
        if(!empty($userType)){
            if($userType == 'admin')
                redirect('./dashboard_admin');
            else
                redirect('./dashboard_user');
        }*/

    }
    public function index()
    {
        /*if(!empty($this->input->post()))
        {
            $this->load->model('LoginModel');
            if(!empty($this->LoginModel->getUser($this->input->post("email"),$this->input->post("password")))){
                $this->session->set_userdata('check_login',true);
            }
        }*/
        $this->load->view('login', null);
    }

    public function check_login()
    {
        
        if(!empty($this->input->post()))
        {
        
            $this->load->model('LoginModel');
            if($this->LoginModel->getUser_admin($this->input->post('email'),$this->input->post('password')))
            {
                /*$session_data = array(
                    'email'     => $this->input->post('email'),
                    'type'      => 'admin'
                );
                $this->session->set_userdata($session_data);*/
                redirect('./dishes');
            }
            else if($this->LoginModel->getUser_user($this->input->post('email'),$this->input->post('password')))
            {
              // $user_id=$this->LoginModel->get_u_id('email');
               $this->LoginModel->set_r_id();
                $session_data = array(
                    'email'     => $this->input->post('email'),
                    'type'      =>'user',
                );
                $this->session->set_userdata($session_data);
              //  echo '<pre>'; print_r($this->session->all_userdata());exit;

                redirect('./menu');
            }
            else
            {
                $this->session->set_flashdata('error',"Invalid Credentials");
                redirect('./home');
              //  $this->load->view('login', null);

            }
            
        }
    }
    public function error(){
         ini_set('display_errors', 1);

    }
}