//#region Variables

var tabla;
var UsuarioId =  $('#UsuarioId').val();
var RolId =  $('#RolId').val();
var MaestroTicketId;
var TicketEStatus;
var k = 0;
var f = 0;
//#endregion

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
    $("#TabReporteServicio").show();
    $("#TabDetalleTicket").hide();
    $("#BotonRegresar").hide();
    $("#TabGeneral").hide();
    $("#TabContentDet").hide();
    $("#TicketIdReporte").val(TicketId);

    //Obtenemos el cliente id y el nombre del cliente que pertenece al ticket
    $.post("../../controller/ctrlTicket.php?op=GetTicketXId",
{TicketId : TicketId}, function(data){
 var Cliente = JSON.parse(data);//parseamos a objeto json los valores de la bd
  $('#Cliente').val(Cliente.Nombre);
  $("#ClienteIdReporte").val(Cliente.UsuarioId);
  $("#Soporte").val(Cliente.Soporte);
  $("#CategoriaReporte").val(Cliente.Categoria);
  $("#CategoriaIdReporte").val(Cliente.CategoriasId);
});
}

//#endregion

//#region Seccion para el grid de servicios

//#region Grid Servicios, aqui se llenan los datos de la tabla de servicios usados


//Array que contendra los datos de la tabla de servicios
var GridServicios = [
    {
      Codigo: '<select style="width:150px"  id="ProductoServicioId0"  class="form-control" onChange="fnSeleccProductoServicio(0)"> '
    + '  <option value="">Seleccionar..</option> '
     + '</select>',
     Nombre: '<input style="width: 300px" type="text" id="txProductoConcat0" class="form-control" disabled>',
      Cantidad: '<input type="number" id="txCantidad0" class="form-control">',
      Precio: '<input type="number" id="txPrecioServicio0" class="form-control" onChange="MontosRenglonServicio(0)">',
      Total: '<input type="number" id="txTotalServicio0" class="form-control" disabled>',
      Comentarios: '<input type="text" id="txComentarios'+k+'" class="form-control">',
      Agregar_Eliminar : '<button type="button" id="AddFilaGridServicio"  class="btn btn-inline btn-success btn-sm ladda-button"><div><i class="fa fa-plus"></i></div></button>',
    }
    ];
    //contendra el cuerpo de la tabla
    var tableBody = "";
    //almacenara las columnas
    var columns = [];

    // se crean las columnas dela tabla
    tableBody =  tableBody = '<tr>';
    for(var prop in GridServicios[0]) {
      if(GridServicios[0].hasOwnProperty(prop)) {

        tableBody = tableBody + ("<th>" + prop + "</th>");

        // lista de columnas.
        columns.push(prop);
      }
    }

    tableBody = tableBody + "</tr>";


    // se crean las filas de la tabla
    GridServicios.forEach(function(row) {
      // se crea una fila por cada indice del array
      tableBody = tableBody + '<tr id="row'+k+'">';

      columns.forEach(function(cell) {
        // Cell es el nombre de cada columna
        // row[cell] obtiene el valor de cada fila
        tableBody = tableBody + "<td>" + row[cell] + "</td>";
      });

      tableBody = tableBody + "</tr>";
    });
    //agregamos el cuerpo de la tabla
    $("#GridServicios").append(tableBody);

    //Se llena e primer dropdown
$.post("../../controller/ctrlProducto.php?op=ListProducto",
{Caso : 2}, function(data){
  $('#ProductoServicioId0').html(data);
});
//funcion que llena el dropdown de servicios
function CargaDropdownProductosServicio(Id){
  $.post("../../controller/ctrlProducto.php?op=ListProducto",
  {Caso : 2}, function(data){
    $('#ProductoServicioId'+Id+'').html(data);
  });
}
//#endregion


//#region funcion selecciona producto: detecta cuando se selecciona un producto en el dropdown de gridservicios, obteniendo los datos del producto
function fnSeleccProductoServicio(index){
  var select = document.getElementById('ProductoServicioId'+index+'');
				var option = select.options[select.selectedIndex];
        var ProductoId = option.value;
        // console.log(ProductoId);
        $.post("../../controller/ctrlProducto.php?op=GetProducto",
        {ProductoId : ProductoId}, function(data){
          data = JSON.parse(data);//parseamos a objeto json los valores de la bd
$('#txProductoConcat'+index+'').val(data.Descripcion);
          // console.log(data.Descripcion);

          // MaestroServicios.push({
          //   ReporteServicioId :0,
          //   ProductoId : ProductoId
          // });

        });


}
//#endregion

