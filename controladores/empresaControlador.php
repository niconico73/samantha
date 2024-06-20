<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class empresaControlador extends mainModel{

        /*---------- Controlador agregar empresa ----------*/
        public function agregar_empresa_controlador(){

			$tipo_documento=mainModel::limpiar_cadena($_POST['empresa_tipo_documento_reg']);
			$numero_documento=mainModel::limpiar_cadena($_POST['empresa_numero_documento_reg']);
			$nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
			$direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);

			$telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
			$email=mainModel::limpiar_cadena($_POST['empresa_email_reg']);

			$impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_nombre_reg']);
			$porcentaje=mainModel::limpiar_cadena($_POST['empresa_impuesto_porcentaje_reg']);
			$impuesto_factura=mainModel::limpiar_cadena($_POST['empresa_impuesto_factura_reg']);

			/*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $impuesto=="" || $porcentaje==""){
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
			
			if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,75}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[a-zA-Z]{2,7}",$impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de impuesto no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[0-9]{1,2}",$porcentaje)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El porcentaje del impuesto no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if($direccion!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La dirección no coincide con el formato solicitado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
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

			/*== Comprobando tipo de documento ==*/
			if(!in_array($tipo_documento, DOCUMENTOS_EMPRESA)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de documento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
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

			/*== Comprobando impuestos de factura ==*/
			if($impuesto_factura!="Si" && $impuesto_factura!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor de mostrar impuestos en facturas y tickets es incorrecto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_empresa_reg=[
				"empresa_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
				"empresa_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
				"empresa_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"empresa_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"empresa_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"empresa_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				"empresa_impuesto_nombre"=>[
					"campo_marcador"=>":Impuesto",
					"campo_valor"=>$impuesto
				],
				"empresa_impuesto_porcentaje"=>[
					"campo_marcador"=>":Porcentaje",
					"campo_valor"=>$porcentaje
				],
				"empresa_factura_impuestos"=>[
					"campo_marcador"=>":FacturaImpuesto",
					"campo_valor"=>$impuesto_factura
				]
			];

			$agregar_empresa=mainModel::guardar_datos("empresa",$datos_empresa_reg);

			if($agregar_empresa->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Empresa registrada!",
					"Texto"=>"Los datos de la empresa se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la empresa, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/
		

		/*---------- Controlador Actualizar empresa ----------*/
		public function actualizar_empresa_controlador(){

			/*== Recuperando id de la empresa ==*/
			$id=mainModel::decryption($_POST['empresa_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando empresa en la DB ==*/
            $check_empresa=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresa_id='$id'");
            if($check_empresa->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado la empresa en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_empresa->closeCursor();
			$check_empresa=mainModel::desconectar($check_empresa);

			$tipo_documento=mainModel::limpiar_cadena($_POST['empresa_tipo_documento_up']);
			$numero_documento=mainModel::limpiar_cadena($_POST['empresa_numero_documento_up']);
			$nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
			$direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

			$telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
			$email=mainModel::limpiar_cadena($_POST['empresa_email_up']);

			$impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_nombre_up']);
			$porcentaje=mainModel::limpiar_cadena($_POST['empresa_impuesto_porcentaje_up']);
			$impuesto_factura=mainModel::limpiar_cadena($_POST['empresa_impuesto_factura_up']);

			/*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $impuesto=="" || $porcentaje==""){
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
			
			if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,75}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[a-zA-Z]{2,7}",$impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de impuesto no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if(mainModel::verificar_datos("[0-9]{1,2}",$porcentaje)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El porcentaje del impuesto no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			if($direccion!=""){
				if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La dirección no coincide con el formato solicitado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
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

			/*== Comprobando tipo de documento ==*/
			if(!in_array($tipo_documento, DOCUMENTOS_EMPRESA)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de documento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
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

			/*== Comprobando impuestos de factura ==*/
			if($impuesto_factura!="Si" && $impuesto_factura!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El valor de mostrar impuestos en facturas y tickets es incorrecto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_empresa_up=[
				"empresa_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
				"empresa_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
				"empresa_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"empresa_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"empresa_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"empresa_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				"empresa_impuesto_nombre"=>[
					"campo_marcador"=>":Impuesto",
					"campo_valor"=>$impuesto
				],
				"empresa_impuesto_porcentaje"=>[
					"campo_marcador"=>":Porcentaje",
					"campo_valor"=>$porcentaje
				],
				"empresa_factura_impuestos"=>[
					"campo_marcador"=>":FacturaImpuesto",
					"campo_valor"=>$impuesto_factura
				]
			];

			$condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];


			if(mainModel::actualizar_datos("empresa",$datos_empresa_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Empresa actualizada!",
					"Texto"=>"La empresa se actualizo con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos de la empresa, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/
    }