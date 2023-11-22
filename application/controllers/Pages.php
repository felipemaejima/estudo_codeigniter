<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        if(!$this->session->userdata('user_id')) { 
            redirect('entrar');
        }
    }
    public function index() {
        $this->load->view('pagina');
    }
}