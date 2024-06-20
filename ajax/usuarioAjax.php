<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_usuario'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();

        /*--------- Agregar usuario ---------*/
        if($_POST['modulo_usuario']=="registrar"){
            echo $ins_usuario->agregar_usuario_controlador();
		}
		
		/*--------- Actualizar usuario ---------*/
        if($_POST['modulo_usuario']=="actualizar"){
            echo $ins_usuario->actualizar_usuario_controlador();
		}
		
		/*--------- Eliminar usuario ---------*/
        if($_POST['modulo_usuario']=="eliminar"){
            echo $ins_usuario->eliminar_usuario_controlador();
        }
        
	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}