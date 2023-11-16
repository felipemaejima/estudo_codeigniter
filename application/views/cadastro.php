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
        #cadastro { 
            height: 100vh;
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
    <?php 
    if(isset($st)) {
        if($st == 1){
            echo "sucesso na validação";
        } else { 
            echo "Erro na validação";
        }
    }
    ?>
    <div id="cadastro"  class="container d-flex justify-content-center align-items-center">
    <?php 
    
    echo form_open();
    
    echo form_label('Nome', 'nome');
    echo form_input([
    'name' => 'nome', 
    'class' => 'form-control'    
    ]);
    echo "<br />";
    echo form_label('Email', 'email');
    echo form_input([
    'name' => 'email', 
    'type' => 'email',
    'class' => 'form-control'    
    ]);
    echo "<br />";
    echo form_label('Senha', 'senha');
    echo form_password([
    'name' => 'senha', 
    'class' => 'form-control'    
    ]);
    echo "<br />";
    echo form_button([
        'class' => 'btn btn-primary', 
        'type' => 'submit', 
        'content' => 'Cadastrar'

    ]);

    echo form_close();
    ?>
    </div>
</body>
</html>