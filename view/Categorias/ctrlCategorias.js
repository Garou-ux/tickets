
//#region variables
var tabla;
var TmpMaestro = {};
//#endregion

function fnListaCategorias(){
//#region Llenamos la tabla que contendra la lista de usuarios
tabla=$('#GridCategorias').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    "searching": true,
    lengthChange: false,
    colReorder: true,
    buttons: [		          
            
            'excelHtml5',
           
            ],
    "ajax":{
        url: '../../controller/ctrlCategoria.php?op=ListaCategorias',
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

//#region fnGetCategoria: se usa para obtener los datos de una categoria en especifico
function fnGetCategoria(CategoriasId){
    $.post("../../controller/ctrlCategoria.php?op=GetCategoria",
    {CategoriasId : CategoriasId},function(data,status){
        TmpMaestro = JSON.parse(data);//parseamos a objeto json los valores de la bd 
        
        //Llenamos los datos del formulario
        $('#Categoria_Nombre').val(TmpMaestro.Nombre);
        $('#Categoria_Uso').val(TmpMaestro.Uso);
        //    console.log(TmpMaestro);
        });
}
//#endregion



//#region evento click del boton nueva categoria, abre el modal para crear una nueva categoria
$(document).on("click","#BtnModalCategorias", function(){
    $('#ModalTitulo').html('Nueva Categoria');
    $('#CategoriaForm')[0].reset();
    $('#ModalCategorias').modal('show');
});
//#endregion

//#region fnEditarCategoria: se usa para editar o dar de baja una categoria
function fnEditarCategoria(CategoriasId,Caso){
    fnGetCategoria(CategoriasId);
    //Caso 1: abre modal con los datos de la categoria para editarla
    //Caso 2: ejecuta la funcion de addcategoria, pero con el parametro de uso =0, esto para darlo de baja
    if(Caso ==1){
        $('#ModalTitulo').html('Editar Categoria # ' + CategoriasId);   
        $('#ModalCategorias').modal('show');
    }
    if(Caso ==2){
        swal({
            title: "¿Estas seguro/a de querer Desactivar la Categoria?",
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
                $.post("../../controller/ctrlCategoria.php?op=AddCategoria",
                { Maestro : Maestro}, function(data){
                    fnListaCategorias();
                $('#ModalCategorias').modal('hide');
                });
              swal("La categoria ah sido desactivada", {
                icon: "success",
              });
            } else {
            //   swal("No se cancelo el ticket");
            }
          });
    }
}
//#endregion



//#region fnGuardar: Guarda los datos de la categoria, ya sea uno nuevo o uno existente
function fnGuardar (){
//llenamos los datos del maestro
TmpMaestro.CategoriasId = Number(TmpMaestro.CategoriasId) || 0;
TmpMaestro.Nombre =$('#Categoria_Nombre').val();
TmpMaestro.Uso = $('#Categoria_Uso').val();
TmpMaestro.Uso   = Number(TmpMaestro.Uso);

let MaestroArr = [];
MaestroArr.push(TmpMaestro);
  //parseamos el objeto a json para mandarlo como parametro
  const Maestro = JSON.stringify(MaestroArr);
  console.log(Maestro);
    //Llamamos al servicio para mandar el parametro y guardar la respuesta
    $.post("../../controller/ctrlCategoria.php?op=AddCategoria",
    { Maestro : Maestro}, function(data){

// console.log(data);     
TmpMaestro = {};
swal("Proceso Completado Correctamente","","success");
fnListaCategorias();
$('#ModalCategorias').modal('hide');
});
}
//#endregion

//#region evento click del boton BtnAddCategoria, ejecuta la funcion guardar
$(document).on("click","#BtnAddCategoria", function(){
    fnGuardar();
 });
//#endregion

fnListaCategorias();//llenamos el grid









