
var Factura_TicketId = 0;
var clientes = [];
var CotizacionIdEditar = 0;
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
 // var _url = "http://ctnredes.com/Reportes/ReporteCotizacion.php?CotizacionId="+Id+"";
  
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

//funcion para dar de baja cotizacion
function fnEliminarCotizacion (CotizacionId){

console.log(CotizacionId);
swal({
    title:'Estas seguro de dar de baja la cotizacion?',
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
    $.post("../../controller/ctrlCotizacion.php?op=EliminarCotizacion",
    {CotizacionId : CotizacionId }, function(data){
        fnListaCotizaciones();
    });
  }
  });

}

//funcion que abre un modal para editar la cotizacion
function fnEditarCotizacion(CotizacionId){
     
    $('#SpanModalCotizacionId').text(CotizacionId); 
    $('#CotizacionModId').val(CotizacionId);
    $('#myModal').modal('show');
    CargaDropdownClientes();
    LoadGridProductos(CotizacionId);

}



//#region funciones para editar la cotizacion
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


    //funcion para cargar el grid de los productos
    function LoadGridProductos(CotizacionId){
      $.ajax({
        type: "GET",
        // url: "http://localhost:8010/jsgridphp/countries/index.php"
        data: {Caso : 0},
        url: '../../controller/ctrlProducto.php?op=ListProducto'
    }).done(function(countries) {
    
        countries.unshift({ ProductoId: "0", ProductoConcat: "" });
        //GETDataClients();
        $("#jsGridEditarCotizacion").jsGrid({
            
            width: "100%",
            filtering: false,
            inserting: true,
          editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            deleteConfirm: "Do you really want to delete client?",
            
            controller: {
              loadData: function(filter) {
                return $.ajax({
                    type: "POST",
                    url: "../../controller/ctrlCotizacion.php?op=LoadCotizacionXId",
                    data:{CotizacionId : CotizacionId }
                }).done(function(data, response){
                
                   // data = JSON.parse(data);
                    // console.log(data);
                    clientes.push(data);
                  ///console.log(data.CotizacionDet[0].Cantidad);
                  // for (let index = 0; index < data.CotizacionDet.length; index++) {
                  //  // const element = data.CotizacionDet[index];
                  //  // console.log(data.CotizacionDet[index].Cantidad);
                  //   clientes.push(
                  //     {
                  //       CotizacionDetId: parseInt(data.CotizacionDet[index].CotizacionDetId),
                  //       CotizacionId   : parseInt($('#CotizacionModId').val()),
                  //       ProductoId     : parseInt(data.CotizacionDet[index].ProductoId),
                  //       Cantidad       : parseInt(data.CotizacionDet[index].Cantidad),
                  //       Precio         : parseFloat(data.CotizacionDet[index].Precio),
                  //       Total          : parseFloat(data.CotizacionDet[index].Total),
                  //       Descripcion    : data.CotizacionDet[index].Descripcion
                  //     });
                    
                  // }
                  
                  // console.log(clientes);
                  });
            },
                // loadData: function() {
                // // console.log(filter);
                //     return $.ajax({
                //         type: "POST",
                //         url: "../../controller/ctrlCotizacion.php?op=LoadCotizacionXId",
                //         data:{CotizacionId : CotizacionId }
                // }).done(function(data, response){
                
                //  // data = JSON.parse(data);
                // ///console.log(data.CotizacionDet[0].Cantidad);
                // for (let index = 0; index < data.CotizacionDet.length; index++) {
                //  // const element = data.CotizacionDet[index];
                //  // console.log(data.CotizacionDet[index].Cantidad);
                //   clientes.push(
                //     {
                //       CotizacionDetId: parseInt(data.CotizacionDet[index].CotizacionDetId),
                //       CotizacionId   : parseInt($('#CotizacionModId').val()),
                //       ProductoId     : parseInt(data.CotizacionDet[index].ProductoId),
                //       Cantidad       : parseInt(data.CotizacionDet[index].Cantidad),
                //       Precio         : parseFloat(data.CotizacionDet[index].Precio),
                //       Total          : parseFloat(data.CotizacionDet[index].Total),
                //       Descripcion    : data.CotizacionDet[index].Descripcion
                //     });
                  
                // }
                
                // console.log(clientes);
                // });
                //     //como devuelve 2 valores iguales no se porque, se borran los nulos
                //     // return $.grep(clientes, function(client) {
                //     //   return (
                //     //     (!filter.CotizacionDetId || client.CotizacionDetId.indexOf(filter.CotizacionDetId) > -1) &&
                //     //     (!filter.Cantidad || client.Cantidad === filter.Cantidad) &&
                //     //     (!filter.Cantidad ||
                //     //       client.Cantidad.indexOf(filter.Cantidad) > -1) &&
                //     //     (!filter.Cantidad || client.ProductoId === filter.ProductoId) &&
                //     //     (filter.Precio === undefined ||
                //     //       client.Precio === filter.Precio)
                //     //       (filter.ProductoId != client.ProductoId)
                //     //   );
                //     // });
                // },
                insertItem: function(item) {
                    // return $.ajax({
                    //     type: "POST",
                    //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                    //     data: item
                    // });
                      
                      if (item.Cantidad != undefined){
                        clientes.push(
                        {
                          CotizacionDetId: 0,
                          CotizacionId   : $('#CotizacionModId').val(),
                          ProductoId     : item.ProductoId,
                          Cantidad       : item.Cantidad,
                          Precio         : item.Precio,
                          Total          : item.Total
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
        //  data : clientes,     
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
//controller: clientes,
          fields: [
            {name: "CotizacionDetId", title: "CotizacionDetId", visible : false},
            {name: "CotizacionId", title: "CotizacionId", visible : false},
            { name: "ProductoId", title: "Producto", type: "select", width: 100, items: countries, valueField: "ProductoId", textField: "ProductoConcat" ,
            validate: { message: 'Ya seleccionaste ese producto', validator: function(value, item) { 
            
            if(value <= 0){
            Mensaje = 'Favor de seleccionar un producto ;c';
            return false;
            }
              var gridData = $("#jsGrid").jsGrid("option", "data");
                             
              for (i = 0; i < gridData.length; i++) {                                		 
                    if(value == gridData[i].ProductoId ){
                    Mensaje = 'Ya seleccionaste ese producto '
                      return false;
                      
                    }
                }
              return true; 
            
            } }
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
      //Cargamos el grid
    

//#endregion

//#region carga el dropdown de clientes(usuarios)
function CargaDropdownClientes(){
  $.post("../../controller/ctrlUsuario.php?op=ListaUsuariosClientes",
   function(data){
    $('#Cotizacion_ClienteId').html(data);
  });
}
//#endregion

//#region funcion que obtiene el evento onchange del select de clientes y asi cargamos el nombre del cliente al input
function GetUsuarioCliente(){
  //Se obtiene el valor seleccionado
  var select = document.getElementById('Cotizacion_ClienteId');
                var option = select.options[select.selectedIndex];
        var UsuarioId = option.value;
        //llamamos al servicio para obtener los datos del cliente y mostrarlos en el input
  $.post("../../controller/ctrlUsuario.php?op=GetUsuario",
  {UsuarioId : UsuarioId }, function(data){
      data = JSON.parse(data);//parseamos a objeto json los valores de la bd
      $('#Cotizacion_NombreCliente').val(data.RazonSocial);
      $('#Cotizacion_Correo').val(data.Correo);
  });
}

//#region funcion que se encarga de guardar los datos de la cotizacion
$(() => {
  $('#BtnEditarcotizacion').click(e => { 
  e.preventDefault();
console.log(clientes);
          });
          });
        
      //#endregion