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
        $('#erroDoc').html(response.error_doc);
    })
}

async function buscaCep() { 
    let cep = $('#cep').val();
    cep = cep.replace(/[^0-9]/g,'')
    let res = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(res => {
            return res.json()
                  .then(data => { 
                     return data;
                   })
  
          });
    if(res.erro){ 
        $('#erro-cep').html('O CEP não é válido');
        $('#log').val(" ");
        $('#bairro').val(" "); 
    }else { 
        $('#log').val(res.logradouro);
        $('#bairro').val(res.bairro); 
    }
  }

function addEndereco() { 
    let end = document.getElementById("endereco-form");
    let form = new FormData(end);
    $.ajax({
        method: "POST", 
        url: urlEndereco, 
        data: form, 
        processData: false,
        contentType: false
    }).done((res) => { 
        console.log(res)
        let response = JSON.parse(res);
        window.location.href = response.redirect;
    }).fail((res) => { 
        let response = JSON.parse(res.responseText);
        $("input[name='csrf_token']").val(response.csrf);
        $('#erro-cep').html(response.error_cep);
        $('#erro-log').html(response.error_log);
        $('#erro-bairro').html(response.error_bairro);
    })
}