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
        const urlEndereco = "<?= site_url('addendereco') ?>"
    </script>
    <?php
    if(isset($styles)) {
    foreach($styles as $style) { ?>
        <link rel="stylesheet" href="<?= base_url("assets/css/$style.css");?>">
    <?php } /* fim foreach */ } //fim if ?>
</head>