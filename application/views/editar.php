    <style>
        form { 
            max-width: 300px;
            min-width: 300px;
        }
        #edit { 
            height: 100vh;
        }
    </style>
    <script>
        function editaUsuario(id) {
        let editForm = document.getElementById('edit-form');    
        let form = new FormData(editForm);    
        $.ajax({
            method: "POST",
            url: `<?php  echo site_url("edit/");?>${id}`,
            data: form,
            processData: false,
            contentType: false
        }).done( (res, statusText, jqXHR) => {
            let response = JSON.parse(res);
            alert(response.msg);
            window.location.href = "<?= site_url("index") ?>";
        }).fail((res, statusText, jsXHR) => { 
            let response = JSON.parse(res.responseText);
            $("input[name='csrf_token']").val(response.csrf);
            $("#erro-user").html(response.error_nome);
            $("#erro-email").html(response.error_email);
            $("#erro-senha").html(response.error_senha);
            $("#erro-cs").html(response.error_cs);
        });
    }
    </script>
</head>
<body>
    <div id="edit"  class="container d-flex justify-content-center align-items-center">
    
    <?php 
    list($user) = $edit_user;
    
    echo form_open('', ['id' => 'edit-form']);
    
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
<a class="btn btn-primary" href="<?php echo site_url('index')?>">Voltar</a>
<?php
    echo form_button([
        'class' => 'btn btn-primary', 
        'onclick' => "editaUsuario($user->id)",
        'content' => 'Editar'

    ]);

    echo form_close();
    ?>
    </div>
</body>
</html>