<?php
$peticion_ajax = true;
$code = (isset($_GET['code'])) ? $_GET['code'] : 0;

require_once "../config/APP.php";
require_once "../controladores/ventaControlador.php";

$ins_venta = new ventaControlador();
$datos_venta = $ins_venta->datos_tabla("Normal", "venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE (venta_codigo='$code')", "*", 0);

if ($datos_venta->rowCount() == 1) {
    $datos_venta = $datos_venta->fetch();
    $datos_empresa = $ins_venta->datos_tabla("Normal", "empresa LIMIT 1", "*", 0)->fetch();

    // ***** INICIO INTEGRACIÓN NUBEFACT - BOLETA *****
    $ruta = "https://api.nubefact.com/api/v1/ee3e84f1-8ee6-4ad9-a0d9-2ad2c62bdcb7"; 
    $token = "07f66bd825c1498e9bb4eabc7645f3c371c1af7e9a244d8bbbebb14155a1219c"; 

    $data = array(
        "operacion"                    => "generar_comprobante",
        "tipo_de_comprobante"          => "2", // 2 para Boleta de Venta
        "serie"                        => "BBB1", // Serie para boletas
        "numero"                       => $datos_venta['venta_id'],
        "sunat_transaction"            => "1",
        "cliente_tipo_de_documento"    => $datos_venta['cliente_tipo_documento'],
        "cliente_numero_de_documento"  => $datos_venta['cliente_numero_documento'],
        "cliente_denominacion"         => $datos_venta['cliente_nombre'] . ' ' . $datos_venta['cliente_apellido'],
        "cliente_direccion"            => $datos_venta['cliente_direccion'],
        "fecha_de_emision"             => date('Y-m-d', strtotime($datos_venta['venta_fecha'])),
        "moneda"                       => "1",
        "porcentaje_de_igv"            => "18.00",
        "total_gravada"                => $datos_venta['venta_subtotal'],
        "total_igv"                    => $datos_venta['venta_impuestos'],
        "total"                        => $datos_venta['venta_total_final'],
        "enviar_automaticamente_a_la_sunat" => "true",
        "items" => array()
    );

    // Datos de los items (igual que para la factura)
    $venta_detalle = $ins_venta->datos_tabla("Normal", "venta_detalle WHERE venta_codigo='" . $datos_venta['venta_codigo'] . "'", "*", 0)->fetchAll();

    foreach ($venta_detalle as $detalle) {
        $valor_unitario = $detalle['venta_detalle_precio_venta'] / 1.18;
        $subtotal = $valor_unitario * $detalle['venta_detalle_cantidad'];
        $igv = $subtotal * 0.18;

        $data['items'][] = [
            "unidad_de_medida" => "NIU",
            "descripcion" => $detalle['venta_detalle_descripcion'],
            "cantidad" => $detalle['venta_detalle_cantidad'],
            "valor_unitario" => number_format($valor_unitario, 2, '.', ''),
            "precio_unitario" => number_format($detalle['venta_detalle_precio_venta'], 2, '.', ''),
            "subtotal" => number_format($subtotal, 2, '.', ''),
            "tipo_de_igv" => 1, // Asumiendo que todos los productos son gravados
            "igv" => number_format($igv, 2, '.', ''),
            "total" => number_format($detalle['venta_detalle_total'], 2, '.', ''),
            "anticipo_regularizacion" => "false"
        ];
    }

    $data_json = json_encode($data);

    //Invocamos el servicio de NUBEFACT
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Token token="' . $token . '"',
        'Content-Type: application/json',
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);
    curl_close($ch);

 // ***** FIN INTEGRACIÓN NUBEFACT *****

 $leer_respuesta = json_decode($respuesta, true);
 if (isset($leer_respuesta['errors'])) {
     // Mostramos los errores si los hay
     echo "Error al generar la factura: " . $leer_respuesta['errors'];
 } else {
     // Factura generada con éxito
     $enlace_pdf = $leer_respuesta['enlace_del_pdf'];
     $enlace_xml = $leer_respuesta['enlace_del_xml'];

     echo "<div class='alert alert-success' role='alert'>Factura generada con éxito. Enlace al PDF: <a href='$enlace_pdf' target='_blank'>Descargar PDF</a></div>";

     // Mostrar respuesta de NubeFacT en una tabla HTML
     echo "<h2>RESPUESTA DE SUNAT</h2>";
echo "<table border='1' style='border-collapse: collapse'><tbody>";
foreach ($leer_respuesta as $clave => $valor) {
    if (is_array($valor)) {
        // Si el valor es un array, lo recorremos
        echo "<tr><th colspan='2'>$clave:</th></tr>";
        foreach ($valor as $subclave => $subvalor) {
            echo "<tr><th>$subclave:</th><td>$subvalor</td></tr>";
        }
    } else {
        // Si el valor no es un array, lo mostramos directamente
        echo "<tr><th>$clave:</th><td>$valor</td></tr>";
    }
}
echo "</tbody></table>";

     // ... (código para generar tu PDF personalizado o usar el PDF de NubeFacT)
 }
} else {
 // ... (tu código para manejar el caso de que no se encuentre la venta)
}