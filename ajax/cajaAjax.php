<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_caja'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/cajaControlador.php";
        $ins_caja = new cajaControlador();
        
        /*--------- Agregar caja ---------*/
        if($_POST['modulo_caja']=="registrar"){
            echo $ins_caja->agregar_caja_controlador();
		}
		
		/*--------- Actualizar caja ---------*/
		if($_POST['modulo_caja']=="actualizar"){
			echo $ins_caja->actualizar_caja_controlador();
		}

		/*--------- Eliminar caja ---------*/
		if($_POST['modulo_caja']=="eliminar"){
			echo $ins_caja->eliminar_caja_controlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}