//#region Eliminar/Agregar filas al grid de servicios
$("#AddFilaGridServicio").click(function (){
// alert('uwu');
k+=1; //ira aumentando el indice por cada fila agregada

GridServicios.push({
  Codigo: '<select style="width:150px" id="ProductoServicioId'+k+'"  class="form-control" onChange="fnSeleccProductoServicio('+k+')"> '
  + '  <option value="">Seleccionar..</option> '
   + '</select>',
 Nombre: '<input type="text" style="width: 300px" id="txProductoConcat'+k+'" class="form-control" disabled>',
 Cantidad: '<input type="number" id="txCantidad'+k+'" class="form-control">',
 Precio: '<input type="number" id="txPrecioServicio'+k+'" class="form-control" onChange="MontosRenglonServicio('+k+')">',
 Total: '<input type="number" id="txTotalServicio'+k+'" class="form-control" disabled>',
 Comentarios: '<input type="text" id="txComentarios'+k+'" class="form-control">',
  Agregar_Eliminar : '<button type="button" id="'+k+'" class="btn btn-inline btn-danger btn-sm ladda-button btn_row_delete"><div><i class="fa fa-trash"></i></div></button>'})

  //Cargamos el dropdown
  CargaDropdownProductosServicio(k);
  // Se crean las filas
  GridServicios.forEach(function(row) {
    //se crea la fila de la tabla con su indice.
    tableBody = '<tr id="row'+k+'">';

    columns.forEach(function(cell) {
      // Cell es el nombre de cada columna
        // row[cell] obtiene el valor de cada fila
      tableBody = tableBody + "<td>" + row[cell] + "</td>";
    });

    tableBody = tableBody + "</tr>";
  });

  $("#GridServicios").append(tableBody);

});


//funcion para eliminar fila de la tabla gridservicios
$(document).on('click','.btn_row_delete', function(){


    var row_id = $(this).attr("id"); //se obtiene el id de la fila
    k-=1; //se resta el indice
    //Eliminanos el index del array
    GridServicios.splice(k,1);
    //elimina la fila de la tabla
    $('#row'+row_id+'').remove();
  

});

//#endregion

//#endregion

//#endregion

//#region Seccion para el grid de material/productos

