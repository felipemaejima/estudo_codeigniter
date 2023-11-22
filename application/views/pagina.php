<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<script> 
    function apagaUsuario(id) {
        let confirm = window.confirm("Tem certeza que deseja apagar o usuário? ");
        if (confirm) {
            let ajax = new XMLHttpRequest();
            ajax.open("DELETE", `<?php echo site_url("users/deleteuser/");?>${id}`, true);
                    ajax.onreadystatechange = () => {
                        if(ajax.readyState == 4 ) { 
                            console.log(ajax.responseText);
                        }
                    };
                    
            ajax.send();
        } 
    }
    </script>
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
        foreach($dados_permitidos as $user) 
        {?> 
            <tr>
                <td><?= $user->nome ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->id ?></td>
                <?php if ($dadosUser->id_tipo == 1) { ?>
                <td><button onclick="apagaUsuario(<?=$user->id?>)">Apagar</button></td>
               <?php } ?>    
            </tr>
            <?php } ?>
        </table>

    </div>

</body>
</html>