<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script> 
    function apagaUsuario(id) {
        let confirm = window.confirm("Tem certeza que deseja apagar o usuário? ");
        if (confirm) {
            let form = new FormData();
            form.append('<?php echo $this->security->get_csrf_token_name(); ?>', "<?php echo $this->security->get_csrf_hash(); ?>")
            form.append('id', id);
            let aj = $.ajax({
                method: "POST",
                url: `<?php  echo site_url("delete/");?>${id}`,
                data: form,
                processData: false,
                contentType: false
            }).done( (res) => {
                let response = JSON.parse(res);
                $(`#user${id}`).remove();
                
        }) 
    }
}
    </script>
</head>
<body>
    <a href="<?php echo site_url('logout'); ?>">Deslogar</a><br>
    <?php list($dadosUser) = $dados_usuario;?>

    <h1>Olá <?= $dadosUser->nome?>! Vejo que é um <?= $dadosUser->tipo_usuario?>, aqui estão seus dados permitidos:  </h1>
    <div class="container">
        <table class="table text-center">
            <tr>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        <?php
        foreach($dados_permitidos as $user) {?> 
            <tr id="user<?=$user->id?>">
                <td><?= $user->nome ?></td>
                <td><?= $user->email ?></td>
                <?php if ($dadosUser->id_tipo == 1) { ?>
                <td>
                    <a class="btn btn-primary" href="<?=site_url("edit/$user->id")?>">Editar</a>
                    <button class="btn btn-primary" onclick="apagaUsuario(<?=$user->id?>)">Apagar</button>
                </td>
               <?php } ?>    
            </tr>
            <?php } ?>
        </table>

    </div>

</body>
</html>