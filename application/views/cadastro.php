<body>
    <div id="cadastro"  class="container d-flex justify-content-center align-items-center">
    <?php 
    
    echo form_open_multipart('', ['id' => 'cadastro-form','class'=> "me-3"]);
    
    echo form_label('Nome', 'nome');
    echo form_input([
    'name' => 'nome', 
    'class' => 'form-control',
    'value' => !!$this->input->post('nome') ? $this->input->post('nome') : ""   
    ]);
    echo "<span id='erroNome' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Email', 'email');
    echo form_input([
    'name' => 'email', 
    'type' => 'email',
    'class' => 'form-control'  ,
    'value' => !!$this->input->post('email') ? $this->input->post('email') : ""  
    ]);
    echo "<span id='erroEmail' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Senha', 'senha');
    echo form_password([
    'name' => 'senha', 
    'class' => 'form-control'    
    ]);
    echo "<span id='erroSenha' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Repita a senha', 'confirmacao-senha');
    echo form_password([
    'name' => 'confirmacao-senha',
    'class' => 'form-control'    
    ]);
    echo "<span id='erroCs' style='color: red;'></span>";
    echo "<br />";
    ?>
    <label for="foto">Foto de Perfil</label>
    <input class="form-control" name="foto" type="file" id="formFile">
    <span id='erroFoto' style='color: red;'></span><br/>
    <label for="tipo-documento">Tipo Documento</label>
    <div class="input-group mb-3">
            <select name='tipo-documento' onchange="mascaraDoc()" class="form-select" id="tipo-documento">
                <option selected value="0" >Selecione o tipo do documento</option>
                <option value="1">CPF</option>
                <option value="2">CNPJ</option>
            </select>
    </div> 
    <?php 
    echo form_label('Documento', 'doc-cpf-cnpj');
    echo form_input([    
    'disabled' => " ",    
    'placeholder' => 'Escolha o tipo do documento',
    'name' => 'doc-cpf-cnpj',
    'id' => 'doc-cpf-cnpj',
    'class' => 'form-control'
    ]);
    echo "<span id='erroDoc' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Usuario Github', 'usergithub');
    echo form_input([
    'name' => 'usergithub', 
    'type' => 'text',
    'class' => 'form-control'  ,
    'value' => !!$this->input->post('usergithub') ? $this->input->post('usergithub') : ""  
    ]);
    ?>
    <br />
    <span>Já tem uma conta? <a href="<?php echo site_url('entrar')?>">Entre!</a></span><br/>
    <?php 
    echo "<br />";
    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => 'cadastrar()',
        'content' => 'Cadastrar'

    ]);

    echo form_close();
    ?>
    </div>