<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class productoControlador extends mainModel{

        /*---------- Controlador agregar producto ----------*/
        public function agregar_producto_controlador(){

            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_reg']);
            $sku=mainModel::limpiar_cadena($_POST['producto_sku_reg']);

            $nombre=mainModel::limpiar_cadena($_POST['producto_nombre_reg']);
            $stock_total=mainModel::limpiar_cadena($_POST['producto_stock_total_reg']);
            $stock_minimo=mainModel::limpiar_cadena($_POST['producto_stock_minimo_reg']);
            $unidad=mainModel::limpiar_cadena($_POST['producto_unidad_reg']);
            $precio_compra=mainModel::limpiar_cadena($_POST['producto_precio_compra_reg']);
			$precio_venta=mainModel::limpiar_cadena($_POST['producto_precio_venta_reg']);
			$precio_venta_mayoreo=mainModel::limpiar_cadena($_POST['producto_precio_venta_mayoreo_reg']);
			$descuento=mainModel::limpiar_cadena($_POST['producto_descuento_reg']);
			$marca=mainModel::limpiar_cadena($_POST['producto_marca_reg']);
			$modelo=mainModel::limpiar_cadena($_POST['producto_modelo_reg']);

			$vencimiento=mainModel::limpiar_cadena($_POST['producto_vencimiento_reg']);
			$fecha_vencimiento=mainModel::limpiar_cadena($_POST['producto_fecha_vencimiento_reg']);

			$garantia_unidad=mainModel::limpiar_cadena($_POST['producto_garantia_unidad_reg']);
			$garantia_tiempo=mainModel::limpiar_cadena($_POST['producto_garantia_tiempo_reg']);

            $categoria=mainModel::limpiar_cadena($_POST['producto_categoria_reg']);
            $estado=mainModel::limpiar_cadena($_POST['producto_estado_reg']);

            /*== comprobar campos vacios ==*/
            if($codigo=="" || $nombre=="" || $stock_total=="" || $stock_minimo=="" || $unidad=="" || $precio_compra=="" || $precio_venta=="" || $descuento=="" || $precio_venta_mayoreo==""){
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
			if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,70}",$codigo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El código de barras no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if($sku!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,70}",$sku)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El SKU no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,20}",$stock_total)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El stock o existencias no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_minimo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El stock mínimo debe de ser igual o mayor a 0, o no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_compra)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta_mayoreo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta por mayoreo no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$descuento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El descuento del producto debe de ser entre 0% a 99%, o no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($marca!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La marca del producto no coincide con el formato solicitado.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			if($modelo!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$modelo)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El modelo del producto no coincide con el formato solicitado.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

            /*== Verificando stock total o existencias ==*/
            if($stock_total<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No puedes registrar un producto con stock o existencias en 0, debes de agregar al menos una unidad.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando presentacion del producto ==*/
			if(!in_array($unidad, PRODUCTO_UNIDAD)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La presentación del producto no es correcta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de compra del producto ==*/
            $precio_compra=number_format($precio_compra,MONEDA_DECIMALES,'.','');
            if($precio_compra<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de venta del producto ==*/
            $precio_venta=number_format($precio_venta,MONEDA_DECIMALES,'.','');
            if($precio_venta<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando precio de venta por mayoreo del producto ==*/
            $precio_venta_mayoreo=number_format($precio_venta_mayoreo,MONEDA_DECIMALES,'.','');
            if($precio_venta_mayoreo<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta por mayoreo no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de compra y venta del producto ==*/
            if($precio_compra>$precio_venta){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra del producto no puede ser mayor al precio de venta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($precio_compra>$precio_venta_mayoreo){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra del producto no puede ser mayor al precio de venta por mayoreo.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando vencimiento del producto ==*/
			if($vencimiento!="Si" && $vencimiento!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El vencimiento del producto no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fecha_vencimiento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El fecha de vencimiento del producto no es correcta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($vencimiento=="Si"){
				$fecha_hoy=date("Y-m-d");
				if($fecha_vencimiento<=$fecha_hoy){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La fecha de vencimiento no puede ser menor o igual que hoy.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			/*== Comprobando garantia del producto ==*/
			if(mainModel::verificar_datos("[0-9]{1,2}",$garantia_unidad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La unidad de tiempo de la garantía no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(!in_array($garantia_tiempo, GARANTIA_TIEMPO)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tiempo de la garantía no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($garantia_unidad==0 || $garantia_tiempo=="N/A"){
				if(($garantia_unidad==0 && $garantia_tiempo!="N/A") || (($garantia_unidad!=0 && $garantia_tiempo=="N/A"))){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Si el producto no tiene garantía coloque 0 en la unidad de tiempo y N/A en tiempo de garantía.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

            /*== Comprobando estado del producto ==*/
			if($estado!="Habilitado" && $estado!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado del producto no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando codigo de producto ==*/
			$check_codigo=mainModel::ejecutar_consulta_simple("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
			if($check_codigo->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El código de producto que ha ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_codigo->closeCursor();
			$check_codigo=mainModel::desconectar($check_codigo);

            /*== Comprobando SKU de producto ==*/
            if($sku!=""){
                $check_sku=mainModel::ejecutar_consulta_simple("SELECT producto_sku FROM producto WHERE producto_sku='$sku'");
                if($check_sku->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El SKU que ha ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
				}
				$check_sku->closeCursor();
				$check_sku=mainModel::desconectar($check_sku);
            }

            /*== Comprobando nombre de producto ==*/
			$check_nombre=mainModel::ejecutar_consulta_simple("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
			if($check_nombre->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Ya existe un producto registrado con el mismo nombre y código de barras",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_nombre->closeCursor();
			$check_nombre=mainModel::desconectar($check_nombre);

            /*== Comprobando categoria ==*/
			$check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
			if($check_categoria->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La categoría seleccionada no se encuentra registrada en el sistema o no está disponible.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_categoria->closeCursor();
			$check_categoria=mainModel::desconectar($check_categoria);

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

			/* Directorios de imagenes */
			$img_dir='../vistas/assets/product/';

            /*== Comprobando si se ha seleccionado una imagen ==*/
            if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

                /* Comprobando formato de las imagenes */
				if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
					$alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"La imagen que ha seleccionado es de un formato que no está permitido.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
				}

				/* Comprobando que la imagen no supere el peso permitido */
				$img_max_size=3072;
				if(($_FILES['producto_foto']['size']/1024)>$img_max_size){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La imagen que ha seleccionado supera el límite de peso permitido.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}

				/* extencion de las imagenes */
				switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
					case 'image/jpeg':
					  $img_ext=".jpg";
					break;
					case 'image/png':
					  $img_ext=".png";
					break;
				}

				/* Cambiando permisos al directorio */
				chmod($img_dir, 0777);

				/* Generando un codigo para la imagen */
				$correlativo=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM producto");
				$correlativo=($correlativo->rowCount())+1;
				$codigo_img=mainModel::generar_codigo_aleatorio(10,$correlativo);

				/* Nombre final de la imagen */
				$img_final_name=$codigo_img.$img_ext;

				/* Moviendo imagen al directorio */
				if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$img_final_name)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No podemos subir la imagen al sistema en este momento, por favor intente nuevamente.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}

            }else{
                $img_final_name="";
            }

            /*== Preparando datos para enviarlos al modelo ==*/
			$datos_producto_reg=[
				"producto_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
				"producto_sku"=>[
					"campo_marcador"=>":Sku",
					"campo_valor"=>$sku
				],
				"producto_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"producto_stock_total"=>[
					"campo_marcador"=>":StockT",
					"campo_valor"=>$stock_total
				],
				"producto_stock_minimo"=>[
					"campo_marcador"=>":StockM",
					"campo_valor"=>$stock_minimo
				],
				"producto_stock_vendido"=>[
					"campo_marcador"=>":Vendido",
					"campo_valor"=>"0"
				],
				"producto_tipo_unidad"=>[
					"campo_marcador"=>":Unidad",
					"campo_valor"=>$unidad
				],
				"producto_precio_compra"=>[
					"campo_marcador"=>":Compra",
					"campo_valor"=>$precio_compra
				],
				"producto_precio_venta"=>[
					"campo_marcador"=>":Venta",
					"campo_valor"=>$precio_venta
				],
				"producto_precio_mayoreo"=>[
					"campo_marcador"=>":VentaMayoreo",
					"campo_valor"=>$precio_venta_mayoreo
				],
				"producto_descuento"=>[
					"campo_marcador"=>":Descuento",
					"campo_valor"=>$descuento
				],
				"producto_marca"=>[
					"campo_marcador"=>":Marca",
					"campo_valor"=>$marca
				],
				"producto_modelo"=>[
					"campo_marcador"=>":Modelo",
					"campo_valor"=>$modelo
				],
				"producto_vencimiento"=>[
					"campo_marcador"=>":Vencimiento",
					"campo_valor"=>$vencimiento
				],
				"producto_fecha_vencimiento"=>[
					"campo_marcador"=>":VencimientoFecha",
					"campo_valor"=>$fecha_vencimiento
				],
				"producto_garantia_unidad"=>[
					"campo_marcador"=>":GarantiaUnidad",
					"campo_valor"=>$garantia_unidad
				],
				"producto_garantia_tiempo"=>[
					"campo_marcador"=>":GarantiaTiempo",
					"campo_valor"=>$garantia_tiempo
				],
				"producto_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"producto_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$img_final_name
				],
				"categoria_id"=>[
					"campo_marcador"=>":Categoria",
					"campo_valor"=>$categoria
				]
            ];

			/*== Agregando producto ==*/
            $agregar_producto=mainModel::guardar_datos("producto",$datos_producto_reg);

			if($agregar_producto->rowCount()!=1){
                if(is_file($img_dir.$img_final_name)){
					chmod($img_dir.$img_final_name, 0777);
					unlink($img_dir.$img_final_name);
                }

				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el producto, por favor intente nuevamente. Código de error: 001",
					"Tipo"=>"error"
				];
			}else{
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Producto registrado!",
					"Texto"=>"El producto se registró con éxito en el sistema",
					"Tipo"=>"success"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador paginador producto ----------*/
		public function paginador_producto_controlador($pagina,$registros,$url,$busqueda,$cargo){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);

			$tipo_lista=["product-search","product-list","product-sold","product-category","product-expiration","product-minimum"];

			if(!in_array($url, $tipo_lista)){
				return '
					<div class="alert alert-danger text-center" role="alert">
						<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
						<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
						<p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que al parecer a ingresado un dato incorrecto.</p>
					</div>
				';
				exit();
			}else{
				$tipo=$url;
			}


			$busqueda=mainModel::limpiar_cadena($busqueda);
			$cargo=mainModel::limpiar_cadena($cargo);
			$tabla="";

			if($tipo=="product-category"){
				$url=SERVERURL.$url."/".$busqueda."/";
			}else{
				$url=SERVERURL.$url."/";
			}


			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			$fecha_hoy=date("Y-m-d");

			$campos="*,TIMESTAMPDIFF(DAY, '$fecha_hoy', producto.producto_fecha_vencimiento) AS dias_vencer";

			if(isset($busqueda) && $busqueda!="" && $tipo=="product-search"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_codigo LIKE '%$busqueda%' OR producto_sku LIKE '%$busqueda%' OR producto_nombre LIKE '%$busqueda%' ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-list"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-sold"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto ORDER BY producto_stock_vendido DESC LIMIT $inicio,$registros";
			}elseif($tipo=="product-category"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE categoria_id='$busqueda' ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-expiration"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_vencimiento='Si' ORDER BY dias_vencer ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-minimum"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_stock_total<=producto_stock_minimo ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas =ceil($total/$registros);

			### Cuerpo de la lista ###
			$tabla.='<ul class="list-unstyled" style="padding: 5px;" >';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

					$total_price=$rows['producto_precio_venta']-($rows['producto_precio_venta']*($rows['producto_descuento']/100));

					$tabla.='<li class="media media-product">';
						if(is_file("./vistas/assets/product/".$rows['producto_foto'])){
							$tabla.='<img class="mr-3 img-fluid img-product-list" src="'.SERVERURL.'vistas/assets/product/'.$rows['producto_foto'].'" alt="'.$rows['producto_nombre'].'">';
						}else{
							$tabla.='<img class="mr-3 img-fluid img-product-list" src="'.SERVERURL.'vistas/assets/img/producto.png" alt="'.$rows['producto_nombre'].'">';
						}
						$tabla.='<div class="media-body product-media-body">
							<p class="text-uppercase text-center media-product-title"><strong>'.$contador.' - '.$rows['producto_nombre'].'</strong></p>
							<div class="container-fluid">
								<div class="row">
									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="fas fa-barcode"></i> <strong>Código de barras:</strong> '.$rows['producto_codigo'].'</div>

									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="fas fa-barcode"></i> <strong>SKU:</strong> '.$rows['producto_sku'].'</div>

									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="far fa-money-bill-alt"></i> <strong>Precio:</strong> '.MONEDA_SIMBOLO.number_format($total_price,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.' ';
									if($rows['producto_descuento']>0){
										$tabla.='<span class="badge badge-success">'.$rows['producto_descuento'].'% de descuento</span>';
									}
									$tabla.='</div><div class="col-12 col-md-6 col-lg-3 col-product" ><i class="fas fa-clipboard-check"></i> <strong>Estado:</strong> '.$rows['producto_estado'].'</div>

									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="fas fa-box"></i> <strong>Disponibles:</strong> '.$rows['producto_stock_total'].'</div>
									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="fas fa-box-open"></i> <strong>Vendidos:</strong> '.$rows['producto_stock_vendido'].'</div>
									<div class="col-12 col-md-6 col-lg-3 col-product"><i class="fas fa-calendar-alt"></i> <strong>Vencimiento:</strong> ';
									if($rows['producto_vencimiento']=="Si"){
										if($rows['dias_vencer']<=0){
											$tabla.='<span class="badge badge-warning">Vencido</span>';
										}else{
											$tabla.="En ".$rows['dias_vencer']." días";
										}
									}else{
									 $tabla.='No tiene';
									}
									$tabla.='</div>
								</div>
							</div>
							<div class="text-right media-product-options">
								<span><i class="fas fa-tools"></i> &nbsp; OPCIONES: </span>
								<a href="'.SERVERURL.'product-info/'.mainModel::encryption($rows['producto_id']).'/" class="btn btn-info" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Información detallada" >
									<i class="fas fa-box-open"></i>
								</a>';
								if($cargo=="Administrador"){
									$tabla.='
									<a href="'.SERVERURL.'product-image/'.mainModel::encryption($rows['producto_id']).'/" class="btn btn-secondary" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Gestionar imagen">
										<i class="far fa-image"></i>
									</a>
									<a href="'.SERVERURL.'product-update/'.mainModel::encryption($rows['producto_id']).'/" class="btn btn-success" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Actualizar producto">
										<i class="fas fa-sync"></i>
									</a>
									<form class="FormularioAjax form-product" action="'.SERVERURL.'ajax/productoAjax.php" method="POST" data-form="delete" autocomplete="off">
										<input type="hidden" name="producto_id_del" value="'.mainModel::encryption($rows['producto_id']).'">
										<input type="hidden" name="modulo_producto" value="eliminar">
										<button type="submit" class="btn btn-warning" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Eliminar producto" >
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
									';
								}
							$tabla.='</div>
						</div>
					</li>
					';
                    $contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='<li class="text-center" >
						<div class="alert text-primary text-center" role="alert">
							<p><i class="far fa-grin-beam-sweat fa-fw fa-5x"></i></p>
							<h4 class="alert-heading">Parece que algo salió mal</h4>
							<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
								Haga clic acá para recargar el listado
							</a>
						</div>
					</li>';
				}else{
					$tabla.='<li class="text-center" >
						<div class="alert text-primary text-center" role="alert">
                            <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">No hay productos en almacén</h4>
                            <p class="mb-0">No hemos encontrado productos registrados en el sistema.</p>
                        </div>
					</li>';
				}
			}

			$tabla.='</ul>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/


		/*---------- Controlador actualizar producto ----------*/
		public function actualizar_producto_controlador(){

			/*== Recuperando id del producto ==*/
			$id=mainModel::decryption($_POST['producto_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando producto en la DB ==*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el producto registrado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

			/* $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_up']); */
			$codigo=$campos['producto_codigo'];

            $sku=mainModel::limpiar_cadena($_POST['producto_sku_up']);

            $nombre=mainModel::limpiar_cadena($_POST['producto_nombre_up']);
            $stock_total=mainModel::limpiar_cadena($_POST['producto_stock_total_up']);
            $stock_minimo=mainModel::limpiar_cadena($_POST['producto_stock_minimo_up']);
            $unidad=mainModel::limpiar_cadena($_POST['producto_unidad_up']);
            $precio_compra=mainModel::limpiar_cadena($_POST['producto_precio_compra_up']);
			$precio_venta=mainModel::limpiar_cadena($_POST['producto_precio_venta_up']);
			$precio_venta_mayoreo=mainModel::limpiar_cadena($_POST['producto_precio_venta_mayoreo_up']);
			$descuento=mainModel::limpiar_cadena($_POST['producto_descuento_up']);
			$marca=mainModel::limpiar_cadena($_POST['producto_marca_up']);
			$modelo=mainModel::limpiar_cadena($_POST['producto_modelo_up']);

			$vencimiento=mainModel::limpiar_cadena($_POST['producto_vencimiento_up']);
			$fecha_vencimiento=mainModel::limpiar_cadena($_POST['producto_fecha_vencimiento_up']);

			$garantia_unidad=mainModel::limpiar_cadena($_POST['producto_garantia_unidad_up']);
			$garantia_tiempo=mainModel::limpiar_cadena($_POST['producto_garantia_tiempo_up']);

            $categoria=mainModel::limpiar_cadena($_POST['producto_categoria_up']);
            $estado=mainModel::limpiar_cadena($_POST['producto_estado_up']);

            /*== comprobar campos vacios ==*/
            if($codigo=="" || $nombre=="" || $stock_total=="" || $stock_minimo=="" || $unidad=="" || $precio_compra=="" || $precio_venta=="" || $descuento=="" || $precio_venta_mayoreo==""){
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
			if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,70}",$codigo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El código de barras no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if($sku!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,70}",$sku)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El SKU no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,20}",$stock_total)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El stock o existencias no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_minimo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El stock mínimo debe de ser igual o mayor a 0, o no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_compra)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta_mayoreo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta por mayoreo no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$descuento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El descuento del producto debe de ser entre 0% a 99%, o no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($marca!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La marca del producto no coincide con el formato solicitado.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			if($modelo!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$modelo)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El modelo del producto no coincide con el formato solicitado.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

            /*== Verificando stock total o existencias ==*/
            if($stock_total<0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No puedes actualizar un producto con stock o existencias menor a 0, debes de agregar al menos una unidad.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando presentacion del producto ==*/
			if(!in_array($unidad, PRODUCTO_UNIDAD)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La presentación del producto no es correcta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de compra del producto ==*/
            $precio_compra=number_format($precio_compra,MONEDA_DECIMALES,'.','');
            if($precio_compra<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de venta del producto ==*/
            $precio_venta=number_format($precio_venta,MONEDA_DECIMALES,'.','');
            if($precio_venta<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando precio de venta por mayoreo del producto ==*/
            $precio_venta_mayoreo=number_format($precio_venta_mayoreo,MONEDA_DECIMALES,'.','');
            if($precio_venta_mayoreo<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de venta por mayoreo no puede ser menor o igual a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando precio de compra y venta del producto ==*/
            if($precio_compra>$precio_venta){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra del producto no puede ser mayor al precio de venta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($precio_compra>$precio_venta_mayoreo){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio de compra del producto no puede ser mayor al precio de venta por mayoreo.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando vencimiento del producto ==*/
			if($vencimiento!="Si" && $vencimiento!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El vencimiento del producto no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_fecha($fecha_vencimiento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El fecha de vencimiento del producto no es correcta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($vencimiento=="Si" && $fecha_vencimiento!=$campos['producto_fecha_vencimiento']){
				$fecha_hoy=date("Y-m-d");
				if($fecha_vencimiento<=$fecha_hoy){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La fecha de vencimiento no puede ser menor o igual que hoy.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			/*== Comprobando garantia del producto ==*/
			if(mainModel::verificar_datos("[0-9]{1,2}",$garantia_unidad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La unidad de tiempo de la garantía no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(!in_array($garantia_tiempo, GARANTIA_TIEMPO)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tiempo de la garantía no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($garantia_unidad==0 || $garantia_tiempo=="N/A"){
				if(($garantia_unidad==0 && $garantia_tiempo!="N/A") || (($garantia_unidad!=0 && $garantia_tiempo=="N/A"))){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Si el producto no tiene garantía coloque 0 en la unidad de tiempo y N/A en tiempo de garantía.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

            /*== Comprobando estado del producto ==*/
			if($estado!="Habilitado" && $estado!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El estado del producto no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

			/*== Comprobando codigo de producto ==*/
			if($codigo!=$campos['producto_codigo']){
				$check_codigo=mainModel::ejecutar_consulta_simple("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
				if($check_codigo->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El código de producto que ha ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_codigo->closeCursor();
				$check_codigo=mainModel::desconectar($check_codigo);
			}


            /*== Comprobando SKU de producto ==*/
            if($sku!="" && $sku!=$campos['producto_sku']){
                $check_sku=mainModel::ejecutar_consulta_simple("SELECT producto_sku FROM producto WHERE producto_sku='$sku'");
                if($check_sku->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El SKU que ha ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
				}
				$check_sku->closeCursor();
				$check_sku=mainModel::desconectar($check_sku);
            }

			/*== Comprobando nombre de producto ==*/
			if($nombre!=$campos['producto_nombre']){
				$check_nombre=mainModel::ejecutar_consulta_simple("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
				if($check_nombre->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ya existe un producto registrado con el mismo nombre y código de barras",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_nombre->closeCursor();
				$check_nombre=mainModel::desconectar($check_nombre);
			}

			/*== Comprobando categoria ==*/
			if($categoria!=$campos['categoria_id']){
				$check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
				if($check_categoria->rowCount()<=0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La categoría seleccionada no se encuentra registrada en el sistema o no está disponible.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_categoria->closeCursor();
				$check_categoria=mainModel::desconectar($check_categoria);
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

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_producto_up=[
				"producto_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
				"producto_sku"=>[
					"campo_marcador"=>":Sku",
					"campo_valor"=>$sku
				],
				"producto_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"producto_stock_total"=>[
					"campo_marcador"=>":StockT",
					"campo_valor"=>$stock_total
				],
				"producto_stock_minimo"=>[
					"campo_marcador"=>":StockM",
					"campo_valor"=>$stock_minimo
				],
				"producto_tipo_unidad"=>[
					"campo_marcador"=>":Unidad",
					"campo_valor"=>$unidad
				],
				"producto_precio_compra"=>[
					"campo_marcador"=>":Compra",
					"campo_valor"=>$precio_compra
				],
				"producto_precio_venta"=>[
					"campo_marcador"=>":Venta",
					"campo_valor"=>$precio_venta
				],
				"producto_precio_mayoreo"=>[
					"campo_marcador"=>":VentaMayoreo",
					"campo_valor"=>$precio_venta_mayoreo
				],
				"producto_descuento"=>[
					"campo_marcador"=>":Descuento",
					"campo_valor"=>$descuento
				],
				"producto_marca"=>[
					"campo_marcador"=>":Marca",
					"campo_valor"=>$marca
				],
				"producto_modelo"=>[
					"campo_marcador"=>":Modelo",
					"campo_valor"=>$modelo
				],
				"producto_vencimiento"=>[
					"campo_marcador"=>":Vencimiento",
					"campo_valor"=>$vencimiento
				],
				"producto_fecha_vencimiento"=>[
					"campo_marcador"=>":VencimientoFecha",
					"campo_valor"=>$fecha_vencimiento
				],
				"producto_garantia_unidad"=>[
					"campo_marcador"=>":GarantiaUnidad",
					"campo_valor"=>$garantia_unidad
				],
				"producto_garantia_tiempo"=>[
					"campo_marcador"=>":GarantiaTiempo",
					"campo_valor"=>$garantia_tiempo
				],
				"producto_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"categoria_id"=>[
					"campo_marcador"=>":Categoria",
					"campo_valor"=>$categoria
				]
            ];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			/*== Actualizando datos del producto ==*/
			if(!mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del producto, Código de error: 001",
					"Tipo"=>"error"
				];
			}else{
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Producto actualizado!",
					"Texto"=>"El producto se actualizo con éxito en el sistema",
					"Tipo"=>"success"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador eliminar producto ----------*/
		public function eliminar_producto_controlador(){

			/*== Recuperando id del producto ==*/
			$id=mainModel::decryption($_POST['producto_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando producto en la DB ==*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El producto que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

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

			/*== Comprobando ventas del producto ==*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM venta_detalle WHERE producto_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar este producto debido a que tiene ventas asociadas, le recomendamos deshabilitar este producto si ya no será usado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			/*== Eliminando devoluciones ==*/
			$check_devoluciones=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM devolucion WHERE producto_id='$id'");
			if($check_devoluciones->rowCount()>0){
				$eliminar_devoluciones=mainModel::eliminar_registro("devolucion","producto_id",$id);
				if($eliminar_devoluciones->rowCount()!=$check_devoluciones->rowCount()){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido eliminar las devoluciones asociadas al producto, por favor intente nuevamente.",
						"Tipo"=>"error"
					];
				}
				$eliminar_devoluciones->closeCursor();
				$eliminar_devoluciones=mainModel::desconectar($eliminar_devoluciones);
			}
			$check_devoluciones->closeCursor();
			$check_devoluciones=mainModel::desconectar($check_devoluciones);

			$imagen_producto='../vistas/assets/product/'.$campos['producto_foto'];

			/*== Eliminando producto ==*/
			$eliminar_producto=mainModel::eliminar_registro("producto","producto_id",$id);
			if($eliminar_producto->rowCount()==1){

				if(is_file($imagen_producto)){
					chmod($imagen_producto, 0777);
					unlink($imagen_producto);
				}

				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Producto eliminado!",
					"Texto"=>"El producto ha sido eliminado del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el producto del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}
			$eliminar_producto->closeCursor();
			$eliminar_producto=mainModel::desconectar($eliminar_producto);

			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador actualizar imagen de producto ----------*/
		public function actualizar_imagen_producto_controlador(){

			/*== Recuperando id del producto ==*/
			$id=mainModel::decryption($_POST['producto_img_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando producto en la DB ==*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el producto registrado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

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

			/*== Comprobando si se ha seleccionado una imagen ==*/
            if($_FILES['producto_foto']['name']=="" || $_FILES['producto_foto']['size']<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Parece que no ha seleccionado una imagen.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* Comprobando formato de las imagenes */
			if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La imagen que ha seleccionado es de un formato que no está permitido.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* Comprobando que la imagen no supere el peso permitido */
			$img_max_size=3072;
			if(($_FILES['producto_foto']['size']/1024)>$img_max_size){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La imagen que ha seleccionado supera el límite de peso permitido.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* Almacenando extencion de la imagen */
			switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
				case 'image/jpeg':
				  $img_ext=".jpg";
				break;
				case 'image/png':
				  $img_ext=".png";
				break;
			}

			/* Nombre final de la imagen */
			$codigo_img=mainModel::generar_codigo_aleatorio(10,$id);
			$img_final_name=$codigo_img.$img_ext;

			/* Directorios de imagenes */
			$img_dir='../vistas/assets/product/';

			/* Cambiando permisos al directorio */
			chmod($img_dir, 0777);

			/* Moviendo imagen al directorio */
			if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$img_final_name)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos subir la imagen al sistema en este momento, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/* Eliminando la imagen anterior */
			if(is_file($img_dir.$campos['producto_foto'])){
				chmod($img_dir, 0777);
				unlink($img_dir.$campos['producto_foto']);
			}

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_producto_up=[
				"producto_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$img_final_name
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Imagen actualizada!",
					"Texto"=>"La imagen del producto se actualizo con éxito",
					"Tipo"=>"success"
				];
			}else{

				if(is_file($img_dir.$img_final_name)){
					chmod($img_dir, 0777);
					unlink($img_dir.$img_final_name);
				}

				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar la imagen, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*---------- Controlador eliminar imagen de producto ----------*/
		public function eliminar_imagen_producto_controlador(){

			/*== Recuperando id del producto ==*/
			$id=mainModel::decryption($_POST['producto_img_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando producto en la DB ==*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el producto registrado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

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

			/* Directorios de imagenes */
			$img_dir='../vistas/assets/product/';

			/* Eliminando la imagen anterior */
			if(is_file($img_dir.$campos['producto_foto'])){
				chmod($img_dir, 0777);
				if(!unlink($img_dir.$campos['producto_foto'])){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido eliminar la imagen del producto, por favor intente nuevamente",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_producto_up=[
				"producto_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Imagen eliminada!",
					"Texto"=>"La imagen del producto se elimino con éxito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Imagen eliminada!",
					"Texto"=>"Hemos tratado de eliminar la imagen del producto, sin embargo, tuvimos algunos inconvenientes en caso de que la imagen no este eliminada por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/

		/*---------- Controlador verificar producto ----------*/
		public function verificar_producto_controlador(){

			$codigo=mainModel::limpiar_cadena($_POST['sale-barcode-input']);

			return $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_codigo='$codigo'");
		} /*-- Fin controlador --*/
    }
