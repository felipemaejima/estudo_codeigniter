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
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        let response = JSON.parse(ajax.responseText);
                        let message = response.msg;
                        console.log(response, message);
                        if (response.validation === false && response.erro == 'usuario') {
                            document.querySelector('#user').style.borderColor = "red"; 
                            document.querySelector('#user').value = "";

                            document.querySelector('#senha').style.borderColor = "red";
                            document.querySelector('#senha').value = "";
                            
                            document.querySelector('#resultado').innerHTML = message;  
                        } else if (response.validation === false && response.erro == 'senha') { 
                            document.querySelector('#senha').style.borderColor = "red";
                            document.querySelector('#senha').value = "";

                            document.querySelector('#resultado').innerHTML = message;
                        } else { 
                            document.querySelector('#user').style.borderColor = "green"; 
                            document.querySelector('#user').value = "";

                            document.querySelector('#senha').style.borderColor = "green";
                            document.querySelector('#senha').value = "";
                            
                            document.querySelector('#resultado').innerHTML = message;  
                        }
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
    <?php 
    if(isset($validation)) {
        echo $validation;
    }
    ?>
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
    
    echo "<br />";
    echo form_label('Senha', 'senha');
    echo form_password([
    'name' => 'senha', 
    'id' => 'senha',
    'class' => 'form-control'    
    ]);
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