<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Pages extends MY_Controller {
    public function __construct(){
        parent::__construct(); 
        if(!$this->session->userdata('user_id')) { 
            redirect(base_url('entrar'));
        }
    }
    public function index() {
        $offset = $this->uri->segment(1) - 1 ;
        $offset = $offset != null && $offset > 0? $offset * 5 : '';

        $query = $this->db->select('users.nome , users.tipo_usuario as id_tipo , tipos_usuarios.tipo_usuario, users.img_profile_path as caminho_foto')
                        ->from('users')
                        ->join('tipos_usuarios', 'users.tipo_usuario = tipos_usuarios.id', 'left')
                        ->where('users.id', $this->session->userdata('user_id'))
                        ->get()->result();
        list($row) = $query;                
        $data['dados_usuario'] = $query; 
        $dadosPermitidos = $this->db->select('id , nome, email, img_profile_path as caminho_user, repo_username')
                                    ->from('users')
                                    ->where('tipo_usuario >', $row->id_tipo )
                                    ->where('st_usuario', 1)
                                    ->or_where('id' , $this->session->userdata('user_id'))
                                    ->limit(5,$offset)
                                    ->order_by('nome')
                                    ->get()->result();    
                                 
        $countRegistros = $this->db->from('users') 
                                    ->where('tipo_usuario >', $row->id_tipo )
                                    ->where('st_usuario', 1)
                                    ->or_where('id' , $this->session->userdata('user_id'))
                                    ->count_all_results();
        $data['qtdPaginas'] = ceil($countRegistros/5);
        $data['dados_permitidos'] = $dadosPermitidos; 
        $data['title'] = 'Página Inicial'; 
        $data['scripts'] = ['pagina'];
        $data['styles'] = ['pagina'];

        $this->my_header($data);                         
        $this->load->view('pagina');
        $this->load->view('components/paginacao');
        $this->load->view('footer/footer');
    }
}