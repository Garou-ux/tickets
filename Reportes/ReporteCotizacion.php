<?php 
require_once("../config/conexion.php");
require_once("../public/libs/fpdf184/fpdf.php");
require_once("../models/Cotizacion.php");

//Variable que contendra el id del reporte a generar el pdf
$CotizacionId = $_GET["CotizacionId"];

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
class PDF extends FPDF
{

// //funcion para convertir numeros a palabras
// function getIndianCurrency(float $number)
// {
//     $decimal = round($number - ($no = floor($number)), 2) * 100;
//     $hundred = null;
//     $digits_length = strlen($no);
//     $i = 0;
//     $str = array();
//     $words = array(0 => '', 1 => 'uno', 2 => 'dos',
//         3 => 'tres', 4 => 'cuatro', 5 => 'cinco', 6 => 'seis',
//         7 => 'siete', 8 => 'ocho', 9 => 'nueve',
//         10 => '10', 11 => '11', 12 => '12',
//         13 => '13', 14 => '14', 15 => '15',
//         16 => '16', 17 => '17', 18 => '18',
//         19 => '19', 20 => '20', 30 => 'thirty',
//         40 => 'forty', 50 => 'fifty', 60 => 'sixty',
//         70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
//     $digits = array('', 'hundred','thousand','lakh', 'crore');
//     while( $i < $digits_length ) {
//         $divider = ($i == 2) ? 10 : 100;
//         $number = floor($no % $divider);
//         $no = floor($no / $divider);
//         $i += $divider == 10 ? 1 : 2;
//         if ($number) {
//             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
//             $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
//             $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
//         } else $str[] = null;
//     }
//     $Rupees = implode('', array_reverse($str));
//     $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
//     return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
// }


