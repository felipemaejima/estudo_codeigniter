<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Logout extends MY_Controller{ 
    
    public function index() {
        if ($this->session->userdata('user_id')) {
            $this->session->sess_destroy();
        }
        redirect(base_url('entrar'));
    }

}