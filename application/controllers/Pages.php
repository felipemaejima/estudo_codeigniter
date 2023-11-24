<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_Controller.php';

class Pages extends My_Controller {
    public function __construct(){
        parent::__construct(); 
        if(!$this->session->userdata('user_id')) { 
            redirect('entrar');
        }
    }
    public function index() {
        $query = $this->db->select('users.nome , users.tipo_usuario as id_tipo , tipos_usuarios.tipo_usuario')
                        ->from('users')
                        ->join('tipos_usuarios', 'users.tipo_usuario = tipos_usuarios.id', 'left')
                        ->where('users.id', $this->session->userdata('user_id'))
                        ->get()->result();
        list($row) = $query;          
        // $this->session->set_userdata('user_tipo', $row->id_tipo);      
        $data['dados_usuario'] = $query; 
        $dadosPermitidos = $this->db->select('id , nome, email, tipo_usuario')
                                    ->from('users')
                                    ->where('tipo_usuario >', $row->id_tipo )
                                    ->where('st_usuario', 1)
                                    ->or_where('id' , $this->session->userdata('user_id'))
                                    ->get()->result();
        $data['dados_permitidos'] = $dadosPermitidos;                            
        $this->load->view('pagina', $data);
    }
}