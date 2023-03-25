 
let user_var = 'Client';

function init(){
    $("#TicketForm").on("submit",function(e){
    GuardarTicket(e);
    });
    }
    
    //#region DocumentReady
    $(document).ready(function() {

    $('#Descripcion').summernote({
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
                console.log("Image Detect.-.");
                myimagetreat(image[0]);
            },
            onPaste: function(e){
                console.log("Text Detected..");
            }
            
        }
    });
    
    $.post("../../controller/ctrlCategoria.php?op=combo",function(data,status){
    $('#CategoriaId').html(data);
    });

        let user_session =  getUserSession();
        user_session
        .then(data => {
           let user = JSON.parse(data)
            if(user.RolId === "1"){
                user_var = 'Admin';
                $(".select_hidden").css('display','block');
                liveSearchSelectPickers();
                getClients();
            }else{
                user_var = 'Client';
            }
        })
        .catch(err => {});
    });
    
    //#endregion
    
    
    //#region funcion para guardar el ticket
    function GuardarTicket(e){
    e.preventDefault();
    e.stopPropagation();
    //$('.Btnguar').prop('disabled', true);
    let _Maestro = {};
    var MaestroArr =[];
    //     var Datos = new FormData($("#TicketForm")[0]);
    
    let Datos  = $("#TicketForm").serializeArray();
    Datos.forEach(function(Datosobj){
    Datosobj.TicketId = 0;
    switch (Datosobj.name) {
    case "CategoriaId":
        _Maestro.CategoriaId = Datosobj.value;
        _Maestro.CategoriaId = Number(_Maestro.CategoriaId);
        break;
    case "Titulo":
        _Maestro.Titulo = Datosobj.value;
        break;
    case "Descripcion":
        _Maestro.Descripcion = Datosobj.value;
        break;
    
        case "UsuarioId":
            _Maestro.UsuarioId   =  user_var === 'Client' ? Datosobj.value : $('#select_cliente').val();
            _Maestro.UsuarioId = Number(_Maestro.UsuarioId);
              break;
            case "NombreReq":
            _Maestro.NombreReq = Datosobj.value;
            break;
    }
    _Maestro.TicketId = 0;
    
    });

    MaestroArr.push(_Maestro);
    if (_Maestro.Titulo == undefined || _Maestro.Titulo ===''){
        swal('Favor de Ingresar un Titulo al ticket','','warning');
        return;
    }
    
    if (_Maestro.CategoriaId == undefined || _Maestro.CategoriaId <=0){
        swal('Favor de seleccionar una categoria','','warning');
        return;
    }
    
    if (_Maestro.Descripcion == undefined || _Maestro.Descripcion ===''){
        swal('Favor de agregar una descripción','','warning');
        return;
    }
    if(_Maestro.NombreReq == undefined || _Maestro.NombreReq === ''){
    swal('El campo Nombre, es requerido','','warning');
    return;
    }
    const TMaestro = JSON.stringify(MaestroArr);
    
    document.getElementById("Maestro").value = TMaestro;
    
    var formData = new FormData($("#TicketMaestroForm")[0]);
    $.ajax({
    url: "../../controller/ctrlTicket.php?op=Add",
    type: "POST",
    data: formData,
    contentType:false,
    processData:false,
    success: function(data){
    $('#TicketMaestroForm').val('');
    $('#Titulo').val('');
    $('#Descripcion').summernote('reset');
    swal("Proceso Completado Correctamente","","success");
    //Obtenemos el Nuevo ticketid generado
    data = JSON.parse(data);
//Llamamos al servicio para enviar la notificacion de correo al usuario
$.post("../../controller/ctrlEnvioEmails.php?op=NotificacionTicketAbierto",
{TicketId : data.TicketId }, function(data){
});

//Ahora al usuario soporte le llegara tambien la notificacion
$.post("../../controller/ctrlEnvioEmails.php?op=NotificacionTicketAsignado",
{TicketId : data.TicketId }, function(data){
});
    }
    });
    //Redirigimos a la consulta de tickets
    // var url = '..\ConsultarTicket\';
    //local
    //location.replace("http://localhost:8012/tickets/view/ConsultarTicket/");
    //servidor
   // location.replace("http://ctnredes.com/view/ConsultarTicket/");
    //local
   // setTimeout(function(){location.replace("http://localhost:8012/tickets/view/ConsultarTicket/");;}, 4000);
   
   //serv
   setTimeout(function(){location.replace("http://ctnredes.com/view/ConsultarTicket/");}, 4000);
    }
    
//#endregion
init();


const clearSelectPicker = (select) => {
    return $(`#${select}`).empty();
  };

  const clearForm = (form) => {
     return $(`#${form}`).trigger("reset");
  };
  
  const refreshSelectPicker = (select) => {
    return $(`.${select}`).selectpicker("refresh");
  };

const liveSearchSelectPickers = () => {
    let select = $('.select');
        select.addClass('selectpicker form-control');
        select.attr("data-live-search", "true");
        select.attr("data-container", "body");

      return setTimeout(() => {
           select.selectpicker({
             livesearch : true
           });
           refreshSelectPicker('select');
           select.selectpicker("render");
        });
  };


  const fillSelectPicker = (objectSelect) => {
    let select = $(`#${objectSelect.select}`);
    clearSelectPicker(objectSelect.select);
    refreshSelectPicker(objectSelect.class);
    let option = `<option/>`;
    for (const process of objectSelect.data) {
      select.append($(option).val(`${process.UsuarioId}`).text(process.Cliente));
    }
    refreshSelectPicker('select');
};

const fetchData = async(url = "", data = {}, method = 'GET') => {
    const response = await fetch(url, {
       method: method, 
       mode: "same-origin",
         cache: "no-cache", 
         credentials: "same-origin", 
         headers: {
           "Content-Type": "application/json",
           "Accept": "application/json",
           "X-Requested-With": "XMLHttpRequest",
        //    "X-CSRF-Token": data._token
         },
         redirect: "follow", 
         referrerPolicy: "no-referrer", 
         body : method === "GET" ? null : JSON.stringify(data)
       
     });
     
return response.json();
}


const getClients = async () => {
    let = data = { url : "../../controller/ctrlUsuario.php?op=getClients" }
    let response = await fetchData(data.url, data, 'GET');
    let optionsSelect = { select : 'select_cliente', data : response, class: 'select' };
    fillSelectPicker(optionsSelect);
};

const getUserSession = async () =>{
    let url = "../../controller/ctrlUsuario.php?op=GetUsuario";
    let response =   await $.post("../../controller/ctrlUsuario.php?op=GetUsuario",
    {UsuarioId : $('#UsuarioId').val()},function(data,status){
        //TmpMaestro = JSON.parse(data);//parseamos a objeto json los valores de la bd 
       return data;
        });
return response;
}
