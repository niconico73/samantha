<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class usuarioControlador extends mainModel{

        /*---------- Controlador agregar usuario ----------*/
        public function agregar_usuario_controlador(){

            $tipo_documento=mainModel::limpiar_cadena($_POST['usuario_tipo_documento_reg']);
            $numero_documento=mainModel::limpiar_cadena($_POST['usuario_numero_documento_reg']);
            $cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);

			$genero=mainModel::limpiar_cadena($_POST['usuario_genero_reg']);
			$lector=mainModel::limpiar_cadena($_POST['usuario_lector_reg']);
			$tipo_codigo=mainModel::limpiar_cadena($_POST['usuario_tipo_codigo_reg']);
            $caja=mainModel::limpiar_cadena($_POST['usuario_caja_reg']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave_1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave_2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
            $estado=mainModel::limpiar_cadena($_POST['usuario_estado_reg']);

            $avatar=mainModel::limpiar_cadena($_POST['usuario_avatar_reg']);

            /*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" || $clave_2==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de documento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El apellido no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if($telefono!=""){
                if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El teléfono no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{4,25}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de usuario no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las contraseñas no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
			/*== Comprobando tipo de documento ==*/
			if(!in_array($tipo_documento, DOCUMENTOS_USUARIOS)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de documento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando cargo ==*/
			if($cargo!="Administrador" && $cargo!="Cajero"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El cargo no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando genero ==*/
			if($genero!="Masculino" && $genero!="Femenino"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El genero no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando configuracion de lector de codigo de barras ==*/
			if($lector!="Habilitado" && $lector!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor del estado del lector de código de barras no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($tipo_codigo!="Barras" && $tipo_codigo!="SKU"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor del tipo de código del lector de código de barras no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
            
            /*== Comprobando estado de la cuenta ==*/
			if($estado!="Activa" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado de la cuenta no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando documento ==*/
            $check_documento=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_tipo_documento='$tipo_documento' AND usuario_numero_documento='$numero_documento'");
			if($check_documento->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_documento->closeCursor();
			$check_documento=mainModel::desconectar($check_documento);

            /*== Comprobando caja de ventas ==*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM caja WHERE caja_id='$caja' AND caja_estado='Habilitada'");
			if($check_caja->rowCount()<1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La caja de ventas seleccionada no existe o se encuentra deshabilitada",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_caja->closeCursor();
			$check_caja=mainModel::desconectar($check_caja);

            /*== Comprobando usuario ==*/
            $check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			if($check_usuario->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de usuario ingresado ya está siendo utilizado, por favor elija otro",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_usuario->closeCursor();
			$check_usuario=mainModel::desconectar($check_usuario);

            /*== Comprobando email ==*/
			if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El correo electrónico ingresado ya se encuentra registrado en el sistema.",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
					$check_email->closeCursor();
					$check_email=mainModel::desconectar($check_email);
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un correo electrónico no valido.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
            }
            
            /*== Comprobando claves ==*/
			if($clave_1!=$clave_2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las contraseñas que acaba de ingresar no coinciden.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$clave=mainModel::encryption($clave_1);
            }
            
            /*== Comprobando privilegios ==*/
			if($_SESSION['cargo_svi']!="Administrador"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando foto o avatar ==*/
            if(!is_file("../vistas/assets/avatar/".$avatar)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el avatar en el sistema, por favor seleccione otro e intente nuevamente.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_usuario_reg=[
				"usuario_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
				"usuario_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
				"usuario_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"usuario_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				"usuario_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
				],
				"usuario_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"usuario_cargo"=>[
					"campo_marcador"=>":Cargo",
					"campo_valor"=>$cargo
				],
				"usuario_usuario"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				"usuario_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"usuario_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"usuario_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"usuario_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				],
				"usuario_lector"=>[
					"campo_marcador"=>":Lector",
					"campo_valor"=>$lector
				],
				"usuario_tipo_codigo"=>[
					"campo_marcador"=>":TipoCodigo",
					"campo_valor"=>$tipo_codigo
				],
				"caja_id"=>[
					"campo_marcador"=>":Caja",
					"campo_valor"=>$caja
				]
			];

			$agregar_usuario=mainModel::guardar_datos("usuario",$datos_usuario_reg);

			if($agregar_usuario->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡$cargo registrado!",
					"Texto"=>"Los datos del $cargo se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el $cargo, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

			$agregar_usuario->closeCursor();
			$agregar_usuario=mainModel::desconectar($agregar_usuario);

			echo json_encode($alerta);
        } /*-- Fin controlador --*/


		/*----------  Controlador paginador usuario  ----------*/
		public function paginador_usuario_controlador($pagina,$registros,$url,$busqueda,$id){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$id=mainModel::limpiar_cadena($id);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id!='$id' AND usuario_id!='1') AND (usuario_tipo_documento LIKE '%$busqueda%' OR usuario_numero_documento LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_cargo LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id!='$id' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas =ceil($total/$registros);

			### Cuerpo de la tabla ###
			$tabla.='
				<div class="table-responsive">
				<table class="table table-dark table-sm">
					<thead>
						<tr class="text-center roboto-medium">
							<th>#</th>
							<th>DOCUMENTO</th>
							<th>CARGO</th>
							<th>NOMBRE</th>
							<th>USUARIO</th>
							<th>TELEFONO</th>
							<th>ACTUALIZAR</th>
							<th>ELIMINAR</th>
						</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="text-center" >
							<td>'.$contador.'</td>
							<td>'.$rows['usuario_tipo_documento'].': '.$rows['usuario_numero_documento'].'</td>
							<td>'.$rows['usuario_cargo'].'</td>
							<td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
							<td>'.$rows['usuario_usuario'].'</td>
							<td>'.$rows['usuario_telefono'].'</td>
							<td>
								<a class="btn btn-success" href="'.SERVERURL.'user-update/'.mainModel::encryption($rows['usuario_id']).'/" >
									<i class="fas fa-sync fa-fw"></i>
								</a>
							</td>
							<td>
								<form class="FormularioAjax" action="'.SERVERURL.'ajax/usuarioAjax.php" method="POST" data-form="delete" enctype="multipart/form-data" autocomplete="off" >
									<input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
									<input type="hidden" name="modulo_usuario" value="eliminar">
									<button type="submit" class="btn btn-warning">
											<i class="far fa-trash-alt"></i>
									</button>
								</form>
							</td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/


		/*---------- Controlador actualizar usuario ----------*/
        public function actualizar_usuario_controlador(){

			/*== Recibiendo id del usuario ==*/
			$id=mainModel::decryption($_POST['usuario_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando usuario en la DB ==*/
			$check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE usuario_id='$id'");
			if($check_user->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado la cuenta de usuario en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_user->fetch();
			}
			$check_user->closeCursor();
			$check_user=mainModel::desconectar($check_user);

			/*== Recibiendo datos del usuario ==*/
			$tipo_documento=mainModel::limpiar_cadena($_POST['usuario_tipo_documento_up']);
			$numero_documento=mainModel::limpiar_cadena($_POST['usuario_numero_documento_up']);
			
			if(isset($_POST['usuario_cargo_up'])){
				$cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_up']);
			}else{
				$cargo=$campos['usuario_cargo'];
			}
			
			
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
            $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_up']);

			$genero=mainModel::limpiar_cadena($_POST['usuario_genero_up']);
			$lector=mainModel::limpiar_cadena($_POST['usuario_lector_up']);
			$tipo_codigo=mainModel::limpiar_cadena($_POST['usuario_tipo_codigo_up']);
            $caja=mainModel::limpiar_cadena($_POST['usuario_caja_up']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_up']);
            $clave_1=mainModel::limpiar_cadena($_POST['usuario_clave_1_up']);
			$clave_2=mainModel::limpiar_cadena($_POST['usuario_clave_2_up']);
			
			if(isset($_POST['usuario_estado_up'])){
				$estado=mainModel::limpiar_cadena($_POST['usuario_estado_up']);
			}else{
				$estado=$campos['usuario_estado'];
			}
            

			$avatar=mainModel::limpiar_cadena($_POST['usuario_foto_up']);
			
			$admin_usuario=mainModel::limpiar_cadena($_POST['administrador_usuario']);
			$admin_clave=mainModel::limpiar_cadena($_POST['administrador_clave']);


			/*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $usuario=="" || $admin_usuario=="" || $admin_clave==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			

			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de documento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El apellido no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if($telefono!=""){
                if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El teléfono no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{4,25}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de usuario no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[a-zA-Z0-9]{4,25}",$admin_usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de usuario de tu cuenta no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La contraseña de tu cuenta no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando tipo de documento ==*/
			if(!in_array($tipo_documento, DOCUMENTOS_USUARIOS)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de documento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando cargo ==*/
			if($cargo!="Administrador" && $cargo!="Cajero"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El cargo no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
            /*== Comprobando genero ==*/
			if($genero!="Masculino" && $genero!="Femenino"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El genero no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando configuracion de lector de codigo de barras ==*/
			if($lector!="Habilitado" && $lector!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor del estado del lector de código de barras no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($tipo_codigo!="Barras" && $tipo_codigo!="SKU"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor del tipo de código del lector de código de barras no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
            
            /*== Comprobando estado de la cuenta ==*/
			if($estado!="Activa" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado de la cuenta no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            
			/*== Comprobando documento ==*/
			if($tipo_documento!=$campos['usuario_tipo_documento'] || $numero_documento!=$campos['usuario_numero_documento']){
				$check_documento=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_tipo_documento='$tipo_documento' AND usuario_numero_documento='$numero_documento'");
				if($check_documento->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_documento->closeCursor();
				$check_documento=mainModel::desconectar($check_documento);
			}
            

            /*== Comprobando caja de ventas ==*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM caja WHERE caja_id='$caja' AND caja_estado='Habilitada'");
			if($check_caja->rowCount()<1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La caja de ventas seleccionada no existe o se encuentra deshabilitada",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_caja->closeCursor();
			$check_caja=mainModel::desconectar($check_caja);

			/*== Comprobando usuario ==*/
			if($usuario!=$campos['usuario_usuario']){
				$check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
				if($check_usuario->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre de usuario ingresado ya está siendo utilizado, por favor elija otro",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_usuario->closeCursor();
				$check_usuario=mainModel::desconectar($check_usuario);
			}

			/*== Comprobando email ==*/
			if($email!=$campos['usuario_email'] && $email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El correo electrónico ingresado ya se encuentra registrado en el sistema.",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}
					$check_email->closeCursor();
					$check_email=mainModel::desconectar($check_email);
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un correo electrónico no valido.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			/*== Comprobando claves ==*/
			if($clave_1!="" || $clave_2!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Las nuevas contraseñas no coincide con el formato solicitado.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}else{
					if($clave_1!=$clave_2){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Las nuevas contraseñas que acaba de ingresar no coinciden.",
							"Tipo"=>"error"
						];
						echo json_encode($alerta);
						exit();
					}else{
						$clave=mainModel::encryption($clave_1);
					}
				}
			}else{
				$clave=$campos['usuario_clave'];
			}
            
			/*== Comprobando foto o avatar ==*/
            if(!is_file("../vistas/assets/avatar/".$avatar)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el avatar en el sistema, por favor seleccione otro e intente nuevamente.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando credenciales para actualizar datos ==*/
			$admin_clave=mainModel::encryption($admin_clave);
			if($_SESSION['id_svi']!=$id){
				if($_SESSION['cargo_svi']!="Administrador"){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}

				$check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave'");
			}else{
				$check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave' AND usuario_id='$id'");
			}

			if($check_cuenta->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Nombre de usuario o contraseña de cuenta incorrectos.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$check_cuenta->closeCursor();
			$check_cuenta=mainModel::desconectar($check_cuenta);

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_usuario_up=[
				"usuario_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
				"usuario_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
				"usuario_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"usuario_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				"usuario_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
				],
				"usuario_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"usuario_cargo"=>[
					"campo_marcador"=>":Cargo",
					"campo_valor"=>$cargo
				],
				"usuario_usuario"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				"usuario_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"usuario_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"usuario_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"usuario_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				],
				"usuario_lector"=>[
					"campo_marcador"=>":Lector",
					"campo_valor"=>$lector
				],
				"usuario_tipo_codigo"=>[
					"campo_marcador"=>":TipoCodigo",
					"campo_valor"=>$tipo_codigo
				],
				"caja_id"=>[
					"campo_marcador"=>":Caja",
					"campo_valor"=>$caja
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("usuario",$datos_usuario_up,$condicion)){

				if($_SESSION['id_svi']==$id){
					$_SESSION['nombre_svi']=$nombre;
					$_SESSION['apellido_svi']=$apellido;
					$_SESSION['usuario_svi']=$usuario;
					$_SESSION['genero_svi']=$genero;
					$_SESSION['cargo_svi']=$cargo;
					$_SESSION['foto_svi']=$avatar;
					$_SESSION['caja_svi']=$caja;
					$_SESSION['lector_estado_svi']=$lector;
					$_SESSION['lector_codigo_svi']=$tipo_codigo;
				}

				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cuenta actualizada!",
					"Texto"=>"Los datos de la cuenta se actualizaron con éxito en el sistema",
					"Tipo"=>"success"
				];

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos de la cuenta, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador eliminar usuario ----------*/
		public function eliminar_usuario_controlador(){

			/*== Recuperando id del usuario ==*/
			$id=mainModel::decryption($_POST['usuario_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando usuario principal ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el usuario principal del sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando usuario en la BD ==*/
			$check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_id='$id'");
			if($check_usuario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El usuario que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_usuario->closeCursor();
			$check_usuario=mainModel::desconectar($check_usuario);

			/*== Comprobando ventas ==*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM venta WHERE usuario_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el usuario debido a que tiene ventas asociadas, recomendamos deshabilitar este usuario si ya no será usado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);


			/*== Comprobando movimientos ==*/
			$check_movimientos=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM movimiento WHERE usuario_id='$id' LIMIT 1");
			if($check_movimientos->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el usuario debido a que tiene movimientos asociados, recomendamos deshabilitar este usuario si ya no será usado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_movimientos->closeCursor();
			$check_movimientos=mainModel::desconectar($check_movimientos);

			/*== Comprobando privilegios ==*/
			if($_SESSION['cargo_svi']!="Administrador"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$eliminar_usuario=mainModel::eliminar_registro("usuario","usuario_id",$id);

			if($eliminar_usuario->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Usuario eliminado!",
					"Texto"=>"El usuario ha sido eliminado del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el usuario del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}

			$eliminar_usuario->closeCursor();
			$eliminar_usuario=mainModel::desconectar($eliminar_usuario);

			echo json_encode($alerta);
		} /*-- Fin controlador --*/
    }