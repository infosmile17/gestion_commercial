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
                                    <h5>Listes des commandes archivés</h5>
                                    <?php
                                    $pages = "cmde_fourni_archives.php";
                                    include_once('searchtext.php');
                                    ?>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fournisseurs</th>
                                                        <th>Date</th>
                                                        <th>Total</th>
                                                        <th>Payée</th>
                                                        <th>Etat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM cmd_achat where total=payee";

                                                    if (isset($_POST['searchtext'])) {
                                                        if ($_POST['searchtext'] != '') {
                                                            $searchtext = $_POST['searchtext'];
                                                            $sql = "SELECT * FROM cmd_achat where  total=payee AND id_fourni IN ( SELECT id FROM fournis WHERE nomprenom LIKE '%$searchtext%'
OR tel1 LIKE '%$searchtext%'
OR tel2 LIKE '%$searchtext%'
)";
                                                        }
                                                    }


                                                    $result = $con->query($sql);
                                                    // var_dump($result);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . getNomFourni($row["id_fourni"], $con) . "</td><td>" . $row["date_ajout"] . "</td><td>" . $row["total"] . "</td><td>" . $row["payee"] . "</td><td>Réglé</td>";
                                                            echo "</tr>";
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