<body>
    <div id="cadastro"  class="container d-flex justify-content-center align-items-center">
    <?php 
    
    echo form_open('', ['id' => 'cadastro-form']);
    
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
    echo form_label('Repita a senha', 'senha');
    echo form_password([
    'name' => 'confirmacao-senha',
    'class' => 'form-control'    
    ]);
    echo "<span id='erroCs' style='color: red;'></span>";
    echo "<br />";
    ?>
    <span>Já tem uma conta? <a href="<?php echo site_url('entrar')?>">Entre!</a></span><br>
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