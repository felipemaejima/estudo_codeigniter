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

// mascara cep
  document.getElementById('cep').addEventListener('input', function (e) {
      var target = e.target, position = target.selectionStart, length = target.value.length;
      target.value = target.value.replace(/\D/g, '');
      target.value = target.value.replace(/(\d{5})(\d{3})$/, '$1-$2');
    
      if (e.inputType !== "deleteContentBackward") {
        position = position === length + 1 ? position : position + 1;
      }
    
      target.setSelectionRange(position, position);
    });

    // $("#cep").blur( async function (e) {
    //   let cep = this.value;
    //   cep = cep.replace(/[^0-9]/g,'')
    
    
    //   await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    // }    
async function buscaCep() { 
  let cep = $('#cep').val();
  cep = cep.replace(/[^0-9]/g,'')
  let res = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(res => {
          return res.json()
                .then(data => { 
                   return data;
                 })

        })  
  $('#log').val(res.logradouro);
  $('#bairro').val(res.bairro); 
}
