<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{ 
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('user', 'User', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode([
                    'validation' => FALSE, 
                    'msg' => "Preencha todos os campos!",
                    'erro' => 'usuario'
                ]);
            } else {
                $user = $this->input->post('user');
                $senha = $this->input->post('senha');
                [$userdb] = $this->db->select('senha')
                        ->from('users')
                        ->where('nome', $user)
                        ->or_where('email', $user)
                        ->get()->result_array();
                $senha_hash = $userdb['senha'];
                if (password_verify($senha, $senha_hash)) {
                    echo json_encode([
                        'validation' => TRUE,
                        'msg' => 'Validado!'
                ]);
                } else {
                    echo json_encode([
                        'validation' => FALSE,
                        'msg' => 'Senha inválida!',
                        'erro' => 'senha'
                    ]);
                }
            }
        } else {
            $this->load->view('login');
        }
    }
}