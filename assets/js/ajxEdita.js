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
