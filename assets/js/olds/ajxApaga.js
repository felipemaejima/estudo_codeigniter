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