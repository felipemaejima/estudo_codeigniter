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
        $('#erro-doc').html(response.error_doc);
    });
}

function selecionaFoto() { 
    document.getElementById('form-file-edit').click();
}

function editaPerfil() { 
    let formProfile = document.getElementById('edit-profile-form');
    let form = new FormData(formProfile)
    $.ajax({
        method: "POST",
        url: urlEditProf, 
        data: form,
        processData: false, 
        contentType: false
    }).done((res)=>{
        let response = JSON.parse(res);
        alert(response.msg);
        window.location.href = urlIndex;
    }).fail((res)=>{
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $("#erro-foto").html(response.error_foto || " ");
        $("#erro-user").html(response.error_nome);
        $("#erro-email").html(response.error_email);
        $("#erro-senha").html(response.error_senha);
        $("#erro-cs").html(response.error_cs);
    })
}

// function readURL() {
//     let input = document.getElementById('form-file-edit');
//     $('#profile').attr('src', input.value);
//     console.log(input.value)
// }

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

function blurImage(){
    let blur = document.getElementById('blur-range').value / 10;
    document.querySelector('.filter').style.filter = `blur(${blur}px)`
}
