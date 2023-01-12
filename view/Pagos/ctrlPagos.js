

//funcion que carga los pagos

function CargarListaTickets (){
  //llenamos el datatable llamando al servicio que retorna los datos
  tabla=$('#GridCategorias').dataTable({
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
          url: '../../controller/ctrlPagos.php?op=ListaPagos',
          type : "post",
          dataType : "json",
          //data:{ UsuarioId : 1},
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

    CargarListaTickets();
    // swal("Sitio en Mantenimiento", {
    //     icon: "warning",
    //   });
});



//funcion para abrir el modal de pagos
function OpenModalPagos(){

    $('#ModalPagos').modal('show');

    $('#SelectPagos').html(data.empleados);

}