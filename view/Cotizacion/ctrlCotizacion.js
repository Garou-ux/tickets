
var Factura_TicketId = 0;
var clientes = null;
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
 //var _url = "http://localhost:8010/tickets/Reportes/ReporteCotizacion.php?CotizacionId="+Id+"";
  
  //server
  var _url = "http://ctnredes.com/Reportes/ReporteCotizacion.php?CotizacionId="+Id+"";
  
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
    $.ajax({
      type: "POST",
      url: "../../controller/ctrlCotizacion.php?op=LoadCotizacionXId",
      data:{CotizacionId : CotizacionId }
  }).done(function(data, response){             
     // data = JSON.parse(data);
      // console.log(data);     
      $('#Cotizacion_Contacto').val(data.Cotizacion[0].Contacto);
      $('#Cotizacion_Correo').val(data.Cotizacion[0].Correo);
      $("#Cotizacion_ClienteId").val(data.Cotizacion[0].UsuarioId);
    });
    LoadGridProductos(CotizacionId);

}



//#region funciones para editar la cotizacion
  //#region Funcion para calcular lo totales de la cotizacion
  function MontosRenglon(ObjectTotales){
    var Cantidad =0, Precio = 0, Total = 0;
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
            url: '../../controller/ctrlProducto.php?op=ListProductosGridCoti'
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
                deleteConfirm: "Estas seguro de eliminar el registo?",          
                controller: {
                  loadData: function(filter) {
                    return $.ajax({
                        type: "POST",
                        url: "../../controller/ctrlCotizacion.php?op=LoadCotizacionDetXId",
                        data:{CotizacionId : CotizacionId }
                    }).done(function(data, response){               
                      var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                      MontosRenglon(datagrid); 
                      });
                },
                    insertItem: function(item) {           
                          if (item.Cantidad != undefined){
                          item.CotizacionDetId = 0;
                          item.CotizacionId = parseInt($('#CotizacionModId').val());
                          var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                          MontosRenglon(datagrid);
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
                        //     type: "POST",
                        //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                        //     data: item
                        // });
                        // var clientIndex = $.inArray(item, clientes);
                        // clientes.splice(clientIndex, 1);
                        var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                        MontosRenglon(datagrid);
                    }
                },

                onItemUpdating: function(args) {
                  // cancel update of the item with empty 'name' field
                  if(args.item.Cantidad > 0) {
                      //args.cancel = true;
                      let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
                      args.item.Total = CantidadGrid;
                      var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                      MontosRenglon(datagrid);
                  }
              },
          onItemInserting: function(args) {
            if(args.item.Cantidad >0) {
               let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
               args.item.Total = CantidadGrid;
                var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                MontosRenglon(datagrid);
            }
        },
        onItemUpdated: function(args) {
          if(args.item.Cantidad > 0) {
            let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
            args.item.Total = CantidadGrid;
            var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
            MontosRenglon(datagrid);
          }
      },
      onItemEditing: function(args) {
        if(args.item.Cantidad > 0) {
         let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
                      args.item.Total = CantidadGrid;
                      var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
          MontosRenglon(datagrid);
        }
    },
          fields : [
           {name : "CotizacionDetId", title: "CotizacionDetId", visible : false},
           {name : "CotizacionId", title: "CotizacionId", visible : false},
          { name : "ProductoId", title: "Producto", type: "select", width: 100, items: countries, /*valueField: "ProductoId",*/ textField: "ProductoConcat" ,
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
        // validate : { message: 'Ya seleccionaste ese producto', validator: function(value, item) {
        
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
            name : "Descripcion", title: "Descripcion", type : "text", filtering : false
        
        },
          { name : "Cantidad", title: "Cantidad", type: "number", width: 50, filtering: false,
        validate : { message: "La cantidad debe ser mayor a 0", validator: function(value, item){ return value > 0;}},
        },
          { name : "Precio", title: "Precio", type: "text", width: 50, filtering: false ,
        validate : { message: "El Precio debe ser mayor a 0", validator: function(value){ return parseFloat(value) > 0;}}
        },
          { name : "Total", title: "Total", width: 50, filtering: false, editable : false ,
      //validate : { message: "El Total debe ser mayor a 0", validator: function(value){ return value;}}
        },
          { type : "control"}
      ]
        });
    
    });         
    }
