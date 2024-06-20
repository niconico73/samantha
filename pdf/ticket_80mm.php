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

    // ***** INICIO INTEGRACIÓN NUBEFACT (BOLETA) *****

    $ruta = "https://api.nubefact.com/api/v1/ee3e84f1-8ee6-4ad9-a0d9-2ad2c62bdcb7";
    $token = "07f66bd825c1498e9bb4eabc7645f3c371c1af7e9a244d8bbbebb14155a1219c"; 

    $data = array(
        "operacion"                    => "generar_comprobante",
        "tipo_de_comprobante"          => "2", 
        "serie"                        => "BBB1", 
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

    $venta_detalle = $ins_venta->datos_tabla("Normal", "venta_detalle WHERE venta_codigo='" . $datos_venta['venta_codigo'] . "'", "*", 0);
    $venta_detalle = $venta_detalle->fetchAll();

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
            "tipo_de_igv" => 1, 
            "igv" => number_format($igv, 2, '.', ''),
            "total" => number_format($detalle['venta_detalle_total'], 2, '.', ''),
            "anticipo_regularizacion" => "false"
        ];
    }

    $data_json = json_encode($data);

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

    // Manejo de errores mejorado
    if (isset($leer_respuesta['errors'])) {
        $errores = is_array($leer_respuesta['errors']) ? $leer_respuesta['errors'] : [$leer_respuesta['errors']]; // Asegurarse de que sea un array
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<i class='fas fa-times-circle'></i> Error al generar la boleta: " . implode(", ", $errores); 
        echo "</div>";
    } else {
        $enlace_pdf = $leer_respuesta['enlace_del_pdf'];

        echo "<div class='alert alert-success' role='alert'>";
        echo "<i class='fas fa-check-circle'></i> Boleta creada con éxito. ";
        echo "<a href='$enlace_pdf' target='_blank' class='alert-link'>Descargar PDF</a>";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-warning' role='alert'>";
    echo "<i class='fas fa-exclamation-triangle'></i> No se encontró la venta.";
    echo "</div>";
}