function apagaUsuario(id) {
    let confirm = window.confirm("Tem certeza que deseja apagar o usuário? ");
    if (confirm) {
        let form = new FormData();
        form.append(nameCsrf, token);
        $.ajax({
            method: "POST",
            url: `${urlDelete}/${id}`,
            data: form,
            processData: false,
            contentType: false
        }).done( (res) => {
            let response = JSON.parse(res);
            token = response.csrf;
            $(`#user${id}`).remove();
        }) 
    }
}

//filtra resultado em tela 
$(document).ready(function(){
    $("#filtro").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#registros tr").filter(function(i) {
        if(i > 0){ 
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        }
      });
    });
  });
  //filtra entre todos os registros 
  function getusers() {
    let form = new FormData();
    let tags = [];
    form.append(nameCsrf, token);
    $.ajax({
      method: "POST", 
      url: urlBusca,
      data: form,
      processData: false,
      contentType: false
    }).done((res) => { 
      let response = JSON.parse(res);
      token = response.csrf;
      (response.result).forEach(value => {
        tags[value.id] = value.nome;
      });
    })
    return tags;
  }
  let tags = getusers();
  
  function buscaUsuario() { 
    let tagsStrings = tags.filter((value) => { 
      return value
    });
      $( "#filtro" ).autocomplete({
        source: tagsStrings,
        select: function (event , ui ){
          tags.filter((value, id ) => { 
            if(value == ui.item.value){
              return window.location.href = `${urlEdit}/${id}`;
            }
          })
        }
      });
  }
  async function getRepos(username, id ){
    let container = document.getElementById(`content${id}`); 
    if (!username) { 
      return container.innerHTML = "Não há repositórios.";
    }
    await fetch(`https://api.github.com/users/${username}/repos`).then(res => res.json())
      .then(data => { 
        if (data.message && data.message == 'Not Found'){ 
          return container.innerHTML = "Repositório não encontrado."
        }
        container.innerHTML = "";
        data.forEach((value) => { 
          let link = document.createElement('a'); 
          link.className = "btn btn-primary m-2"; 
          link.target ="_blank";
          link.href = `https://github.com/${username}/${value.name}`;
          link.textContent = value.name;
          container.appendChild(link);
        })
      }).catch((err) => { 
        console.log(err)
      })
  }