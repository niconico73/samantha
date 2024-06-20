<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-bg show-nav-lateral"></div>
    <div class="full-box nav-lateral-content scroll">
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/<?php echo $_SESSION['foto_svi']; ?>" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">
            <?php echo $_SESSION['nombre_svi']; ?><br><small class="roboto-condensed-light"><?php echo $_SESSION['cargo_svi']; ?></small>
            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="<?php echo SERVERURL; ?>dashboard/">
                        <i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-briefcase fa-fw"></i> &nbsp; Administración <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
                            <li>
                                <a href="<?php echo SERVERURL; ?>cashier-new/">
                                    <i class="fas fa-cash-register fa-fw"></i> &nbsp; Nueva caja
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SERVERURL; ?>category-new/">
                                    <i class="fas fa-tags fa-fw"></i> &nbsp; Nueva categoría
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SERVERURL; ?>user-new/">
                                    <i class="fas fa-user-tie fa-fw"></i> &nbsp; Nuevo usuario
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo SERVERURL; ?>client-new/">
                                <i class="fas fa-child fa-fw"></i> &nbsp; Nuevo cliente
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-boxes fa-fw"></i> &nbsp; Productos <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
                            <li>
                                <a href="<?php echo SERVERURL; ?>product-new/">
                                    <i class="fas fa-box fa-fw"></i> &nbsp; Nuevo producto
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-list/">
                                <i class="fas fa-boxes fa-fw"></i> &nbsp; Productos en almacen
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-sold/">
                                <i class="fas fa-fire-alt fa-fw"></i> &nbsp; Lo más vendido
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-category/">
                                <i class="fab fa-shopify fa-fw"></i> &nbsp; Productos por categoría
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-expiration/">
                                <i class="fas fa-history fa-fw"></i> &nbsp; Productos por vencimiento
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-minimum/">
                                <i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>product-search/">
                                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar productos
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Ventas <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-new/">
                                <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Nueva venta
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-new/wholesale/">
                                <i class="fas fa-parachute-box fa-fw"></i> &nbsp; Venta por mayoreo
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-list/">
                                <i class="fas fa-coins fa-fw"></i> &nbsp; Ventas realizadas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-pending/">
                                <i class="fab fa-creative-commons-nc fa-fw"></i> &nbsp; Ventas pendientes
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-search-date/">
                                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar venta (Fecha)
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>sale-search-code/">
                                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar venta (Código)
                            </a>
                        </li>
                    </ul>
                </li>

              

                <?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-truck-loading fa-fw"></i> &nbsp; Devoluciones <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL; ?>return-list/">
                                <i class="fas fa-people-carry fa-fw"></i> &nbsp; Devoluciones realizadas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>return-search/">
                                <i class="fas fa-dolly-flatbed fa-fw"></i> &nbsp; Buscar devoluciones
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="far fa-file-pdf fa-fw"></i> &nbsp; Reportes <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL; ?>report-sales/">
                                <i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reportes de ventas Individuales
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>report-inventory/">
                                <i class="fas fa-box-open fa-fw"></i> &nbsp; Reportes de inventario
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-cogs fa-fw"></i> &nbsp; Configuraciones <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
                            <li>
                                <a href="<?php echo SERVERURL; ?>company/">
                                    <i class="fas fa-store-alt fa-fw"></i> &nbsp; Datos de la empresa
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo SERVERURL."user-update/".$lc->encryption($_SESSION['id_svi'])."/"; ?>">
                                <i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar cuenta
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</section>
