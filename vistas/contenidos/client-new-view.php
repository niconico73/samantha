<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-child fa-fw"></i> &nbsp; Nuevo cliente
    </h3>
    <p class="text-justify">
        En el módulo CLIENTE podrá registrar en el sistema los datos de sus clientes más frecuentes para realizar ventas, además podrá realizar búsquedas de clientes, actualizar datos de sus clientes o eliminarlos si así lo desea.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>client-new/">
                <i class="fas fa-child fa-fw"></i> &nbsp; Nuevo cliente
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>client-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>client-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="save" autocomplete="off" >
        <input type="hidden" name="modulo_cliente" value="registrar">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo_documento_reg" id="cliente_tipo_documento">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="cliente_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
        <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="cliente_numero_documento_reg" id="cliente_numero_documento" maxlength="30">
        <button type="button" class="btn btn-primary" onclick="extraerDatosCliente()">Extraer</button> </div>
</div>
<script>function extraerDatosCliente() {
  const documentoInput = document.getElementById("cliente_numero_documento");
  const documento = documentoInput.value.trim();

  if (documento.length !== 11 && documento.length !== 8) {
    alert("Ingrese un RUC o DNI válido (8 o 11 dígitos)");
    return;
  }

  const tipoDocumento = documento.length === 11 ? 'sunat/ruc' : 'reniec/dni';

  // URL de tu endpoint PHP
  const apiUrl = `ajax/consultar_documento.php?numero=${documento}&tipo=${tipoDocumento}`;

  fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Llenar los campos del formulario con los datos obtenidos
        // ... (ajusta según la estructura de la respuesta de apis.net.pe)
      } else {
        alert("Error al consultar el RUC/DNI: " + data.message);
      }
    })
    .catch((error) => {
      alert("Error en la petición: " + error);
    });
}
</script>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_reg" id="cliente_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellidos <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_apellido_reg" id="cliente_apellido" maxlength="35">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="fas fa-map-marked-alt"></i> &nbsp; Información de residencia</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_provincia" class="bmd-label-floating">Estado, provincia o departamento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_provincia_reg" id="cliente_provincia" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_ciudad" class="bmd-label-floating">Ciudad o pueblo <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_ciudad_reg" id="cliente_ciudad" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Calle o dirección de casa <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" class="form-control" name="cliente_direccion_reg" id="cliente_direccion" maxlength="70">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="far fa-address-book"></i> &nbsp; Información de contacto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_reg" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_reg" id="cliente_email" maxlength="50">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
</div>