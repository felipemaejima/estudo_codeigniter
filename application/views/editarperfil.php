<?php list($user) = $profile_data; ?>
<body>
    <div id="edit-profile"  class="container d-flex justify-content-center align-items-center"> 
           
    <?php 
    
    echo form_open('', ['id' => 'edit-profile-form']); ?>
    <div class="d-flex justify-content-center ">
        <label for="foto" class="circle-edit mb-3 filter" onclick="selecionaFoto()">
            <img id="profile" src="<?= $user->caminho_foto ? base_url($user->caminho_foto) : base_url("assets/imgs/foto_padrao.png") ; ?>" alt="">
        </label> 
        <input  name="foto" type="file" id="form-file-edit">
    </div>
    <span id='erro-foto' style='color: red;'></span><br>
    <label for="blur-range" class="form-label">Blur</label>
    <input onchange="blurImage()" min="0" max="30" type="range" class="form-range" id="blur-range">
    <label for="exampleColorInput" class="form-label">Cor</label>
    <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c" title="Choose your color">
    <?php 
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
        'onclick' => 'editaPerfil()',
        'content' => 'Editar'

    ]);

    echo form_close();
    ?>
    </div>
