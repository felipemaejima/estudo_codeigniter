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
        $('#erroFoto').html(response.error_foto || " ");
    })
}