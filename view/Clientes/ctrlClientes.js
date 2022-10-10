
//#region variables
var tabla;
var TmpMaestro = {};
//#endregion

function fnListaUsuarios(){
//#region Llenamos la tabla que contendra la lista de usuarios
tabla=$('#GridClientes').dataTable({
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
        url: '../../controller/ctrlUsuario.php?op=ListaGridUsuariosClientes',
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
        $('#Usuario_RazonSocial').val(TmpMaestro.RazonSocial);
        $('#Usuario_Telefono').val(TmpMaestro.Telefono);
        $('#Usuario_CP').val(TmpMaestro.CodigoPostal);
        $('#Usuario_Contacto').val(TmpMaestro.Contacto);
           console.log(TmpMaestro);
        });
}
//#endregion

//#region document ready, aqui se llenan los datos al momento de cargar la pagina
$(document).ready(function(){
        //Ejecutamos la funcion para llenar el datatable de usuarios de tipo cliente
        fnListaUsuarios();

});
//#endregion

//#region evento click del boton nuevo usuario, abre el modal para crear un nuevo usuario
$(document).on("click","#BtnModalClientes", function(){
    TmpMaestro.UsuarioId = 0;
    $('#ModalTitulo').html('Nuevo Cliente');
    $('#UsuarioForm')[0].reset();
    $('#ModalClientes').modal('show');
});
//#endregion

//#region fnEditarUsuario: se usa para editar o dar de baja un usuario
function fnEditarCliente(UsuarioId,Caso){
    fnGetUsuario(UsuarioId);
    //Caso 1: abre modal con los datos del usuario para editarlo
    //Caso 2: ejecuta la funcion de addusuario, pero con el parametro de uso =0, esto para darlo de baja
    if(Caso ==1){
        $('#ModalTitulo').html('Editar Cliente # ' + UsuarioId);   
        $('#ModalClientes').modal('show');
    }
    if(Caso ==2){
        swal({
            title: "¿Estas seguro/a de querer dar de baja al cliente?",
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
                $.post("../../controller/ctrlUsuario.php?op=AddUsuarioCliente",
                { Maestro : Maestro}, function(data){
                fnListaUsuarios();
                $('#ModalUsuario').modal('hide');
                });
              swal("El Usuario ha sido dado de baja", {
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
TmpMaestro.RolId =  2
TmpMaestro.RolId = Number(TmpMaestro.RolId);
TmpMaestro.Uso   = 1;
TmpMaestro.RazonSocial =  $('#Usuario_RazonSocial').val();
TmpMaestro.Telefono = $('#Usuario_Telefono').val();
TmpMaestro.Telefono =  Number(TmpMaestro.Telefono);
TmpMaestro.CodigoPostal = $('#Usuario_CP').val();
TmpMaestro.CodigoPostal = Number(TmpMaestro.CodigoPostal);
TmpMaestro.Contacto = $('#Usuario_Contacto').val();
let MaestroArr = [];
MaestroArr.push(TmpMaestro);
  //parseamos el objeto a json para mandarlo como parametro
  const Maestro = JSON.stringify(MaestroArr);
  console.log(Maestro);
    //Llamamos al servicio para mandar el parametro y guardar la respuesta
    $.post("../../controller/ctrlUsuario.php?op=AddUsuarioCliente",
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
$(document).on("click","#BtnAddCliente", function(){
    fnGuardar();
 });
//#endregion









