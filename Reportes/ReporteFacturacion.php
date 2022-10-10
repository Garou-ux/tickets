<?php 
require_once("../config/conexion.php");
require_once("../public/libs/fpdf184/fpdf.php");
require_once("../models/ReporteServicio.php");

//Variable que contendra el id del reporte a generar el pdf
$ReporteServicioId = $_GET["ReporteServicioId"];

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
class PDF extends FPDF
{

    //Aqui se guardan los datos del encabezado, nombre cliente, descripcion del equipo etc..
    function DatosEncabezado(){
        $ReporteServicio =  new ReporteServicio();
    //Se llama a la funcion que obtiene los datos del encabezado
    $Datos = $ReporteServicio->GetReporteServicio($GLOBALS["ReporteServicioId"]);
    //Validamos que se obtengan datos
    if(is_array($Datos)==true and count($Datos)>0){
        //Asignamos los valores a un array
        foreach($Datos as $row)
        {
            $output["Folio"] = $row["Folio"];
            $output["TicketId"] = $row["TicketId"];
            $output["Cliente"] = $row["Cliente"];
            $output["Colonia"] = $row["Colonia"];
            $output["Empresa"] = $row["Empresa"];
            $output["Ciudad"] = $row["Ciudad"];
            $output["Telefono"] = $row["Telefono"];
            $output["Clave"] = $row["Clave"];
            $output["RFC"] = $row["RFC"];
            $output["Fecha"] = date("d/m/Y H:i:s", strtotime($row["Fecha"]));
            $output["CodigoPostal"] = $row["CodigoPostal"];
            $output["Marca"] = $row["Marca"];
            $output["Modelo"] = $row["Modelo"];
            $output["Serie"] = $row["Serie"];
            $output["Otros"] = $row["Otros"];
            $output["InspeccionVisual"] = $row["InspeccionVisual"];
            $output["FallaPresentada"] = $row["FallaPresentada"];
            $output["Servicio"] = $row["Servicio"];
            $output["Refacciones"] = $row["Refacciones"];
            $output["ViaticosOtros"] = $row["ViaticosOtros"];
            $output["SubTotal"] = $row["SubTotal"];
            $output["IVA"] = $row["IVA"];
            $output["Total"] = $row["Total"];
            $output["Categoria"] = $row["Categoria"];
        }
     //Retornamos el resultado a objeto json   
        return   json_encode($output);
        }  
    }

// Encabezado
function Header()
{
    //Obtenemos los datos devueltos de la funcion
    $obj = $this->DatosEncabezado();
    //Esto es para acceder a cada dato del json
    $arr = json_decode($obj, true);
    // Logo
    //imagen de la empresa
    $this->Image('../public/ConecTotalLogo.jpg',10,1,70);
    //Asignamos la fuente del encabezado
    $this->SetFont('Arial','B',10);
    // Movemos hacia la derecha
    $this->Cell(80);
    // Title

    //ReporteServicioId
    $this->Cell(80,10,"Reporte de Servicio No:".$arr["Folio"]."" ,1,0,'L');
    // Salto de linea
    $this->Ln(20);
    //Cliente
    $this->Cell(40,10,"Cliente:".$arr["Cliente"]."" ,0,0);
    //Movemos hacia la derecha el siguiente campo
    // $this->Cell(70);
    $this->Ln(5);
    //Ciudad
    $this->Cell(20,10,"Ciudad:".$arr["Ciudad"]."" ,0,0);
    //Salto de linea
    $this->Ln(5);
    //Colonia
    $this->Cell(10,10,"Colonia:".$arr["Colonia"]."" ,0,0);
    //Movemos hacia la derecha el siguiente campo
    $this->Ln(5);
    //Ciudad
    $this->Cell(86,10,"RFC:".$arr["RFC"]."" ,0,0);
    //Salto de linea
    $this->Ln(5);
    //Empresa
    $this->Cell(22,10,"Razon Social:".$arr["Empresa"]."" ,0,0);
    //Movemos hacia la derecha los siguientes campos
    $this->Ln(5);
    $this->Cell(40,10,"Telefono:".$arr["Telefono"]."" ,0,0);
}
 
//Encabezado donde se muestran los campos de la descripcion del equipo
function HeaderEquipo()
{
   
     //Salto de linea
     $this->Ln(20);
    $this->SetFont('Arial','',10);
    //Color del texto
    $this->SetTextColor(247, 245, 245);
    //Color del borde
    $this->SetFillColor(24, 26, 24);
    //Texto
    $this->Cell(0,6,"Descripcion del Equipo",0,1,'L',true);
    //Salto de linea
    $this->Ln(4);

}

//aqui se muestran la descripcion del equipo
function DescripcionEquipo(){
    //Obtenemos los datos devueltos de la funcion
    $obj = $this->DatosEncabezado();
    //Esto es para acceder a cada dato del json
    $arr = json_decode($obj, true);
  
     //Fuente 
     $this->SetTextColor(10,10,10);
    $this->SetFont('Arial','',10);
   //Marca
    $this->Cell(14,10,"Marca:"." ".$arr["Marca"]."" ,0,0,'L');
      //Movemos hacia la derecha el siguiente campo
      $this->Cell(80);
      //Inspeccion visual
      $this->Cell(40,10,"Inspeccion Visual:".$arr["InspeccionVisual"]."" ,0,0);
    //Salto de linea
    $this->Ln(8);
    //Modelo
    $this->Cell(14,10,"Modelo:"." ".$arr["Modelo"]."" ,0,0);
     //Movemos hacia la derecha el siguiente campo
    $this->Cell(80);
    //Falla presentada
    $this->Cell(40,10,"Falla Presentada:".$arr["FallaPresentada"]."" ,0,0);
    //Salto de linea
    $this->Ln(8);
    //Serie
    $this->Cell(14,10,"Serie:"." ".$arr["Serie"]."" ,0,0);
    //Salto de linea
    $this->Ln(8);
    //Otros
    $this->Cell(14,10,"Otros:"." ".$arr["Otros"]."" ,0,0);


}

//Encabezado donde se muestran los servicios y productos usados en el servicio
function HeaderProductosServicios()
{
   
     //Salto de linea
     $this->Ln(20);
    $this->SetFont('Arial','',10);
    //Color del texto
    $this->SetTextColor(247, 245, 245);
    //Color del borde
    $this->SetFillColor(24, 26, 24);
    //Texto
    $this->Cell(0,6,"Descripcion del Servicio",0,1,'L',true);
    //Salto de linea
    $this->Ln(4);

}

//aqui se muestran los servicios y productos utilizados
function TablaServicios()
{
    $obj = $this->DatosEncabezado();
    $this->SetFont('Arial','',8);
    //Esto es para acceder a cada dato del json
    $arr = json_decode($obj, true);
    $this->SetTextColor(5,5,5);
    $str = utf8_decode($arr["Categoria"]);
    $this->Cell(0,10,"Tipo de Servicio:"." ".$str."" ,0,0,'L');
    $this->Ln(9);
    $header = array('Diagnostico o Servicio Realizado'
    , 'Cantidad', 
    'Comentarios');
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(0, 25, 79);
    $this->SetTextColor(255);
    // $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(86, 20, 84);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    $ReporteServicio =  new ReporteServicio();
    //Se llama a la funcion que obtiene los datos para llenar los servicios y los productos
    $Datos = $ReporteServicio->GetReporteServicioDet($GLOBALS["ReporteServicioId"]);
    foreach($Datos as $row)
    {
        //Solo llenara los que son de tipo servicio
        if($row[4] == 1){
        $this->Cell($w[0],10,$row[3],'LR',0,'L',$fill);
        $this->Cell($w[1],10,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[2],10,$row[1],'LR',0,'L',$fill);
        $this->Ln();
        $fill = !$fill;
        }
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

function TablaMateriales(){
    $this->Ln(9);
    $header = array('Material Utilizado'
    , 'Cantidad', 
    'Comentarios');
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(0, 25, 79);
    $this->SetTextColor(255);
    // $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(86, 20, 84);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    $ReporteServicio =  new ReporteServicio();
    //Se llama a la funcion que obtiene los datos para llenar los servicios y los productos
    $Datos = $ReporteServicio->GetReporteServicioDet($GLOBALS["ReporteServicioId"]);
    foreach($Datos as $row)
    {
        //Solo llenara los que son de tipo servicio
        if($row[4] == 0){
        $this->Cell($w[0],10,$row[3],'LR',0,'L',$fill);
        $this->Cell($w[1],10,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[2],10,$row[1],'LR',0,'L',$fill);
        $this->Ln();
        $fill = !$fill;
        }
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//Totales
function Totales(){
     //Obtenemos los datos devueltos de la funcion
     $obj = $this->DatosEncabezado();
     //Esto es para acceder a cada dato del json
     $arr = json_decode($obj, true);
    // su posicion sera 1.5 cm antes de que termine la pagina
    $this->SetY(-70);
    // fuente
    $this->SetFont('Arial','B',10);
    // $this->Ln(5);
    $this->Cell(80,10,"Precio de Servicio y Refacciones" ,1,0,'C');
    $this->Ln(8);
    //Servicio
    $this->Cell(28,10,"*Servicio:".$arr["Servicio"]."" ,0,0,'C'); 
     //Movemos hacia la derecha el siguiente campo
     $this->Cell(80);
     //SubTotal
     $this->Cell(28,10,"SubTotal:".$arr["SubTotal"]."" ,0,0,'C'); 
    $this->Ln(6);
    //Refacciones
    $this->Cell(35,10,"Refacciones:".$arr["Servicio"]."" ,0,0,'C'); 
     //Movemos hacia la derecha el siguiente campo
     $this->Cell(80);
     //SubTotal
    //  $iva =money_format("$", $arr["IVA"]);
    $iva = "$ ".number_format($arr["IVA"], 2);
     $this->Cell(28,10,"IVA:".$iva."" ,0,0,'C'); 
    $this->Ln(6);
    //Refacciones
    $this->Cell(31,10,"Viaticos/Otros:".$arr["ViaticosOtros"]."" ,0,0,'C'); 
     //Movemos hacia la derecha el siguiente campo
     $this->Cell(80);
     //SubTotal
     $this->Cell(28,10,"Total:".$arr["Total"]."" ,0,0,'C'); 
}

// Page footer
function Footer()
{
   
    // su posicion sera 1.5 cm antes de que termine la pagina
    $this->SetY(-15);
    // fuente
    $this->SetFont('Arial','I',8);
    // Numero de pagina
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
$pdf = new PDF();
//header
$pdf->AddPage();//Agregamos pagina
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
$pdf->HeaderEquipo(); //Mostramos la el header donde se muestra la descripcion del equipo
$pdf->DescripcionEquipo();
$pdf->HeaderProductosServicios();
$pdf->TablaServicios();
$pdf->TablaMateriales();
$pdf->Totales();
$pdf->Output();//Se crea el PDF


?>