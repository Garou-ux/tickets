
//#region variables
var tabla;
var Factura_TicketId = 0;
//#endregion


//funcion encargada de llenar el datatable de tickets listos para facturacion
function fnListaTicketsFacturacion(){
    //#region Llenamos la tabla que contendra la lista de usuarios
    tabla=$('#GridTicketsFacturacion').dataTable({
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
            url: '../../controller/ctrlFacturacion.php?op=GetTicketsFacturacion',
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


    function FacturaTicket(TicketId){
        $('#ModalTicketFactura').modal('show');
        Factura_TicketId = TicketId;
   
    }

    fnListaTicketsFacturacion();

  
    $(document).on("click","#BtnAddTicketFactura", function(){
           $.post("../../controller/ctrlFacturacion.php?op=UpdateTicketFactura",
        { TicketId : Factura_TicketId, Factura : $("#Ticket_Factura").val()}, function(data){
    
            fnListaTicketsFacturacion();
            Factura_TicketId = 0;
            $("#Ticket_Factura").val('')
            $('#ModalTicketFactura').modal('hide');
    });
     });


     //#region funcion para mandar a imprimir el pdf de la cotizacion

function fnMostrarPDFFactura(Id){

  //local
 //  var _url = "http://localhost:8010/tickets/Reportes/ReporteServicio.php?ReporteServicioId="+Id+"";

    //server
  var _url = "http://ctnredes.com/Reportes/ReporteServicio.php?ReporteServicioId="+Id+"";
    
    
    // console.log(_url);
    //Mandamos a imprimir el reporte
          printJS({ printable: _url, type: 'pdf', showModal: true })
  }
  
  //#endregion