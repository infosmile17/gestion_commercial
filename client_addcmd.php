<?php
session_start();
$_SESSION['total_qte'] = 0;
$_SESSION['total_prix'] = 0;
include_once('header.php');
?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('client_functions.php');
        if (isset($_GET['id_mod'])) {
            $id_mod = ($_GET['id_mod'] != 0) ? $_GET['id_mod'] : 0;
            if ($id_mod != 0) {
                $sql = "SELECT * FROM cmd_vente where id=$id_mod";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION['total_prix'] = $row['total'];
                $id_client  = $row['id_client'];
                $date_cmd  = $row['date_ajout'];
        ?>

                ?><div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- Main-body start -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <!-- Basic table card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Modifier commande : vente </h5>
                                            <div class="card-block">
                                                <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <form class="form-control" action="client_apiCmde.php" method="POST">
                                                    <div class="form-group row">
                                                        <input type="hidden" name="id_mod" value="<?= $id_mod ?>">
                                                        <input type="hidden" name="total_prix" id="total_prix_php" value="<?= $_SESSION['total_prix'] ?>">
                                                        <label class="col-sm-3 col-form-label">Selectionner client :</label>
                                                        <select name="id_clients" class="form-control col-sm-3" required>
                                                            <?php

                                                            $sql22 = "select id,nomprenom FROM `clients`";
                                                            $result22 = $con->query($sql22);
                                                            if ($result22->num_rows > 0) {
                                                                while ($row22 = $result22->fetch_assoc()) {
                                                                    $selected = '';
                                                                    if ($id_client == $row22['id']) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    echo "<option class='form-control' value='" . $row22['id'] . "' " . $selected . ">" . $row22["nomprenom"] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <!-- button Default -->
                                                        <label class="col-sm-3 col-form-label">Date commande :</label>
                                                        <input type="date" name="date_cmd" class="col-sm-3 form-control" value="<?= $date_cmd; ?>" required />
                                                    </div>
                                                    <h3>Listes des produits
                                                        <button type="button" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">+</button>
                                                        <button type="submit" class="btn btn-success btn-outline-success waves-effect" value="Enregistrer commande" name="save_cmde">Enregistrer commande </button>

                                                    </h3>
                                                </form>
                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Model</th>
                                                                    <th>Quantité</th>
                                                                    <th>Prix de vente</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="table_ligne_cmde_update">
                                                                <?php
                                                                $sql_cmd_client = "select * from cmd_vente_ligne where id_cmd=" . $id_mod;
                                                                $result_cmd_client = $con->query($sql_cmd_client);
                                                                if ($result_cmd_client->num_rows > 0) {
                                                                    while ($row_tem = $result_cmd_client->fetch_assoc()) {
                                                                        $id_ligne = $row_tem['id'];
                                                                        $article = get_product($row_tem['id_article'], $con);
                                                                        $qte = $row_tem['qte'];
                                                                        $prix_vente = $row_tem['prix_vente'];
                                                                        $total_ligne = (int) $prix_vente * (int) $qte;
                                                                        $model = get_model($row_tem['id_model'], $con);

                                                                        echo "<tr>
                                                                        <td>" . $article . "</td>
                                                                        <td>" . $model . "</td>
                                                                        <td>" . $qte . "</td>
                                                                        <td>" . $prix_vente . "</td>
                                                                        <td>" . $total_ligne . "</td>
                                                                        <td>" . $id_ligne . "</td>
                                                                    </tr>";
                                                                    }
                                                                }
                                                                ?>

                                                            </tbody>
                                                            <tbody id="table_ligne_cmde">

                                                            </tbody>
                                                            <tr>
                                                                <th>Total</th>
                                                                <th id="total_qte"></th>
                                                                <th></th>
                                                                <th id="total_prix"></th>
                                                                <th></th>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="animation-model">
                                        <div class="md-modal md-effect-9" id="modal-9">
                                            <div class="md-content">
                                                <h3>Nouvelle ligne commande</h3>
                                                <div>
                                                    <div>
                                                        <div id="ligne_cmde">
                                                            <input type="hidden" name="id_cmd" id="id_cmd" value="<?= $id_cmd; ?>" />
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Articles</label>
                                                                <div class="col-sm-9">
                                                                    <select name="id_article" id="id_article" class="form-control">
                                                                        <option value="0">Selectionner un article</option>
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
                                                                <label class="col-sm-3 col-form-label">Model 2</label>
                                                                <div class="col-sm-9">
                                                                    <select name="id_model" id="id_model" class="form-control"></select>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label"><b>Quantité</b></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control" name="qte" id="qte">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Prix vente</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control" name="prix_vente" id="prix_vente">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button class="btn btn-primary waves-effect" value="enregistrer_ligne" name="enregistrer_ligne" id="enregistrer_ligne">Enregistrer</button>
                                                                <button class="btn btn-primary waves-effect md-close" id="close_btn" value="vider">Vider</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--animation modal  Dialogs ends -->
                                <div class="md-overlay"></div>
                            </div>
                        </div>
                    </div>
                </div><?php
                    }
                } else {
                    $id_cmd = get_insert_cmd($con);
                        ?>
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
                                        <h5>Une nouvelle commande : vente </h5>
                                        <div class="card-block">
                                            <div class="card-header-right">
                                                <ul class="list-unstyled card-option">
                                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                                    <li><i class="fa fa-trash close-card"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <form class="form-control" action="client_apiCmde.php" method="POST">
                                                <div class="form-group row">
                                                    <input type="hidden" name="id_cmd" value="<?= $id_cmd ?>">
                                                    <input type="hidden" name="total_prix" id="total_prix_php" value="<?= $_SESSION['total_prix'] ?>">
                                                    <label class="col-sm-3 col-form-label">Selectionner client :</label>
                                                    <select name="id_clients" class="form-control col-sm-3" required>
                                                        <?php

                                                        $sql22 = "select id,nomprenom FROM `clients`";
                                                        $result22 = $con->query($sql22);
                                                        if ($result22->num_rows > 0) {
                                                            while ($row22 = $result22->fetch_assoc()) {
                                                                echo "<option class='form-control' value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                    <!-- button Default -->
                                                    <label class="col-sm-3 col-form-label">Date commande :</label>
                                                    <input type="date" name="date_cmd" class="col-sm-3 form-control" required />
                                                </div>
                                                <h3>Listes des produits
                                                    <button type="button" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">+</button>
                                                    <button type="submit" class="btn btn-success btn-outline-success waves-effect" value="Enregistrer commande" name="save_cmde">Enregistrer commande </button>

                                                </h3>
                                            </form>
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Produit</th>
                                                                <th>Model</th>
                                                                <th>Quantité</th>
                                                                <th>Prix d'vente</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table_ligne_cmde">

                                                        </tbody>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th id="total_qte"></th>
                                                            <th></th>
                                                            <th id="total_prix"></th>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="animation-model">
                                    <div class="md-modal md-effect-9" id="modal-9">
                                        <div class="md-content">
                                            <h3>Nouvelle ligne commande</h3>
                                            <div>
                                                <div>
                                                    <div id="ligne_cmde">
                                                        <input type="hidden" name="id_cmd" id="id_cmd" value="<?= $id_cmd; ?>" />
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Articles</label>
                                                            <div class="col-sm-9">
                                                                <select name="id_article" id="id_article" class="form-control">
                                                                    <option value="0">Selectionner un article</option>
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
                                                            <label class="col-sm-3 col-form-label">Model</label>
                                                            <div class="col-sm-9">
                                                                <select name="id_model" id="id_model" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"><b>Quantité</b></label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control" name="qte" id="qte">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Prix vente</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control" name="prix_vente" id="prix_vente">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-primary waves-effect" value="enregistrer_ligne" name="enregistrer_ligne" id="enregistrer_ligne">Enregistrer</button>
                                                            <button class="btn btn-primary waves-effect md-close" id="close_btn" value="vider">Vider</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--animation modal  Dialogs ends -->
                            <div class="md-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>



    </div>
</div>
</div>
<!-- Required Jquery -->
<?php include_once('footer.php'); ?>
<script>
    $(document).ready(function() {
        $("#enregistrer_ligne").click(function() {
            dat = {
                enregistrer_ligne: 'enregistrer_ligne',
                id_cmd: $("#id_cmd").val(),
                id_article: $("#id_article").val(),
                qte: $("#qte").val(),
                prix_vente: $("#prix_vente").val(),
                id_model: $("#id_model").val()
            }
            $.get("client_apiCmde.php", dat,
                function(ligne, status) {
                    if (ligne.article) {
                        $("#table_ligne_cmde").append("<tr><td>" + ligne.article + "</td><td>" + ligne.model + "</td><td>" + ligne.qte + "</td><td>" + ligne.prix_vente + "</td><td>" + ligne.total_ligne + "</td><td>" + ligne.id_ligne + "</td></tr>");
                    } else {
                        alert('erreur d ajout');
                    }
                    $('#id_article option[value="0"]').attr("selected", true);
                    $("#qte").val('');
                    $("#prix_vente").val('');
                    $("#id_model").val('');
                    $('#close_btn').trigger("click");
                });
        });
        $("#id_article").change(function() {
            $.get("client_apiCmde.php", {
                    get_model: 'get_model',
                    id_art: $("#id_article").val(),
                },
                function(ligne, status) {
                    $("#id_model").html(ligne);
                });

        });
    });
</script>