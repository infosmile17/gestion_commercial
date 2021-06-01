<?php
include_once('header.php');
?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('functions.php'); ?>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
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
                            <?php

                            if (isset($_GET['mod'])) {
                                if ($_GET['mod'] != '') {
                                    $id = $_GET['mod'];
                                    $sql = "select * FROM `articles` WHERE `id` ='{$id}' LIMIT 1";
                                    $result = $con->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                            ?>
                                        <br>
                                        <br>
                                        <div>
                                            <h2 class="center">Modifier un article</h2>
                                            <form action="apiArticles.php" method="POST" alt="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="id_mod" value="<?php echo $row['id']; ?>" />
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"><b>Reference</b></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="reference" value="<?php echo $row['reference']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Titre</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="titre" value="<?php echo $row['titre']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Quantité minimal</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="qte_min" value="<?php echo $row['qte_min']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Listes des models</label>
                                                    <div class="col-sm-9">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <tbody id="models">
                                                                    <?php
                                                                    $sql_am = "SELECT * FROM articles_model as am,model as m  WHERE am.id_model = m.id and `id_article` = " . $id;
                                                                    $result_am = $con->query($sql_am);
                                                                    $compteur = 0;
                                                                    if ($result_am->num_rows > 0) {
                                                                        while ($row22 = $result_am->fetch_assoc()) {
                                                                            //   $models[$compteur] = ['id' => $row22['id'], 'nom' => $row22['nom'], 'qte' => $row22['qte']];
                                                                            echo "<tr alt='" . $row22['id'] . "'><th colspan='9'>" . $row22['nom'] . "</th><th colspan='2'>" . $row22['qte'] . "</th><th>";
                                                                            echo "<span style='display: initial;' class='delete_model btn btn-primary waves-effect' value='sam'>X</span>";
                                                                            echo "</th></tr>";
                                                                            $compteur++;
                                                                        }
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                                <script>

                                                                </script>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Model</label>
                                                    <div class="col-sm-9">
                                                        <select name="id_model_update" id="id_model_update" class="form-control">
                                                            <option value="0">Selectionner un model</option>
                                                            <?php
                                                            if ($compteur != 0) {
                                                                $sql22 = "select * FROM `model` where id != (select id_model FROM articles_model WHERE id_article=" . $id . ")";
                                                            } else {
                                                                $sql22 = "select * FROM `model`";
                                                            }
                                                            $result22 = $con->query($sql22);
                                                            if ($result22->num_rows > 0) {
                                                                while ($row22 = $result22->fetch_assoc()) {
                                                                    echo "<option value='" . $row22['id'] . "'>" . $row22["nom"] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label text-muted">Description</label>
                                                    <div class="col-sm-10">
                                                        <textarea rows="5" cols="5" class="form-control" name="description"><?php echo $row['description']; ?></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary waves-effect" type="submit" value="enregistrer_modification" name="enregistrer_modification">Enregistrer modification</button>
                                                <button class="btn btn-primary waves-effect md-close" type="reset" value="vider">Vider</button>

                                            </form>
                                        </div>
                                    <?php
                                    } else {
                                        header("location: 404.php");
                                    }
                                }
                            } elseif (isset($_GET['info'])) {
                                if ($_GET['info'] != '') {
                                    $id = trim($_GET['info']);
                                    $sql = "select * FROM `articles` WHERE `id` =" . $id . " LIMIT 1";
                                    $result = $con->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();

                                        $sql_am = "SELECT * FROM articles_model as am,model as m  WHERE am.id_model = m.id and `id_article` = " . $id;
                                        $result_am = $con->query($sql_am);

                                    ?>
                                        <div class="md-content">
                                            <h3>Information articles</h3>
                                            <form action="apiArticles.php" method="POST">
                                                <input type="hidden" name="id_sup" id="id_sup" value="<?php echo $row['id']; ?>" />
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"><b>Reference</b></label>
                                                    <label class="col-sm-9 col-form-label" id="reference"><?php echo $row['reference']; ?></label>

                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Titre</label>
                                                    <label class="col-sm-9 col-form-label" id="titre"><?php echo $row['titre']; ?></label>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Quantité minimal</label>
                                                    <label class="col-sm-9 col-form-label" id="qte_min"><?php echo $row['qte_min']; ?></label>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Listes des models</label>
                                                    <div class="col-sm-9">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <tbody id="models">
                                                                    <?php
                                                                    if ($result_am->num_rows > 0) {
                                                                        while ($row22 = $result_am->fetch_assoc()) {
                                                                            echo "<tr><th>" . $row22['nom'] . "</th><th>" . $row22['qte'] . "</th></tr>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Description</label>
                                                    <label class="col-sm-9 col-form-label" id="description"><?php echo $row['description']; ?></label>
                                                </div>

                                                <button class="btn btn-primary waves-effect" value="modifier" name="modifier">
                                                    <a style="color:white" href="articles.php?mod=<?= $row["id"]; ?>">
                                                        Modifier </a></button>

                                                <button class="btn btn-primary waves-effect" type="submit" value="Supprimer" name="supprimer">Supprimer</button>
                                                <button class="btn btn-primary waves-effect md-close" type="reset" value="vider">Fermer</button>
                                            </form>

                                            <br>
                                            <br>
                                            <div>

                                            </div>
                                    <?php
                                    } else {
                                        header("location: 404.php");
                                    }
                                }
                            } else {

                                    ?>
                                    <br>
                                    <h5>Listes des articles</h5>
                                    <!-- button Default -->
                                    <button type="button" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">nouveau</button>
                                    <?php
                                    $pages = "articles.php";
                                    include_once('searchtext.php');
                                    $sql = "SELECT * FROM articles";


                                    if (isset($_POST['searchtext'])) {
                                        if ($_POST['searchtext'] != '') {
                                            $searchtext = $_POST['searchtext'];
                                            $sql = "SELECT * FROM articles WHERE reference LIKE '%$searchtext%'
OR titre LIKE '%$searchtext%'
OR description LIKE '%$searchtext%'
";
                                            echo "<h6 style='text-align:center'>Filtrer par : <label class='badge badge-info'>" . $_POST['searchtext'] . "</label></h6>";
                                        }
                                    }

                                    ?>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Reference</th>
                                                        <th>Titre</th>
                                                        <th>Model : qte</th>
                                                        <th>Description</th>
                                                        <th>Opérations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php


                                                    $result = $con->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {

                                                            $items = getArticleModelQte($row["id"], $con);

                                                            echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . $row["reference"] . "</td><td>" . $row["titre"] . "</td><td>";
                                                            if ($items) {
                                                                while ($row2 = $items->fetch_assoc()) {
                                                                    echo getNameModel($row2["id_model"], $con) . " : ";
                                                                    echo $row2["qte"] . '</br>';
                                                                }
                                                            }
                                                            echo "</td><td>" . $row["description"] . "</td><td>";
                                                    ?>
                                                            <a href="articles.php?info=<?= $row["id"]; ?>" class="info btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon">
                                                                <i class="icofont icofont-eye-alt"></i>
                                                                </button>
                                                                <a href="articles.php?mod=<?= $row["id"]; ?>" class="btn btn-success btn-outline-success waves-effect md-trigger btn-icon">
                                                                    <i class="icofont icofont-exchange"></i>
                                                                </a>
                                                        <?php
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
                        <!-- Page body start -->
                        <div class="page-body button-page">
                            <div class="row">
                                <!-- Animation modal start / Nifty Modal Window Effects start-->

                                <div class="animation-model">
                                    <!-- animation modal Dialogs start -->
                                    <div class="md-modal md-effect-9" id="modal-9">
                                        <div class="md-content">
                                            <h3>Nouveau article</h3>
                                            <div>
                                                <form action="apiArticles.php" method="POST">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label"><b>Reference</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="reference">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Titre</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="titre">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Quantité minimal</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control" name="qte_min">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Listes des models</label>
                                                        <div class="col-sm-9" id="model_selected">
                                                        </div>
                                                        <div id="model_input_hidden">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Model</label>
                                                        <div class="col-sm-9">
                                                            <select name="id_model" id="id_model" class="form-control">
                                                                <option value="0">Selectionner un modele</option>
                                                                <?php
                                                                $sql22 = "select id,nom FROM `model`";
                                                                $result22 = $con->query($sql22);
                                                                if ($result22->num_rows > 0) {
                                                                    while ($row22 = $result22->fetch_assoc()) {
                                                                        echo "<option value='" . $row22['id'] . "'>" . $row22["nom"] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label text-muted">Description</label>
                                                        <div class="col-sm-10">
                                                            <textarea rows="5" cols="5" class="form-control" name="description"></textarea>
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

                            </div>

                        </div>
                        <!-- Page-body end -->
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Required Jquery -->
<?php include_once('footer.php'); ?>
<script>
    $(document).ready(function() {
        compteur = 0;
        $('.delete_model').click(function() {
            let this_model = $(this).parents('tr');
            let id_model_del = $(this).parents('tr').attr('alt');
            let id_article_del = $(this).parents('form').attr('alt');
            $.post("apiArticles.php", {
                    id_model_del: id_model_del,
                    id_article_del: id_article_del
                },
                function(ligne, status) {
                    this_model.remove();
                });
        });
        $("#id_model").change(() => {
            compteur++;
            if ($("#id_model").val() != 0) {
                $("#model_selected").append('<input type="hidden" class="form-control" value="' + $("#id_model").val() + '" readonly name="model_' + compteur + '"/><input class="form-control" value="' + $("#id_model  option:selected").html() + '" readonly/>');
            }
        });
        $("#id_model_update").change(() => {
            compteur++;
            if ($("#id_model_update").val() != 0) {
                $("#models").append('<input type="hidden" class="form-control" value="' + $("#id_model_update").val() + '" readonly name="model_' + compteur + '"/><input class="form-control" value="' + $("#id_model_update  option:selected").html() + '" readonly/>');
            }
        });
        $("#add_model").click(function() {
            id_model: $("#id_model").get();
            //alert($("#id_model").select());
            $.post("apiArticles.php", {
                    add_model: 'add_model',
                    id_model: $("#id_model").val(),
                    id_article: $("#id_article").val(),
                    qte: $("#qte").val(),
                    prix_achat: $("#prix_achat").val()
                },
                function(ligne, status) {
                    if (ligne.article) {
                        $("#table_ligne_cmde").append("<tr><td>" + ligne.article + "</td><td>" + ligne.qte + "</td><td>" + ligne.prix_achat + "</td><td>" + ligne.total_ligne + "</td><td>" + ligne.id_ligne + "</td></tr>");
                    } else {
                        alert('erreur d ajout');
                    }
                });
        });
        $('.update').click(function() {
            dat = {
                id_info_jq: $(this).val()
            }
            compteur = 0;
            $.get("apiArticles.php", dat,
                function(ligne, status) {
                    $("#id_sup_update").val(ligne.id);
                    $("#reference_up").val(ligne.reference);
                    $("#titre_up").val(ligne.titre);
                    $("#description_up").html(ligne.description);
                    $("#qte_min_up").val(ligne.qte_min);
                    $("#model_selected_up").html("");
                    ligne.models.forEach(model => {
                        compteur++;
                        var htmlbutton = "<button value='" + model.id + "' type='button' style='height: 35px;' class='moin_model btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon'>-</button>";
                        $("#model_selected_up").append('<input type="hidden" class="form-control" value="' + model.id + '" readonly name="model_' + compteur + '"/><input style="float:left;width:92%;" class="form-control" value="' + model.nom + '" readonly/>' + htmlbutton);
                    });
                });
        });

        $('.info').click(function() {
            dat = {
                id_info_jq: $(this).val()
            }
            $.get("apiArticles.php", dat,
                function(ligne, status) {
                    console.log(ligne);
                    $("#info_article").html(ligne);
                });
        });
    });
</script>