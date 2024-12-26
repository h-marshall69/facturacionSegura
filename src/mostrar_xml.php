<?php

declare(strict_types=1);

use PhpZip\ZipFile;

require '../vendor/autoload.php';

// Verificar si el parámetro "f" está presente en la URL.
if (!isset($_GET['f'])) {
    echo 'Parámetro "f" requerido.';
    exit();
}

$file = $_GET['f'];
$baseFiles =  '..\file'; // Asegúrate de que esta es la ruta correcta para la carpeta 'file'.

// Normalizar la ruta eliminando posibles barras invertidas
//$file = str_replace('\\', '/', $file);  // Reemplazar cualquier barra invertida por barra normal.

// Verificar que el archivo solicitado está en la carpeta 'file'.
$info = pathinfo($file);
$zipPath = $baseFiles . DIRECTORY_SEPARATOR . $info['basename'];
$xmlPath = $baseFiles . DIRECTORY_SEPARATOR . $info['filename'] . '.xml';

// Si el archivo XML ya existe, simplemente lo mostramos.
if (file_exists($xmlPath)) {
    header('Content-Type: text/xml');
    readfile($xmlPath);
    exit();
}

// Verificar si el archivo ZIP existe.
if (!file_exists($zipPath)) {
    echo $zipPath;
    echo 'Archivo ZIP no existe.';
    exit();
}

try {
    // Abrir y extraer el archivo ZIP.
    $zipFile = new ZipFile();
    $zipFile->openFile($zipPath);
    $zipFile->extractTo($baseFiles); // Extraer a la carpeta 'file'
    $zipFile->close();

    // Verificar si el archivo XML fue extraído correctamente.
    if (file_exists($xmlPath)) {
        header('Content-Type: text/xml');
        readfile($xmlPath);
    } else {
        echo 'Archivo XML no encontrado después de extraer el ZIP.';
    }
} catch (Exception $e) {
    // Manejo de errores en caso de problemas con el ZIP.
    echo 'Error al procesar el archivo ZIP: ' . $e->getMessage();
}
