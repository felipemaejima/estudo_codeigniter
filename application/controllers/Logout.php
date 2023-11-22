<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller{ 
    
    public function index() {
        if ($this->session->userdata('user_id')) {
            $this->session->sess_destroy();
        }
        redirect('entrar');
    }

}