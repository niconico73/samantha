<?php

	$peticion_ajax=true;
    $orden=(isset($_GET['order'])) ? $_GET['order'] : "";


	/*---------- Incluyendo configuraciones ----------*/
	require_once "../config/APP.php";


	if($orden!="" && ($orden=="nasc" || $orden=="ndesc" || $orden=="sasc" || $orden=="sdesc")){

        if($orden=="nasc"){
            $orden="producto_nombre ASC";
        }elseif($orden=="ndesc"){
            $orden="producto_nombre DESC";
        }elseif($orden=="sasc"){
            $orden="producto_stock_total ASC";
        }elseif($orden=="sdesc"){
            $orden="producto_stock_total DESC";
        }else{
            $orden="producto_nombre ASC";
        }

		/*---------- Instancia al controlador producto ----------*/
	    require_once "../controladores/productoControlador.php";
        $ins_producto = new productoControlador();

		/*---------- Seleccion de datos de la empresa ----------*/
		$datos_empresa=$ins_producto->datos_tabla("Normal","empresa LIMIT 1","*",0);
		$datos_empresa=$datos_empresa->fetch();


		require "./code128.php";

		$pdf = new PDF_Code128('P','mm','Letter');
		$pdf->SetMargins(17,17,17);
		$pdf->AddPage();
		$pdf->Image(SERVERURL.'vistas/assets/img/logo.png',165,12,35,35,'PNG');

		$pdf->SetFont('Arial','B',16);
		$pdf->SetTextColor(32,100,210);
		$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,0,'L');

		$pdf->Ln(9);

		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_tipo_documento'].": ".$datos_empresa['empresa_numero_documento']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_direccion']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_empresa['empresa_telefono']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: ".$datos_empresa['empresa_email']),0,0,'L');

        $pdf->Ln(15);

        $pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1",strtoupper("Reporte de inventario general (".date("d")."-".date("m")."-".date("Y").")")),0,'C',false);

		$pdf->SetFillColor(23,83,201);
		$pdf->SetDrawColor(23,83,201);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,iconv("UTF-8", "ISO-8859-1",'Codigo'),1,0,'C',true);
		$pdf->Cell(100,8,iconv("UTF-8", "ISO-8859-1",'Nombre'),1,0,'C',true);
		$pdf->Cell(16,8,iconv("UTF-8", "ISO-8859-1",'Stock'),1,0,'C',true);
		$pdf->Cell(30,8,iconv("UTF-8", "ISO-8859-1",'Unidad'),1,0,'C',true);

		$pdf->Ln(8);

		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(39,39,51);

		/*----------  Seleccionando datos de productos  ----------*/
        $campos_productos="producto_codigo,producto_sku,producto_nombre,producto_stock_total,producto_tipo_unidad";

        $check_producto=$ins_producto->datos_tabla("Normal","producto WHERE (producto_estado = 'Habilitado' AND producto_stock_total >= 1) ORDER BY $orden",$campos_productos,0);

        if($check_producto->rowCount()>=1){
            $datos_productos=$check_producto->fetchAll();

			foreach($datos_productos as $row){
				$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",$row['producto_codigo']),'LB',0,'C');
				$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",$ins_producto->limitar_cadena($row['producto_nombre'],70,"...")),'LB',0,'C');
				$pdf->Cell(16,7,iconv("UTF-8", "ISO-8859-1",$row['producto_stock_total']),'LB',0,'C');
				$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1",$row['producto_tipo_unidad']),'LRB',0,'C');
				$pdf->Ln(7);
			}

        }else{
            $pdf->Cell(181,7,iconv("UTF-8", "ISO-8859-1","No hay datos de productos para mostrar"),'LBR',0,'C');
        }
		$pdf->Output("I","Reporte inventario ".date("d")."-".date("m")."-".date("Y").".pdf",true);

	}else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include '../vistas/inc/Head.php'; ?>
</head>
<body>
	<div class="full-box container-404">
		<div>
			<p class="text-center"><i class="far fa-thumbs-down fa-10x"></i></p>
			<h1 class="text-center">¡Ocurrió un error!</h1>
			<p class="lead text-center">No ha seleccionado un orden valido</p>
		</div>
	</div>
	<?php include '../vistas/inc/Script.php'; ?>
</body>
</html>
<?php } ?>
