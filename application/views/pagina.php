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
