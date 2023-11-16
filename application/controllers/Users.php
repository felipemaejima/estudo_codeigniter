<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

	public function getUsers() { 
        $data['users'] = $this->db->get('users')->result_array();
        $this->load->view('index' , $data);
    }

    public function setUser() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->view('cadastro');
        } else {
            $this->form_validation->set_rules('nome' , 'Nome', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required');
            $this->form_validation->set_rules('senha' , 'Senha', 'required');
            if($this->form_validation->run() == FALSE) {
                $data['st'] = 0;
                $this->load->view('cadastro', $data);
            } else {
                $inserir = [
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                ];
                $this->db->insert('users', $inserir);
                $data['st'] = 1;
                $this->load->view('cadastro', $data);
            } 
        }
    }
}
