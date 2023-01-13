
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
//funcion que carga los pagos

function CargarListaTickets (){
  Spinner('GridCategoria', true);
  //llenamos el datatable llamando al servicio que retorna los datos
  tabla=$('#GridCategorias').dataTable({
      "aProcessing": true,
      "aServerSide": true,
      order: [[0, 'desc']],
      dom: 'Bfrtip',
      "searching": true,
      buttons: [
              'excelHtml5'
              ],
      "ajax":{
          url: '../../controller/ctrlPagos.php?op=ListaPagos',
          type : "post",
          dataType : "json",
          //data:{ UsuarioId : 1},
        //   error: function(e){
        //       console.log(e.responseText);
        //       alert(e.responseText);
        //       return;
        //   }
      },
      columns: [
        {
        data   : 'PagoId'
        },
        {
        data   : 'Nombre'
        },
        {
        data   : 'Factura'
        },
        {
        data   : 'Total'
        },
        {
        data   : 'FechaPago'
        },
        { "data": "Btn",
        render: function(data, type, full){return `<button type="button" onclick="OpenModalPagos(${full.PagoId});" class="btn btn-primary">Editar</button>`;}
        },
        { "data": "BtnEliminar",
        render: function(data, type, full){return `<button type="button" onclick="DesactivarPago(${full.PagoId});" class="btn btn-danger">Eliminar</button>`;}
        }

    ],
  });
  Spinner('GridCategoria', false);
  }

  function CargaDropdownClientes(){
    $.post("../../controller/ctrlPagos.php?op=GetListUsuarios",
     function(data){
      $('#SelectPagos').html(data);
    });
  }

$(document).ready(function(){

    CargarListaTickets();
    CargaDropdownClientes();
    // swal("Sitio en Mantenimiento", {
    //     icon: "warning",
    //   });
});



//funcion para abrir el modal de pagos
function OpenModalPagos(PagoId = 0){
  if(PagoId > 0){
    Spinner('GridCategorias', true);
  let _data = {
    PagoId   : PagoId
  }
    $.ajax({
    type     : "POST",
    url      : "../../controller/ctrlPagos.php?op=GetDataPagoXId",
    data     : _data,
    dataType : "json",
    }).done(function(data) {
          // data = JSON.parse(data);
          $('#pPagoId').show();
        $('#smallpagoid').text(PagoId);
        $('#ModalPagos').modal('show');
        $('#SelectPagos').val(data[0].Nombre);
        $('#FacturaN').val(data[0].Factura);
        $('#Pago').val(data[0].Total);
        $('#PagoId').val(PagoId);
        Spinner('GridCategorias', false);
      }).fail(function(data) {
        Spinner('GridCategorias', false);
        console.log(data);
    });
  }else{
   $('#pPagoId').hide();
   $('#PagoId').val(0);
    $('#UsuarioForm').trigger("reset");
    $('#ModalPagos').modal('show');
  }
}

function AgregarEditarPago(PagoId = 0){
  Spinner('ModalPagos', true);
    let _data = {
        PagoId    : $('#PagoId').val() || 0,
        UsuarioId : $('#SelectPagos').val(),
        Factura   : $('#FacturaN').val(),
        Total     : $('#Pago').val()
    };
   $.ajax({
    type: "POST",
    url: "../../controller/ctrlPagos.php?op=AddEditPago",
    data: _data,
    dataType: "json",
   }).done(function(data) {
        console.log(data);
        // data = JSON.parse(data);
         swal(data.Title, 
         data.Mensaje, 
         data.Type);
         $('#UsuarioForm').trigger("reset");
         $('#ModalPagos').modal('hide');
         Spinner('ModalPagos', false);
        //  CargarListaTickets();
        setTimeout(() => {
          location.reload();
        }, 1000);
    }).fail(function(data) {
      console.log(data);
        console.log('eror');
        Spinner('ModalPagos', false);
   });
}

function DesactivarPago(PagoId){

  swal({
    title: "¿Esas Seguro de desactivar el registro?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
 })
  .then((willDelete) => {
    if (willDelete) {
      Spinner('GridCategorias', true);
      let _data = {
       PagoId : PagoId
      }
     $.ajax({
       type: "POST",
       url: "../../controller/ctrlPagos.php?op=DesactivarPago",
       data: _data,
       dataType: "json",
     }).done(function(data) {
       swal(data.Title, 
         data.Mensaje, 
         data.Type);
       setTimeout(() => {
         location.reload();
       }, 1000);
       }).fail(function(data) {
         Spinner('GridCategorias', false);
         console.log(data);
     });
    } else {
      // swal(":c00");
    }
  });
}