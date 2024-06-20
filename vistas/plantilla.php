<?php
	/*---------- Iniciando sesion ----------*/
	include "./vistas/inc/session_start.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "./vistas/inc/Head.php"; ?>
</head>
<body>
	<?php
		$peticion_ajax=false;
		
		require_once "./controladores/vistasControlador.php";
		$IV = new vistasControlador();

		$vistas=$IV->obtener_vistas_controlador();

		if($vistas=="login" || $vistas=="404"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else{

			$pagina=explode("/", $_GET['views']);

			/*-- Instanciar controlador login --*/
			require_once "./controladores/loginControlador.php";
			$lc = new loginControlador();

			/*-- Forzar cierre de sesion --*/
			if(!isset($_SESSION['token_svi']) || !isset($_SESSION['usuario_svi']) || !isset($_SESSION['cargo_svi']) || !isset($_SESSION['caja_svi'])){
				$lc->forzar_cierre_sesion_controlador();
				exit();
			}
	?>
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php include "./vistas/inc/NavLateral.php"; ?>

		<!-- Page content -->
		<section class="full-box page-content scroll">
			<?php 
				include "./vistas/inc/NavBar.php";
				include $vistas;
			?>
		</section>
	</main>
	<?php
			include "./vistas/inc/LogOut.php";
		}
		include "./vistas/inc/Script.php"; 
	?>
</body>
</html>