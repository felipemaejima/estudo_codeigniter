<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('user_id')) {
            redirect('index');
        }
    }

	public function getUsers() { 
        $data['users'] = $this->db->get('users')->result_array();
        $this->load->view('index' , $data);
    }

    public function setUser() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('nome' , 'Nome', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required|is_unique[users.email]|valid_email', [
                'is_unique' => "E-mail já cadastrado."
            ]);
            $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');
            if($this->form_validation->run() == FALSE) {
                $this->output->set_status_header(400);
                echo json_encode([
                    'error_nome' => strip_tags(form_error('nome')),
                    'error_email' => strip_tags(form_error('email')),
                    'error_senha' => strip_tags(form_error('senha')),
                    'error_cs' =>strip_tags(form_error('confirmacao-senha')),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else {
                $inserir = [
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                ];
                $query = $this->db->insert('users', $inserir);

                if($query){
                    $newUser = $this->db->select('id')->from('users')->where('email', $this->input->post('email'))->get()->result();
                    list($row) = $newUser;
                    $this->session->set_userdata('user_id', $row->id); 
                    echo json_encode([
                        'redirect' => site_url('index')
                    ]);
                }
            } 
        } else {
           $this->load->view('cadastro');
        }
    }
}
