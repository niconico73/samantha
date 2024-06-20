<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class movimientoControlador extends mainModel{

        /*---------- Controlador agregar movimiento ----------*/
        public function agregar_movimiento_controlador(){

            $caja=mainModel::limpiar_cadena($_POST['movimiento_caja_reg']);
            $tipo=mainModel::limpiar_cadena($_POST['movimiento_tipo_reg']);
            $cantidad=mainModel::limpiar_cadena($_POST['movimiento_cantidad_reg']);
            $motivo=mainModel::limpiar_cadena($_POST['movimiento_motivo_reg']);

            /*== comprobar campos vacios ==*/
            if($caja=="" || $tipo=="" || $cantidad=="" || $motivo==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado o seleccionado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[0-9.]{1,25}",$cantidad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La cantidad de efectivo no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,70}",$motivo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El motivo del movimiento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando tipo de movimiento ==*/
			if($tipo!="Retiro de efectivo" && $tipo!="Entrada de efectivo"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de movimiento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando que la cantidad sea mayor a 0 ==*/
            $cantidad=number_format($cantidad,MONEDA_DECIMALES,'.','');
            if($cantidad<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La cantidad de efectivo debe de ser mayor a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando caja en la DB ==*/
			$check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE caja_id='$caja'");
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
            
            /*== Comprobando privilegios ==*/
			if($_SESSION['cargo_svi']!="Administrador" && $_SESSION['cargo_svi']!="Cajero"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
            
            if($tipo=="Retiro de efectivo"){
                if($cantidad>$campos['caja_efectivo']){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"La cantidad de efectivo a retirar debe de ser igual o menor al efectivo disponible en caja.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $saldo_actual=$campos['caja_efectivo']-$cantidad;
            }else{
                $saldo_actual=$campos['caja_efectivo']+$cantidad;
            }

            /*== Ajustando parametros del movimiento ==*/
            $correlativo=mainModel::ejecutar_consulta_simple("SELECT movimiento_id FROM movimiento");
			$correlativo=($correlativo->rowCount())+1;

			$codigo=mainModel::generar_codigo_aleatorio(8,$correlativo);
			$fecha=date("Y-m-d");
            $hora=date("h:i a");
            $saldo_anterior=number_format($campos['caja_efectivo'],MONEDA_DECIMALES,'.','');
            $saldo_actual=number_format($saldo_actual,MONEDA_DECIMALES,'.','');

            /*== Preparando datos del movimiento para enviarlos al modelo ==*/
            $datos_movimiento_reg=[
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
                    "campo_valor"=>$saldo_actual
                ],
                "usuario_id"=>[
                    "campo_marcador"=>":Usuario",
                    "campo_valor"=>$_SESSION['id_svi']
                ],
                "caja_id"=>[
                    "campo_marcador"=>":Caja",
                    "campo_valor"=>$caja
                ]
            ];
            
            $agregar_movimiento=mainModel::guardar_datos("movimiento",$datos_movimiento_reg);

            if($agregar_movimiento->rowCount()<1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido agregar el movimiento de la caja, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
			}
			
			$agregar_movimiento->closeCursor();
			$agregar_movimiento=mainModel::desconectar($agregar_movimiento);

            /*== Preparando datos de la caja para enviarlos al modelo ==*/
			$datos_caja_up=[
				"caja_efectivo"=>[
					"campo_marcador"=>":Efectivo",
					"campo_valor"=>$saldo_actual
				]
            ];
            
            $condicion=[
				"condicion_campo"=>"caja_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$caja
			];
                
            if(mainModel::actualizar_datos("caja",$datos_caja_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Movimiento registrado!",
					"Texto"=>"El movimiento de efectivo de la caja ha sido realizado con éxito, efectivo actual en caja: ".MONEDA_SIMBOLO.$saldo_actual." ".MONEDA_NOMBRE,
					"Tipo"=>"success"
				];
			}else{
                mainModel::eliminar_registro("movimiento","movimiento_codigo",$codigo);

				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido realizar el movimiento de la caja, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador --*/


        /*---------- Controlador paginador movimiento ----------*/
		public function paginador_movimiento_controlador($pagina,$registros,$url,$tipo,$fecha_inicio,$fecha_final){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$tipo=mainModel::limpiar_cadena($tipo);
			$fecha_inicio=mainModel::limpiar_cadena($fecha_inicio);
			$fecha_final=mainModel::limpiar_cadena($fecha_final);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
            
            if($tipo=="Busqueda"){
				if(mainModel::verificar_fecha($fecha_inicio) || mainModel::verificar_fecha($fecha_final)){
					return '
						<div class="alert alert-danger text-center" role="alert">
							<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
							<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
							<p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que al parecer a ingresado una fecha incorrecta.</p>
						</div>
					';
					exit();
				}
            }
            
            $campos_tablas="movimiento.movimiento_id,movimiento.movimiento_fecha,movimiento.movimiento_hora,movimiento.movimiento_tipo,movimiento.movimiento_motivo,movimiento.movimiento_saldo_anterior,movimiento.movimiento_cantidad,movimiento.movimiento_saldo_actual,caja.caja_numero,usuario.usuario_nombre,usuario.usuario_apellido";

			if($tipo=="Busqueda" && $fecha_inicio!="" && $fecha_final!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos_tablas FROM movimiento INNER JOIN caja ON movimiento.caja_id=caja.caja_id INNER JOIN usuario ON movimiento.usuario_id=usuario.usuario_id WHERE (movimiento_fecha BETWEEN '$fecha_inicio' AND '$fecha_final') ORDER BY movimiento_id DESC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos_tablas FROM movimiento INNER JOIN caja ON movimiento.caja_id=caja.caja_id INNER JOIN usuario ON movimiento.usuario_id=usuario.usuario_id ORDER BY movimiento_id DESC LIMIT $inicio,$registros";
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
                            <th>CAJA</th>
							<th>FECHA Y HORA</th>
							<th>TIPO</th>
							<th>E. ANTERIOR</th>
							<th>CANTIDAD</th>
                            <th>E. ACTUAL</th>
                            <th>USUARIO</th>
                            <th>MOTIVO</th>
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
                            <td>Caja N.'.$rows['caja_numero'].'</td>
							<td>'.date("d-m-Y", strtotime($rows['movimiento_fecha'])).' '.$rows['movimiento_hora'].'</td>
							<td>'.$rows['movimiento_tipo'].'</td>
                            <td>'.MONEDA_SIMBOLO.number_format($rows['movimiento_saldo_anterior'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                            <td>'.MONEDA_SIMBOLO.number_format($rows['movimiento_cantidad'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                            <td>'.MONEDA_SIMBOLO.number_format($rows['movimiento_saldo_actual'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                            <td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
                            <td>
								<button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="'.$rows['movimiento_tipo'].'" data-content="'.$rows['movimiento_motivo'].'" >
									<i class="fas fa-info-circle"></i>
								</button>
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
							<td colspan="9">
								<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="9">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando movimientos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/
    }