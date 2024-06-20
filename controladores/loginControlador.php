<?php
	if($peticion_ajax){
		require_once "../modelos/loginModelo.php";
	}else{
		require_once "./modelos/loginModelo.php";
	}

	class loginControlador extends loginModelo{

		/*----------  Controlador iniciar sesion  ----------*/
		public function iniciar_sesion_controlador(){

			$usuario=mainModel::limpiar_cadena($_POST['usuario_log']);
			$clave=mainModel::limpiar_cadena($_POST['clave_log']);

			/*== Comprobando campos vacios ==*/
			if($usuario=="" || $clave==""){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "No has llenado todos los campos que son requeridos.",
					  type: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}


			/*== Verificando integridad datos ==*/
			if(mainModel::verificar_datos("[a-zA-Z0-9]{4,35}",$usuario)){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "El nombre de usuario no coincide con el formato solicitado.",
					  type: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}
			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "La contraseña no coincide con el formato solicitado.",
					  type: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}

			$clave=mainModel::encryption($clave);

			$datos_login=[
				"Usuario"=>$usuario,
				"Clave"=>$clave
			];

			$datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);

			if($datos_cuenta->rowCount()==1){

				$row=$datos_cuenta->fetch();

				$datos_cuenta->closeCursor();
			    $datos_cuenta=mainModel::desconectar($datos_cuenta);

				$_SESSION['id_svi']=$row['usuario_id'];
				$_SESSION['nombre_svi']=$row['usuario_nombre'];
				$_SESSION['apellido_svi']=$row['usuario_apellido'];
				$_SESSION['genero_svi']=$row['usuario_genero'];
				$_SESSION['usuario_svi']=$row['usuario_usuario'];
				$_SESSION['cargo_svi']=$row['usuario_cargo'];
				$_SESSION['foto_svi']=$row['usuario_foto'];
				$_SESSION['lector_estado_svi']=$row['usuario_lector'];
				$_SESSION['lector_codigo_svi']=$row['usuario_tipo_codigo'];
				$_SESSION['caja_svi']=$row['caja_id'];
				$_SESSION['token_svi']=mainModel::encryption(uniqid(mt_rand(), true));

				if(headers_sent()){
					echo "<script> window.location.href='".SERVERURL."dashboard/'; </script>";
				}else{
					return header("Location: ".SERVERURL."dashboard/");
				}

			}else{
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "El nombre de usuario o contraseña no son correctos.",
					  type: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
			}
		} /*-- Fin controlador --*/


		/*----------  Controlador forzar cierre de sesion  ----------*/
		public function forzar_cierre_sesion_controlador(){

			unset($_SESSION['id_svi']);
			unset($_SESSION['nombre_svi']);
			unset($_SESSION['apellido_svi']);
			unset($_SESSION['genero_svi']);
			unset($_SESSION['usuario_svi']);
			unset($_SESSION['cargo_svi']);
			unset($_SESSION['foto_svi']);
			unset($_SESSION['lector_estado_svi']);
			unset($_SESSION['lector_codigo_svi']);
			unset($_SESSION['caja_svi']);
			unset($_SESSION['token_svi']);

			session_destroy();

			if(headers_sent()){
				echo "<script> window.location.href='".SERVERURL."login/'; </script>";
			}else{
				return header("Location: ".SERVERURL."login/");
			}
		} /*-- Fin controlador --*/


		/*----------  Controlador cierre de sesion  ----------*/
		public function cerrar_sesion_controlador(){

			$token=mainModel::decryption($_POST['token']);
			$usuario=mainModel::decryption($_POST['usuario']);

			if($token==$_SESSION['token_svi'] && $usuario==$_SESSION['usuario_svi']){

				unset($_SESSION['id_svi']);
				unset($_SESSION['nombre_svi']);
				unset($_SESSION['apellido_svi']);
				unset($_SESSION['genero_svi']);
				unset($_SESSION['usuario_svi']);
				unset($_SESSION['cargo_svi']);
				unset($_SESSION['foto_svi']);
				unset($_SESSION['lector_estado_svi']);
				unset($_SESSION['lector_codigo_svi']);
				unset($_SESSION['caja_svi']);
				unset($_SESSION['token_svi']);

				session_destroy();
				
				$alerta=[
					"Alerta"=>"redireccionar",
					"URL"=>SERVERURL."login/"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se pudo cerrar la sesión.",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/

        /*----------  Controlador para obtener ventas según el rol del usuario  ----------*/
		public function obtener_ventas_controlador($pagina){
            // Verifica si el usuario está autenticado
            if (!isset($_SESSION['cargo_svi'])) {
                // Si el usuario no está autenticado, redirige a la página de inicio de sesión
                header("Location: login.php");
                exit();
            }

            // Obtén el rol del usuario actual desde la sesión
            $rol = $_SESSION['cargo_svi'];

            // Incluye el controlador de ventas
            require_once "../controladores/ventaControlador.php";
            $ins_venta = new ventaControlador();

            // Si el usuario es Administrador, muestra todas las ventas
            if ($rol == "administrador") {
                echo $ins_venta->paginador_venta_controlador($pagina[1], 15, $pagina[0], "", "");
            } elseif ($rol == "cajero") {
                // Si el usuario es Cajero, muestra solo las ventas realizadas por él mismo
                if (!isset($_SESSION['id_svi'])) {
                    // Si no se ha almacenado el ID del cajero en la sesión, redirige a la página de inicio de sesión
                    header("Location: login.php");
                    exit();
                }
                $usuario_id = $_SESSION['id_svi'];
                echo $ins_venta->paginador_venta_controlador($pagina[1], 15, $pagina[0], "usuario_id", $usuario_id);
            } else {
                // Si el usuario tiene otro rol, muestra un mensaje de error o redirige a una página apropiada
                echo "Acceso no autorizado";
            }
        } /*-- Fin controlador --*/

	}
?>
