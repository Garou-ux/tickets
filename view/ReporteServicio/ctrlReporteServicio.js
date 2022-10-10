
//#region Variables
var ClienteId, UsuarioId;
//#endregion


//#region Valida que se en el boton para validar en # de ticket
$(document).on('click','#BtnValidaTicket', function(){
alert('uwu');
});

//#endregion

//#region Guarda los datos del reporte
$(document).on('click','#GuardaReporte', function(){
    let _Maestro = {};
    let _Material = [];
  
    _Material = $('#MaterialUtilizado').val();
//     _Material.ReporteServicioMaterialId = 1;
//     _Material.ReporteServicioId = 1;

//     let MaestroArr = [];
//     MaestroArr.push(_Material); 
//parseamos el objeto a json para mandarlo como parametro
//   const Maestro = JSON.stringify(MaestroArr);
//   console.log(Maestro);
});

//#endregion

//#region funcion que valida que solo se escriban numeros en el input de # ticket
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
//#endregion