//filtra resultado 
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