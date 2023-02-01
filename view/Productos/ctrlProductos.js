
//#region variables
var tabla;
var TmpMaestro = {};
//#endregion



//#region document ready, aqui se llenan los datos al momento de cargar la pagina
$(document).ready(function(){

    //Llenamos el select con los Roles del usuario
    // $.post("../../controller/ctrlProducto.php?op=ListarProductoCategoria",function(data,status){
    //     // console.log(data);
    //     $('#ProductoServicio_Categoria').html(data);
    //     });

});
//#endregion

//Se cargan los productos en el gridproductos
function fnListaProductos(){
    //#region Llenamos la tabla que contendra la lista de usuarios
    tabla=$('#GridProductos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        order: [[4, 'asc']],  
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                
                'excelHtml5',
               
                ],
        "ajax":{
            url: '../../controller/ctrlProducto.php?op=ListaProductosGrid',
           
            type : "post",
            dataType : "json",		
            data:{ Caso : 0},				
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


//se cargan los servicios en el gridservicios
function fnListaServicios(){
    //#region Llenamos la tabla que contendra la lista de usuarios
    tabla=$('#GridServicios').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        order: [[4, 'desc']],  
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                
                'excelHtml5',
               
                ],
        "ajax":{
            url: '../../controller/ctrlProducto.php?op=ListaProductosGrid',
           
            type : "post",
            dataType : "json",		
            data:{ Caso : 1},				
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


//#region fnGetProductoServicio: se usa para obtener los datos de un producto/servicio x id
function fnGetProductoServicio(ProductoId){
    LoadDropdownCategorias();
    setTimeout(() => {
        $.post("../../controller/ctrlProducto.php?op=GetProducto",
        {ProductoId : ProductoId},function(data,status){
            TmpMaestro = JSON.parse(data);//parseamos a objeto json los valores de la bd 
            
            //Llenamos los datos del formulario
            $('#ProductoServicio_Clave').val(TmpMaestro.Clave);
            $('#ProductoServicio_Descripcion').val(TmpMaestro.Descripcion);
            $('#ProductoServicio_ClaveSat').val(TmpMaestro.ClaveSat);
            $('#ProductoServicio_Categoria').val(TmpMaestro.ProdCategoriaId);
            $('#ProductoServicio_EsServicio').val(TmpMaestro.EsServicio);
            $('#ProductoServicio_Uso').val(TmpMaestro.Uso);
            });
    }, 100);
}
//#endregion



//#region evento click del boton nuevo producto/servicio, abre el modal para crear un nuevo producto/servicio
$(document).on("click","#BtnModalProductoServicio", function(){
   

    $.post("../../controller/ctrlProducto.php?op=ListarProductoCategoria",function(data,status){
        console.log(data);
        $('#ProductoServicio_Categoria').html(data);
        $('#ModalTitulo').html('Nuevo Producto/Servicio');
        $('#ProductoServicioForm')[0].reset();
        $('#ModalProductosServicios').modal('show');    
        });        
  
            
});

function LoadDropdownCategorias(){
    $.post("../../controller/ctrlProducto.php?op=ListarProductoCategoria",function(data,status){
        // console.log(data);
        $('#ProductoServicio_Categoria').html(data);  
        });      
}
//#endregion

//#region fnEditarProductoServicio: se usa para editar o dar de baja un producto
function fnEditarProductoServicio(ProductoId,Caso,EsServicio){
    fnGetProductoServicio(ProductoId);
    //Caso 1: abre modal con los datos del producto para editarlo
    //Caso 2: ejecuta la funcion de addproductoservicio, pero con el parametro de uso =0, esto para darlo de baja
    if(Caso ==1){
        $('#ModalTitulo').html('Editar Producto # ' + ProductoId);   
        $('#ModalProductosServicios').modal('show');
    }
    if(Caso ==2){
        swal({
            title: "¿Estas seguro/a de querer Desactivar el producto?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                TmpMaestro.Uso = 0;
                let MaestroArr = [];
                MaestroArr.push(TmpMaestro);
                //parseamos el objeto a json para mandarlo como parametro
                const Maestro = JSON.stringify(MaestroArr);
                $.post("../../controller/ctrlProducto.php?op=DesactivarProducto",
                { ProductoId : ProductoId}, function(data){
                    fnListaProductos(); //se llena el grid de productos
                    fnListaServicios();//llenamos el grid de servicios
                $('#ModalProductosServicios').modal('hide');
                });
              swal("El producto ha sido desactivado", {
                icon: "success",
              });
            } else {
            //   swal("No se cancelo el ticket");
            }
          });
    }
}
//#endregion



//#region fnGuardar: Guarda los datos del producto/servicio, ya sea uno nuevo o uno existente
function fnGuardar (){
//llenamos los datos del maestro
TmpMaestro.ProductoId = Number(TmpMaestro.ProductoId) || 0;
TmpMaestro.Clave = $('#ProductoServicio_Clave').val();
TmpMaestro.Descripcion = $('#ProductoServicio_Descripcion').val();
TmpMaestro.ClaveSat = $('#ProductoServicio_ClaveSat').val();
TmpMaestro.ProdCategoriaId = $('#ProductoServicio_Categoria').val();
TmpMaestro.ProdCategoriaId = Number(TmpMaestro.ProdCategoriaId);
TmpMaestro.EsServicio = $('#ProductoServicio_EsServicio').val();
TmpMaestro.EsServicio = Number(TmpMaestro.EsServicio);
TmpMaestro.Uso = $('#ProductoServicio_Uso').val();
TmpMaestro.Uso = Number(TmpMaestro.Uso);

let MaestroArr = [];
MaestroArr.push(TmpMaestro);
  //parseamos el objeto a json para mandarlo como parametro
  const Maestro = JSON.stringify(MaestroArr);
  console.log(Maestro);
    //Llamamos al servicio para mandar el parametro y guardar la respuesta
    $.post("../../controller/ctrlProducto.php?op=AddProducto",
    { Maestro : Maestro}, function(data){

// console.log(data);     
$('#ProductoServicioForm')[0].reset();
TmpMaestro = {};
swal("Proceso Completado Correctamente","","success");
fnListaProductos(); //se llena el grid de productos
fnListaServicios();//llenamos el grid de servicios
$('#ModalProductosServicios').modal('hide');
});
}
//#endregion

//#region evento click del boton BtnAddCategoria, ejecuta la funcion guardar
$(document).on("click","#BtnAddProductoServicio", function(){
    fnGuardar();
 });
//#endregion

fnListaProductos(); //se llena el grid de productos
// fnListaServicios();//llenamos el grid de servicios









