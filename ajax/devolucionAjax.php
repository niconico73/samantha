<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_devolucion'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/devolucionControlador.php";
        $ins_devolucion = new devolucionControlador();
        
		/*--------- Devolucion de venta ---------*/
		if($_POST['modulo_devolucion']=="venta"){
			echo $ins_devolucion->devolucion_venta_controlador();
		}
        
	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}