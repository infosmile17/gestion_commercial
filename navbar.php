<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">

        <ul class="pcoded-item pcoded-left-item">
            <li class="<?php echo ($SCRIPT_NAME == '/bti/index.php') ? 'active' : ''; ?>">
                <a href="index.php" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Tableau de board</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="pcoded-hasmenu <?php
                                        $list_url_name = ['/bti/payement_transp_archives.php', '/bti/commandes.php', '/bti/payement_fournis.php', '/bti/payement_trans.php', '/bti/fourni.php', '/bti/transporteur.php', '/bti/payement_fournis_archives.php', '/bti/cmde_fourni_archives.php'];
                                        echo (in_array($SCRIPT_NAME, $list_url_name)) ? 'active pcoded-trigger' : '';
                                        ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-arrow-circle-down"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Achats</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/commandes.php') ? 'active' : ''; ?>">
                        <a href="commandes.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Commandes</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/payement_fournis.php') ? 'active' : ''; ?>">
                        <a href="payement_fournis.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement F </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/payement_trans.php') ? 'active' : ''; ?>">
                        <a href="payement_trans.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement T </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/fourni.php') ? 'active' : ''; ?>">
                        <a href="fourni.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Fournisseurs</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/transporteur.php') ? 'active' : ''; ?>">
                        <a href="transporteur.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Transporteur</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>


                    <li class="<?php echo ($SCRIPT_NAME == '/bti/payement_fournis_archives.php') ? 'active' : ''; ?>">
                        <a href="payement_fournis_archives.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement F archivés</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/payement_transp_archives.php') ? 'active' : ''; ?>">
                        <a href="payement_transp_archives.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement T archivés</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/cmde_fourni_archives.php') ? 'active' : ''; ?>">
                        <a href="cmde_fourni_archives.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Commandes archivés</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php
                                        $list_url_vente = ['/bti/client_commandes.php', '/bti/client_payement.php', '/bti/clients.php', '/bti/client_payement_archive.php', '/bti/client_archives.php'];
                                        echo (in_array($SCRIPT_NAME, $list_url_vente)) ? 'active pcoded-trigger' : '';
                                        ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-arrow-circle-down"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Ventes</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/client_commandes.php') ? 'active' : ''; ?>">
                        <a href="client_commandes.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Commandes client</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/client_payement.php') ? 'active' : ''; ?>">
                        <a href="client_payement.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement client</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/clients.php') ? 'active' : ''; ?>">
                        <a href="clients.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Clients</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/client_payement_archive.php') ? 'active' : ''; ?>">
                        <a href="client_payement_archive.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Payement client archivés</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/client_archives.php') ? 'active' : ''; ?>">
                        <a href="client_archives.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Commandes archivés</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php
                                        $list_url_stock = ['/bti/articles.php', '/bti/models.php'];
                                        echo (in_array($SCRIPT_NAME, $list_url_stock)) ? 'active pcoded-trigger' : '';
                                        ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-server"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Stock</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/articles.php') ? 'active' : ''; ?>">
                        <a href="articles.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Articles</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php echo ($SCRIPT_NAME == '/bti/models.php') ? 'active' : ''; ?>">
                        <a href="models.php" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Marques</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>