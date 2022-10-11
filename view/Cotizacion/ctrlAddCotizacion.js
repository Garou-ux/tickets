//#region Variables
var tabla;
var TmpMaestro = {};
var f = 0;
var clientes = [];
//#endregion
//aqui se obtiene el parametro enviado, que viene siendo el id de la cotizacion
window.$_GET = new URLSearchParams(location.search);
var CotizacionId = $_GET.get('CotizacionId');



//Si cotizacionid es 0, significa que sera una nueva, si es>0 es una cotizacion a editar
if(CotizacionId == 0){
    $('#TituloPagina').text('Nueva Cotización');
}
if(CotizacionId>0){
    $('#TituloPagina').text('Cotización #'+CotizacionId+''); 
}

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


//#endregion

//#region Seccion para el grid de material/productos

//#region Carga el array que contendra las columnas del gridmateriales
//Array que contendra los datos de la tabla de servicios
var GridProductoMaterial = [
    {
      Codigo: '<select style="width:150px"  id="ProductoMaterialId0"  class="form-control" onChange="fnSeleccProducto(0)"> '
    + '  <option value="">Seleccionar..</option> '
     + '</select>',
     Nombre: '<input style="width: 300px" type="text" id="txProductoConcatMaterial0" class="form-control" >',
      Cantidad: '<input type="number" id="txCantidadMaterial0" class="form-control" onChange="MontosRenglon(0)">',
      Precio: '<input type="number" id="txPrecio0" class="form-control" onChange="MontosRenglon(0)">',
      Total: '<input type="number" id="txTotal0" class="form-control" disabled>',
      Agregar_Eliminar : '<button type="button" id="AddFilaGridMaterial"  class="btn btn-inline btn-success btn-sm ladda-button"><div><i class="fa fa-plus"></i></div></button>',
    }
    ];
    //contendra el cuerpo de la tabla
    var tableBody = "";
    //almacenara las columnas
    var columns = [];
  
    // se crean las columnas dela tabla
    tableBody = tableBody + "<tr>";
    for(var prop in GridProductoMaterial[0]) {
      if(GridProductoMaterial[0].hasOwnProperty(prop)) {
  
        tableBody = tableBody + ("<th>" + prop + "</th>");
  
        // lista de columnas.
        columns.push(prop);
      }
    }
  
    tableBody = tableBody + "</tr>";
  
  
    // se crean las filas de la tabla
    GridProductoMaterial.forEach(function(row) {
      // se crea una fila por cada indice del array
      tableBody = tableBody + "<tr>";
  
      columns.forEach(function(cell) {
        // Cell es el nombre de cada columna
        // row[cell] obtiene el valor de cada fila
        tableBody = tableBody + "<td>" + row[cell] + "</td>";
      });
  
      tableBody = tableBody + "</tr>";
    });
    //agregamos el cuerpo de la tabla
    $("#GridMateriales").append(tableBody);
  
    //Se llena el primer dropdown
  // $.post("../../controller/ctrlProducto.php?op=ListProducto",
  // {Caso : 0}, function(data){
  // $('#ProductoMaterialId0').html(data);
  // });
  //funcion que llena el dropdown de servicios
  function CargaDropdownProductos(Id){
  $.post("../../controller/ctrlProducto.php?op=ListProducto",
  {Caso : 0}, function(data){
    $('#ProductoMaterialId'+Id+'').html(data);
  });
  }
  
  //#endregion
  
  //#region funcion selecciona producto: detecta cuando se selecciona un producto en el dropdown de gridservicios, obteniendo los datos del producto
  function fnSeleccProducto(index){
    var select = document.getElementById('ProductoMaterialId'+index+'');
                  var option = select.options[select.selectedIndex];
          var ProductoId = option.value;
          // console.log(ProductoId);
          $.post("../../controller/ctrlProducto.php?op=GetProducto",
          {ProductoId : ProductoId}, function(data){
            data = JSON.parse(data);//parseamos a objeto json los valores de la bd
  $('#txProductoConcatMaterial'+index+'').val(data.Descripcion);
            // console.log(data.Descripcion);
          });
  
  
  }
  //#endregion
  
  //#region Eliminar/Agregar filas al grid de servicios
  $("#AddFilaGridMaterial").click(function (){
    // alert('uwu');
    f+=1; //ira aumentando el indice por cada fila agregada
  
    GridProductoMaterial.push({
      Codigo: '<select style="width:150px"  id="ProductoMaterialId'+f+'"  class="form-control" onChange="fnSeleccProducto('+f+')"> '
    + '  <option value="">Seleccionar..</option> '
     + '</select>',
     Nombre: '<input style="width: 300px" type="text" id="txProductoConcatMaterial'+f+'" class="form-control" >',
      Cantidad: '<input type="number" id="txCantidadMaterial'+f+'" class="form-control" onChange="MontosRenglon('+f+')">',
      Precio: '<input type="number" id="txPrecio'+f+'" class="form-control" onChange="MontosRenglon('+f+')">',
      Total: '<input type="number" id="txTotal'+f+'" class="form-control" disabled>',
      Agregar_Eliminar : '<button type="button" id="'+f+'" class="btn btn-inline btn-danger btn-sm ladda-button btn_row_deleteMaterial"><div><i class="fa fa-trash"></i></div></button>'})
  
      //Cargamos el dropdown
      CargaDropdownProductos(f);
      // Se crean las filas
      GridProductoMaterial.forEach(function(row) {
        //se crea la fila de la tabla con su indice.
        tableBody = '<tr id="rowMaterial'+f+'">';
  
        columns.forEach(function(cell) {
          // Cell es el nombre de cada columna
            // row[cell] obtiene el valor de cada fila
          tableBody = tableBody + "<td>" + row[cell] + "</td>";
        });
  
        tableBody = tableBody + "</tr>";
      });
  
      $("#GridMateriales").append(tableBody);
  
    });
  
  
    //funcion para eliminar fila de la tabla gridservicios
    $(document).on('click','.btn_row_deleteMaterial', function(){
  
  
        var row_id = $(this).attr("id"); //se obtiene el id de la fila
        f-=1; //se resta el indice
        //Eliminanos el index del array
        GridProductoMaterial.splice(f,1);
        //elimina la fila de la tabla
        $('#rowMaterial'+row_id+'').remove();
        // console.log(GridProductoMaterial);
  
    });
  
    //#endregion
  
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
//#region funcion que se encarga de guardar los datos de la cotizacion
$(() => {
    $('#BtnGuardaCotizacion').click(e => { 
    e.preventDefault();
    Spinner('ContentCotizacion', true);
      //Ahora obtenemos los datos en general (Maestro)
      let MaestroReporte ={};  
      MaestroReporte.CotizacionId = Number(CotizacionId);
      MaestroReporte.ClienteId = $("#Cotizacion_ClienteId").val();
      MaestroReporte.ClienteId = Number(MaestroReporte.ClienteId);
      MaestroReporte.Contacto = $("#Cotizacion_Contacto").val();
      MaestroReporte.Correo = $("#Cotizacion_Correo").val();
      //totales
      //Se recalculan los totales
      MontosRenglon(clientes);
      MaestroReporte.SubTotal = $("#SpanSubtotal").text();
      MaestroReporte.IVA = $("#SpanIVA").text();
      MaestroReporte.Total = $("#SpanTotal").text();   
      MaestroReporte.SubTotal =parseFloat(MaestroReporte.SubTotal);
      MaestroReporte.IVA =parseFloat(MaestroReporte.IVA);
      MaestroReporte.Total =parseFloat(MaestroReporte.Total);
      // totales 
      // //Ya con los datos listos, validamos que existan nulos
      if(MaestroReporte.Total == undefined || MaestroReporte.Total <=0 || isNaN(MaestroReporte.Total)){
        swal('Capture los totales del reporte','','warning');
        Spinner('ContentCotizacion', false);
        return;
      }
      //Datos
      console.log(MaestroReporte);
      
      if( MaestroReporte.ClienteId === 0 ||  MaestroReporte.ClienteId === null ||  MaestroReporte.ClienteId === undefined){
        swal('Selecciona el cliente','','warning');
        Spinner('ContentCotizacion', false);
         return;
      }
      
      if( MaestroReporte.Contacto === '' ||  MaestroReporte.Contacto === null ||  MaestroReporte.Contacto === undefined){
        swal('Captura el contacto','','warning');
        Spinner('ContentCotizacion', false);
         return;
      }
      
      if( MaestroReporte.Correo === '' ||  MaestroReporte.Correo === null ||  MaestroReporte.Correo === undefined){
        swal('Captura el correo','','warning');
        Spinner('ContentCotizacion', false);
         return;
      }
      
      if(clientes.length <= 0){
        swal('Captura al menos un producto','','warning');
        Spinner('ContentCotizacion', false);
         return;
      }
      let vMaestro = [];
      let tmpDetalle = [];
      vMaestro.push(MaestroReporte);
      const Maestro = JSON.stringify(vMaestro);
      //console.log(Maestro);
       let bandera = false;
       //validamos los nulos y los repetidos
      //  for(let i = 0; i< clientes.length; i++){
      //  //validamos los productos repetidos
      //  let Producto = clientes[i].ProductoId;
      //  if(clientes.length == 1 &&  (clientes[i].Cantidad > 0 && clientes[i].Precio > 0 && clientes[i].Total > 0) ){
      //   tmpDetalle.push({
      //     CotizacionDetId:0,
      //     CotizacionId:0,
      //     ProductoId:  clientes[i].ProductoId,
      //     Cantidad:clientes[i].Cantidad,
      //     Precio: clientes[i].Precio,
      //     Total: clientes[i].Total
      //   });
      //   bandera = true;
      //  }
      //  else if(clientes.length > 1 && (clientes[i].ProductoId != Producto) && (clientes[i].Cantidad > 0 && clientes[i].Precio > 0 && clientes[i].Total > 0)){
      //   tmpDetalle.push({
      //     CotizacionDetId:0,
      //     CotizacionId:0,
      //     ProductoId:  clientes[i].ProductoId,
      //     Cantidad:clientes[i].Cantidad,
      //     Precio: clientes[i].Precio,
      //     Total: clientes[i].Total
      //   });
      //   bandera = true;
      //  } else{
       
      //   // swal('Existen datos repetidos o revisa que las cantidades, precios y totales sean > 0','','warning');
      //   // Spinner('ContentCotizacion', false);
      //   // bandera = false;
      //   // break;
         
      //  }
    
      //  }
      //  if(!bandera){
      //   Spinner('ContentCotizacion', false);
      //  return;
       
      //  }
       var myJsonString = JSON.stringify(clientes);
       console.log(myJsonString);
     
     $.post("../../controller/ctrlCotizacion.php?op=AddCotizacion",
          { Maestro: Maestro , Detalle : myJsonString}, 
          function(data){
           //Obtenemos el Nuevo ReporteServicioId generado para mandarlo como parametro y que se genere el pdf
          //  title: '',
          //  text: '',
          //  type: null,
           data = JSON.parse(data);
           if(data.Bandera){
            // swal({
            //   title : data.Title,
            //   text  : data.Mensaje,
            //   type  : data.Type,
            // //   });
            //   swal({
            //     text: data.Mensaje,
            //     title : data.Title,
            //     type: 'warning'
            //   }
            //  );
            swal(data.Title, data.Mensaje, data.Type);
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
            LoadGrid();
            Spinner('ContentCotizacion', false);
          // //Obtenemos el pdf que se genera
          // //local
          // console.log(data.CotizacionId);
          var _url = "http://localhost:8010/tickets/Reportes/ReporteCotizacion.php?CotizacionId="+data.CotizacionId+"";
          
          // //server
          //  var _url = "http://ctnredes.com/Reportes/ReporteServicio.php?ReporteServicioId="+data.ReporteServicioId+"";
          
          
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
              Spinner('ContentCotizacion', false);
           }
            });
            });
            });
        //#endregion
          //Ejecutamos la funcion para llenar el select de los clientes
          CargaDropdownClientes();
          // GETDataClients();
          //console.log(clientes);
          var Mensaje = '';
          //funcion para cargar el grid de los productos
          function LoadGrid(){
            $.ajax({
              type: "GET",
              // url: "http://localhost:8010/jsgridphp/countries/index.php"
              data: {Caso : 0},
              url: '../../controller/ctrlProducto.php?op=ListProducto'
          }).done(function(countries) {
          
              countries.unshift({ ProductoId: "0", ProductoConcat: "" });
              //GETDataClients();
              $("#jsGrid").jsGrid({
                  
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
                      // console.log(filter);
                          // return $.ajax({
                          //     type: "GET",
                          //     url: "http://localhost:8010/jsgridphp/clients/index.php",
                          //     data: filter
                          // });
                          //como devuelve 2 valores iguales no se porque, se borran los nulos
                          return $.grep(clientes, function(client) {
                            return (
                              (!filter.CotizacionDetId || client.CotizacionDetId.indexOf(filter.CotizacionDetId) > -1) &&
                              (!filter.Cantidad || client.Cantidad === filter.Cantidad) &&
                              (!filter.Cantidad ||
                                client.Cantidad.indexOf(filter.Cantidad) > -1) &&
                              (!filter.Cantidad || client.ProductoId === filter.ProductoId) &&
                              (filter.Precio === undefined ||
                                client.Precio === filter.Precio)
                                (filter.ProductoId != client.ProductoId)
                            );
                          });
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
                                CotizacionDetId: 0,
                                CotizacionId   : 0,
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
                        let CantidadGrid = args.item.Cantidad * args.item.Precio;
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
                 let CantidadGrid = args.item.Cantidad * args.item.Precio;
                 args.item.Total = CantidadGrid;
                  //alert("Specify the name of the item!");
                  MontosRenglon(clientes);
              }
          },
          onItemUpdated: function(args) {
            // cancel update of the item with empty 'name' field
            if(args.item.Cantidad > 0) {
              console.log(args.item);
              let CantidadGrid = args.item.Cantidad * args.item.Precio;
              args.item.Total = CantidadGrid;
              MontosRenglon(clientes);
            }
        },
        
        onItemEditing: function(args) {
          // cancel editing of the row of item with field 'ID' = 0
          if(args.item.Cantidad > 0) {
            console.log(args.item);
            let CantidadGrid = args.item.Cantidad * args.item.Precio;
            args.item.Total = CantidadGrid;
            MontosRenglon(clientes);
          }
      },
    
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
                  { name: "Precio", title: "Precio", type: "number", width: 50, filtering: false ,
                  validate: { message: "El Precio debe ser mayor a 0", validator: function(value){ return value > 0;}}
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
        LoadGrid();