<body>
    <div id="login"  class="container d-flex justify-content-center align-items-center">
    
    <?php 
    
    echo form_open('', ['id' => 'login-form']);
    
    echo form_label('Usuário', 'user');
    echo form_input([
    'name' => 'user', 
    'id' => 'user',
    'class' => 'form-control'    
    ]);
    
    echo "<span id='erroUser' style='color: red;'></span>";
    echo "<br />";

    echo form_label('Senha', 'senha');
    echo form_password([
    'name' => 'senha', 
    'id' => 'senha',
    'class' => 'form-control'    
    ]);

    echo "<span id='erroSenha' style='color: red;'></span>";
    echo "<br />";
    ?>
    <span>Não tem acesso? <a href="<?php echo site_url('cadastro')?>">Cadastre-se!</a></span><br>
    <?php
    echo "<br />";

    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => 'validar()',
        'content' => 'Entrar'

    ]);

    echo form_close();
    ?>
    </div>