<?php
$peticion_ajax = true;
require_once "../config/APP.php";
include "../vistas/inc/session_start.php";

if (isset($_POST['modulo_venta'])) {
    require_once "../controladores/ventaControlador.php";
    $ins_venta = new ventaControlador();

    switch ($_POST['modulo_venta']) {
        case 'agregar_producto':
            echo $ins_venta->agregar_producto_carrito_controlador();
            break;
        
        case 'eliminar_producto':
            echo $ins_venta->eliminar_producto_carrito_controlador();
            break;
            
        
        case 'actualizar_producto':
            echo $ins_venta->actualizar_producto_carrito_controlador();
            break;
        
        case 'buscar_cliente':
            echo $ins_venta->buscar_cliente_venta_controlador();
            break;
        
        case 'agregar_cliente':
            echo $ins_venta->agregar_cliente_venta_controlador();
            break;
        
        case 'eliminar_cliente':
            echo $ins_venta->eliminar_cliente_venta_controlador();
            break;
        
        case 'buscar_codigo':
            echo $ins_venta->buscar_codigo_venta_controlador();
            break;
        
        case 'aplicar_descuento':
            echo $ins_venta->aplicar_descuento_venta_controlador();
            break;
        
        case 'remover_descuento':
            echo $ins_venta->remover_descuento_venta_controlador();
            break;
        
        case 'registrar_venta':
            echo $ins_venta->registrar_venta_controlador();
            break;
        
        case 'agregar_pago':
            echo $ins_venta->agregar_pago_venta_controlador();
            break;

        case 'registrar_detalle_pago':
                echo $ins_venta->registrar_detalle_pago_controlador();
                break;

        case 'actualizar_detalle_pago':
                    echo $ins_venta->actualizar_detalle_pago_controlador();
                    break;
        
        case 'eliminar_venta':
            echo $ins_venta->eliminar_venta_controlador();
            break;
        
        default:
            echo json_encode(array("success" => false, "message" => "M贸dulo de venta no v谩lido"));
            break;
    }
} else {
    session_destroy();
    header("Location: " . SERVERURL . "login/");
}
?>
