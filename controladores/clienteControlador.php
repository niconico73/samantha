<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class clienteControlador extends mainModel{

        /*---------- Controlador agregar cliente ----------*/
        public function agregar_cliente_controlador(){

            $tipo_documento=mainModel::limpiar_cadena($_POST['cliente_tipo_documento_reg']);
            $numero_documento=mainModel::limpiar_cadena($_POST['cliente_numero_documento_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);

            $provincia=mainModel::limpiar_cadena($_POST['cliente_provincia_reg']);
            $ciudad=mainModel::limpiar_cadena($_POST['cliente_ciudad_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $email=mainModel::limpiar_cadena($_POST['cliente_email_reg']);

            /*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $provincia=="" || $ciudad=="" || $direccion=="" || $telefono==""){
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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$provincia)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Estado o provincia no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$ciudad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Ciudad o pueblo no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Calle o dirección no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

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
			
			/*== Comprobando documento ==*/
            $check_documento=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
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

            /*== Comprobando email ==*/
			if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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
            
            /*== Preparando datos para enviarlos al modelo ==*/
			$datos_cliente_reg=[
                "cliente_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
                ],
                "cliente_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
                ],
                "cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
                ],
                "cliente_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
                "cliente_provincia"=>[
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
                ],
                "cliente_ciudad"=>[
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
                ],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
                ],
                "cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
                ]
            ];

            $agregar_cliente=mainModel::guardar_datos("cliente",$datos_cliente_reg);

			if($agregar_cliente->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Cliente registrado!",
					"Texto"=>"Los datos del cliente se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el cliente, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

			$agregar_cliente->closeCursor();
			$agregar_cliente=mainModel::desconectar($agregar_cliente);

			echo json_encode($alerta);
        } /*-- Fin controlador --*/


        /*----------  Controlador paginador cliente  ----------*/
		public function paginador_cliente_controlador($pagina,$registros,$url,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE ((cliente_id!='1') AND (cliente_tipo_documento LIKE '%$busqueda%' OR cliente_numero_documento LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR 	cliente_provincia LIKE '%$busqueda%' OR cliente_ciudad LIKE '%$busqueda%')) ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE cliente_id!='1' ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
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
							<th>NOMBRE</th>
                            <th>ESTADO</th>
                            <th>CIUDAD</th>
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
							<td>'.$rows['cliente_tipo_documento'].': '.$rows['cliente_numero_documento'].'</td>
							<td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
                            <td>'.$rows['cliente_provincia'].'</td>
                            <td>'.$rows['cliente_ciudad'].'</td>
							<td>'.$rows['cliente_telefono'].'</td>
							<td>
								<a class="btn btn-success" href="'.SERVERURL.'client-update/'.mainModel::encryption($rows['cliente_id']).'/" >
									<i class="fas fa-sync fa-fw"></i>
								</a>
							</td>
							<td>
								<form class="FormularioAjax" action="'.SERVERURL.'ajax/clienteAjax.php" method="POST" data-form="delete" enctype="multipart/form-data" autocomplete="off" >
									<input type="hidden" name="cliente_id_del" value="'.mainModel::encryption($rows['cliente_id']).'">
									<input type="hidden" name="modulo_cliente" value="eliminar">
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
				$tabla.='<p class="text-right">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/


		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizar_cliente_controlador(){

			/*== Recibiendo id del cliente ==*/
			$id=mainModel::decryption($_POST['cliente_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando cliente por defecto ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos actualizar los datos de este cliente ya que es el definido por defecto (Publico en general).",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando cliente en la DB ==*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el cliente en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_cliente->fetch();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

			/*== Recibiendo datos del cliente ==*/
			$tipo_documento=mainModel::limpiar_cadena($_POST['cliente_tipo_documento_up']);
            $numero_documento=mainModel::limpiar_cadena($_POST['cliente_numero_documento_up']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_up']);

            $provincia=mainModel::limpiar_cadena($_POST['cliente_provincia_up']);
            $ciudad=mainModel::limpiar_cadena($_POST['cliente_ciudad_up']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_up']);

            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $email=mainModel::limpiar_cadena($_POST['cliente_email_up']);

            /*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $provincia=="" || $ciudad=="" || $direccion=="" || $telefono==""){
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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$provincia)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Estado o provincia no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$ciudad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Ciudad o pueblo no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Calle o dirección no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

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
			
			/*== Comprobando documento ==*/
			if($tipo_documento!=$campos['cliente_tipo_documento'] || $numero_documento!=$campos['cliente_numero_documento']){
				$check_documento=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
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

            /*== Comprobando email ==*/
			if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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
			
			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_cliente_up=[
                "cliente_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
                ],
                "cliente_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
                ],
                "cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
                ],
                "cliente_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
                "cliente_provincia"=>[
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
                ],
                "cliente_ciudad"=>[
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
                ],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
                ],
                "cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
                ]
			];
			
			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("cliente",$datos_cliente_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cliente actualizado!",
					"Texto"=>"Los datos del cliente se actualizaron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del cliente, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*----------  Controlador eliminar cliente  ----------*/
		public function eliminar_cliente_controlador(){

			/*== Recuperando id del cliente ==*/
			$id=mainModel::decryption($_POST['cliente_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando cliente principal ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar los datos de este cliente ya que es el definido por defecto (Publico en general)",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando cliente en la BD ==*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El cliente que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

			/*== Comprobando ventas ==*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM venta WHERE cliente_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el cliente debido a que tiene ventas asociadas.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			$eliminar_cliente=mainModel::eliminar_registro("cliente","cliente_id",$id);

			if($eliminar_cliente->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cliente eliminado!",
					"Texto"=>"El cliente ha sido eliminado del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el cliente del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}

			$eliminar_cliente->closeCursor();
			$eliminar_cliente=mainModel::desconectar($eliminar_cliente);

			echo json_encode($alerta);
		} /*-- Fin controlador --*/
    }