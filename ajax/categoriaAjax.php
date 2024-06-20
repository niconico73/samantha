<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";
    include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_categoria'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/categoriaControlador.php";
        $ins_categoria = new categoriaControlador();

        /*--------- Agregar categoria ---------*/
        if($_POST['modulo_categoria']=="registrar"){
            echo $ins_categoria->agregar_categoria_categoria();
        }
        
        /*--------- Actualizar categoria ---------*/
        if($_POST['modulo_categoria']=="actualizar"){
            echo $ins_categoria->actualizar_categoria_controlador();
		}
        
        /*--------- Eliminar categoria ---------*/
        if($_POST['modulo_categoria']=="eliminar"){
            echo $ins_categoria->eliminar_categoria_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."login/");
	}