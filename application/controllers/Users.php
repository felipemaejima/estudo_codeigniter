<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function getUser() { 
        if (!$this->session->userdata('user_id')){
            redirect(base_url('entrar'));
        }
        $query = $this->db->select('id , nome')->from('users')
                        ->get()->result();
        echo json_encode([
            'result' => $query, 
            'csrf' => $this->security->get_csrf_hash()
        ]);         
    }

    public function addEndereco() { 
        if (!$this->session->userdata('user_id')){
            redirect(base_url('entrar'));
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $endData = [];
            $errors = [];
            $this->form_validation->set_rules('cep', 'CEP', 'required|min_length[9]', [
                    'min_length' => 'O formato do CEP não é válido!'
            ]); 
            
            $this->form_validation->set_rules('log', 'Logradouro', 'required'); 
            $this->form_validation->set_rules('bairro', 'Bairro', 'required');

            if($this->input->post('num')){
                $endData['numero'] = $this->input->post('num');
            }
            if($this->form_validation->run() == FALSE) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                
                echo json_encode([
                    'error_cep' => form_error('cep'),
                    'error_log' => form_error('log'),
                    'error_bairro' => form_error('bairro'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
            } else { 
                $endData = array_merge($endData, [
                    'id_user' => $this->session->userdata('user_id'),
                    'cep' => preg_replace("/[^0-9]/", "", $this->input->post('cep')),
                    'logradouro' => $this->input->post('log'),
                    'bairro' => $this->input->post('bairro')
                ]);
                $query = $this->db->insert('users_enderecos', $endData);

                if($query){
                    echo json_encode([
                        'redirect' => site_url('')
                    ]);
                }
            }
        }else {
            $data = [
                'title' => 'Adicionar Endereço',
                'styles' => ['endereco'],
                'scripts' => ['endereco']
            ];
            
            $this->my_header($data);
            $this->load->view('endereco'); 
            $this->load->view('footer/footer');
        }
    }

    public function setUser() {
        if ($this->session->userdata('user_id')) {
            redirect(base_url(''));
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
            if ($this->input->post('tipo-documento') == 1) { 
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[14]', [
                    'min_length' => "Formato do CPF não é válido!"
                ]);
            }else if($this->input->post('tipo-documento') == 2) {
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[18]', [
                    'min_length' => "Formato do CNPJ não é válido!"
                ]);
            } else {
                $this->form_validation->set_rules('doc-cpf-cnpj' , 'Documento', 'required');
            }

      
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
                    'error_doc' => form_error('doc-cpf-cnpj'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
                echo json_encode($errors);
            } else {
                $inserir = array_merge($inserir, [
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                    'tipo_usuario' => 3,
                    'tipo_documento' => $this->input->post('tipo-documento'),
                    'doc_cpf_cnpj' => preg_replace("/[^0-9]/", "", $this->input->post('doc-cpf-cnpj'))
                ]);
                $query = $this->db->insert('users', $inserir);

                if($query){
                    $newUser = $this->db->select('id')->from('users')->where('email', $this->input->post('email'))->get()->result();
                    list($row) = $newUser;
                    $this->session->set_userdata('user_id', $row->id); 
                    echo json_encode([
                        'redirect' => site_url('cadastro/2/')
                    ]);
                }
            } 
        } else {
            $this->my_header([
                'title' => "Cadastro", 
                'scripts' => ['cadastro'], 
                'styles' => ['cadastro']
            ]);
            $this->load->view('cadastro');
            $this->load->view('footer/footer');
        }
    }

    public function deleteUser() { 
        if (!$this->session->userdata('user_id')) {
            redirect(base_url('entrar'));
        } 
        if ($this->session->userdata('user_tipo_id') != 1){ 
            redirect(base_url(''));
        }
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $id = $this->uri->segment(2);  
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
            redirect(base_url('entrar'));
        } 
        if ($this->session->userdata('user_tipo_id') != 1){ 
            redirect(base_url(''));
        }
        $id = $this->uri->segment(2);
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $attData = [];
            $errors = [];
            $imgDelete = FALSE;

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
                $attData['senha'] = password_hash($this->input->post('senha'), PASSWORD_DEFAULT); 
            }
            
            if($_FILES['foto']['name']) {
                if(!$this->upload->do_upload('foto')) {
                    $errors['error_foto'] = $this->upload->display_errors('','');
                } else { 
                    $attData['img_profile_path'] = $config['upload_path'] . $this->upload->data('file_name');
                    $imgDelete = TRUE;
                } 
            } 

            if ($this->input->post('tipo-documento') == 1) { 
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[14]', [
                    'min_length' => "Formato do CPF não é válido!"
                ]);
            }else if($this->input->post('tipo-documento') == 2) {
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[18]', [
                    'min_length' => "Formato do CNPJ não é válido!"
                ]);
            } else {
                $this->form_validation->set_rules('doc-cpf-cnpj' , 'Documento', 'required');
            }

            if($this->form_validation->run() == FALSE || isset($errors['error_foto'])) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                $errors = array_merge($errors, [
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'error_doc' => form_error('doc-cpf-cnpj'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
                echo json_encode($errors);
            } else { 
                $query = $this->db->select('img_profile_path as caminho_antigo')->from('users')->where('id', $id)->get()->result();
                list($old) = $query;
                if($old->caminho_antigo && $imgDelete){ 
                    unlink($old->caminho_antigo);
                }
                $attData = array_merge($attData, [
                    'nome' => $this->input->post('user'),
                    'email' => $this->input->post('email') ,
                    'tipo_documento' => $this->input->post('tipo-documento'),
                    'doc_cpf_cnpj' => preg_replace("/[^0-9]/", "", $this->input->post('doc-cpf-cnpj'))
                ]);
                $att = $this->db->set($attData)
                ->where('id', $id)
                ->update('users');      
                if($att) { 
                    echo json_encode([
                        'msg' => "Registro editado com sucesso!"
                    ]);
                } else { 
                    echo json_encode([
                        'msg' => "O registro não foi editado!",
                        'csrf' => $this->security->get_csrf_hash()
                    ]);
                }
            }
        }else { 
            $data['profile_data'] = $this->db->select("id, nome, email, img_profile_path as caminho_foto, doc_cpf_cnpj as doc,tipo_documento")
                                        ->from('users')
                                        ->where('id', $id)
                                        ->get()->result();
            $data = array_merge($data, [
                'title' => 'Editar Perfil',
                'styles' => ['editar'],
                'scripts' => ['editar']
            ]);
            $this->my_header($data);
            $this->load->view('editar');
            $this->load->view('footer/footer');
        }
    }

    public function editprofile() { 
        if (!$this->session->userdata('user_id')) {
            redirect(base_url('entrar'));
        } 
        $id = $this->session->userdata('user_id');
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $attData = [];
            $errors = [];
            $imgDelete = FALSE;

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
                $attData['senha'] = password_hash($this->input->post('senha'), PASSWORD_DEFAULT); 
            }
            
            if($_FILES['foto']['name']) {
                if(!$this->upload->do_upload('foto')) {
                    $errors['error_foto'] = $this->upload->display_errors('','');
                } else { 
                    $attData['img_profile_path'] = $config['upload_path'] . $this->upload->data('file_name');
                    $imgDelete = TRUE;
                } 
            } 

            if ($this->input->post('tipo-documento') == 1) { 
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[14]', [
                    'min_length' => "Formato do CPF não é válido!"
                ]);
            }else if($this->input->post('tipo-documento') == 2) {
                $this->form_validation->set_rules('doc-cpf-cnpj', 'Documento', 'required|min_length[18]', [
                    'min_length' => "Formato do CNPJ não é válido!"
                ]);
            } else {
                $this->form_validation->set_rules('doc-cpf-cnpj' , 'Documento', 'required');
            }

            if($this->form_validation->run() == FALSE || isset($errors['error_foto'])) {
                $this->output->set_status_header(400);
                $this->form_validation->set_error_delimiters('','');
                $errors = array_merge($errors, [
                    'error_nome' => form_error('nome'),
                    'error_email' => form_error('email'),
                    'error_senha' => form_error('senha'),
                    'error_cs' => form_error('confirmacao-senha'),
                    'error_doc' => form_error('doc-cpf-cnpj'),
                    'csrf' => $this->security->get_csrf_hash()
                ]);
                echo json_encode($errors);
            } else { 
                $query = $this->db->select('img_profile_path as caminho_antigo')->from('users')->where('id', $id)->get()->result();
                list($old) = $query;
                if($old->caminho_antigo && $imgDelete){ 
                    unlink($old->caminho_antigo);
                }
                $attData = array_merge($attData, [
                    'nome' => $this->input->post('user'),
                    'email' => $this->input->post('email') ,
                    'tipo_documento' => $this->input->post('tipo-documento'),
                    'doc_cpf_cnpj' => preg_replace("/[^0-9]/", "", $this->input->post('doc-cpf-cnpj'))
                ]);
                $att = $this->db->set($attData)
                ->where('id', $id)
                ->update('users');      
                if($att) { 
                    echo json_encode([
                        'msg' => "Registro editado com sucesso!"
                    ]);
                } else { 
                    echo json_encode([
                        'msg' => "O registro não foi editado!",
                        'csrf' => $this->security->get_csrf_hash()
                    ]);
                }
            }
        }else { 
            $data['profile_data'] = $this->db->select("id, nome, email, img_profile_path as caminho_foto, doc_cpf_cnpj as doc,tipo_documento")
                                        ->from('users')
                                        ->where('id', $id)
                                        ->get()->result();
            $data = array_merge($data, [
                'title' => 'Editar Perfil',
                'styles' => ['editarperfil'],
                'scripts' => ['editarperfil']
            ]);
            $this->my_header($data);
            $this->load->view('editarperfil');
            $this->load->view('footer/footer');
        }
    }
}
