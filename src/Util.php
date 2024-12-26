<?php

require '../vendor/autoload.php';

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\GeneratorFactory;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\HtmlReport;
use Greenter\Report\PdfReport;  // Usamos PdfReport de Greenter
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\XmlUtils;
use Greenter\See;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;

/**@var $see See*/
$see = require '../resources/config.php';

// Datos del formulario
$serie = $_POST['serie'] ?? 'F001';
$correlativo = $_POST['correlativo'] ?? '1';
$fechaEmision = $_POST['fechaEmision'] ?? date('Y-m-d\TH:i:s');
$tipoMoneda = $_POST['moneda'] ?? 'PEN';

// Datos del cliente
$tipoDoc = $_POST['tipoDoc'] ?? '6';
$numDoc = $_POST['numDoc'] ?? '20000000001';
$rznSocial = $_POST['rznSocial'] ?? 'CLIENTE GENERICO';

// Crear cliente
$client = new Client();
$client->setTipoDoc($tipoDoc)
    ->setNumDoc($numDoc)
    ->setRznSocial($rznSocial);

// Datos del emisor
$address = new Address();
$address->setUbigueo('150101')
    ->setDepartamento('LIMA')
    ->setProvincia('LIMA')
    ->setDistrito('LIMA')
    ->setUrbanizacion('-')
    ->setDireccion('Av. Villa Nueva 221')
    ->setCodLocal('0000');

$company = new Company();
$company->setRuc('20123456769')
    ->setRazonSocial('GREEN SAC')
    ->setNombreComercial('GREEN')
    ->setAddress($address);

// Crear factura
$invoice = new Invoice();
$invoice->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie($serie)
    ->setCorrelativo($correlativo)
    ->setFechaEmision(new DateTime($fechaEmision))
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda($tipoMoneda)
    ->setCompany($company)
    ->setClient($client);

// Procesar productos
$productos = $_POST['productos'] ?? [];
$totalGravadas = 0;
$totalIGV = 0;
$totalVenta = 0;

$details = [];
foreach ($productos as $producto) {
    $cantidad = (float)$producto['cantidad'];
    $precioUnitario = (float)$producto['precio'];
    $valorVenta = $cantidad * $precioUnitario;
    $igv = $valorVenta * 0.18;
    $precioTotal = $valorVenta + $igv;

    $item = new SaleDetail();
    $item->setCodProducto($producto['codigo'])
        ->setUnidad('NIU')
        ->setCantidad($cantidad)
        ->setDescripcion($producto['descripcion'])
        ->setMtoBaseIgv($valorVenta)
        ->setPorcentajeIgv(18.00)
        ->setIgv($igv)
        ->setTipAfeIgv('10')
        ->setTotalImpuestos($igv)
        ->setMtoValorVenta($valorVenta)
        ->setMtoValorUnitario($precioUnitario)
        ->setMtoPrecioUnitario($precioUnitario * 1.18);

    $details[] = $item;

    $totalGravadas += $valorVenta;
    $totalIGV += $igv;
    $totalVenta += $precioTotal;
}

$invoice->setMtoOperGravadas($totalGravadas)
    ->setMtoIGV($totalIGV)
    ->setTotalImpuestos($totalIGV)
    ->setValorVenta($totalGravadas)
    ->setSubTotal($totalVenta)
    ->setMtoImpVenta($totalVenta)
    ->setDetails($details);

// Leyenda
$legend = new Legend();
$legend->setCode('1000')
    ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');
$invoice->setLegends([$legend]);

// Envío a SUNAT
$result = $see->send($invoice);

if (!$result->isSuccess()) {
    echo 'Error: ' . $result->getError()->getCode() . ' - ' . $result->getError()->getMessage();
    exit();
}

// Guardar XML firmado
file_put_contents('../files/' . $invoice->getName() . '.xml', $see->getFactory()->getLastXml());

// Guardar CDR
file_put_contents('../files/'. 'R-' . $invoice->getName() . '.zip', $result->getCdrZip());

// Respuesta de SUNAT
$cdr = $result->getCdrResponse();
echo 'Estado: ' . $cdr->getDescription();

header('Location: ../index.php');
exit(); 