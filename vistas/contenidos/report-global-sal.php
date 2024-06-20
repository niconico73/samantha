<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reportes de ventas
    </h3>
    <p class="text-justify">
        En el módulo REPORTES podrá ver, generar e imprimir reportes de ventas en formato PDF.
    </p>
</div>

<div class="container-fluid">
    <div id="today-sales">
        <h4 class="text-center">Estadísticas de ventas de hoy (<?php echo date("d-m-Y"); ?>)</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-dashboard">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Ventas realizadas</th>
                        <th scope="col">Total en ventas</th>
                        <th scope="col">Costo de ventas</th>
                        <th scope="col">Ganancias</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $fecha_hoy=date("Y-m-d");
                        $check_ventas=$lc->datos_tabla("Normal","venta WHERE venta_fecha='$fecha_hoy'","*",0);

                        $ventas_totales=0;
                        $total_ventas=0;
                        $total_costos=0;
                        $total_utilidades=0;

                        if($check_ventas->rowCount()>=1){
                            $datos_ventas=$check_ventas->fetchAll();

                            foreach($datos_ventas as $ventas){
                                $ventas_totales++;
                                $total_ventas+=$ventas['venta_total_final'];
                                $total_costos+=$ventas['venta_costo'];
                                $total_utilidades+=$ventas['venta_utilidad'];
                            }
                    ?>
                    <tr class="text-center">
                        <td><?php echo $ventas_totales; ?></td>
                        <td><?php echo MONEDA_SIMBOLO.number_format($total_ventas,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></td>
                        <td><?php echo MONEDA_SIMBOLO.number_format($total_costos,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></td>
                        <td><?php echo MONEDA_SIMBOLO.number_format($total_utilidades,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></td>
                    </tr>
                    <?php }else{ ?>
                    <tr class="text-center">
                        <td colspan="4">NO HAY VENTAS REALIZADAS EL DÍA DE HOY</td>
                    </tr>
                    <?php
                        }
                        $check_ventas->closeCursor();
                        $check_ventas=$lc->desconectar($check_ventas);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($total_utilidades>0 || $ventas_totales>0){ ?>
    <p class="text-center">
        <a href="#" class="btn btn-outline-info print-barcode" data-id="#today-sales"><i class="fas fa-print"></i> &nbsp; Imprimir</a>
    </p>
    <?php } ?>
    <hr>
    <div class="container-fluid">
        <h4 class="text-center">Generar reporte personalizado</h4>
        <div class="form-neon">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha_inicio" >Fecha inicial (día/mes/año)</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha_final" >Fecha final (día/mes/año)</label>
                            <input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="button" class="btn btn-raised btn-info" onclick="generar_reporte()" ><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generar_reporte(){
        Swal.fire({
			title: '¿Quieres generar el reporte?',
			text: "La generación del reporte PDF puede tardar unos minutos para completarse",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, generar',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if(result.value){
                let fecha_inicio=document.querySelector('#fecha_inicio').value;
                let fecha_final=document.querySelector('#fecha_final').value;

                fecha_inicio.trim();
                fecha_final.trim();

                if(fecha_inicio!="" && fecha_final!=""){
                    url="<?php echo SERVERURL; ?>pdf/report-sales.php?fi="+fecha_inicio+"&&ff="+fecha_final;
                    window.open(url,'Imprimir reporte de ventas','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe de ingresar la fecha de inicio y final para generar el reporte.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
			}
		});
    }
</script>
