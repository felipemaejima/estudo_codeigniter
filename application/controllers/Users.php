<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_Controller.php';

class Users extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function setUser() {
        if ($this->session->userdata('user_id')) {
            redirect('index');
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('nome' , 'Nome', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required|is_unique[users.email]|valid_email', [
                'is_unique' => "E-mail já cadastrado."
            ]);
            $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');
            if($this->form_validation->run() == FALSE) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                echo json_encode([
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else {
                $inserir = [
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                    'tipo_usuario' => 3
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

    public function deleteUser() { 
        if (!$this->session->userdata('user_id')) {
            redirect('entrar');
        } 
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $id = $this->uri->segment(2);
            //Apagando registro diretamente
                // 
                // $del = $this->db->delete('users', [ 'id' => $id]);
    
                // if ($del) {
                //     echo json_encode([
                //         'msg' => "Registro apagado com sucesso!"
                //     ]);
                // } else { 
                //     echo json_encode([
                //         'msg' => "O registro não foi apagado!"
                //     ]);
                // }
            
            // Apagando com coluna st_usuario (0 ou 1)    
            $del = $this->db->set('st_usuario', 0)
                     ->where('id', $id)
                     ->update('users');      
            if($del) { 
                echo json_encode([
                    'msg' => "Registro apagado com sucesso!"
                ]);
            } else { 
                echo json_encode([
                    'msg' => "O registro não foi apagado!"
                ]);
            }
        }
    }

    public function editUser() {
        if (!$this->session->userdata('user_id')) {
            redirect('entrar');
        } 
        $id = $this->uri->segment(2);
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $attData = [];
            $this->form_validation->set_rules('user' , 'Usuário', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required|valid_email', [
                'is_unique' => "E-mail já cadastrado."
            ]);
            if($this->input->post('senha')) { 
                $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
                $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');
                $attData['senha'] = $this->input->post('senha'); 
            }
            
            if($this->form_validation->run() == FALSE) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                echo json_encode([
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else { 
                $attData = array_merge($attData, [
                    'nome' => $this->input->post('user'),
                    'email' => $this->input->post('email') 
                ]);
                $att = $this->db->set($attData)
                ->where('id', $id)
                ->update('users');      
                if($att) { 
                    echo json_encode([
                        'msg' => "Registro editado com sucesso!",
                    ]);
                } else { 
                    echo json_encode([
                        'msg' => "O registro não foi editado!",
                        'csrf' => $this->security->get_csrf_hash()
                    ]);
                }
            }
        }else { 
            $data['edit_user'] = $this->db->select("id , nome, email")
                                        ->from('users')
                                        ->where('id', $id)
                                        ->get()->result();
            $this->load->view('editar', $data);
        }
    }
}
