<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-people-carry fa-fw"></i> &nbsp; Devoluciones realizadas
    </h3>
    <p class="text-justify">
        En el módulo DEVOLUCIONES podrá ver el listado de todas las devoluciones de compras y ventas realizadas. Además, podrá buscar devoluciones por fecha.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>return-list/">
                <i class="fas fa-people-carry fa-fw"></i> &nbsp; Devoluciones realizadas
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>return-search/">
                <i class="fas fa-dolly-flatbed fa-fw"></i> &nbsp; Buscar devoluciones
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/devolucionControlador.php";
        $ins_devolucion = new devolucionControlador();

        echo $ins_devolucion->paginador_devolucion_controlador($pagina[1],15,$pagina[0],"","");
    ?>
</div>