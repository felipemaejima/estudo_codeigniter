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
        $('#erroUser').html(response.error_user || "");
        $('#erroSenha').html(response.error_senha || "");
    })
}