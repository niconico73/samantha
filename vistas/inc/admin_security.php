<?php
    if($_SESSION['cargo_svi']!="Administrador"){
        $lc->forzar_cierre_sesion_controlador();
		exit();
    }