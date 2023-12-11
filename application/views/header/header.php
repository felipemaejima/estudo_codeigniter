<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        // variáveis/constantes necessárias para o uso das funções
        const nameCsrf = "<?= $this->security->get_csrf_token_name(); ?>";
        let token = "<?= $this->security->get_csrf_hash(); ?>";
        const urlDelete = "<?= site_url('delete')?>";
        const urlCadastro = "<?= site_url('users/setuser'); ?>" ; 
        const urlLogin = "<?= site_url('login');?>";
        const urlEdit = "<?= site_url('edit');?>" ;
        const urlIndex = "<?= site_url('')?>";
        const urlBusca = "<?= site_url('getuser'); ?> ";
        const urlEditProf = "<?= site_url('editprofile'); ?>";
        const urlEndereco = "<?= site_url('addendereco') ;?>";
    </script>
    <?php
    if(isset($styles)) :
    foreach($styles as $style) : ?>
        <link rel="stylesheet" href="<?= base_url("assets/css/$style.css");?>">
    <?php endforeach; endif; ?>
</head>

<?php
    if (isset($dados_usuario)) {
            list($dadosUser) = $dados_usuario;
            ?>
            <body>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <div class="dropdown ms-3">
                                        <div class="d-flex justify-content-space-between align-items-center">
                                            <div class="circle me-3">
                                                <a href="<?= base_url('editprofile')?>">
                                                    <img id="profile" src="<?= $dadosUser->caminho_foto ? base_url($dadosUser->caminho_foto) : base_url("assets/imgs/foto_padrao.png") ; ?>" alt="">
                                                </a>
                                            </div>
                                            <span class="dropdown-toggle"><?php  echo $dadosUser->nome?> </span>
                                        </div>
                                        <div class="dropdown-content">
                                            <a class="dropdown-item" href="<?php echo site_url('logout'); ?>">Sair</a>
                                        </div>
                                    </div>
                                </ul>
                                <?php if (!$this->uri->segment(1) || is_numeric($this->uri->segment(1))) : ?>
                                    <div class="d-flex ui-widget">
                                        <input id="filtro" onkeyup="buscaUsuario()" class="form-control me-2" type="search" placeholder="Buscar Usuário" aria-label="Search">          
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>
                </header>
                <br>
      <?php }; ?>      