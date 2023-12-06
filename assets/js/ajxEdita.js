function editaUsuario(id) {
    let editForm = document.getElementById('edit-form');    
    let form = new FormData(editForm);    

    $.ajax({
        method: "POST",
        url: `${urlEdit}/${id}`,
        data: form,
        processData: false,
        contentType: false
    }).done( (res) => {
        let response = JSON.parse(res);
        alert(response.msg);
        window.location.href = urlIndex;
    }).fail((res) => { 
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $("#erro-user").html(response.error_nome);
        $("#erro-email").html(response.error_email);
        $("#erro-senha").html(response.error_senha);
        $("#erro-cs").html(response.error_cs);
        $('#erro-doc').html(response.error_doc);
    });
}

function selecionaFoto() { 
    document.getElementById('form-file-edit').click();
}
 
function readImage() {
    if (this.files && this.files[0]) {
        var file = new FileReader();
        file.onload = function(e) {
            document.getElementById("profile").src = e.target.result;
        };       
        file.readAsDataURL(this.files[0]);
    }
}
document.getElementById("form-file-edit").addEventListener("change", readImage, false);
