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
                            <?php include('msg.php'); ?>
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
                                    <h5>Listes des commandes</h5>
                                    <!-- button Default -->
                                    <a href="addcmd.php" class="btn btn-success btn-outline-success waves-effect">nouveau</a>
                                    <?php
                                    $pages = "commandes.php";
                                    include_once('searchtext.php');
                                    $sql_cmd = "DELETE FROM `cmd_achat` WHERE `total` =0";
                                    if ($con->query($sql_cmd) === TRUE) {
                                        $last_id = $con->insert_id;
                                        $sql2 = "DELETE FROM `cmd_achat_ligne` WHERE `id_cmd` ='{$last_id}'";
                                        $con->query($sql2);
                                    }

                                    $sql = "SELECT * FROM cmd_achat where total != payee";

                                    if (isset($_POST['searchtext'])) {
                                        if ($_POST['searchtext'] != '') {
                                            $searchtext = $_POST['searchtext'];
                                            $sql = "SELECT * FROM cmd_achat where total != payee AND id_fourni IN ( SELECT id FROM fournis WHERE nomprenom LIKE '%$searchtext%'
OR tel1 LIKE '%$searchtext%'
OR tel2 LIKE '%$searchtext%'
)";
                                            echo "<h6 style='text-align:center'>Filtrer par : <label class='badge badge-info'>" . $_POST['searchtext'] . "</label></h6>";
                                        }
                                    }
                                    ?>
                                    <!-- Basic table card end -->
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
                                                        <th>Opérations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php




                                                    $result = $con->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . getNomFourni($row["id_fourni"], $con) . "</td><td>" . $row["date_ajout"] . "</td><td>" . $row["total"] . "</td><td>" . $row["payee"] . "</td><td>";
                                                    ?>

                                                            <button value="<?= $row["id"]; ?>" type="button" class="info btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon" data-modal="modal-info">
                                                                <i class="icofont icofont-eye-alt"></i>
                                                            </button>
                                                            <!--
                                                            <a href="addcmd.php?id_mod=<?php // $row["id"]; 
                                                                                        ?>" type="button" class="update btn btn-success btn-outline-success waves-effect md-trigger btn-icon" data-modal="modal-12">
                                                                <i class="icofont icofont-exchange"></i>
                                                            </a>-->
                                                    <?php
                                                            //  echo "<a href='commandes.php?mod=" . $row["id"] . "'>modifier</a> | <a href='apiCmdeFournis.php?del_cmde=" . $row["id"] . "'>Supprimer</a></td></tr>";
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

                                <!-- Animation modal start / Nifty Modal Window Effects start-->
                                <div class="col-sm-12">

                                    <div class="animation-model">
                                        <!-- animation modal Dialogs start -->
                                        <div class="md-modal md-effect-9" id="modal-9">
                                            <div class="md-content">
                                                <h3>Entrer en stock</h3>
                                                <div>
                                                    <form action="apiCmdeFournis.php" method="POST">

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Articles</label>
                                                            <div class="col-sm-9">
                                                                <select name="id_article" class="form-control form-control-round">
                                                                    <?php
                                                                    $sql22 = "select id,reference,titre FROM `articles`";
                                                                    $result22 = $con->query($sql22);
                                                                    if ($result22->num_rows > 0) {
                                                                        while ($row22 = $result22->fetch_assoc()) {
                                                                            echo "<option value='" . $row22['id'] . "'>" . $row22["reference"] . " : " . $row22["titre"] . "</option>";
                                                                        }
                                                                    }
                                                                    //$con->close();
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Fournisseurs</label>
                                                            <div class="col-sm-9">
                                                                <select name="id_fournis" class="form-control form-control-round">
                                                                    <?php
                                                                    $sql22 = "select id,nomprenom FROM `fournis`";
                                                                    $result22 = $con->query($sql22);
                                                                    if ($result22->num_rows > 0) {
                                                                        while ($row22 = $result22->fetch_assoc()) {
                                                                            echo "<option value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
                                                                        }
                                                                    }
                                                                    $con->close();
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b>Quantité</b></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="qte">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Prix achat</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control form-control-round" name="prix_achat">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary waves-effect md-close" type="submit" value="enregistrer" name="enregistrer">Enregistrer</button>
                                                        <button class="btn btn-primary waves-effect md-close" type="reset" value="vider">Vider</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--animation modal  Dialogs ends -->
                                        <div class="md-overlay"></div>
                                    </div>
                                    <div class="animation-model">
                                        <!-- animation modal Dialogs start -->
                                        <div class="md-modal md-effect-9" id="modal-info">
                                            <div class="md-content">
                                                <h3>Information Commande</h3>
                                                <div>

                                                    <form action="apiCmdeFournis.php" method="POST">
                                                        <input type="hidden" name="id_sup" id="id_sup" value="" />
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Fournisseur</label>
                                                            <label class="col-sm-9 col-form-label" id="nom_fourni"></label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Date commande</label>
                                                            <label class="col-sm-9 col-form-label" id="date_ajout"></label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Total</label>
                                                            <label class="col-sm-9 col-form-label" id="total"></label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Payee</label>
                                                            <label class="col-sm-9 col-form-label" id="payee"></label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Reste à payer</label>
                                                            <label class="col-sm-9 col-form-label" id="reste"></label>
                                                        </div>
                                                        <button class="btn btn-primary waves-effect" type="submit" value="Supprimer_fournisseur" name="Supprimer_fournisseur">Supprimer</button>
                                                        <button class="btn btn-primary waves-effect md-close" type="reset" value="vider">Fermer</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--animation modal  Dialogs ends -->
                                        <div class="md-overlay"></div>
                                    </div>

                                </div>
                            </div>
                            <!-- Page-body end -->
                        </div>
                    </div>
                    <!-- Main-body end -->

                </div>
            </div>
            <!-- Required Jquery -->
            <?php include_once('footer.php'); ?>
            <script>
                $(document).ready(function() {
                    $('.info').click(function() {
                        dat = {
                            id_info_cmd: $(this).val()
                        }
                        $.get("apiCmdeFournis.php", dat,
                            function(ligne, status) {
                                console.log(ligne);
                                $("#date_ajout").html(ligne.date_ajout);
                                $("#nom_fourni").html(ligne.nom_fourni);
                                $("#payee").html(ligne.payee);
                                $("#reste").html(ligne.reste);
                                $("#total").html(ligne.total);
                                $("#id_sup").val(ligne.id);
                            });
                    });
                });
            </script>