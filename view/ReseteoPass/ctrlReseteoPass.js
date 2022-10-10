

$(document).ready(function(){

    //Se usa para ocultar el form de cambio de contraseña
    $("#FormCambioPass").hide();
 

  });

  $(document).on('click','#CambiarPass', function(){
    $("#FormCambio").hide();
    $("#FormCambioPass").show();

    });