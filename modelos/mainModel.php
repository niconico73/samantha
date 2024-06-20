<?php

	if($peticion_ajax){
		require_once "../config/SERVER.php";
	}else{
		require_once "./config/SERVER.php";
	}

	class mainModel{

		/*----------  Funcion conectar a BD  ----------*/
		protected static function conectar(){
			$conexion = new PDO(SGBD,USER,PASS);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		} /*--  Fin Funcion --*/


		/*----------  Funcion desconectar de DB  ----------*/
		public function desconectar($consulta){
			global $conexion, $consulta;
			$consulta=null;
			$conexion=null;
			return $consulta;
		} /*--  Fin Funcion --*/


		/*----------  Funcion ejecutar consultas simples  ----------*/
		protected static function ejecutar_consulta_simple($consulta){
			$sql=self::conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		} /*--  Fin Funcion --*/


		/*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
		protected static function guardar_datos($tabla,$datos){
			$query="INSERT INTO $tabla (";
			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo;
				}else{
					$query.=",".$campo;
				}
				$C++;
			}

			$query.=") VALUES(";
			$Z=0;
			foreach ($datos as $campo => $indice){
				if($Z<=0){
					$query.=$indice["campo_marcador"];
				}else{
					$query.=",".$indice["campo_marcador"];
				}
				$Z++;
			}

			$query.=")";
			$sql=self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->execute();

			return $sql;
		} /*-- Fin Funcion --*/


		/*---------- Funcion datos tabla ----------*/
        public function datos_tabla($tipo,$tabla,$campo,$id){
			$tipo=self::limpiar_cadena($tipo);
			$tabla=self::limpiar_cadena($tabla);
			$campo=self::limpiar_cadena($campo);

			$id=self::decryption($id);
			$id=self::limpiar_cadena($id);

            if($tipo=="Unico"){
                $sql=self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($tipo=="Normal"){
                $sql=self::conectar()->prepare("SELECT $campo FROM $tabla");
            }
            $sql->execute();

            return $sql;
		} /*-- Fin Funcion --*/


		/*----------  Funcion para ejecutar una consulta UPDATE preparada  ----------*/
		protected static function actualizar_datos($tabla,$datos,$condicion){
			$query="UPDATE $tabla SET ";

			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo."=".$indice["campo_marcador"];
				}else{
					$query.=",".$campo."=".$indice["campo_marcador"];
				}
				$C++;
			}

			$query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];

			$sql=self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

			$sql->execute();

			return $sql;
		} /*-- Fin Funcion --*/


		/*---------- Funcion eliminar registro ----------*/
        protected static function eliminar_registro($tabla,$campo,$id){
            $sql=self::conectar()->prepare("DELETE FROM $tabla WHERE $campo=:ID");

            $sql->bindParam(":ID",$id);
            $sql->execute();

            return $sql;
        } /*-- Fin Funcion --*/


		/*----------  Encriptar cadenas ----------*/
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		} /*--  Fin Funcion --*/


		/*----------  Desencriptar cadenas  ----------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		} /*--  Fin Funcion --*/


		/*----------  Limitar cadenas de texto  ----------*/
		public function limitar_cadena($cadena,$limite,$sufijo){
			if(strlen($cadena)>$limite){
				return substr($cadena,0,$limite).$sufijo;
			}else{
				return $cadena;
			}
		} /*--  Fin Funcion --*/


		/*----------  Funcion generar codigos aleatorios  ----------*/
		protected static function generar_codigo_aleatorio($longitud,$correlativo){
			$codigo="";
			$caracter="Letra";
			for($i=1; $i<=$longitud; $i++){
				if($caracter=="Letra"){
					$letra_aleatoria=chr(rand(ord("a"),ord("z")));
					$letra_aleatoria=strtoupper($letra_aleatoria);
					$codigo.=$letra_aleatoria;
					$caracter="Numero";
				}else{
					$numero_aleatorio=rand(0,9);
					$codigo.=$numero_aleatorio;
					$caracter="Letra";
				}
			}
			return $codigo."-".$correlativo;
		} /*--  Fin Funcion --*/


		/*----------  Funcion limpiar cadenas  ----------*/
		protected static function limpiar_cadena($cadena){
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			$cadena=str_ireplace("<script>", "", $cadena);
			$cadena=str_ireplace("</script>", "", $cadena);
			$cadena=str_ireplace("<script src", "", $cadena);
			$cadena=str_ireplace("<script type=", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("DROP TABLE", "", $cadena);
			$cadena=str_ireplace("DROP DATABASE", "", $cadena);
			$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
			$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
			$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
			$cadena=str_ireplace("<?php", "", $cadena);
			$cadena=str_ireplace("?>", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace("^", "", $cadena);
			$cadena=str_ireplace("<", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			$cadena=str_ireplace("::", "", $cadena);
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			return $cadena;
		} /*--  Fin Funcion --*/


		/*---------- Funcion verificar datos (expresion regular) ----------*/
		protected static function verificar_datos($filtro,$cadena){
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
            }else{
                return true;
            }
		} /*--  Fin Funcion --*/


		/*---------- Funcion verificar fechas ----------*/
		protected static function verificar_fecha($fecha){
			$valores=explode('-',$fecha);
			if(count($valores)==3 && checkdate($valores[1], $valores[2], $valores[0])){
				return false;
			}else{
				return true;
			}
		} /*--  Fin Funcion --*/


		/*---------- Funcion obtener nombre de mes ----------*/
		public function obtener_nombre_mes($mes){
			switch($mes){
				case 1:
					$nombre_mes="enero";
				break;
				case 2:
					$nombre_mes="febrero";
				break;
				case 3:
					$nombre_mes="marzo";
				break;
				case 4:
					$nombre_mes="abril";
				break;
				case 5:
					$nombre_mes="mayo";
				break;
				case 6:
					$nombre_mes="junio";
				break;
				case 7:
					$nombre_mes="julio";
				break;
				case 8:
					$nombre_mes="agosto";
				break;
				case 9:
					$nombre_mes="septiembre";
				break;
				case 10:
					$nombre_mes="octubre";
				break;
				case 11:
					$nombre_mes="noviembre";
				break;
				case 12:
					$nombre_mes="diciembre";
				break;
				default:
					$nombre_mes="No definido";
				break;
			}
			return $nombre_mes;
		} /*--  Fin Funcion --*/


		/*----------  Funcion paginador de tablas ----------*/
		protected static function paginador_tablas($pagina,$Npaginas,$url,$botones){
			$tabla='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

			if($pagina==1){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-left"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina-1).'/">Anterior</a></li>
				';
			}

			$ci=0;
			for($i=$pagina; $i<=$Npaginas; $i++){
				if($ci>=$botones){
					break;
				}
				if($pagina==$i){
					$tabla.='<li class="page-item" ><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
				}else{
					$tabla.='<li class="page-item" ><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
				}
				$ci++;
			}

			if($pagina==$Npaginas){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-right"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina+1).'/">Siguiente</a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.$Npaginas.'/"><i class="fas fa-angle-double-right"></i></a></li>
				';
			}

			$tabla.='</ul></nav>';
			return $tabla;
		} /*--  Fin Funcion --*/

/*--  INICIO --*/
/*----------  Función para obtener los datos de una venta  ----------*/
public static function obtener_datos_venta($venta_codigo){
	$venta_codigo = self::limpiar_cadena($venta_codigo);
	$consulta = "SELECT * FROM venta WHERE venta_codigo=:Codigo";
	$sql = self::conectar()->prepare($consulta);
	$sql->bindParam(":Codigo", $venta_codigo);
	$sql->execute();
	return $sql->fetch(PDO::FETCH_ASSOC);
} /*-- Fin Funcion --*/

/*----------  Función para agregar un pago a una venta  ----------*/
public static function agregar_pago_venta($venta_codigo, $monto_pago){
	$venta_codigo = self::limpiar_cadena($venta_codigo);
	$monto_pago = floatval($monto_pago);
	
	// Verificar si la venta existe
	$venta = self::obtener_datos_venta($venta_codigo);
	if(!$venta){
		return false; // La venta no existe
	}
	
	// Calcular nuevo monto pagado y estado de la venta
	$venta_total_final = floatval($venta['venta_total_final']);
	$venta_pagado = floatval($venta['venta_pagado']);
	$venta_pendiente = $venta_total_final - $venta_pagado;
	
	if($monto_pago <= $venta_pendiente){
		$venta_estado = "Pendiente";
	}else{
		$venta_estado = "Cancelado";
	}
	
	// Actualizar datos de la venta
	$datos_venta = [
		"venta_pagado" => [
			"campo_marcador" => ":Pagado",
			"campo_valor" => $venta_pagado + $monto_pago
		],
		"venta_estado" => [
			"campo_marcador" => ":Estado",
			"campo_valor" => $venta_estado
		]
	];
	
	$condicion = [
		"condicion_campo" => "venta_codigo",
		"condicion_marcador" => ":Codigo",
		"condicion_valor" => $venta_codigo
	];
	
	if(!self::actualizar_datos("venta", $datos_venta, $condicion)){
		return false; // No se pudo actualizar la venta
	}
	
	// Guardar el pago en la base de datos
	$datos_pago = [
		"pago_fecha" => [
			"campo_marcador" => ":Fecha",
			"campo_valor" => date("Y-m-d")
		],
		"pago_monto" => [
			"campo_marcador" => ":Monto",
			"campo_valor" => $monto_pago
		],
		"venta_codigo" => [
			"campo_marcador" => ":Codigo",
			"campo_valor" => $venta_codigo
		],
		"usuario_id" => [
			"campo_marcador" => ":Usuario",
			"campo_valor" => $_SESSION['id_svi']
		],
		"caja_id" => [
			"campo_marcador" => ":Caja",
			"campo_valor" => $_SESSION['caja_svi']
		]
	];

	$agregar_pago = self::guardar_datos("pago", $datos_pago);

	return $agregar_pago->rowCount() > 0;
}

/*--  FIN --*/

		/*----------  Funcion generar select ----------*/
		public function generar_select($datos,$campo_db){
			$check_select='';
			$text_select='';
			$count_select=1;
			$select='';
			foreach($datos as $row){

				if($campo_db==$row){
					$check_select='selected=""';
					$text_select=' (Actual)';
				}

				$select.='<option value="'.$row.'" '.$check_select.'>'.$count_select.' - '.$row.$text_select.'</option>';

				$check_select='';
				$text_select='';
				$count_select++;
			}
			return $select;
		} /*--  Fin Funcion --*/

	}
?>
