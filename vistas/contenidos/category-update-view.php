<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar categoría
    </h3>
    <p class="text-justify">
        En el módulo CATEGORÍA usted podrá registrar las categorías que servirán para agregar productos y también podrá ver los productos que pertenecen a una categoría determinada. Además de lo antes mencionado, puede actualizar los datos de las categorías, realizar búsquedas de categorías o eliminarlas si así lo desea.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>category-new/">
                <i class="fas fa-tags fa-fw"></i> &nbsp; Nueva categoría
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>category-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de categorías
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>category-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar categoría
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/btn_go_back.php";
        
        $datos_categoria=$lc->datos_tabla("Unico","categoria","categoria_id",$pagina[1]);

        if($datos_categoria->rowCount()==1){
            $campos=$datos_categoria->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/categoriaAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="modulo_categoria" value="actualizar">
        <input type="hidden" name="categoria_id_up" value="<?php echo $pagina[1]; ?>" >
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información de la categoría</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="categoria_nombre" class="bmd-label-floating">Nombre de la categoría <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ ]{3,40}" class="form-control" name="categoria_nombre_up" value="<?php echo $campos['categoria_nombre']; ?>" id="categoria_nombre" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="categoria_ubicacion" class="bmd-label-floating">Pasillo o ubicación de la categoría <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,100}" class="form-control" name="categoria_ubicacion_up" value="<?php echo $campos['categoria_ubicacion']; ?>" id="categoria_ubicacion" maxlength="100">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="categoria_estado" class="bmd-label-floating">Estado de la categoría</label>
                            <select class="form-control" name="categoria_estado_up" id="categoria_estado">
                                <?php
                                    $array_estado=["Habilitada","Deshabilitada"];
                                    echo $lc->generar_select($array_estado,$campos['categoria_estado']);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
        } 
    ?>
</div>