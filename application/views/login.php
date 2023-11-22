<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        form { 
            max-width: 300px;
            min-width: 300px;
        }
        #login { 
            height: 100vh;
        }
    </style>
    <script>
        function validar() { 
                let form = document.getElementById("login-form");
                let formData = new FormData(form);

                let ajax = new XMLHttpRequest();
                ajax.open("POST", "<?php echo site_url('login'); ?>", true);
                ajax.onreadystatechange = () => {
                    console.log(ajax.responseText);
                    if (ajax.readyState == 4 && ajax.status == 400) {
                        let response = JSON.parse(ajax.responseText);
                        document.querySelector("input[name='csrf_token']").value = response.csrf;
                        document.querySelector('#erroUser').innerHTML = response.error_user || "" ;
                        document.querySelector('#erroSenha').innerHTML = response.error_senha || "";
                    } else if (ajax.readyState == 4 && ajax.status == 200){
                        let response = JSON.parse(ajax.responseText);
                        window.location.href = response.redirect;
                    }
                    console.log(response);
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
    <div id="login"  class="container d-flex justify-content-center align-items-center">
    
    <?php 
    
    echo form_open('', ['id' => 'login-form']);

    echo "<p id='resultado'></p>";
    
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
    echo "<br />";

    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => 'validar()',
        'content' => 'Entrar'

    ]);

    echo form_close();
    ?>
    </div>
</body>
</html>