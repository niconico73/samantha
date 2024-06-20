<?php

	/*----------  Ruta o dominio del servidor  ----------*/
	const SERVERURL="http://localhost/SVIL/";


	/*----------  Nombre de la empresa o compañia  ----------*/
	const COMPANY="SISTEMA VENTAS";

	/*---------- Nombre de la sesion (Solo numeros y letras sin espacios ejemplo: VENTAS) ----------*/
	const SESSION_NAME="SVIL";


	/*----------  Configuración de moneda  ----------*/
	const MONEDA_SIMBOLO="S/";
	const MONEDA_NOMBRE="PEN";
	const MONEDA_DECIMALES="2";
	const MONEDA_SEPARADOR_MILLAR=",";
	const MONEDA_SEPARADOR_DECIMAL=".";


	/*----------  Tipos de documentos  ----------*/
	const DOCUMENTOS_USUARIOS=["1","6","4"];
	const DOCUMENTOS_EMPRESA=["1","6","4"];


	/*----------  Tipos de unidades de productos  ----------*/
	const PRODUCTO_UNIDAD=["Unidad","Otro"];

	/*----------  Garantia de productos  ----------*/
	const GARANTIA_TIEMPO=["N/A","Dias","Semanas","Mes","Meses","Año","Años"];


	/*----------  Marcador de campos obligatorios  ----------*/
	const CAMPO_OBLIGATORIO='&nbsp; <i class="fab fa-font-awesome-alt"></i> &nbsp;';



	/*----------  Tamaño de papel de impresora termica (en milimetros)  
		THERMAL_PRINT_SIZE -> 80 | 57
	----------*/
	const THERMAL_PRINT_SIZE="80";


	/*----------  Zona horaria  ----------*/
	date_default_timezone_set("America/El_Salvador");

	/*
		Configuración de zona horaria de tu país, para más información visita
		http://php.net/manual/es/function.date-default-timezone-set.php
		http://php.net/manual/es/timezones.php
	*/