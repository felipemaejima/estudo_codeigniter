<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends MY_Controller{ 
    
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_id')) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('user', 'Usuário', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                echo json_encode([
                    'error_user' => form_error('user'), 
                    'error_senha' => form_error('senha'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else {
                $user = $this->input->post('user');
                $senha = $this->input->post('senha');
                $userdb = $this->db->select('senha, id, tipo_usuario')
                                ->from('users')
                                ->where('nome', $user)
                                ->or_where('email', $user)
                                ->get()->result_array();
                [$userdb] = $userdb ? $userdb : [null];
                if ($userdb) {
                    $senha_hash = $userdb['senha'];
                        if (password_verify($senha, $senha_hash)) {   
                            $this->session->set_userdata('user_id', $userdb['id']);
                            $this->session->set_userdata('user_tipo_id', $userdb['tipo_usuario']);
                            echo json_encode([
                                'redirect' => site_url('')
                            ]);
                        } else {
                            $this->output->set_status_header(400);
                            echo json_encode([
                                'error_senha' => 'Senha inválida!',
                                'csrf' => $this->security->get_csrf_hash()
                            ]);
                        }
                } else { 
                    $this->output->set_status_header(400);
                    echo json_encode([
                        'error_user' => "Usuário não existe.",
                        'csrf' => $this->security->get_csrf_hash()
                    ]);
                }
            }
        } else {
            $data = [
                'title' => "Entrar", 
                'scripts' => ['login'],
                'styles' => ['login']
            ]; 
            $this->my_header($data);
            $this->load->view('login');
            $this->load->view('footer/footer');
        }
    }
}