//#region Carga el array que contendra las columnas del gridmateriales
//Array que contendra los datos de la tabla de servicios
var GridProductoMaterial = [
  {
    Codigo: '<select style="width:150px"  id="ProductoMaterialId0"  class="form-control" onChange="fnSeleccProducto(0)"> '
  + '  <option value="">Seleccionar..</option> '
   + '</select>',
   Nombre: '<input style="width: 300px" type="text" id="txProductoConcatMaterial0" class="form-control" disabled>',
    Cantidad: '<input type="number" id="txCantidadMaterial0" class="form-control">',
    Precio: '<input type="number" id="txPrecioMaterial0" class="form-control" onChange="MontosRenglonMaterial(0)">',
    Total: '<input type="number" id="txTotalMaterial0" class="form-control" disabled>',
    Comentarios: '<input type="text" id="txComentariosMaterial0" class="form-control">',
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

  //Se llena e primer dropdown
$.post("../../controller/ctrlProducto.php?op=ListProducto",
{Caso : 1}, function(data){
$('#ProductoMaterialId0').html(data);
});
//funcion que llena el dropdown de servicios
function CargaDropdownProductos(Id){
$.post("../../controller/ctrlProducto.php?op=ListProducto",
{Caso : 1}, function(data){
  $('#ProductoMaterialId'+Id+'').html(data);
});
}

//#endregion

  //#region Funcion para calcular lo totales de la cotizacion
  function MontosRenglonMaterial(index){
    var Cantidad =0, Precio = 0, Total = 0;
    Cantidad= $('#txCantidadMaterial'+index+'').val();
    Precio = $('#txPrecioMaterial'+index+'').val(); 
  

    if (Cantidad>0 && Precio>0){
Total = Cantidad * Precio;
Total = parseFloat(Total).toFixed(2);
$('#txTotalMaterial'+index+'').val(Total); 

// SpanSubtotal SpanIVA SpanTotal
//Recorremos todos los valores de la tabla para asi obtener los totales de los productos ya sumados
let SubTotal = 0, TotalCot = 0, IVA = 0, TotalCantidad =0, TotalPrecio = 0;

for (var i = 0; i<GridServicios.length; i++){
  TotalPrecio += parseFloat(document.getElementById("GridServicios").rows[i+1].cells[4].firstChild.value) ||0;
}

for (var i = 0; i<GridProductoMaterial.length; i++){
    TotalPrecio += parseFloat(document.getElementById("GridMateriales").rows[i+1].cells[4].firstChild.value) ||0;
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

    }
}

function MontosRenglonServicio(index){
  var Cantidad =0, Precio = 0, Total = 0;
  Cantidad= $('#txCantidad'+index+'').val();
  Precio = $('#txPrecioServicio'+index+'').val(); 


  if (Cantidad>0 && Precio>0){
Total = Cantidad * Precio;
Total = parseFloat(Total).toFixed(2);
$('#txTotalServicio'+index+'').val(Total); 

// SpanSubtotal SpanIVA SpanTotal
//Recorremos todos los valores de la tabla para asi obtener los totales de los productos ya sumados
let SubTotal = 0, TotalCot = 0, IVA = 0, TotalCantidad =0, TotalPrecio = 0;
for (var i = 0; i<GridServicios.length; i++){
  TotalPrecio += parseFloat(document.getElementById("GridServicios").rows[i+1].cells[4].firstChild.value) ||0;
}

for (var i = 0; i<GridProductoMaterial.length; i++){
  TotalPrecio += parseFloat(document.getElementById("GridMateriales").rows[i+1].cells[4].firstChild.value) ||0;
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
  }
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
   Nombre: '<input style="width: 300px" type="text" id="txProductoConcatMaterial'+f+'" class="form-control" disabled>',
    Cantidad: '<input type="number" id="txCantidadMaterial'+f+'" class="form-control">',
    Precio: '<input type="number" id="txPrecioMaterial'+f+'" class="form-control" onChange="MontosRenglonMaterial('+f+')">',
    Total: '<input type="number" id="txTotalMaterial'+f+'" class="form-control" disabled>',
    Comentarios: '<input type="text" id="txComentariosMaterial'+f+'" class="form-control">',
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



//#region fnGuardarReporteServicio: Guarda los datos del reporte


  $(() => {
    $('#BtnGuardaReporte').click(e => {
var TMaestroServicios = []; //obtendra los datos del grid servicio
for(var i = 0;i<GridServicios.length;i++){
  TMaestroServicios.push({
  //Se aplica el +1 ya que el primer tr es de las columnas y no de las filas
  ProductoId: Number(document.getElementById("GridServicios").rows[i+1].cells[0].firstChild.value),
  ProductoConcat: Number(document.getElementById("GridServicios").rows[i+1].cells[1].firstChild.value),
  Cantidad: Number(document.getElementById("GridServicios").rows[i+1].cells[2].firstChild.value),
  Precio: parseFloat(document.getElementById("GridServicios").rows[i+1].cells[3].firstChild.value),
    Total: parseFloat(document.getElementById("GridServicios").rows[i+1].cells[4].firstChild.value),
  Comentarios: document.getElementById("GridServicios").rows[i+1].cells[5].firstChild.value,
});
}
// console.log(MaestroServicios);
//Parseamos a JSON el objeto para mandar como parametro al stored
const MaestroServicios = JSON.stringify(TMaestroServicios);


//Ahora obtenemos los datos del grid de Productos/Materiales

var TMaestroMateriales = [];
for(var i = 0;i<GridProductoMaterial.length;i++){
  TMaestroMateriales.push({
    //Se aplica el +1 ya que el primer tr es de las columnas y no de las filas
    ProductoId: Number(document.getElementById("GridMateriales").rows[i+1].cells[0].firstChild.value),
    ProductoConcat: Number(document.getElementById("GridMateriales").rows[i+1].cells[1].firstChild.value),
    Cantidad: Number(document.getElementById("GridMateriales").rows[i+1].cells[2].firstChild.value),
    Precio: parseFloat(document.getElementById("GridMateriales").rows[i+1].cells[3].firstChild.value),
    Total: parseFloat(document.getElementById("GridMateriales").rows[i+1].cells[4].firstChild.value),
    Comentarios: document.getElementById("GridMateriales").rows[i+1].cells[5].firstChild.value,
  });
  }
  //Parseamos a JSON el objeto para mandar como parametro al stored
  const MaestroMateriales = JSON.stringify(TMaestroMateriales);
  

//Ahora obtenemos los datos en general (Maestro)
let MaestroReporte ={};

MaestroReporte.TicketId = $("#TicketIdReporte").val();
MaestroReporte.TicketId = Number(MaestroReporte.TicketId);
MaestroReporte.ClienteId = $("#ClienteIdReporte").val();
MaestroReporte.ClienteId = Number(MaestroReporte.ClienteId);
MaestroReporte.Marca = $("#Marca").val();
MaestroReporte.Modelo = $("#Modelo").val();
MaestroReporte.Serie = $("#Serie").val();
MaestroReporte.Otros = $("#Otros").val();
MaestroReporte.InspeccionVisual = $("#InspeccionVisual").val();
MaestroReporte.CategoriaId = $("#CategoriaIdReporte").val();
MaestroReporte.CategoriaId = Number(MaestroReporte.CategoriaId);
MaestroReporte.FallaPresentada = $("#FallaPresentada").val();

//totales
MaestroReporte.Servicio = $("#TotalServicio").val();
MaestroReporte.Refacciones = $("#TotalRefacciones").val();
MaestroReporte.ViaticosOtros = $("#TotalViaticosOtros").val();
MaestroReporte.SubTotal = $("#SpanSubtotal").text();
MaestroReporte.IVA = $("#SpanIVA").text();
MaestroReporte.Total = $("#SpanTotal").text();

MaestroReporte.Servicio =parseFloat(MaestroReporte.Servicio);
MaestroReporte.Refacciones =parseFloat(MaestroReporte.Refacciones);
MaestroReporte.ViaticosOtros =parseFloat(MaestroReporte.ViaticosOtros);
MaestroReporte.SubTotal =parseFloat(MaestroReporte.SubTotal);
MaestroReporte.IVA =parseFloat(MaestroReporte.IVA);
MaestroReporte.Total =parseFloat(MaestroReporte.Total);
// totales

//Ya con los datos listos, validamos que existan nulos

if(MaestroReporte.TicketId == undefined || MaestroReporte.TicketId <=0){
  swal('Favor de revisar los datos','','warning');
  return;
}

if(MaestroMateriales == undefined || MaestroMateriales.length<=0){
  swal('Agregue al menos un producto','','warning');
  return;
}
if(MaestroServicios == undefined || MaestroServicios.length<=0){
  swal('Agregue al menos un producto','','warning');
  return;
}

if(MaestroReporte.Total == undefined || MaestroReporte.Total <=0 || isNaN(MaestroReporte.Total)){
  swal('Capture los totales del reporte','','warning');
  return;
}

// console.log(MaestroReporte);
var vMaestro = [];
vMaestro.push(MaestroReporte);
const Maestro = JSON.stringify(vMaestro);
console.log(Maestro);
console.log(MaestroServicios);
console.log(MaestroMateriales);

$.post("../../controller/ctrlReporteServicio.php?op=AddReporteServicio",
{ Maestro : Maestro, MaestroServicios : MaestroServicios, MaestroMateriales: MaestroMateriales}, 
function(data){
 //Obtenemos el Nuevo ReporteServicioId generado para mandarlo como parametro y que se genere el pdf
 data = JSON.parse(data);

// swal("Proceso Completado Correctamente","","success");

//Obtenemos el pdf que se genera
//local
//var _url = "http://localhost/TICKETSV1/Reportes/ReporteServicio.php?ReporteServicioId="+data.ReporteServicioId+"";

//server
 var _url = "http://ctnredes.com/Reportes/ReporteServicio.php?ReporteServicioId="+data.ReporteServicioId+"";


// console.log(_url);
//Mandamos a imprimir el reporte
      printJS({ printable: _url, type: 'pdf', showModal: true })
LimpiarDatosReporteServicio();
});

    });
})


//Funcion para calcular lo totales de servicio
$(document).ready(function(){
  $(".inputTotales").on("input",function() {
      var total=0, iva = 0, subtotal = 0;
      $(".inputTotales").each(function(){
          if(!isNaN(parseInt($(this).val())))
          {
            total+=parseInt($(this).val());  
          }
      });
      subtotal = total /1.16;
      subtotal = parseFloat(subtotal).toFixed(2);
      iva = subtotal *0.16;
      iva = parseFloat(iva).toFixed(2);
      total = parseFloat(total).toFixed(2);
      $("#SpanSubtotal").text(subtotal);
      $("#SpanIVA").text(iva);
      $("#SpanTotal").text(total);
	});
})


//#endregion

//#region funcion limpiarDatosReporteServicio, limpia todas las variables que se usaron en el reporte de materiales

function LimpiarDatosReporteServicio(){
  //limpiamos las filas del gridServicios 

  GridServicios = [];
  

  $("#tbServicios tbody tr").remove();
      //Ahora las filas del gridproductomaterial
      GridProductoMaterial =[];
      $("#tbMateriales tbody tr").remove();
      //Limpiamos los datos del formulario
      document.getElementById("FormReporteServicioLimp").reset();
     
      //Ahora ocultamos el tab y volvemos al tab general
      // fnOcultarTabDetalle();
      
      

}

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
});;
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
  });;
}
