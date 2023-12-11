document.getElementById('cep').addEventListener('input', function (e) {
    var target = e.target, position = target.selectionStart, length = target.value.length;
    target.value = target.value.replace(/\D/g, '');
    target.value = target.value.replace(/(\d{5})(\d{3})$/, '$1-$2');
  
    if (e.inputType !== "deleteContentBackward") {
      position = position === length + 1 ? position : position + 1;
    }
  
    target.setSelectionRange(position, position);
  });
  async function buscaCep() { 
    let cep = $('#cep').val();
    cep = cep.replace(/[^0-9]/g,'')
    let res = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(res => {
            return res.json()
                  .then(data => { 
                     return data;
                   })
  
          }).catch((err)=> {
            console.log(err)
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