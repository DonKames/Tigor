<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

ob_start();
include "Cotizacion.php";
$html = ob_get_clean();
echo $html;


$dompdf = new Dompdf();
//$options = $dompdf->getOptions();
//$options->set(array('isRemoteEnabled' => true));
//$dompdf->setOptions($options);
$dompdf->loadHtml($html);
//$dompdf->setPaper('letter');
$dompdf->render();
//header("Content-type: application/pdf");
//header("Content-Disposition: inline; filename=documento.pdf");
//echo $dompdf->output();
//$dompdf->stream("cotizacion.pdf", array("Attachment" => false));

/*if (isset($_POST['btnForm'])) {
    require_once '../vendor/autoload.php';
    require_once 'BaseDatos.php';
    require_once 'GUMPController.php';
    $cc = new CrearPDF;
    switch ($_POST['btnForm']) {
        case 'crearPDF':
            $cc->crearPDF();
            break;
    }
}*/

/*class CrearPDF{
    function crearPDF(){
        $pdf = new Dompdf();
        $pdf->loadHtml($_POST['cotizacion']);
        $pdf->render();
        $resultadoPdf = $pdf->output();
        $name = "cotizacion.pdf";
        $bytes = file_put_contents($name, $resultadoPdf);
    }
}*/