<?php
//ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../scripts/funcionesCotizacion.js"></script>

    <script src="../node_modules/html2pdf.js/dist/html2pdf.bundle.min.js"></script>

    <!--<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../sass/custom.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container" id="body">
        <div class="row card">
            <div class="card-body">
                <div class="row">
                    <img src="../imgs/tigor header cotiz.jpg" alt="">
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon1">Nombre</span>
                            <input type="text" class="form-control" placeholder="Username" value="Nombre" aria-label="Username" id="nombreCotizacion" aria-describedby="basic-addon1" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon2">N° Cotización</span>
                            <input type="text" class="form-control" placeholder="Username" value="N° Cotización" aria-label="Username" id="numeroCotizacion" aria-describedby="basic-addon2" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon3">RUT</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="rutCotizacion" aria-describedby="basic-addon3" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon4">Fecha</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="fechaCotizacion" aria-describedby="basic-addon4" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon5">Dirección</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="direccionCotizacion" aria-describedby="basic-addon5" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon6">Comuna</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="comunaCotizacion" aria-describedby="basic-addon6" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon7">Email</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="emailCotizacion" aria-describedby="basic-addon7" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text col-3" id="basic-addon8">Teléfono</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="telefonoCotizacion" aria-describedby="basic-addon8" readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Valor Unitario</th>
                                    <th>Unidades</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="tBodyProdsCotizacion"></tbody>
                        </table>
                        <div class="d-flex flex-row-reverse">
                            <div class="col-12 col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text col-3" id="basic-addon1">Valor Neto</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" value="0" id="valorNetoCotizacion" aria-describedby="basic-addon1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <div class="col-12 col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text col-3" id="basic-addon1">IVA 19%</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" value="0" id="ivaNetoCotizacion" aria-describedby="basic-addon1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <div class="col-12 col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text col-3" id="basic-addon1">TOTAL</span>
                                    <input type="text" class="form-control fw-bold" placeholder="Username" aria-label="Username" value="0" id="totalCotizacion" aria-describedby="basic-addon1" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = crearPDF();
    </script>
</body>

</html>
<?php
/*ob_start();
include "./Cotizacion.php";
$html = ob_get_clean();
echo $html;

require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
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
//$dompdf->stream();*/
?>