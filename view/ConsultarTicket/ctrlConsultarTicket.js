//#region Variables

var tabla;
var UsuarioId =  $('#UsuarioId').val();
var RolId =  $('#RolId').val();
var MaestroTicketId;
var TicketEStatus;
var k = 0;
var f = 0;
var clientes = [];
//#endregion



     //funcion para mostrar un spinner en lo que se guarda
     function Spinner(Contenedor, Mostrar){
      if(Mostrar){
        $('#'+Contenedor).waitMe({
          effect : 'win8_linear',
          text : '',
          bg : 'rgba(255,255,255,0.7)',
          color : '#838786' ,
          maxSize : '',
          waitTime : -1,
          textPos : 'vertical',
          fontSize : '',
          source : '',
          onClose : function() {}
          });
      }else{
        $('#'+Contenedor).waitMe('hide');
      }
      }


function CargarListaTickets (){
//llenamos el datatable llamando al servicio que retorna los datos
tabla=$('#GridTickets').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    order: [[0, 'desc']], 
    dom: 'Bfrtip',
    "searching": true,
    lengthChange: false,
    colReorder: false,
    buttons: [
            'excelHtml5'
            ],
    "ajax":{
        url: '../../controller/ctrlTicket.php?op=ListTicketUsuario',
        type : "post",
        dataType : "json",
        data:{ UsuarioId : UsuarioId},
        error: function(e){
            console.log(e.responseText);
            alert(e.responseText);
            return;
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
}

$(document).ready(function(){

      //Se usa para ocultar el boton de retorno
      $("#TabDetalleTicket").hide();
      $("#BotonRegresar").hide();
      $("#TabReporteServicio").hide();

      CargarListaTickets();


            //Se configura el summernote donde se respondera al ticket
            $('#Respuesta').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture']]
                  ],
                  popover:{
                     image:[],
                     link:[],
                     air:[]
                  },
                height: 180,
                lang:"es-ES",
                callback :{
                    onImageUpload: function(image){
                        // console.log("Image Detect.-.");
                        myimagetreat(image[0]);
                    },
                    onPaste: function(e){
                        // console.log("Text Detected..");
                    }
                }
            });
        });

          //      //#region funcion para visualizar el detalle de un ticket
          // function fnVerTicket(TicketId){
          //     //Mostramos la informacion del ticket seleccionado
          //   $('#myModalResponderTicket').modal('show');
          // MaestroTicketId = TicketId;//le damos valor a esta variable que se usara globalmente en varias funciones
          // //llamamos al servicio para llenar el encabezado
          // $.post("../../controller/ctrlTicket.php?op=GetTicketXId",
          // {TicketId: TicketId}, function(data){
          //     data = JSON.parse(data);//parseamos a objeto json los valores de la bd
          //     // console.log(data.Estatus);
          //      //Asignamos los valores a los campos
          //     $('#NoTicket').html('Ticket # ' + data.TicketId);
          //     $('#SpanEstatusTicket').html(data.Estatus);
          //     $('#SpanNombreUsuario').html(data.Nombre);
          //     $('#SpanFechaCreacion').html(data.FechaCreado);
          //     $.post("../../controller/ctrlTicket.php?op=GetAllDataTicketXId",
          //     {TicketId: TicketId }, function(dataa){
          //     dataa = JSON.parse(dataa);
          //       $('#SpanSolicitante').html(dataa[0].NombreSolicitante);
          //     });
          //     $('#DataCategoria').val(data.Categoria);
          //     $('#DataTitulo').val(data.Titulo);
          //     TicketEstatus = data.TicketEstatus;
          //     $('#DataDescripcion').summernote('code',data.Descripcion,{
          //         toolbar: [
          
          //             ['style', ['bold', 'italic', 'underline', 'clear']],
          //             ['font', ['strikethrough', 'superscript', 'subscript']],
          //             ['fontsize', ['fontsize']],
          //             ['color', ['color']],
          //             ['para', ['ul', 'ol', 'paragraph']],
          //             ['height', ['height']],
          //             ['insert', ['picture']]
          //           ],
          //         //   popover:{
          //         //     image:[],
          //         //     link:[],
          //         //     air:[]
          //         // },
          //     });
          
          //     // console.log(TicketEstatus);
          //     //Si el ticket esta cerrado, deshabilitamos los botones y el summernote para responder
          //     if(TicketEstatus == "Cerrado"){
          //         $("#BtnAddTicketRespuesta").attr("disabled", true);
          //         $("#BtnCerrarTicket").attr("disabled", true);
          //         $('#Respuesta').summernote('disable',{
          //             popover:{
          //                 image:[],
          //                 link:[],
          //                 air:[]
          //                               },
          //         });
          //         $("#RowRespuesta").hide(); //Ocultamos la vista donde se actualiza el ticket
          //     }
          //     if(TicketEstatus == "Abierto"){
          //         $("#BtnAddTicketRespuesta").attr("disabled", false);
          //         $("#BtnCerrarTicket").attr("disabled", false);
          //         $('#Respuesta').summernote('enable',{
          //             popover:{
          //                 image:[],
          //                 link:[],
          //                 air:[]
          //                               },
          //         });
          //         $("#RowRespuesta").show();
          //     }
          // });
          //     //Llamamos al servicio para llenar los datos del detalle
          //     $.post("../../controller/ctrlTicket.php?op=GetTicketDetXId",
          //     {TicketId : TicketId}, function(data){
          // // console.log(data);
          // //Se cargan los datos en el div
          // $('#DetalleTicket').html(data);
          // });
          
          // //Se configura el summernote donde se muestra la descripcion del ticket
          // $('#DataDescripcion').summernote('disable',{
          //     toolbar: [
          //         // [groupName, [list of button]]
          //         ['style', ['bold', 'italic', 'underline', 'clear']],
          //         ['font', ['strikethrough', 'superscript', 'subscript']],
          //         ['fontsize', ['fontsize']],
          //         ['color', ['color']],
          //         ['para', ['ul', 'ol', 'paragraph']],
          //         ['height', ['height']],
          //         ['insert', ['picture']]
          //       ],
          //       popover:{
          //         image:[],
          //         link:[],
          //         air:[]
          //                       },
          // height:200,
          // lang:'es-ES',
          // });
          // }
          // //#endregion
     //#region funcion para visualizar el detalle de un ticket
