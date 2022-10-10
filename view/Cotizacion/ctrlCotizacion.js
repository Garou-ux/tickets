
var Factura_TicketId = 0;
//#region funcion que carga la tabla de las cotizaciones
function fnListaCotizaciones(){
    //#region Llenamos la tabla que contendra la lista de usuarios
    tabla=$('#GridCotizaciones').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        order: [[0, 'desc']],   
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                
                'excelHtml5',
               
                ],
        "ajax":{
            url: '../../controller/ctrlCotizacion.php?op=ListaCotizacion',
            type : "post",
            dataType : "json",						
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable(); 
    //#endregion
    }


//#endregion

fnListaCotizaciones();


//#region funcion para mandar a imprimir el pdf de la cotizacion

function fnMostrarPDFCotizacion(Id){

  //local
    var _url = "http://localhost:8010/tickets/Reportes/ReporteCotizacion.php?CotizacionId="+Id+"";
  
  //server
  //var _url = "http://ctnredes.com/Reportes/ReporteCotizacion.php?CotizacionId="+Id+"";
  
  //Mandamos a imprimir el reporte
  printJS({ printable: _url, type: 'pdf', showModal: true });
  }
  
  //#endregion
  
  //funcion SetCotiPagado: primero, agrega la factura, despues
  
function SetCotiPagado(CotizacionId){
    swal({
        title:'La cotizacion ya fue pagada?',
        text:"",
        type:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#d33',
        confirmButtonText:'Si',
        cancelButtonText:'No :c',
        confirmButtonClass:'btn btn-success',
        cancelButtonClass:'btn btn-danger',
        buttonsStyling:false,
        reverseButtons:true
      })
      .then((value) => {
      if (value) {
          $.post("../../controller/ctrlCotizacion.php?op=SetCotiPagado",
        {CotizacionId :CotizacionId }, function(data){
            fnListaCotizaciones();
        });
      }
      });;
}


function ModalCotiFactura(CotizacionId){
    $('#ModalTicketFactura').modal('show');
    Factura_TicketId = CotizacionId;

}

$(document).on("click","#BtnAddTicketFactura", function(){
console.log(Factura_TicketId);
console.log(Number($("#Ticket_Factura").val()));
$.post("../../controller/ctrlCotizacion.php?op=SetCotiFactura",
{ CotizacionId : Factura_TicketId, Factura : Number($("#Ticket_Factura").val())}, 
function(data){
    Factura_TicketId = 0;
    $("#Ticket_Factura").val('')
    $('#ModalTicketFactura').modal('hide');
    fnListaCotizaciones();
});

 });

function SetCotiPagado(CotizacionId){

console.log(CotizacionId);

    swal({
        title:'La cotizacion ya fue pagada?',
        text:"",
        type:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#d33',
        confirmButtonText:'Si',
        cancelButtonText:'No :c',
        confirmButtonClass:'btn btn-success',
        cancelButtonClass:'btn btn-danger',
        buttonsStyling:false,
        reverseButtons:true
      })
      .then((value) => {
      if (value) {
        $.post("../../controller/ctrlCotizacion.php?op=SetCotiPagado",
        {CotizacionId : CotizacionId }, function(data){
            fnListaCotizaciones();
        });
      }
      });;
  
}