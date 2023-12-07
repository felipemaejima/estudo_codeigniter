function apagaUsuario(id) {
    let confirm = window.confirm("Tem certeza que deseja apagar o usuário? ");
    if (confirm) {
        let form = new FormData();
        form.append(nameCsrf, token)
        form.append('id', id);
        $.ajax({
            method: "POST",
            url: `${urlDelete}/${id}`,
            data: form,
            processData: false,
            contentType: false
        }).done( (res) => {
            let response = JSON.parse(res);
            token = response.csrf;
            $(`#user${id}`).remove();
        }) 
    }
}

function cadastrar() { 
    let form = document.getElementById("cadastro-form");
    let formData = new FormData(form);

    $.ajax({
        method: "POST", 
        url: urlCadastro, 
        data: formData, 
        processData: false,
        contentType: false
    }).done( res => { 
        let response = JSON.parse(res); 
        window.location.href = response.redirect;
    }).fail( res => { 
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $('#erroNome').html(response.error_nome);
        $('#erroEmail').html(response.error_email);
        $('#erroSenha').html(response.error_senha);
        $('#erroCs').html(response.error_cs);
    })
}

function validar() { 
    let form = document.getElementById("login-form");
    let formData = new FormData(form);

    $.ajax({
        method: "POST", 
        url: urlLogin, 
        data: formData, 
        processData: false,
        contentType: false
    }).done( res => { 
        let response = JSON.parse(res); 
        window.location.href = response.redirect;
    }).fail( res => { 
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $('#erroUser').html(response.error_user);
        $('#erroSenha').html(response.error_senha);
    })
}

function editaUsuario(id) {
    let editForm = document.getElementById('edit-form');    
    let form = new FormData(editForm);    
    $.ajax({
        method: "POST",
        url: `${urlEdit}/${id}`,
        data: form,
        processData: false,
        contentType: false
    }).done( (res, statusText, jqXHR) => {
        let response = JSON.parse(res);
        alert(response.msg);
        window.location.href = urlIndex;
    }).fail((res, statusText, jsXHR) => { 
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $("#erro-user").html(response.error_nome);
        $("#erro-email").html(response.error_email);
        $("#erro-senha").html(response.error_senha);
        $("#erro-cs").html(response.error_cs);
    });
}
