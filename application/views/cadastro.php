    <style>
        form { 
            max-width: 300px;
            min-width: 300px;
        }
        #cadastro { 
            height: 100vh;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline; 
        }
    </style>
    <script>
        function cadastrar() { 
                let form = document.getElementById("cadastro-form");
                let formData = new FormData(form);

                let ajax = new XMLHttpRequest();
                ajax.open("POST", "<?php echo site_url('users/setuser'); ?>", true);
                ajax.onreadystatechange = () => {
                    if (ajax.readyState == 4 && ajax.status == 400) {
                        let response = JSON.parse(ajax.responseText);
                        document.querySelector("input[name='csrf_token']").value = response.csrf;
                        document.querySelector('#erroNome').innerHTML = response.error_nome;
                        document.querySelector('#erroEmail').innerHTML = response.error_email;
                        document.querySelector('#erroSenha').innerHTML = response.error_senha;
                        document.querySelector('#erroCs').innerHTML = response.error_cs;
                    } else if (ajax.readyState == 4 && ajax.status == 200) {
                        let response = JSON.parse(ajax.responseText);
                        window.location.href = response.redirect;
                        
                    }
                };
                ajax.send(formData);
        }
    </script>
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
</body>
</html>