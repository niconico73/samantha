<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_login'])){

		require_once "../controladores/loginControlador.php";
		$ins_login= new loginControlador();

		/*--------- Cerrar sesion ---------*/
        if($_POST['modulo_login']=="cerrar_sesion"){
			echo $ins_login->cerrar_sesion_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}