//#endregion

//#region carga el dropdown de clientes(usuarios)
function CargaDropdownClientes(){
  $.post("../../controller/ctrlUsuario.php?op=ListaUsuariosClientes",
   function(data){
    $('#Cotizacion_ClienteId').html(data);
  });
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
    Spinner('myModal', true);
   // console.log(clientes);
   var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
      //Ahora obtenemos los datos en general (Maestro)
      let MaestroReporte ={};  
      MaestroReporte.CotizacionId =  parseInt($('#CotizacionModId').val());
      MaestroReporte.ClienteId = $("#Cotizacion_ClienteId").val();
      MaestroReporte.ClienteId = Number(MaestroReporte.ClienteId);
      MaestroReporte.Contacto = $("#Cotizacion_Contacto").val();
      MaestroReporte.Correo = $("#Cotizacion_Correo").val();
      //totales
      //Se recalculan los totales
      MontosRenglon(datagrid);
      MaestroReporte.SubTotal = $("#SpanSubtotal").text();
      MaestroReporte.IVA = $("#SpanIVA").text();
      MaestroReporte.Total = $("#SpanTotal").text();   
      MaestroReporte.SubTotal =parseFloat(MaestroReporte.SubTotal);
      MaestroReporte.IVA =parseFloat(MaestroReporte.IVA);
      MaestroReporte.Total =parseFloat(MaestroReporte.Total);
      // totales 
      // //Ya con los datos listos, validamos que existan nulos
      if(MaestroReporte.Total == undefined || MaestroReporte.Total <=0 || isNaN(MaestroReporte.Total)){
        swal('Capture los totales del reporte','O da click en la tabla para calcularlos en automatico','warning');
        Spinner('myModal', false);
        return;
      }
      //Datos
    //  console.log(MaestroReporte);
      
      if( MaestroReporte.ClienteId === 0 ||  MaestroReporte.ClienteId === null ||  MaestroReporte.ClienteId === undefined){
        swal('Selecciona el cliente','','warning');
        Spinner('myModal', false);
         return;
      }
      
      if( MaestroReporte.Contacto === '' ||  MaestroReporte.Contacto === null ||  MaestroReporte.Contacto === undefined){
        swal('Captura el contacto','','warning');
        Spinner('myModal', false);
         return;
      }
      
      if( MaestroReporte.Correo === '' ||  MaestroReporte.Correo === null ||  MaestroReporte.Correo === undefined){
        swal('Captura el correo','','warning');
        Spinner('myModal', false);
         return;
      }
      
      if(datagrid.length <= 0){
        swal('Captura al menos un producto','','warning');
        Spinner('myModal', false);
         return;
      }
      let vMaestro = [];
      let tmpDetalle = [];
      vMaestro.push(MaestroReporte);
      const Maestro = JSON.stringify(vMaestro);
      //console.log(Maestro);
       let bandera = false;
       var myJsonString = JSON.stringify(clientes);
       //console.log(myJsonString);
       
       console.log(datagrid);
       var myJsonString = JSON.stringify(datagrid);
        console.log(myJsonString);
      // return;
     //return;
     $.post("../../controller/ctrlCotizacion.php?op=EditarCotizacion",
          { Maestro: Maestro , Detalle : myJsonString}, 
          function(data){
           //Obtenemos el Nuevo ReporteServicioId generado para mandarlo como parametro y que se genere el pdf
          //  title: '',
          //  text: '',
          //  type: null,
           data = JSON.parse(data);
           if(data.Bandera){
            swal(data.Title, 
            data.Mensaje, 
            data.Type);
            clientes = []; 
            $("#jsGrid").jsGrid("clearInsert");
            $("#jsGrid").jsGrid("reset");
            $("#jsGrid").jsGrid("refresh");
            $("#jsGrid").jsGrid("destroy");
            $('#SpanSubtotal').text(''); 
            $('#SpanIVA').text(''); 
            $('#SpanTotal').text(''); 
            $('#Cotizacion_Contacto').val('');
            $('#Cotizacion_Correo').val('');
           // LoadGrid();
            Spinner('myModal', false);
            fnListaCotizaciones();
            $('#myModal').modal('hide');
           // fnEditarCotizacion(data.CotizacionId);
          // //Obtenemos el pdf que se genera
          // //local
          // console.log(data.CotizacionId);
       // var _url = "http://localhost:8010/tickets/Reportes/ReporteCotizacion.php?CotizacionId="+data.CotizacionId+"";     
          // //server
       var _url = "http://ctnredes.com/Reportes/ReporteCotizacion.php?CotizacionId="+data.CotizacionId+"";     
        // console.log(_url);
          // //Mandamos a imprimir el reporte
        printJS({ printable: _url, type: 'pdf', showModal: true });
        // LimpiarDatosReporteServicio();
           }else{
            swal({
              title : data.Title,
              text  : data.Mensaje,
              type  : data.Type,
              });
              Spinner('myModal', false);
           }
            });
            });
            });
        
              //#endregion
        //       var db = {

        //         loadData: function(filter) {
        //             return $.grep(this.clients, function(client) {
        //                 return (!filter.Name || client.Name.indexOf(filter.Name) > -1)
        //                     && (!filter.Age || client.Age === filter.Age)
        //                     && (!filter.Address || client.Address.indexOf(filter.Address) > -1)
        //                     && (!filter.Country || client.Country === filter.Country)
        //                     && (filter.Married === undefined || client.Married === filter.Married);
        //             });
        //         },
        
        //         insertItem: function(insertingClient) {
        //             this.clients.push(insertingClient);
        //         },
        
        //         updateItem: function(updatingClient) { },
        
        //         deleteItem: function(deletingClient) {
        //             var clientIndex = $.inArray(deletingClient, this.clients);
        //             this.clients.splice(clientIndex, 1);
        //         }
        
        //     };
        
        //     window.db = db;
        
        // db.countries = [
        //     { Name: "", Id: 0 },
        //     { Name: "United States", Id: 1 },
        //     { Name: "Canada", Id: 2 },
        //     { Name: "United Kingdom", Id: 3 },
        //     { Name: "France", Id: 4 },
        //     { Name: "Brazil", Id: 5 },
        //     { Name: "China", Id: 6 },
        //     { Name: "Russia", Id: 7 }
        // ];
        
        // db.clients = [
        //     {
        //         "Name": "Otto Clay",
        //         "Age": 61,
        //         "Country": 6,
        //         "Address": "Ap #897-1459 Quam Avenue",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Connor Johnston",
        //         "Age": 73,
        //         "Country": 7,
        //         "Address": "Ap #370-4647 Dis Av.",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Lacey Hess",
        //         "Age": 29,
        //         "Country": 7,
        //         "Address": "Ap #365-8835 Integer St.",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Timothy Henson",
        //         "Age": 78,
        //         "Country": 1,
        //         "Address": "911-5143 Luctus Ave",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Ramona Benton",
        //         "Age": 43,
        //         "Country": 5,
        //         "Address": "Ap #614-689 Vehicula Street",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Ezra Tillman",
        //         "Age": 51,
        //         "Country": 1,
        //         "Address": "P.O. Box 738, 7583 Quisque St.",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Dante Carter",
        //         "Age": 59,
        //         "Country": 1,
        //         "Address": "P.O. Box 976, 6316 Lorem, St.",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Christopher Mcclure",
        //         "Age": 58,
        //         "Country": 1,
        //         "Address": "847-4303 Dictum Av.",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Ruby Rocha",
        //         "Age": 62,
        //         "Country": 2,
        //         "Address": "5212 Sagittis Ave",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Imelda Hardin",
        //         "Age": 39,
        //         "Country": 5,
        //         "Address": "719-7009 Auctor Av.",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Jonah Johns",
        //         "Age": 28,
        //         "Country": 5,
        //         "Address": "P.O. Box 939, 9310 A Ave",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Herman Rosa",
        //         "Age": 49,
        //         "Country": 7,
        //         "Address": "718-7162 Molestie Av.",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Arthur Gay",
        //         "Age": 20,
        //         "Country": 7,
        //         "Address": "5497 Neque Street",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Xena Wilkerson",
        //         "Age": 63,
        //         "Country": 1,
        //         "Address": "Ap #303-6974 Proin Street",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Lilah Atkins",
        //         "Age": 33,
        //         "Country": 5,
        //         "Address": "622-8602 Gravida Ave",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Malik Shepard",
        //         "Age": 59,
        //         "Country": 1,
        //         "Address": "967-5176 Tincidunt Av.",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Keely Silva",
        //         "Age": 24,
        //         "Country": 1,
        //         "Address": "P.O. Box 153, 8995 Praesent Ave",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Hunter Pate",
        //         "Age": 73,
        //         "Country": 7,
        //         "Address": "P.O. Box 771, 7599 Ante, Road",
        //         "Married": false
        //     },
        //     {
        //         "Name": "Mikayla Roach",
        //         "Age": 55,
        //         "Country": 5,
        //         "Address": "Ap #438-9886 Donec Rd.",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Upton Joseph",
        //         "Age": 48,
        //         "Country": 4,
        //         "Address": "Ap #896-7592 Habitant St.",
        //         "Married": true
        //     },
        //     {
        //         "Name": "Jeanette Pate",
        //         "Age": 59,
        //         "Country": 2,
        //         "Address": "P.O. Box 177, 7584 Amet, St.",
        //         "Married": false
        //     }
        // ];
        

            //   $("#jsGrid1").jsGrid({
            //     height: 300,
            //     width: "100%",
            // inserting: true,
            //     selecting: true,
            //     autoload: true,
            
            //     pageSize: 15,
            //     pageButtonCount: 5,
            
            //     deleteConfirm: "Do you really want to delete the client?",
            
            //     controller: db,
            
            //     rowRenderer: function(item) {
            //         var $row = $('<tr>');            
            
            //         this._renderCells($row, item);
                    
            //         $row.attr("id", "popover");
                    
            //         $row.attr("data-content", item.Address);
                    
            //         $row.attr("title", item.Name);
                    
            //         return $row;
            //             },
            
            //     fields: [
            //         { name: "Name", type: "textarea", width: 150 },
            //         { name: "Age", type: "number", width: 50 },
            //         { name: "Address", type: "text", width: 200 },
            //         { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name",
            // insertTemplate: function(value, item) {
            //                          console.log('in inserttemplate 0');
            //                             var $select = jsGrid.fields.select.prototype.insertTemplate.call(this);
            //                             $select.addClass('selectpicker form-control');
            //                             $select.attr("data-live-search", "true");
            //                 $select.attr("data-container", "body");
                                        
            //                             setTimeout(function() {
            //                                 $select.selectpicker({
            //                                     liveSearch: true
            //                                 });		             		
            //                                 $select.selectpicker('refresh');
            //                                 $select.selectpicker('render');
            //                             });
            //                             console.log('in inserttemplate 2');	
            //                             return $select;
            //                         },            
            //         },
            //         { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
            //         { type: "control" }
            //     ]
            // });
            
            // $("tr[id=popover]").popover({placement:"top",trigger:"hover"});