function fnVerTicket(TicketId){
  //Mostramos la informacion del ticket seleccionado
  $("#TabDetalleTicket").show(); //Mostramos el div que contiene el detalle
  $("#TabGeneral").hide(); //Ocultamos el tabgeneral
  $("#BotonRegresar").show(); //Mostramos el boton de regresar
  $("#TabReporteServicio").hide();//Ocultamos el tab de reporte de servicio
MaestroTicketId = TicketId;//le damos valor a esta variable que se usara globalmente en varias funciones
//llamamos al servicio para llenar el encabezado
$.post("../../controller/ctrlTicket.php?op=GetTicketXId",
{TicketId: TicketId}, function(data){
  data = JSON.parse(data);//parseamos a objeto json los valores de la bd
  // console.log(data.Estatus);
   //Asignamos los valores a los campos
  $('#NoTicket').html('Ticket # ' + data.TicketId);
  $('#SpanEstatusTicket').html(data.Estatus);
  $('#SpanNombreUsuario').html(data.Nombre);
  $('#SpanFechaCreacion').html(data.FechaCreado);
  $.post("../../controller/ctrlTicket.php?op=GetAllDataTicketXId",
  {TicketId: TicketId }, function(dataa){
  dataa = JSON.parse(dataa);
    $('#SpanSolicitante').html(dataa[0].NombreSolicitante);
  });
  $('#DataCategoria').val(data.Categoria);
  $('#DataTitulo').val(data.Titulo);
  TicketEstatus = data.TicketEstatus;
  $('#DataDescripcion').summernote('code',data.Descripcion,{
      toolbar: [

          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['insert', ['picture']]
        ],
        popover:{
          image:[],
          link:[],
          air:[]
      },
  });

  // console.log(TicketEstatus);
  //Si el ticket esta cerrado, deshabilitamos los botones y el summernote para responder
  if(TicketEstatus == "Cerrado"){
      $("#BtnAddTicketRespuesta").attr("disabled", true);
      $("#BtnCerrarTicket").attr("disabled", true);
      $('#Respuesta').summernote('disable',{
          popover:{
              image:[],
              link:[],
              air:[]
                            },
      });
      $("#RowRespuesta").hide(); //Ocultamos la vista donde se actualiza el ticket
  }
  if(TicketEstatus == "Abierto"){
      $("#BtnAddTicketRespuesta").attr("disabled", false);
      $("#BtnCerrarTicket").attr("disabled", false);
      $('#Respuesta').summernote('enable',{
          popover:{
              image:[],
              link:[],
              air:[]
                            },
      });
      $("#RowRespuesta").show();
  }
});
  //Llamamos al servicio para llenar los datos del detalle
  $.post("../../controller/ctrlTicket.php?op=GetTicketDetXId",
  {TicketId : TicketId}, function(data){
// console.log(data);
//Se cargan los datos en el div
$('#DetalleTicket').html(data);
});

//Se configura el summernote donde se muestra la descripcion del ticket
$('#DataDescripcion').summernote('disable',{
  toolbar: [
      // [groupName, [list of button]]
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['insert', ['picture']]
    ],
    popover:{
      image:[],
      link:[],
      air:[]
                    },
height:200,
lang:'es-ES',
});
}
//#endregion

        //#region funcion para ocultar el tab de respuesta del ticket y mostrar el tab general
        function fnOcultarTabDetalle(){
            $("#TabContentDet").show();
            CargarListaTickets();
            $("#TabDetalleTicket").hide();
            $("#TabGeneral").show();
            $("#BotonRegresar").hide();
            $("#TabReporteServicio").hide();
        }
        //#endregion

    //#region Se usa cuando se da click en el boton de enviar respuesta
      $(document).on('click','#BtnAddTicketRespuesta', function(){
          let _Maestro = {};
          let MaestroArr =[];
          _Maestro.TicketId = MaestroTicketId;
          _Maestro.TicketId = Number(_Maestro.TicketId);
          _Maestro.UsuarioId = UsuarioId;
          _Maestro.UsuarioId = Number(_Maestro.UsuarioId);
          _Maestro.Respuesta = $('#Respuesta').val();
      
          if (_Maestro.Respuesta.trim() == ""){
              swal('Favor de agregar una Respuesta','','warning');
              return;
          }
      
          MaestroArr.push(_Maestro);
          //convertimos el objeto a json para mandarlo como parametro
          const Maestro = JSON.stringify(MaestroArr);
      
          // console.log(Maestro);
          //Llamamos al servicio para mandar el parametro y guardar la respuesta
             $.post("../../controller/ctrlTicket.php?op=AddTicketRespuesta",
             { Maestro : Maestro}, function(data){
      
         console.log(data);
         $('#Respuesta').summernote('reset');
         swal("Proceso Completado Correctamente","","success");
         fnVerTicket(MaestroTicketId);
         });
      });
    //#endregion



      //#region Sirve para dar por terminado el ticket
      $(document).on('click','#BtnCerrarTicket', function(){
          swal({
              title: "¿Estas seguro/a de querer cerrar el ticket?",
              text: "",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  $.post("../../controller/ctrlTicket.php?op=CerrarTicket",
                  { TicketId : MaestroTicketId, UsuarioId :UsuarioId}, function(data){
                  console.log(data);
                  $('#Respuesta').summernote('reset');
                  fnVerTicket(MaestroTicketId);
      
                  });
                  //Se manda notificacion de que el ticket ah sido cerrado(solucionado)
      $.post("../../controller/ctrlEnvioEmails.php?op=NotificacionTicketCerrado",
      {TicketId : MaestroTicketId }, function(data){
      });
                swal("El ticket ah sido cerrado", {
                  icon: "success",
                });
              } else {
                swal("No se cancelo el ticket");
              }
            });
          // console.log('uwuwuwuwu')
          });
      //#endregion
     //#region fnReporteServicio: se usa para mostrar el tab para generar un reporte del servicio
            function fnReporteServicio(TicketId){
              $('#myModalReporteServicio').modal('show');
              $('#SpanModalTicketId').text(TicketId);
              $.ajax({
                type: "POST",
                dataType : "json",
                url: "../../controller/ctrlTicket.php?op=GetDataReporteServicio",
                data:{TicketId : TicketId }
            }).done(function(data, response){             
               // data = JSON.parse(data);
                console.log(data);     
                $('#Cliente').val(data[0].Cliente);
                $('#Soporte').val(data[0].Soporte);
                $("#Categoria").val(data[0].Categoria);
                $("#ClienteIdReporte").val(data[0].ClienteId);
                $("#CategoriaIdTicket").val(data[0].CategoriaId);
              });
              LoadGrid();
            }
     //#endregion
          
         //#region Funcion para calcular lo totales de la cotizacion
            function MontosRenglon(ObjectTotales){
              var Cantidad =0, Precio = 0, Total = 0;
              
              // Cantidad = ObjectTotales.Cantidad;
              // Precio = ObjectTotales.Precio;
              // Total = ObjectTotales.Total;
            
            
              // if (Cantidad>0 && Precio>0){
            // Total = Cantidad * Precio;
            // Total = parseFloat(Total).toFixed(2);
            //$('#txTotal'+index+'').val(Total); 
            
            // SpanSubtotal SpanIVA SpanTotal
            //Recorremos todos los valores de la tabla para asi obtener los totales de los productos ya sumados
            let SubTotal = 0, TotalCot = 0, IVA = 0, TotalCantidad =0, TotalPrecio = 0;
            for (var i = 0; i < ObjectTotales.length; i++){
              TotalPrecio += parseFloat(ObjectTotales[i].Total);
            }
            
            SubTotal = TotalPrecio;
            IVA = SubTotal * 0.16;
            TotalCot = SubTotal + IVA;
            
            
            // TotalCot = TotalPrecio;
            // SubTotal = TotalCot / 1.16;
            // IVA  = TotalCot * 0.16;
            
            TotalCot = parseFloat(TotalCot).toFixed(2);
            SubTotal = parseFloat(SubTotal).toFixed(2);
            IVA  = parseFloat(IVA).toFixed(2);
            $('#SpanSubtotal').text(SubTotal); 
            $('#SpanIVA').text(IVA); 
            $('#SpanTotal').text(TotalCot); 
              // }
            }
        //#endregion
     
        
    //#region fnGuardarReporteServicio: Guarda los datos del reporte
          $(() => {
            $('#BtnGuardarReporteServicio').click(e => {  
            Spinner('myModalReporteServicio', true);
        //Ahora obtenemos los datos en general (Maestro)
        let MaestroReporte ={};
        MaestroReporte.TicketId = $("#SpanModalTicketId").text();
        MaestroReporte.TicketId = Number(MaestroReporte.TicketId);
        MaestroReporte.ClienteId = $("#ClienteIdReporte").val();
        MaestroReporte.ClienteId = Number(MaestroReporte.ClienteId);
        MaestroReporte.Marca = $("#Marca").val();
        MaestroReporte.Modelo = $("#Modelo").val();
        MaestroReporte.Serie = $("#Serie").val();
        MaestroReporte.Otros = $("#Otros").val();
        MaestroReporte.InspeccionVisual = $("#InspeccionVisual").val();
        MaestroReporte.CategoriaId = $("#CategoriaIdTicket").val();
        MaestroReporte.CategoriaId = Number(MaestroReporte.CategoriaId);
        MaestroReporte.FallaPresentada = $("#FallaPresentada").val();
        //totales
        // MaestroReporte.Servicio = $("#TotalServicio").val();
        // MaestroReporte.Refacciones = $("#TotalRefacciones").val();
        // MaestroReporte.ViaticosOtros = $("#TotalViaticosOtros").val();
        MaestroReporte.SubTotal = $("#SpanSubtotal").text();
        MaestroReporte.IVA = $("#SpanIVA").text();
        MaestroReporte.Total = $("#SpanTotal").text();
        
        // MaestroReporte.Servicio =parseFloat(MaestroReporte.Servicio);
        // MaestroReporte.Refacciones =parseFloat(MaestroReporte.Refacciones);
        // MaestroReporte.ViaticosOtros =parseFloat(MaestroReporte.ViaticosOtros);
        MaestroReporte.SubTotal =parseFloat(MaestroReporte.SubTotal);
        MaestroReporte.IVA =parseFloat(MaestroReporte.IVA);
        MaestroReporte.Total =parseFloat(MaestroReporte.Total);
        // totales
        
        //Ya con los datos listos, validamos que no existan nulos
        if(MaestroReporte.TicketId == undefined || MaestroReporte.TicketId <=0){
          Spinner('myModalReporteServicio', false);
          swal('Favor de revisar los datos','','warning');
          return;
        }
        
        if(clientes == undefined || clientes.length<=0){
          Spinner('myModalReporteServicio', false);
          swal('Agregue al menos un producto','','warning');
          return;
        }
        if(MaestroReporte.Total == undefined || MaestroReporte.Total <=0 || isNaN(MaestroReporte.Total)){
          Spinner('myModalReporteServicio', false);
          swal('Capture los totales del reporte','','warning');
          return;
        }
        MontosRenglon(clientes);
        let vMaestro = [];
        vMaestro.push(MaestroReporte);
        const Maestro = JSON.stringify(vMaestro);
         var myJsonString = JSON.stringify(clientes);
         console.log(myJsonString);
        $.post("../../controller/ctrlReporteServicio.php?op=AddReporteServicio",
          { Maestro : Maestro, Detalle : myJsonString}, 
              function(data){
                     //Obtenemos el Nuevo ReporteServicioId generado para mandarlo como parametro y que se genere el pdf
                     data = JSON.parse(data);
                     if(data.Bandera){
                           Spinner('myModalReporteServicio', false);
                            swal(data.Title, 
                            data.Mensaje, 
                            data.Type);
                            clientes = []; 
                            $("#jsGridReporteServicio").jsGrid("clearInsert");
                            $("#jsGridReporteServicio").jsGrid("reset");
                            $("#jsGridReporteServicio").jsGrid("refresh");
                            $("#jsGridReporteServicio").jsGrid("destroy");
                            $('#SpanSubtotal').text(''); 
                            $('#SpanIVA').text(''); 
                            $('#SpanTotal').text(''); 
                            $('#FormGeneral').trigger("reset");
                            $('#FormDescripcionEquipo').trigger("reset");
                            $('#FormProductosServicios').trigger("reset");
                            CargarListaTickets();
                           //Obtenemos el pdf que se genera
                           //local
                          //  var _url = "http://localhost:8010/tickets/Reportes/ReporteServicio.php?ReporteServicioId="+data.ReporteServicioId+"";
                          //server
                         var _url = "http://ctnredes.com/Reportes/ReporteServicio.php?ReporteServicioId="+data.ReporteServicioId+"";
                         // console.log(_url);
                         //Mandamos a imprimir el reporte
                         printJS({ printable: _url, type: 'pdf', showModal: true })
                         $('#myModalReporteServicio').modal('hide');
                    }else{
                      Spinner('myModalReporteServicio', false);
                      swal(data.Title, 
                        data.Mensaje, 
                        data.Type);
                   }
         });
        });
       });
     //#endregion
     
    //elimina el ticket
        function fnEliminarTicket(TicketId){
        swal({
          title:'Seguro de Eliminar este Ticket?, Se perderan todos los datos perro',
          text:"Se perderan todos los datos",
          type:'warning',
          showCancelButton:true,
          confirmButtonColor:'#3085d6',
          cancelButtonColor:'#d33',
          confirmButtonText:'Si, Borralo Perro',
          cancelButtonText:'No :c',
          confirmButtonClass:'btn btn-success',
          cancelButtonClass:'btn btn-danger',
          buttonsStyling:false,
          reverseButtons:true
        })
        .then((value) => {
        if (value) {
            $.post("../../controller/ctrlTicket.php?op=DeleteTicket",
          {TicketId :TicketId }, function(data){
            CargarListaTickets();
          });
        }
        });
        }

     //Pone el ticket como pagado
        function SetTicketPagado(TicketId){
          swal({
            title:'El Ticket ya fue pagado?',
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
              $.post("../../controller/ctrlTicket.php?op=SetTicketPagado",
            {TicketId :TicketId }, function(data){
              CargarListaTickets();
            });
          }
          });
        }
   //funcion para cargar el grid de los productos
     function LoadGrid(){
    $.ajax({
      type: "GET",
      // url: "http://localhost:8010/jsgridphp/countries/index.php"
      data: {Caso : 0},
      url: '../../controller/ctrlProducto.php?op=ListProductosGridCoti'
  }).done(function(countries) {
  
      countries.unshift({ ProductoId: "0", ProductoConcat: "" });
      //GETDataClients();
      $("#jsGridReporteServicio").jsGrid({
          
          width: "100%",
          filtering: false,
          inserting: true,
          editing: true,
          sorting: true,
          paging: true,
          autoload: true,
          deleteConfirm: "Estas seguro de eliminar la fila?",
          
          controller: {
              loadData: function(filter) {
              // console.log(filter);
                  // return $.ajax({
                  //     type: "GET",
                  //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                  //     data: filter
                  // });
                  //como devuelve 2 valores iguales no se porque, se borran los nulos
                  // return $.grep(clientes, function(client) {
                  //   return (
                  //     (!filter.CotizacionDetId || client.CotizacionDetId.indexOf(filter.CotizacionDetId) > -1) &&
                  //     (!filter.Cantidad || client.Cantidad === filter.Cantidad) &&
                  //     (!filter.Cantidad ||
                  //       client.Cantidad.indexOf(filter.Cantidad) > -1) &&
                  //     (!filter.Cantidad || client.ProductoId === filter.ProductoId) &&
                  //     (filter.Precio === undefined ||
                  //       client.Precio === filter.Precio)
                  //       (filter.ProductoId != client.ProductoId)
                  //   );
                  // });
              },
              insertItem: function(item) {
                  // return $.ajax({
                  //     type: "POST",
                  //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                  //     data: item
                  // });
                    
                    if (item.Cantidad != undefined){
                      clientes.push(
                      {
                        ReporteServicioDetalleId: 0,
                        ReporteServicioId   : 0,
                        ProductoId     : item.ProductoId,
                        Cantidad       : item.Cantidad,
                        Precio         : item.Precio,
                        Total          : item.Total,
                        Comentarios    : item.Comentarios
                      });
                      MontosRenglon(clientes);
                    }              
              },
              updateItem: function(item) {
                  // return $.ajax({
                  //     type: "PUT",
                  //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                  //     data: item
                  // });
              },
              deleteItem: function(item) {
                  // return $.ajax({
                  //     type: "DELETE",
                  //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                  //     data: item
                  // });
                  var clientIndex = $.inArray(item, clientes);
                  clientes.splice(clientIndex, 1);
                  MontosRenglon(clientes);
              }
          },
          onItemUpdating: function(args) {
            // cancel update of the item with empty 'name' field
            if(args.item.Cantidad > 0) {
                //args.cancel = true;
                let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
                args.item.Total = CantidadGrid;
                MontosRenglon(clientes);
            }
        },
        //data : clientes,     
    onItemInserting: function(args) {
      // cancel insertion of the item with empty 'name' field
      if(args.item.Cantidad >0) {
         // args.cancel = true;
         console.log(args.item);
         let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
         args.item.Total = CantidadGrid;
          //alert("Specify the name of the item!");
          MontosRenglon(clientes);
      }
  },
  onItemUpdated: function(args) {
    // cancel update of the item with empty 'name' field
    if(args.item.Cantidad > 0) {
      console.log(args.item);
      let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
      args.item.Total = CantidadGrid;
      MontosRenglon(clientes);
    }
},

onItemEditing: function(args) {
  // cancel editing of the row of item with field 'ID' = 0
  if(args.item.Cantidad > 0) {
    console.log(args.item);
   let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
                args.item.Total = CantidadGrid;
    MontosRenglon(clientes);
  }
},

        fields: [
          {name: "ReporteServicioDetalleId", title: "ReporteServicioDetalleId", visible : false},
          {name: "ReporteServicioId", title: "ReporteServicioId", visible : false},
          { name: "ProductoId", title: "Materiales/Servicios", type: "select", width: 100, items: countries, valueField: "ProductoId", textField: "ProductoConcat" ,
          insertTemplate: function(value, item) {
            console.log('in inserttemplate 0');
               var $select = jsGrid.fields.select.prototype.insertTemplate.call(this);
               $select.addClass('selectpicker form-control');
               $select.attr("data-live-search", "true");
               $select.attr("data-container", "body");
               
               setTimeout(function() {
                   $select.selectpicker({
                       liveSearch: true
                   });		             		
                   $select.selectpicker('refresh');
                   $select.selectpicker('render');
               });
               console.log('in inserttemplate 2');	
               return $select;
           },  
          
          // validate: { message: 'Ya seleccionaste ese producto', validator: function(value, item) { 
          
          // if(value <= 0){
          // Mensaje = 'Favor de seleccionar un producto ;c';
          // return false;
          // }
          //   var gridData = $("#jsGrid").jsGrid("option", "data");
                           
          //   for (i = 0; i < gridData.length; i++) {                                		 
          //         if(value == gridData[i].ProductoId ){
          //         Mensaje = 'Ya seleccionaste ese producto '
          //           return false;
                    
          //         }
          //     }
          //   return true; 
          
          // } }
          },
          {
          name : "Comentarios", title: "Comentarios", type : "text", filtering : false
          
          },
          { name: "Cantidad", title: "Cantidad", type: "number", width: 50, filtering: false,
          validate: { message: "La cantidad debe ser mayor a 0", validator: function(value, item){ return value > 0;}},        
          },
          { name: "Precio", title: "Precio", type: "text", width: 50, filtering: false ,
          validate: { message: "El Precio debe ser mayor a 0", validator: function(value){ return parseFloat(value) > 0;}}
          },
          { name: "Total", title: "Total", width: 50, filtering: false, editable : false ,
        //validate: { message: "El Total debe ser mayor a 0", validator: function(value){ return value;}}
          },
        { type: "control"}
      ]
      });
  
  });         
      }          