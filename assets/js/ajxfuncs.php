<script>
    function apagaUsuario(id) {
        let confirm = window.confirm("Tem certeza que deseja apagar o usuário? ");
        if (confirm) {
            let form = new FormData();
            form.append('<?php echo $this->security->get_csrf_token_name(); ?>', "<?php echo $this->security->get_csrf_hash(); ?>")
            form.append('id', id);
            $.ajax({
                method: "POST",
                url: `<?php  echo site_url("delete/");?>${id}`,
                data: form,
                processData: false,
                contentType: false
            }).done( (res) => {
                let response = JSON.parse(res);
                $(`#user${id}`).remove();
                
            }) 
        }
    }

</script>