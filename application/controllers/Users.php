<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_Controller.php';

class Users extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function setUser() {
        if ($this->session->userdata('user_id')) {
            redirect('');
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $errors = [];
            $inserir = [];

            $config['upload_path']          = "assets/imgs/";
            $config['allowed_types']        = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);

            $this->form_validation->set_rules('nome' , 'Nome', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required|is_unique[users.email]|valid_email', [
                'is_unique' => "E-mail já cadastrado."
            ]);
            $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');

            // print_r($_FILES['foto']['name']);
            // return ;
            if($_FILES['foto']['name']) {
                if(!$this->upload->do_upload('foto')) {
                    $errors['error_foto'] = $this->upload->display_errors('','');
                } else { 
                    $inserir['img_profile_path'] = $config['upload_path'] . $this->upload->data('file_name');
                } 
            }  

            if($this->form_validation->run() == FALSE || isset($errors['error_foto'])) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                $errors = array_merge($errors, [
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
                echo json_encode($errors);
            } else {
                $inserir = array_merge($inserir, [
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                    'tipo_usuario' => 3
                ]);
                $query = $this->db->insert('users', $inserir);

                if($query){
                    $newUser = $this->db->select('id')->from('users')->where('email', $this->input->post('email'))->get()->result();
                    list($row) = $newUser;
                    $this->session->set_userdata('user_id', $row->id); 
                    echo json_encode([
                        'redirect' => site_url('')
                    ]);
                }
            } 
        } else {
            $this->my_header([
                'title' => "Cadastro", 
                'scripts' => ['ajxCadastra'], 
                'styles' => ['style']
            ]);
            $this->load->view('cadastro');
            $this->load->view('footer/footer');
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
                    'msg' => "Registro apagado com sucesso!",
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else { 
                echo json_encode([
                    'msg' => "O registro não foi apagado!", 
                    'csrf' => $this->security->get_csrf_hash()
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
            $data['edit_user'] = $this->db->select("id , nome, email, img_profile_path as caminho_foto")
                                        ->from('users')
                                        ->where('id', $id)
                                        ->get()->result();
            $data = array_merge($data, [
                'title' => 'Editar Usuário', 
                'scripts' => ['ajxEdita'],
                'styles' => ['style']
            ]);
            $this->my_header($data);
            $this->load->view('editar');
            $this->load->view('footer/footer');
        }
    }

    public function editprofile() { 
        if (!$this->session->userdata('user_id')) {
            redirect('entrar');
        } 
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $attData = [];
            $errors = [];

            $config['upload_path']          = "assets/imgs/";
            $config['allowed_types']        = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);


            $this->form_validation->set_rules('user' , 'Usuário', 'required');
            $this->form_validation->set_rules('email' , 'Email', 'required|valid_email', [
                'is_unique' => "E-mail já cadastrado."
            ]);
            if($this->input->post('senha')) { 
                $this->form_validation->set_rules('senha' , 'Senha', 'required|min_length[6]');
                $this->form_validation->set_rules('confirmacao-senha' , 'Repita a senha', 'required|matches[senha]');
                $attData['senha'] = $this->input->post('senha'); 
            }
            
            if($_FILES['foto']['name']) {
                if(!$this->upload->do_upload('foto')) {
                    $errors['error_foto'] = $this->upload->display_errors('','');
                } else { 
                    $attData['img_profile_path'] = $config['upload_path'] . $this->upload->data('file_name');
                } 
            } 

            if($this->form_validation->run() == FALSE || isset($errors['error_foto'])) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                $errors = array_merge($errors, [
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
                echo json_encode($errors);
            } else { 
                $query = $this->db->select('img_profile_path as caminho_antigo')->from('users')->where('id', $this->session->userdata('user_id'))->get()->result();
                list($old) = $query;
                unlink($old->caminho_antigo);
                $attData = array_merge($attData, [
                    'nome' => $this->input->post('user'),
                    'email' => $this->input->post('email') 
                ]);
                $att = $this->db->set($attData)
                ->where('id', $this->session->userdata('user_id'))
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
            $data['profile_data'] = $this->db->select("nome, email, img_profile_path as caminho_foto ")
                                        ->from('users')
                                        ->where('id', $this->session->userdata('user_id'))
                                        ->get()->result();
            $data = array_merge($data, [
                'title' => 'Editar Perfil',
                'styles' => ['style'],
                'scripts' => ['ajxEdita']
            ]);
            $this->my_header($data);
            $this->load->view('editarperfil');
            $this->load->view('footer/footer');
        }

        
    }
}
