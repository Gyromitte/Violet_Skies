<?php
require_once 'vendor/autoload.php'; // Cargar la librería AWS SDK para PHP

use Aws\S3\S3Client;
use Aws\Exception\S3Exception;

$bucketName = 'violetskiesbucket'; // Reemplaza con el nombre de tu bucket
$archivoSubido = $_FILES['archivo'];

// Configura las credenciales y el cliente de Amazon S3
$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'us-east-1', // Reemplaza con tu región
    'credentials' => [
        'key' => 'AKIASU4V6AHHNR5A3SHF',
        'secret' => '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',
    ],
]);

try {
    // Subir el archivo a Amazon S3
    $resultado = $s3->putObject([
        'Bucket' => $bucketName,
        'Key' => $archivoSubido['name'],
        'Body' => fopen($archivoSubido['tmp_name'], 'rb'),
        'ACL' => 'public-read', // Hacer el archivo público
    ]);

    // Obtener la URL pública del archivo
    $urlArchivo = $resultado['ObjectURL'];

    // Mostrar la URL del archivo subido
    echo "Archivo subido exitosamente. URL: <a href=\"$urlArchivo\">$urlArchivo</a>";
} catch (S3Exception $e) {
    echo "Error al subir el archivo: " . $e->getMessage();
}
?>