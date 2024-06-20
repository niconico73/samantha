<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes
    </h3>
    <p class="text-justify">
        En el módulo CLIENTE podrá registrar en el sistema los datos de sus clientes más frecuentes para realizar ventas, además podrá realizar búsquedas de clientes, actualizar datos de sus clientes o eliminarlos si así lo desea.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>client-new/">
                <i class="fas fa-child fa-fw"></i> &nbsp; Nuevo cliente
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>client-list/">
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
    <?php
        require_once "./controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();

        echo $ins_cliente->paginador_cliente_controlador($pagina[1],15,$pagina[0],"");
    ?>
</div>