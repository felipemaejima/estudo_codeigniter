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
            $(`#user${id}`).remove();
        }) 
    }
}

function cadastrar() { 
    let form = document.getElementById("cadastro-form");
    let formData = new FormData(form);

    let ajax = new XMLHttpRequest();
    ajax.open("POST", urlCadastro, true);
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

function validar() { 
    let form = document.getElementById("login-form");
    let formData = new FormData(form);

    let ajax = new XMLHttpRequest();
    ajax.open("POST", urlLogin, true);
    ajax.onreadystatechange = () => {
        if (ajax.readyState == 4 && ajax.status == 400) {
            let response = JSON.parse(ajax.responseText);
            document.querySelector("input[name='csrf_token']").value = response.csrf;
            document.querySelector('#erroUser').innerHTML = response.error_user || "" ;
            document.querySelector('#erroSenha').innerHTML = response.error_senha || "";
        } else if (ajax.readyState == 4 && ajax.status == 200){
            let response = JSON.parse(ajax.responseText);
            window.location.href = response.redirect;
        }
    };
    
    ajax.send(formData);
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
