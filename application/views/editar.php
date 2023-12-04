<body>
    <div id="edit"  class="container d-flex justify-content-center align-items-center">
    
    <?php 
    list($user) = $edit_user;
    
    if($user->tipo_documento == 1){ 
        $Doc = preg_replace("/[^0-9]/", "", $user->doc);
        $Doc = str_pad($Doc, 11, '0', STR_PAD_LEFT);
        $Doc = preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "\$1.\$2.\$3-\$4", $Doc);
    } else if($user->tipo_documento == 2){ 
        $Doc = $user->doc;
        $Doc = substr($Doc, 0, 2).'.'.substr($Doc, 2, 3).'.'.substr($Doc, 5, 3).'/'.substr($Doc, 8, 4).'-'.substr($Doc, -2);
    }
    
    echo form_open('', ['id' => 'edit-form']); ?>
        <div class="d-flex justify-content-center">
            <label for="foto" class="circle-edit mb-3" onclick="selecionaFoto()">
                <img id="profile" src="<?= $user->caminho_foto ? base_url($user->caminho_foto) : base_url("assets/imgs/foto_padrao.png") ; ?>" alt="">
            </label> 
            <input name="foto" type="file" id="form-file-edit">
        </div>
        <span id='erro-foto' style='color: red;'></span><br>
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

    $selectedCpf = $user->tipo_documento == 1 ? 'selected' : ' '; 
    $selectedCnpj = $user->tipo_documento == 2 ? 'selected' : ' ';  
    ?>
    <label for="tipo-documento">Tipo Documento</label>
    <div class="input-group mb-3">
            <select name='tipo-documento' onchange="mascaraDoc()" class="form-select" id="tipo-documento">
                <option <?= $selectedCpf ?> value="1">CPF</option>
                <option <?= $selectedCnpj ?> value="2">CNPJ</option>
            </select>
    </div>
    <?php

    echo form_label('Documento', 'doc-cpf-cnpj');
    echo form_input([
    'name' => 'doc-cpf-cnpj',
    'id' => 'doc-cpf-cnpj',
    'class' => 'form-control',
    'value' => $Doc 
    // 'onchange' => 'mascaraDoc()' 
    ]);
    echo "<span id='erro-doc' style='color: red;'></span>";
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