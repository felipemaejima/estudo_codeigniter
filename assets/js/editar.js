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

function mascaraDoc() { 
    let tipodoc = $('#tipo-documento').val();
    if (tipodoc == 2 ){ 
        document.getElementById('doc-cpf-cnpj').disabled = false;
        document.getElementById('doc-cpf-cnpj').value = "";
        document.getElementById('doc-cpf-cnpj').placeholder ='00.000.000/0000-00';
        document.getElementById('doc-cpf-cnpj').maxLength ='18';
        document.getElementById('doc-cpf-cnpj').addEventListener('input', function (e) {
            var target = e.target, position = target.selectionStart, length = target.value.length;
            target.value = target.value.replace(/\D/g, '');
            target.value = target.value.replace(/(\d{2})(\d)/, '$1.$2');
            target.value = target.value.replace(/(\d{3})(\d)/, '$1.$2');
            target.value = target.value.replace(/(\d{3})(\d)/, '$1/$2');
            target.value = target.value.replace(/(\d{4})(\d{2})$/, '$1-$2');
          
            if (e.inputType !== "deleteContentBackward") {
              position = position === length + 1 ? position : position + 1;
            }
          
            target.setSelectionRange(position, position);
          });
    }else if(tipodoc == 1) { 
        document.getElementById('doc-cpf-cnpj').disabled = false;
        document.getElementById('doc-cpf-cnpj').value = "";
        document.getElementById('doc-cpf-cnpj').placeholder ='000.000.000-00';
        document.getElementById('doc-cpf-cnpj').maxLength ='14';
        document.getElementById('doc-cpf-cnpj').addEventListener('input', function (e) {
            var target = e.target, position = target.selectionStart, length = target.value.length;
            target.value = target.value.replace(/\D/g, '');
            target.value = target.value.replace(/(\d{3})(\d)/, '$1.$2');
            target.value = target.value.replace(/(\d{3})(\d)/, '$1.$2');
            target.value = target.value.replace(/(\d{3})(\d{2})$/, '$1-$2');
          
            if (e.inputType !== "deleteContentBackward") {
              position = position === length + 1 ? position : position + 1;
            }
          
            target.setSelectionRange(position, position);
          });
    }else if(tipodoc == 0) {
        document.getElementById('doc-cpf-cnpj').value = "";
        document.getElementById('doc-cpf-cnpj').placeholder = "Escolha o tipo do documento";
        document.getElementById('doc-cpf-cnpj').disabled = true;
    }
}
