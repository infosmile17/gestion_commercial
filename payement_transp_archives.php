<?php include_once('header.php'); ?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('functions.php'); ?>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <div class="page-body">
                            <!-- Basic table card start -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                            <li><i class="fa fa-trash close-card"></i></li>
                                        </ul>
                                    </div>
                                    <h5>Listes des payements transporteurs archivés</h5>
                                    <?php
                                    $pages = "payement_transps.php";
                                    include_once('searchtext.php');
                                    ?>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Commande</th>
                                                        <th>Transporteur</th>
                                                        <th>Total</th>
                                                        <th>Montant payée</th>
                                                        <th>Date</th>
                                                        <th>Opérations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM payement_transp where id_cmd IN (SELECT id FROM cmd_achat where `total` = `payee`) ORDER BY id_cmd DESC";

                                                    $result = $con->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $getinfo = getinfocmdtransp($row["id_cmd"], $con);
                                                            echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . $row["id_cmd"] . "</td><td>" . getNomTransp($getinfo[0], $con) . "</td><td>" . $getinfo[1] . "</td><td>" . $row["montant"] . "</td><td>" . $row["date"] . "</td><td>";

                                                    ?>

                                                            <a href='apipayement.php?id_cmd=<?= $row["id_cmd"]; ?>&del=<?= $row["id"]; ?>' class="info btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon" data-modal="modal-info">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                    <?php

                                                            echo "</td></tr>";
                                                        }
                                                    } else {
                                                        echo "0 resultats";
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Required Jquery -->
            <?php include_once('footer.php'); ?>