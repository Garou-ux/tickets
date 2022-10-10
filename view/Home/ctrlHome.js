function init(){
   
}

$(document).ready(function(){
    var UsuarioId = $('#UsuarioId').val();

    //Llenamos los totales de tickets por estatus
        $.post("../../controller/ctrlTicket.php?op=GetTotalTicketsXEstatus", 
        {UsuarioId: UsuarioId}, function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.Totales);
            $('#lbltotalabierto').html(data.TotalAbiertos);
            $('#lbltotalcerrado').html(data.TotalCerrados);
        }); 
    
        //Se llama al servicio para obtener los datos y llenar la grafica
        $.post("../../controller/ctrlTicket.php?op=GetTotalTicketsXCategoriaGrafico",
        {UsuarioId:UsuarioId},function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'Nombre',
                ykeys: ['TotalTickets'],
                labels: ['Total'],
                barColors: ["#17202A"], 
            });
        }); 


 
});

init();