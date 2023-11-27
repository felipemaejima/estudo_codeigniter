    <style>
        form { 
            max-width: 300px;
            min-width: 300px;
        }
        #login { 
            height: 100vh;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    <!-- <div id="cadastro"  class="container d-flex justify-content-center align-items-center">
        <form action="" method="post">
        <div class="mb-3">
            <label for="exampleInputName1" class="form-label">Name</label>
            <input name="nome" type="text" class="form-control" id="exampleInputName1">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="senha" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div> -->
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