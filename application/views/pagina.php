<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Olá <?php
     list($row) = $this->db->select('nome')->from('users')->where('id', $this->session->userdata('user_id'))->get()->result(); 
     echo $row->nome;
    ?>!</h1> <br>
    <a href="<?php echo site_url('logout'); ?>">Deslogar</a>
</body>
</html>