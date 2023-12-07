<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }

    protected function my_header($data) {
        // title, scripts, dados, styles (apenas title é parametro obrigatório)

        $data['title'] = isset($data['title']) ? $data['title'] : 'Sem título'; 
        

        $this->load->view('header/header', $data);
    }
}