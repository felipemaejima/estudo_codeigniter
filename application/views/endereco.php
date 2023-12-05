<body>
    <div id="endereco"  class="container d-flex justify-content-center align-items-center">
    <?php 
    
    echo form_open_multipart('', ['id' => 'endereco-form']);
    
    echo form_label('CEP', 'cep');
    echo form_input([
    'name' => 'cep', 
    'id' => 'cep', 
    'onblur' => 'buscaCep()',
    'class' => 'form-control' ,
    'placeholder' => '00000-000',
    'maxlength' => '9'
    ]);
    echo "<span id='erro-cep' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Logradrouro', 'log');
    echo form_input([
    'name' => 'log',
    'id' => 'log',
    'class' => 'form-control'
    ]);
    echo "<span id='erro-log' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Bairro', 'bairro');
    echo form_input([
    'name' => 'bairro', 
    'id' => 'bairro', 
    'class' => 'form-control'    
    ]);
    echo "<span id='erro-bairro' style='color: red;'></span>";
    echo "<br />";
    echo form_label('Número', 'num');
    echo form_input([
    'name' => 'num',
    'class' => 'form-control'    
    ]);
    echo "<span id='erro-num' style='color: red;'></span>";
    echo "<br />";
    ?>
    <a class="btn btn-primary" href="<?php echo site_url('')?>">Pular</a>
    <?php
    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => 'addEndereco()',
        'content' => 'Adicionar'

    ]);

    echo form_close();
    ?>
    </div>