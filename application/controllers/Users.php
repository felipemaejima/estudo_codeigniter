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
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('nome' , 'Nome', 'required|is_unique[users.nome]' , [
                'is_unique' => "Nome de usuário já existente"
            ]);
            $this->form_validation->set_rules('email' , 'Email', 'required|is_unique[users.email]|valid_email', [
                'is_unique' => "E-mail já cadastrado"
            ]);
            $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');
            if($this->form_validation->run() == FALSE) {
                echo json_encode([
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha')
                ]);
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
        } else {
            $this->load->view('cadastro');
        }
    }
}
