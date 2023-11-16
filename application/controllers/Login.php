<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{ 
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function validation() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            file_get_contents("http://localhost/estudo_codeigniter/index.php/entrar")

            $this->form_validation->set_rules('user', 'User', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['validation'] = 'usuário não encontrado!';
                $this->load->view('login', $data);
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
                    $data['validation'] = "login correto!";
                    $this->load->view('login' , $data);
                } else {
                    $data['validation'] = 'senha inválida!';
                    $this->load->view('login' , $data);
                }
            }
        } else {
            $this->load->view('login');
        }
    }
}