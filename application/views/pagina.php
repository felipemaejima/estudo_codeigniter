</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('logout'); ?>">Sair</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <input id="filtro" class="form-control me-2" type="search" placeholder="Buscar Usuário" aria-label="Search">
                    <!-- <button class="btn btn-outline-success" type="submit">Buscar</button> -->
                </div>
            </div>
        </div>
    </nav>
    </header>
    <?php list($dadosUser) = $dados_usuario;?>
    <br>
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
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php 
                    $paginaAtual = $this->uri->segment(1);
                    $disabledAnt = $paginaAtual == null || $paginaAtual == 1 ? 'disabled' : ' ' ; 
                    $disabledProx = $paginaAtual == ((ceil($total_registros / 5))) ? 'disabled' : ' ' ; 

                    for($cont = 1; $cont <=  ceil($total_registros / 5); $cont++) { ?>
                        <?php if($cont == 1){ ?>
                            <li class="page-item <?= $disabledAnt ?>">
                                <a class="page-link" href="<?= site_url($paginaAtual-1)?>">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?> 
                        <li class="page-item <?= $cont == $paginaAtual ? 'disabled' : '' ;?> ">
                            <a class="page-link" href="<?= site_url($cont) ?>"><?= $cont ?></a>
                        </li>
                        <?php if($cont == (ceil($total_registros / 5)) ){ ?>
                            <li class="page-item <?= $disabledProx ?>">
                                <a class="page-link" href="<?= site_url($paginaAtual+1)?>">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </nav>
        </div>

    </div>
