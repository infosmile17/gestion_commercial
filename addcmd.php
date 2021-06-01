<?php
session_start();
$_SESSION['total_qte'] = 0;
$_SESSION['total_prix'] = 0;
include_once('header.php');
?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('functions.php');
        if (isset($_GET['id_mod'])) {
            $id_mod = ($_GET['id_mod'] != 0) ? $_GET['id_mod'] : 0;
            if ($id_mod != 0) {
                $sql = "SELECT * FROM cmd_achat where id=$id_mod";
                $result = $con->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION['total_prix'] = $row['total'];
                $id_fournisseur  = $row['id_fourni'];
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
                                            <h5>Modifier commande : achat </h5>
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
                                                <form class="form-control" action="apiCmdeFournis.php" method="POST">
                                                    <div class="form-group row">
                                                        <input type="hidden" name="id_mod" value="<?= $id_mod ?>">
                                                        <input type="hidden" name="total_prix" id="total_prix_php" value="<?= $_SESSION['total_prix'] ?>">
                                                        <label class="col-sm-3 col-form-label">Selectionner fournisseur :</label>
                                                        <select name="id_fournis" class="form-control col-sm-3" required>
                                                            <?php

                                                            $sql22 = "select id,nomprenom FROM `fournis`";
                                                            $result22 = $con->query($sql22);
                                                            if ($result22->num_rows > 0) {
                                                                while ($row22 = $result22->fetch_assoc()) {
                                                                    $selected = '';
                                                                    if ($id_fournisseur == $row22['id']) {
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
                                                                    <th>Prix d'achat</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="table_ligne_cmde_update">
                                                                <?php
                                                                $sql_cmd_fournisseur = "select * from cmd_achat_ligne where id_cmd=" . $id_mod;
                                                                $result_cmd_fournisseur = $con->query($sql_cmd_fournisseur);
                                                                if ($result_cmd_fournisseur->num_rows > 0) {
                                                                    while ($row_tem = $result_cmd_fournisseur->fetch_assoc()) {
                                                                        $id_ligne = $row_tem['id'];
                                                                        $article = get_product($row_tem['id_article'], $con);
                                                                        $qte = $row_tem['qte'];
                                                                        $prix_achat = $row_tem['prix_achat'];
                                                                        $total_ligne = (int) $prix_achat * (int) $qte;
                                                                        $model = get_model($row_tem['id_model'], $con);

                                                                        echo "<tr>
                                                                        <td>" . $article . "</td>
                                                                        <td>" . $model . "</td>
                                                                        <td>" . $qte . "</td>
                                                                        <td>" . $prix_achat . "</td>
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
                                                                    <label class="col-sm-3 col-form-label">Prix achat</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control" name="prix_achat" id="prix_achat">
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
                                        <?php
                                        if (isset($_SESSION)) {
                                            //var_dump($_SESSION);
                                        }
                                        ?>
                                        <h5>Une nouvelle commande : achat </h5>
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
                                        <form class="form-control" action="apiCmdeTransp.php" method="POST">
                                            <div class="form-group row">
                                                <input type="hidden" name="id_cmd" value="<?= $id_cmd ?>">
                                                <input type="hidden" name="total_prix" id="total_prix_php" value="<?= $_SESSION['total_prix'] ?>">
                                                <label class="col-sm-2 col-form-label">Fournisseur :</label>
                                                <div class="col-sm-10">
                                                    <select name="id_fournis" class="form-control col-sm-5" required>
                                                        <?php

                                                        $sql22 = "select id,nomprenom FROM `fournis`";
                                                        $result22 = $con->query($sql22);
                                                        if ($result22->num_rows > 0) {
                                                            while ($row22 = $result22->fetch_assoc()) {
                                                                echo "<option class='form-control' value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Date commande :</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="date_cmd" class="col-sm-5 form-control" required />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Transporteur :</label>
                                                <div class="col-sm-10">
                                                    <select name="id_transp" class="form-control col-sm-5" required>
                                                        <?php

                                                        $sql22 = "select id,nomprenom FROM `transp`";
                                                        $result22 = $con->query($sql22);
                                                        if ($result22->num_rows > 0) {
                                                            while ($row22 = $result22->fetch_assoc()) {
                                                                echo "<option class='form-control' value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Frait transport ( DT ):</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="transport" class="col-sm-5 form-control" required />
                                                </div>
                                            </div>
                                            <h3>Listes des produits
                                            </h3>

                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Produit</th>
                                                                <th>Model</th>
                                                                <th>Quantité</th>
                                                                <th>Prix d'achat</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table_ligne_cmde">
                                                        </tbody>


                                                        <tr>
                                                            <th colspan="2">Total</th>
                                                            <th id="total_qte"></th>
                                                            <th></th>
                                                            <th id="total_prix"></th>
                                                            <th></th>
                                                        </tr>
                                                    </table>
                                                    <button type="button" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">+</button>
                                                    <br>
                                                    <br>
                                                    <input type="submit" class="btn btn-success btn-outline-success waves-effect" value="Enregistrer commande" name="save_cmde" />
                                                </div>
                                            </div>
                                        </form>
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
                                                            <label class="col-sm-3 col-form-label">Prix achat</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" name="prix_achat" id="prix_achat">
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
        let total_qtee = 0;
        let total_prix = 0;
        $("#enregistrer_ligne").click(function() {
            dat = {
                enregistrer_ligne: 'enregistrer_ligne',
                id_cmd: $("#id_cmd").val(),
                id_article: $("#id_article").val(),
                qte: $("#qte").val(),
                prix_achat: $("#prix_achat").val(),
                id_model: $("#id_model").val()
            }
            $.get("apiCmdeFournis.php", dat,
                function(ligne, status) {
                    if (ligne.article) {
                        $("#table_ligne_cmde").append("<tr><td>" + ligne.article + "</td><td>" + ligne.model + "</td><td>" + ligne.qte + "</td><td>" + ligne.prix_achat + "</td><td>" + ligne.total_ligne + "</td><td>" + ligne.id_ligne + "</td></tr>");
                        total_qtee += parseInt(ligne.qte);
                        total_prix += parseInt(ligne.total_ligne);
                        //  alert(total_qtee);
                        // alert(total_prix);
                    } else {
                        alert('erreur d ajout');
                    }
                    $('#id_article option[value="0"]').attr("selected", true);
                    $("#qte").val('');
                    $("#prix_achat").val('');
                    $("#id_model").val('');
                    $('#close_btn').trigger("click");
                    $('#total_qte').html(total_qtee);
                    $('#total_prix').html(total_prix);
                });
        });
        $("#id_article").change(function() {
            $.get("apiCmdeFournis.php", {
                    get_model: 'get_model',
                    // id_cmd: $("#id_cmd").val(),
                    id_art: $("#id_article").val(),
                    // qte: $("#qte").val(),
                    // prix_achat: $("#prix_achat").val()
                },
                function(ligne, status) {
                    $("#id_model").html(ligne);
                });
        });
    });
</script>