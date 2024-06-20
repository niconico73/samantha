<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_movimiento'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/movimientoControlador.php";
        $ins_movimiento = new movimientoControlador();
        
        /*--------- Agregar movimiento ---------*/
        if($_POST['modulo_movimiento']=="registrar"){
            echo $ins_movimiento->agregar_movimiento_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}