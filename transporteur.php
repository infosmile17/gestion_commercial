<?php
include_once('header.php');
?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php'); ?>
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
                                    <?php
                                    if (isset($_GET['mod'])) {
                                        if ($_GET['mod'] != '') {
                                            $id = $_GET['mod'];
                                            $sql = "select * FROM `transp` WHERE `id` ='{$id}' LIMIT 1";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                    ?>
                                                <br>
                                                <br>
                                                <div>
                                                    <form action="apiTransp.php" method="POST">
                                                        <input type="hidden" name="id_mod" value="<?php echo $row['id']; ?>" />
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b>Nom et Prénom</b></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="nomprenom" value="<?php echo $row['nomprenom']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Téléphone 1</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="tel1" value="<?php echo $row['tel1']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Téléphone 2</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="tel2" value="<?php echo $row['tel2']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="email" value="<?php echo $row['email']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label text-muted">Adresse</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-round" name="adresse" value="<?php echo $row['adresse']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label text-muted">Remarque</label>
                                                            <div class="col-sm-10">
                                                                <textarea rows="5" cols="5" class="form-control" name="remarques"><?php echo $row['remarques']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary waves-effect md-close" type="submit" value="enregistrer_modification" name="enregistrer_modification">Enregistrer modification</button>
                                                        <button class="btn btn-primary waves-effect md-close" type="reset" value="vider">Vider</button>

                                                    </form>
                                                </div>
                                        <?php
                                            } else {
                                                $msg = 'Erreur de selection du transporteur !';
                                                header("location: fourni.php");
                                            }
                                        }
                                    } else {

                                        ?>

                                        <br>
                                        <h5>Listes des transporteurs</h5>
                                        <!-- button Default -->
                                        <button type="button" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">nouveau</button>
                                        <?php
                                        $pages = "fourni.php";
                                        include_once('searchtext.php');
                                        $sql = "SELECT * FROM transp";

                                        if (isset($_POST['searchtext'])) {
                                            if ($_POST['searchtext'] != '') {
                                                $searchtext = $_POST['searchtext'];
                                                $sql = "SELECT * FROM transp WHERE nomprenom LIKE '%$searchtext%'
    OR tel1 LIKE '%$searchtext%'
    OR tel2 LIKE '%$searchtext%'
    OR email LIKE '%$searchtext%'
    OR adresse LIKE '%$searchtext%'
    OR remarques LIKE '%$searchtext%'
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
                                                            <th>Nom et Prénom</th>
                                                            <th>Téléphone 1</th>
                                                            <th>Téléphone 2</th>
                                                            <th>Email</th>
                                                            <th>Opérations</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="transp_tabs">
                                                        <?php

                                                        $result = $con->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . $row["nomprenom"] . "</td><td>" . $row["tel1"] . "</td><td>" . $row["tel2"] . "</td><td>" . $row["email"] . "</td><td>";
                                                        ?>
                                                                <button value="<?= $row["id"]; ?>" type="button" class="info btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon" data-modal="modal-info">
                                                                    <i class="icofont icofont-eye-alt"></i>
                                                                </button>
                                                                <button value="<?= $row["id"]; ?>" type="button" class="update btn btn-success btn-outline-success waves-effect md-trigger btn-icon" data-modal="modal-12">
                                                                    <i class="icofont icofont-exchange"></i>
                                                                </button>

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
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Basic table card end -->

                            <!-- Page body start -->
                            <div class="page-body button-page">
                                <div class="row">
                                    <!-- Animation modal start / Nifty Modal Window Effects start-->

                                    <div class="card-block">
                                        <div class="animation-model">
                                            <!-- animation modal Dialogs start -->
                                            <div class="md-modal md-effect-9" id="modal-9">
                                                <div class="md-content">
                                                    <h3>Nouveau transporteur</h3>
                                                    <div>
                                                        <form action="apiTransp.php" method="POST">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"><b>Nom et Prénom</b></label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="nomprenom">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Téléphone 1</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="tel1">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Téléphone 2</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="tel2">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="email">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Adresse</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="adresse">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label text-muted">Remarque</label>
                                                                <div class="col-sm-10">
                                                                    <textarea rows="5" cols="5" class="form-control" name="remarques"></textarea>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary waves-effect" type="submit" value="enregistrer" name="enregistrer">Enregistrer</button>
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
                                            <div class="md-modal md-effect-9" id="modal-12">
                                                <div class="md-content">
                                                    <h3>Modifier information transporteur</h3>
                                                    <div>
                                                        <form action="apiTransp.php" method="POST">
                                                            <input type="hidden" name="id_mod" id="id_mod_jq" value="" />
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"><b>Nom et Prénom</b></label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="nomprenom" id="nomprenom_jq" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Téléphone 1</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="tel1" id="tel1_jq" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Téléphone 2</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="tel2" id="tel2_jq" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="email" id="email_jq" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Adresse</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-round" name="adresse" id="adresse_jq" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label text-muted">Remarque</label>
                                                                <div class="col-sm-10">
                                                                    <textarea rows="5" cols="5" class="form-control" id="remarques_jq" name="remarques"></textarea>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary waves-effect" type="submit" value="enregistrer_modification" name="enregistrer_modification">Enregistrer modification</button>
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
                                                    <h3>Information transporteur</h3>
                                                    <div>
                                                        <form action="apiTransp.php" method="POST">
                                                            <input type="hidden" name="id_sup" id="id_sup" value="" />
                                                            <div class="form-group row">
                                                                <label style="font-size: 23px;" class="col-sm-6 col-form-label " id="nomprenom_info"></label>
                                                                <label style="font-size: 23px;" class="col-sm-3 col-form-label" id="tel1_info"></label>
                                                                <label style="font-size: 23px;" class="col-sm-3 col-form-label" id="tel2_info"></label>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Email</label>
                                                                <label class="col-sm-9 col-form-label" id="email_info"></label>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Adresse</label>
                                                                <label class="col-sm-9 col-form-label" id="adresse_info"></label>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label text-muted">Remarque</label>
                                                                <label class="col-sm-9 col-form-label" id="remarques_info"></label>
                                                            </div>
                                                            <button class="btn btn-primary waves-effect" type="submit" value="Supprimer_transporteur" name="Supprimer_transporteur">Supprimer</button>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Required Jquery -->
        <?php include_once('footer.php'); ?>
        <script src='script_transp.js'></script>
        <script>

        </script>