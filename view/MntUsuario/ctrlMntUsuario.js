
//#region variables
var tabla;
var TmpMaestro = {};
//#endregion

function fnListaUsuarios(){
//#region Llenamos la tabla que contendra la lista de usuarios
tabla=$('#GridUsuarios').dataTable({
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
        url: '../../controller/ctrlUsuario.php?op=ListaUsuarios',
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

//#region fnGetUsuario: se usa para obtener los datos de un usuario en especifico
function fnGetUsuario(UsuarioId){
    $.post("../../controller/ctrlUsuario.php?op=GetUsuario",
    {UsuarioId : UsuarioId},function(data,status){
        TmpMaestro = JSON.parse(data);//parseamos a objeto json los valores de la bd 
        
        //Llenamos los datos del formulario
        $('#Usuario_Nombre').val(TmpMaestro.Nombre);
        $('#Usuario_RFC').val(TmpMaestro.RFC);
        $('#Usuario_Correo').val(TmpMaestro.Correo);
        $('#Usuario_Pass').val(TmpMaestro.Pass);
        $('#Usuario_PassValida').val(TmpMaestro.Pass);
        $('#Usuario_Rol').val(TmpMaestro.RolId);
        //    console.log(TmpMaestro);
        });
}
//#endregion

//#region document ready, aqui se llenan los datos al momento de cargar la pagina
$(document).ready(function(){

    //Llenamos el select con los Roles del usuario
    $.post("../../controller/ctrlUsuario.php?op=ListaUsuarioRol",function(data,status){
        // console.log(data);
        $('#Usuario_Rol').html(data);
        });
        //Ejecutamos la funcion para llenar el datatable de usuarios
        fnListaUsuarios();

});
//#endregion

//#region evento click del boton nuevo usuario, abre el modal para crear un nuevo usuario
$(document).on("click","#BtnModalUsuario", function(){
    $('#ModalTitulo').html('Nuevo Usuario');
    $('#UsuarioForm')[0].reset();
    $('#ModalUsuario').modal('show');
});
//#endregion

//#region fnEditarUsuario: se usa para editar o dar de baja un usuario
function fnEditarUsuario(UsuarioId,Caso){
    fnGetUsuario(UsuarioId);
    //Caso 1: abre modal con los datos del usuario para editarlo
    //Caso 2: ejecuta la funcion de addusuario, pero con el parametro de uso =0, esto para darlo de baja
    if(Caso ==1){
        $('#ModalTitulo').html('Editar Usuario # ' + UsuarioId);   
        $('#ModalUsuario').modal('show');
    }
    if(Caso ==2){
        swal({
            title: "¿Estas seguro/a de querer eliminar el usuario?",
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
                $.post("../../controller/ctrlUsuario.php?op=AddUsuario",
                { Maestro : Maestro}, function(data){
                fnListaUsuarios();
                $('#ModalUsuario').modal('hide');
                });
              swal("El Usuario ah sido eliminado", {
                icon: "success",
              });
            } else {
            //   swal("No se cancelo el ticket");
            }
          });
    }
}
//#endregion



//#region fnGuardar: Guarda los datos del usuario, ya sea uno nuevo o uno existente
function fnGuardar (){
//llenamos los datos del maestro
TmpMaestro.UsuarioId = Number(TmpMaestro.UsuarioId) || 0;
TmpMaestro.Nombre =$('#Usuario_Nombre').val();
TmpMaestro.RFC = $('#Usuario_RFC').val();
TmpMaestro.Correo = $('#Usuario_Correo').val();
TmpMaestro.Pass = $('#Usuario_PassValida').val();
TmpMaestro.RolId =$('#Usuario_Rol').val();
TmpMaestro.RolId = Number(TmpMaestro.RolId);
TmpMaestro.Uso   = Number(TmpMaestro.Uso);

let MaestroArr = [];
MaestroArr.push(TmpMaestro);
  //parseamos el objeto a json para mandarlo como parametro
  const Maestro = JSON.stringify(MaestroArr);
  console.log(Maestro);
    //Llamamos al servicio para mandar el parametro y guardar la respuesta
    $.post("../../controller/ctrlUsuario.php?op=AddUsuario",
    { Maestro : Maestro}, function(data){

// console.log(data);     
TmpMaestro = {};
swal("Proceso Completado Correctamente","","success");
fnListaUsuarios();
$('#ModalUsuario').modal('hide');
});
}
//#endregion

//#region evento click del boton addusuario, ejecuta la funcion guardar
$(document).on("click","#BtnAddUsuario", function(){
    fnGuardar();
 });
//#endregion









