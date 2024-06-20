<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class cajaControlador extends mainModel{

        /*---------- Controlador agregar caja ----------*/
        public function agregar_caja_controlador(){

            $numero=mainModel::limpiar_cadena($_POST['caja_numero_reg']);
			$nombre=mainModel::limpiar_cadena($_POST['caja_nombre_reg']);
			$estado=mainModel::limpiar_cadena($_POST['caja_estado_reg']);
			$efectivo=mainModel::limpiar_cadena($_POST['caja_efectivo_reg']);

            /*== comprobar campos vacios ==*/
            if($numero=="" || $nombre==""){
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
			if(mainModel::verificar_datos("[0-9]{1,5}",$numero)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre o código de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9.]{1,25}",$efectivo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El efectivo de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando estado de la caja ==*/
			if($estado!="Habilitada" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado de la caja no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
            
            /*== Comprobando numero de caja ==*/
			$check_numero=mainModel::ejecutar_consulta_simple("SELECT caja_numero FROM caja WHERE caja_numero='$numero'");
			if($check_numero->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de caja ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_numero->closeCursor();
			$check_numero=mainModel::desconectar($check_numero);

            /*== Comprobando nombre de caja ==*/
			$check_nombre=mainModel::ejecutar_consulta_simple("SELECT caja_nombre FROM caja WHERE caja_nombre='$nombre'");
			if($check_nombre->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre o código de caja ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_nombre->closeCursor();
			$check_nombre=mainModel::desconectar($check_nombre);
			
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

			/*== Comprobando que el efectivo sea mayor o igual a 0 ==*/
			$efectivo=number_format($efectivo,MONEDA_DECIMALES,'.','');
			if($efectivo<0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No puedes colocar una cantidad de efectivo menor a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_caja_reg=[
				"caja_numero"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero
				],
				"caja_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"caja_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"caja_efectivo"=>[
					"campo_marcador"=>":Efectivo",
					"campo_valor"=>$efectivo
				]
			];
            
			$agregar_caja=mainModel::guardar_datos("caja",$datos_caja_reg);

			if($agregar_caja->rowCount()!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la caja, por favor intente nuevamente",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$agregar_caja->closeCursor();
			$agregar_caja=mainModel::desconectar($agregar_caja);

			/*== Comprobando movimiento de efectico de caja ==*/
			if($efectivo>0){

				$check_caja=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM caja WHERE caja_numero='$numero' AND caja_nombre='$nombre'");
				$campos=$check_caja->fetch();

				$check_caja->closeCursor();
				$check_caja=mainModel::desconectar($check_caja);
				
				$correlativo=mainModel::ejecutar_consulta_simple("SELECT movimiento_id FROM movimiento");
				$correlativo=($correlativo->rowCount())+1;

				$codigo=mainModel::generar_codigo_aleatorio(8,$correlativo);
				$fecha=date("Y-m-d");
				$hora=date("h:i a");
				$tipo="Entrada de efectivo";
				$motivo="Registro de datos de la caja";

				/*== Preparando datos para enviarlos al modelo ==*/
				$datos_movimiento=[
					"movimiento_codigo"=>[
						"campo_marcador"=>":Codigo",
						"campo_valor"=>$codigo
					],
					"movimiento_fecha"=>[
						"campo_marcador"=>":Fecha",
						"campo_valor"=>$fecha
					],
					"movimiento_hora"=>[
						"campo_marcador"=>":Hora",
						"campo_valor"=>$hora
					],
					"movimiento_tipo"=>[
						"campo_marcador"=>":Tipo",
						"campo_valor"=>$tipo
					],
					"movimiento_motivo"=>[
						"campo_marcador"=>":Motivo",
						"campo_valor"=>$motivo
					],
					"movimiento_saldo_anterior"=>[
						"campo_marcador"=>":Anterior",
						"campo_valor"=>0.00
					],
					"movimiento_cantidad"=>[
						"campo_marcador"=>":Cantidad",
						"campo_valor"=>$efectivo
					],
					"movimiento_saldo_actual"=>[
						"campo_marcador"=>":Actual",
						"campo_valor"=>$efectivo
					],
					"usuario_id"=>[
						"campo_marcador"=>":Usuario",
						"campo_valor"=>$_SESSION['id_svi']
					],
					"caja_id"=>[
						"campo_marcador"=>":Caja",
						"campo_valor"=>$campos['caja_id']
					]
				];

				$agregar_movimiento=mainModel::guardar_datos("movimiento",$datos_movimiento);

				if($agregar_movimiento->rowCount()<1){
					mainModel::eliminar_registro("caja","caja_id",$campos['caja_id']);
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido registrar el efectivo de la caja, por favor intente nuevamente",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
				    exit();
				}
				$agregar_movimiento->closeCursor();
				$agregar_movimiento=mainModel::desconectar($agregar_movimiento);
			}

			$alerta=[
				"Alerta"=>"limpiar",
				"Titulo"=>"¡Caja registrada!",
				"Texto"=>"La caja se registró con éxito en el sistema",
				"Tipo"=>"success"
			];
			echo json_encode($alerta);
        } /*-- Fin controlador --*/


        /*---------- Controlador paginador caja ----------*/
		public function paginador_caja_controlador($pagina,$registros,$url,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM caja WHERE caja_numero LIKE '%$busqueda%' OR caja_nombre LIKE '%$busqueda%' OR caja_estado LIKE '%$busqueda%' ORDER BY caja_numero ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM caja ORDER BY caja_numero ASC LIMIT $inicio,$registros";
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
							<th>NUMERO DE CAJA</th>
							<th>NOMBRE / CODIGO</th>
							<th>EFECTIVO</th>
							<th>ESTADO</th>
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
							<td>'.$rows['caja_numero'].'</td>
							<td>'.$rows['caja_nombre'].'</td>
							<td>'.$rows['caja_efectivo'].'</td>
							<td>'.$rows['caja_estado'].'</td>
							<td>
								<a class="btn btn-success" href="'.SERVERURL.'cashier-update/'.mainModel::encryption($rows['caja_id']).'/" >
									<i class="fas fa-sync fa-fw"></i>
								</a>
							</td>
                            <td>
								<form class="FormularioAjax" action="'.SERVERURL.'ajax/cajaAjax.php" method="POST" data-form="delete" autocomplete="off" >
									<input type="hidden" name="caja_id_del" value="'.mainModel::encryption($rows['caja_id']).'">
									<input type="hidden" name="modulo_caja" value="eliminar">
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
							<td colspan="6">
								<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="6">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando cajas <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/


		/*---------- Controlador actualizar caja ----------*/
		public function actualizar_caja_controlador(){

			/*== Recuperando id de la caja ==*/
			$id=mainModel::decryption($_POST['caja_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando caja en la DB ==*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE caja_id='$id'");
            if($check_caja->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado la caja de ventas en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_caja->fetch();
			}
			$check_caja->closeCursor();
			$check_caja=mainModel::desconectar($check_caja);

			$numero=mainModel::limpiar_cadena($_POST['caja_numero_up']);
			$nombre=mainModel::limpiar_cadena($_POST['caja_nombre_up']);
			$estado=mainModel::limpiar_cadena($_POST['caja_estado_up']);

			$efectivo=mainModel::limpiar_cadena($_POST['caja_efectivo_up']);

			/*== Comprobando que los campos no estén vacios ==*/
            if($numero=="" || $nombre==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son requeridos.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[0-9]{1,5}",$numero)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			if(mainModel::verificar_datos("[0-9.]{1,25}",$efectivo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El efectivo de caja no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando estado de la caja ==*/
			if($estado!="Habilitada" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado de la caja no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando numero de caja ==*/
			if($numero!=$campos['caja_numero']){
				$check_numero=mainModel::ejecutar_consulta_simple("SELECT caja_numero FROM caja WHERE caja_numero='$numero'");
				if($check_numero->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El número de caja ingresado ya está siendo utilizado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_numero->closeCursor();
				$check_numero=mainModel::desconectar($check_numero);
			}

			/*== Comprobando nombre de caja ==*/
			if($nombre!=$campos['caja_nombre']){
				$check_nombre=mainModel::ejecutar_consulta_simple("SELECT caja_nombre FROM caja WHERE caja_nombre='$nombre'");
				if($check_nombre->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre de caja ingresado ya está siendo utilizado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_nombre->closeCursor();
				$check_nombre=mainModel::desconectar($check_nombre);
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

			/*== Comprobando movimiento de efectico de caja ==*/
			$efectivo=number_format($efectivo,MONEDA_DECIMALES,'.','');

			if($efectivo<0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No puedes colocar una cantidad de efectivo menor a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($efectivo!=$campos['caja_efectivo']){

				$saldo_anterior=number_format($campos['caja_efectivo'],MONEDA_DECIMALES,'.','');
				$motivo="Actualización de datos de la caja";

				if($efectivo>$campos['caja_efectivo']){
					$cantidad=$efectivo-$campos['caja_efectivo'];
					$tipo="Entrada de efectivo";
				}elseif($efectivo<$campos['caja_efectivo']){
					$cantidad=$campos['caja_efectivo']-$efectivo;
					$tipo="Retiro de efectivo";
				}else{
					$cantidad=0;
					$tipo="Actualización de caja";
				}


				$cantidad=number_format($cantidad,MONEDA_DECIMALES,'.','');

				$correlativo=mainModel::ejecutar_consulta_simple("SELECT movimiento_id FROM movimiento");
				$correlativo=($correlativo->rowCount())+1;

				$codigo=mainModel::generar_codigo_aleatorio(8,$correlativo);
				$fecha=date("Y-m-d");
				$hora=date("h:i a");

				/*== Preparando datos para enviarlos al modelo ==*/
				$datos_movimiento=[
					"movimiento_codigo"=>[
						"campo_marcador"=>":Codigo",
						"campo_valor"=>$codigo
					],
					"movimiento_fecha"=>[
						"campo_marcador"=>":Fecha",
						"campo_valor"=>$fecha
					],
					"movimiento_hora"=>[
						"campo_marcador"=>":Hora",
						"campo_valor"=>$hora
					],
					"movimiento_tipo"=>[
						"campo_marcador"=>":Tipo",
						"campo_valor"=>$tipo
					],
					"movimiento_motivo"=>[
						"campo_marcador"=>":Motivo",
						"campo_valor"=>$motivo
					],
					"movimiento_saldo_anterior"=>[
						"campo_marcador"=>":Anterior",
						"campo_valor"=>$saldo_anterior
					],
					"movimiento_cantidad"=>[
						"campo_marcador"=>":Cantidad",
						"campo_valor"=>$cantidad
					],
					"movimiento_saldo_actual"=>[
						"campo_marcador"=>":Actual",
						"campo_valor"=>$efectivo
					],
					"usuario_id"=>[
						"campo_marcador"=>":Usuario",
						"campo_valor"=>$_SESSION['id_svi']
					],
					"caja_id"=>[
						"campo_marcador"=>":Caja",
						"campo_valor"=>$id
					]
				];

				$agregar_movimiento=mainModel::guardar_datos("movimiento",$datos_movimiento);

				if($agregar_movimiento->rowCount()<1){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido actualizar el efectivo de la caja, por favor intente nuevamente",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
				    exit();
				}
				$agregar_movimiento->closeCursor();
				$agregar_movimiento=mainModel::desconectar($agregar_movimiento);
			}

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_caja_up=[
				"caja_numero"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero
				],
				"caja_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"caja_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"caja_efectivo"=>[
					"campo_marcador"=>":Efectivo",
					"campo_valor"=>$efectivo
				]
			];

			$condicion=[
				"condicion_campo"=>"caja_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("caja",$datos_caja_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Caja actualizada!",
					"Texto"=>"La caja se actualizo con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{

				if($efectivo!=$campos['caja_efectivo']){
					mainModel::eliminar_registro("movimiento","movimiento_codigo",$codigo);
				}
				
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos de la caja, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador eliminar caja ----------*/
		public function eliminar_caja_controlador(){

			/*== Recuperando id de la caja ==*/
			$id=mainModel::decryption($_POST['caja_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando caja en la DB ==*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM caja WHERE caja_id='$id'");
            if($check_caja->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La caja de ventas que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_caja->closeCursor();
			$check_caja=mainModel::desconectar($check_caja);

			/*== Comprobando caja principal ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar la caja principal del sistema. Le recomendamos deshabilitar esta caja si ya no será usada en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando ventas de la caja ==*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM venta WHERE caja_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar la caja debido a que tiene ventas asociadas, le recomendamos deshabilitar esta caja si ya no será usada en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			/*== Comprobando movimientos de la caja ==*/
			$check_movimientos=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM movimiento WHERE caja_id='$id' LIMIT 1");
			if($check_movimientos->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar la caja debido a que tiene movimientos asociados, le recomendamos deshabilitar esta caja si ya no será usada en el sistema.",
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

			$eliminar_caja=mainModel::eliminar_registro("caja","caja_id",$id);

			if($eliminar_caja->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Caja eliminada!",
					"Texto"=>"La caja de ventas ha sido eliminada del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar la caja de ventas del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}

			$eliminar_caja->closeCursor();
			$eliminar_caja=mainModel::desconectar($eliminar_caja);

			echo json_encode($alerta);
		} /*-- Fin controlador --*/
    }