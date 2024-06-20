<?php
// Obtén el número de documento y el tipo (RUC o DNI)
$documento = $_GET['numero'];
$tipoDocumento = $_GET['tipo']; // 'ruc' o 'dni'

// URL de la API de apis.net.pe
$apiUrl = "https://api.apis.net.pe/v2/{$tipoDocumento}/{$documento}";

// Tu token de autenticación
$token = "apis-token-9016.l53yw-78s-VCMViWe7AinqkBV8PNN-tt"; // Reemplaza con tu token real

// Configuración de cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Referer: https://apis.net.pe/consulta-dni-api', // O ajusta según el tipo de documento
    'Authorization: Bearer ' . $token
));

// Ejecutar la petición
$response = curl_exec($ch);
curl_close($ch);

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo $response;