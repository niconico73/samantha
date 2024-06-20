<?php
// Conexión a la basede datos (reemplaza con tus datos)
$pdo = new PDO("mysql:host=tu_host;dbname=tu_base_de_datos", "tu_usuario", "tu_contraseña");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $venta_codigo = $_POST["venta_codigo"];
    $metodo_pago = $_POST["metodo_pago"];
    $numero_operacion = $_POST["numero_operacion"];
    $tipo_pago = $_POST["tipo_pago"];

    // Validación de datos (puedes agregar más validaciones según tus necesidades)
    if (empty($venta_codigo) || empty($metodo_pago) || empty($numero_operacion) || empty($tipo_pago)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }

    // Determinar el número de pago
    $pago_numero = ($tipo_pago == "Pago inicial") ? 1 : 2;

    // Obtener fecha y hora actual
    $pago_fecha = date("Y-m-d"); 
    $pago_hora = date("H:i:s");

    try {
        // Iniciar una transacción (opcional, pero recomendado para garantizar la integridad de los datos)
        $pdo->beginTransaction();

        // Insertar el pago en la tabla pago
        $stmt = $pdo->prepare("INSERT INTO pago (venta_codigo, pago_fecha, pago_hora, pago_monto, usuario_id, caja_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$venta_codigo, $pago_fecha, $pago_hora, $datos_venta['venta_total_final'], $_SESSION['usuario_svi'], $_SESSION['caja_svi']]);
        $pago_id = $pdo->lastInsertId(); // Obtener el ID del pago insertado
        
        // Insertar el detalle del pago en la tabla detalle_pago
        $stmt = $pdo->prepare("INSERT INTO detalle_pago (pago_id, venta_codigo, pago_numero, metodo_pago, numero_operacion) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$pago_id, $venta_codigo, $pago_numero, $metodo_pago, $numero_operacion]);

        // Confirmar la transacción (opcional)
        $pdo->commit();

        // Redirigir de vuelta a la página de detalles de la venta
        header("Location: detalles_venta.php?venta_codigo=" . $venta_codigo);
        exit();
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error (opcional)
        $pdo->rollBack();

        echo "Error al registrar el pago: " . $e->getMessage();
    }
}