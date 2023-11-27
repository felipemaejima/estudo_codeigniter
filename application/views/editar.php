<body>
    <div id="edit"  class="container d-flex justify-content-center align-items-center">
    
    <?php 
    list($user) = $edit_user;
    
    echo form_open('', ['id' => 'edit-form']);
    
    echo form_label('Usuário', 'user');
    echo form_input([
    'name' => 'user', 
    'id' => 'user',
    'class' => 'form-control' ,
    'value' => $user->nome  
    ]);
    echo "<span id='erro-user' style='color: red;'></span>";
    echo "<br />";

    echo form_label('Email', 'email');
    echo form_input([
    'name' => 'email', 
    'id' => 'email',
    'class' => 'form-control', 
    'value' => $user->email   
    ]);
    echo "<span id='erro-email' style='color: red;'></span>";
    echo "<br />";

    echo form_label('Nova senha', 'senha');
    echo form_password([
    'name' => 'senha', 
    'class' => 'form-control'    
    ]);
    echo "<span id='erro-senha' style='color: red;'></span>";
    echo "<br />";

    echo form_label('Repita a senha', 'senha');
    echo form_password([
    'name' => 'confirmacao-senha',
    'class' => 'form-control'    
    ]);
    echo "<span id='erro-cs' style='color: red;'></span>";
    echo "<br />";
    echo "<br />";
?>
<a class="btn btn-primary" href="<?php echo site_url('')?>">Voltar</a>
<?php
    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => "editaUsuario($user->id)",
        'content' => 'Editar'

    ]);

    echo form_close();
    ?>
    </div>
    
</body>
</html>