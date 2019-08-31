<?php

class Dashboard_Admin extends CI_Controller
{
    public function index(){
    
        $data['view'] = '/main_view';
        $this->load->view('dashboard_admin',$data);

       
    }
    public function Models()
    {
        $xcrud = Xcrud::get_instance();
        $xcrud->table('models');
        $xcrud->unset_title();
        $xcrud->change_type('image','image','',array('width'=>300,'path'=>'../../uploads')); // resize main image
        $result = $xcrud->render();
        $data['data'] = $result;
        $data['title'] = 'Models';
        $data['view'] = '/xview';
        $this->load->view('dashboard_admin',$data);
    }
}
?>