<?php list($dadosUser) = $dados_usuario; ?>
<h3 class="text-center">Olá <?= $dadosUser->nome?>! Vejo que é um <?= $dadosUser->tipo_usuario?>,<br> aqui estão seus dados permitidos:  </h3>
<br>
<div class="container">
    <table class="table text-center" id="registros">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    <?php
    foreach($dados_permitidos as $user) {?> 
        <tr id="user<?=$user->id?>">
            <td>
                <div class="d-flex justify-content-space-between align-items-center">
                    <div class="circle-users me-4">
                            <img id="profile-user" src="<?= $user->caminho_user ? base_url($user->caminho_user) : base_url("assets/imgs/foto_padrao.png") ; ?>" alt="">
                    </div>
                    <?= $user->nome ?>
                </div>
            </td>
            <td><?= $user->email ?></td>
            <?php if ($dadosUser->id_tipo == 1) { ?>
            <td>
                <a class="btn btn-primary" href="<?=site_url("edit/$user->id")?>">Editar</a>
                <button class="btn btn-primary" onclick="apagaUsuario(<?=$user->id?>)">Apagar</button>
            </td>
            <?php } ?>    
        </tr>
        <tr>
            <td colspan="3">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button onclick="getRepos('<?=$user->repo_username;?>' , <?=$user->id;?>)"  class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$user->id?>" aria-expanded="false" aria-controls="collapseTwo">
                                Repositórios
                            </button>
                        </h2>
                    <div id="collapse<?=$user->id?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div id="content<?=$user->id?>" class="accordion-body justify-content-space-between">
                        .   .   .
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
