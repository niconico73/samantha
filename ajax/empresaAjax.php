<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_empresa'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/empresaControlador.php";
		$ins_empresa = new empresaControlador();
		
		/*--------- Agregar empresa ---------*/
		if($_POST['modulo_empresa']=="registrar"){
			echo $ins_empresa->agregar_empresa_controlador();
		}

		/*--------- Actualizar empresa ---------*/
		if($_POST['modulo_empresa']=="actualizar"){
			echo $ins_empresa->actualizar_empresa_controlador();
		}
        
	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}