    //Aqui se guardan los datos del encabezado, nombre cliente, descripcion del equipo etc..
    function DatosEncabezado(){
        $ReporteCotizacion =  new Cotizacion();
    //Se llama a la funcion que obtiene los datos del encabezado
    $Datos = $ReporteCotizacion->ReporteCotizacion($GLOBALS["CotizacionId"]);
    //Validamos que se obtengan datos
    if(is_array($Datos)==true and count($Datos)>0){
        //Asignamos los valores a un array
        foreach($Datos as $row)
        {
            $output["CotizacionId"] = $row["CotizacionId"];
            $output["Nombre"] = $row["Nombre"];
            $output["RFC"] = $row["RFC"];
            $output["SubTotal"] = $row["SubTotal"];
            $output["IVA"] = $row["IVA"];
            $output["Total"] = $row["Total"];
            $output["Fecha"] = date("d/m/Y H:i:s", strtotime($row["Fecha"]));
            $output["RazonSocial"] = $row["RazonSocial"];
            $output["Contacto"] = $row["Contacto"];
            $output["Correo"] = $row["Correo"];

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

    $str = utf8_decode("Cotización No ");
    //CotizacionId
    $this->Cell(80,10,$str.$arr["CotizacionId"]."" ,1,0,'C');
    // Salto de linea
    $this->Ln(20);
    //Cliente
    $str = utf8_decode($arr["Nombre"]);
    $this->Cell(40,10,"Cliente:".$str."" ,0,0,'L');
    //Movemos hacia la derecha el siguiente campo
    $this->Cell(70);
    //Ciudad
    $this->Ln(8);
    $this->Cell(15,10,"RFC:".$arr["RFC"]."" ,0,0);
     // Salto de linea
     $this->Ln(8);
     //Razon Social
     $this->Cell(86,10,"Razon Social:".$arr["RazonSocial"]."" ,0,0);
      //Movemos hacia la derecha el siguiente campo

    $this->Cell(70);

    //Contacto
     $this->Ln(8);
    $this->Cell(15,10,"Contacto:".$arr["Contacto"]."" ,0,0);

     // Salto de linea
     $this->Ln(8);
     $this->Cell(60,10,"Correo:".$arr["Correo"]."" ,0,0);

}
 



//Encabezado donde se muestran los servicios y productos usados en el servicio
function HeaderProductosServicios()
{
   
     //Salto de linea
     $this->Ln(20);
    $this->SetFont('Arial','',12);
    //Color del texto
    $this->SetTextColor(247, 245, 245);
    //Color del borde
    $this->SetFillColor(24, 26, 24);
    //Texto
    $this->Cell(0,6,"Productos/Servicios",0,1,'L',true);
    //Salto de linea
    $this->Ln(4);

}


//aqui se muestran los servicios y productos utilizados
function TablaServiciosProductos()
{
    $obj = $this->DatosEncabezado();
    //Esto es para acceder a cada dato del json
    $arr = json_decode($obj, true);
    $this->SetTextColor(5,5,5);
    $header = array('Clave'
    , 'Descripcion', 
    'Cantidad',
    'Precio',
    'Total'
);
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(0, 25, 79);
    $this->SetTextColor(255);
    // $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',8);
    // Cabecera
    $w = array(20, 100, 20,20,20);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    $ReporteCotizacion =  new Cotizacion();
    $tempFontSize = 8;
    $fontSize = 8;
    //Se llama a la funcion que obtiene los datos para llenar los servicios y los productos
    $Datos = $ReporteCotizacion->ReporteCotizacionDet($GLOBALS["CotizacionId"]);
    
    //ni_set('memory_limit', '100000M');
    // foreach($Datos as $row)
    // {
    //     //Solo llenara los que son de tipo servicio
        
    //     $this->Cell($w[0],10,$row[0],'LR',0,'L',$fill);
    //     $cellwidth = 100;
    //     //echo $this->GetStringWidth($row[1]);
    //     // while($this->GetStringWidth($row[1]) > $cellwidth){
    //     //     $this->SetFontSize($tempFontSize -= 0.1);
    //     // }
        
    //     $this->Cell($cellwidth,10,$row[1],1,0);
    //     // $tempFontSize = $fontSize;
    //     // $this->SetFontSize($fontSize);
    //     $this->Cell($w[2],10,$row[2],'LR',0,'L',$fill);
    //     $this->Cell($w[3],10,$row[3],'LR',0,'L',$fill);
    //     $this->Cell($w[4],10,$row[4],'LR',0,'L',$fill);
    //     $this->Ln();
    //     $fill = !$fill;
        
    // }
    
    //metodo multicell
  
    foreach($Datos as $row){
        $cellwidth = 100;
        $cellheight =5;
        $line = 1;
        if($this->GetStringWidth($row[1])< $cellwidth ){
        $line =1;
        }else{
        $textLength = strlen($row[1]); //total del texto de descripcion
        $errMargin = 10;
        $startChar = 0;
        $maxChar = 0;
        $textArray = array();
        $tmpString = "";
        
        while ($startChar <  $textLength) {
            while (
                $this->GetStringWidth($tmpString) < ($cellwidth - $errMargin) &&
                ($startChar + $maxChar) < $textLength) {
                $maxChar++;
                $tmpString = substr($row[1], $startChar, $maxChar);
            }
            $startChar = $startChar + $maxChar;
           // echo($textArray);
           // echo($tmpString);
            array_push($textArray, $tmpString);
            $maxChar = 0;
            $tmpString = '';
        }
        $line = count($textArray);
        
        
        }
        $this->Cell($w[0],($line * $cellheight),$row[0],1);
        $xPos = $this->GetX();
        $yPos = $this->GetY();
        //$w, $h, $txt, $border=0, $align='J', $fill=false
        $this->MultiCell($cellwidth, $cellheight,$row[1],1);
        $this->SetXY($xPos + $cellwidth, $yPos);
        // $this->Cell($cellwidth,10,$row[1],1,0);
        // $tempFontSize = $fontSize;
        // $this->SetFontSize($fontSize);
        // $this->Cell($w[2],10,$row[2],'LR',0,'L',$fill);
        // $this->Cell($w[3],10,$row[3],'LR',0,'L',$fill);
        // $this->Cell($w[4],10,$row[4],'LR',0,'L',$fill);
        // $this->Ln();
        $this->Cell($w[2],($line * $cellheight),$row[2],1,0);
        $this->Cell($w[3],($line * $cellheight),$row[3],1,0);
        $this->Cell($w[4],($line * $cellheight),$row[4],1,1);
        $fill = !$fill;
    }
    // Línea de cierre
   // $this->Cell(array_sum($w),0,'','T');
     //Salto de linea
     
   
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
       //Movemos hacia la derecha el siguiente campo
       $this->Cell(150);
    //SubTotal
    $this->Cell(28,10,"SubTotal: $".$arr["SubTotal"]."" ,0,0,'C'); 
   $this->Ln(6);
   //IVA
   $this->Cell(150);
   $this->Cell(28,10,"IVA: $".$arr["IVA"]."" ,0,0,'C'); 
   $this->Ln(6);
   //Total
   $this->Cell(150);
   $this->Cell(28,10,"Total: $".$arr["Total"]."" ,0,0,'C'); 
   $this->Ln(6);
  
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
$pdf->HeaderProductosServicios();
$pdf->TablaServiciosProductos();
$pdf->Totales();
$pdf->Output();//Se crea el PDF


?>