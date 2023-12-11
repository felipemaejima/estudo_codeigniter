<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model { 
    public function __construct(){ 
        parent::__construct();
    }
    public function get_userdata() { 
        $query = $this->db->select('users.nome , users.tipo_usuario as id_tipo , tipos_usuarios.tipo_usuario, users.img_profile_path as caminho_foto')
                        ->from('users')
                        ->join('tipos_usuarios', 'users.tipo_usuario = tipos_usuarios.id', 'left')
                        ->where('users.id', $this->session->userdata('user_id'))
                        ->get()->result();
        list($row) = $query;                
        return $query; 
    }
}