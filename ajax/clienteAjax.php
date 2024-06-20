<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_cliente'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();

        /*--------- Agregar cliente ---------*/
        if($_POST['modulo_cliente']=="registrar"){
            echo $ins_cliente->agregar_cliente_controlador();
		}
		
		/*--------- Actualizar cliente ---------*/
        if($_POST['modulo_cliente']=="actualizar"){
            echo $ins_cliente->actualizar_cliente_controlador();
        }

		/*--------- Eliminar cliente ---------*/
        if($_POST['modulo_cliente']=="eliminar"){
			echo $ins_cliente->eliminar_cliente_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}