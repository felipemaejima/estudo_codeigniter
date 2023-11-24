<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_Controller.php';

class Logout extends My_Controller{ 
    
    public function index() {
        if ($this->session->userdata('user_id')) {
            $this->session->sess_destroy();
        }
        redirect('entrar');
    }

}