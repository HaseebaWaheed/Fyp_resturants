<?php

class Register extends CI_Controller {
    

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('SignUpModel');
    }
    function index(){
        $this->load->view('register');
    }

    function validation()
    {
        $this->form_validation->set_rules('username','Username','required|trim');
        $this->form_validation->set_rules('email','Email Address','required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run())
        {
            $data = array(
                'username'  => $this->input->post('username'),
                'email'     => $this->input->post('email'),
                'password'  => $this->input->post('password'),
                'status'    => '0'
            );
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
            $id = $this->SignUpModel->signup_user($data);
            if($id>0)
            {
                redirect('./dashboard_user');
            }
            else{
                echo ("can't insert into database");
            }
        }
        else
        {
            $this->index();
        }
    }
}

?>