<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-box-open fa-fw"></i> &nbsp; Reportes de inventario
    </h3>
    <p class="text-justify">
        En el módulo REPORTES podrá ver, generar e imprimir reportes de inventario en formato PDF.
    </p>
</div>

<div class="container-fluid">
    <div class="container-fluid">
        <h4 class="text-center">Generar reporte de inventario personalizado</h4>
        <div class="form-neon">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="orden_reporte_inventario" class="bmd-label-floating">Ordenar por</label>
                            <select class="form-control" name="orden_reporte_inventario" id="orden_reporte_inventario">
                                <option value="nasc" selected="" >Nombre (ascendente)</option>
                                <option value="ndesc">Nombre (descendente)</option>
                                <option value="sasc">Stock (menor - mayor)</option>
                                <option value="sdesc">Stock (mayor - menor)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="button" class="btn btn-raised btn-info" onclick="generar_reporte_inventario()" ><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generar_reporte_inventario(){
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
                let orden=document.querySelector('#orden_reporte_inventario').value;

                orden.trim();

                if(orden!=""){
                    url="<?php echo SERVERURL; ?>pdf/report-inventory.php?order="+orden;
                    window.open(url,'Imprimir reporte de inventario','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe de seleccionar un orden para generar el reporte.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
			}
		});
    }
</script>
