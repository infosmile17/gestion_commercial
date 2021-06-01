<?php include_once('header.php'); ?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('client_functions.php'); ?>
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
                                    <h5>Listes des payements (archives): clients</h5>
                                    <!-- button Default -->
                                    <button type="button" id="btn-nouveau" class="btn btn-success btn-outline-success waves-effect md-trigger" data-modal="modal-9">nouveau</button>

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
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Commande</th>
                                                        <th>clients</th>
                                                        <th>Total cmde</th>
                                                        <th>Montant payée</th>
                                                        <th>Date</th>
                                                        <th>Opérations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM payement_client where id_cmd IN (SELECT id FROM cmd_vente where `total` = `payee`) ORDER BY id_cmd DESC";
                                                    $result = $con->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $getinfo = getinfocmd($row["id_cmd"], $con);
                                                            echo "<tr><td scope='row'>" . $row["id"] . "</td><td>" . $row["id_cmd"] . "</td><td>" . getNomclient($getinfo[0], $con) . "</td><td>" . $getinfo[1] . "</td><td>" . $row["montant"] . "</td><td>" . $row["date"] . " : " . $row["temps"] . "</td><td>";
                                                    ?>
                                                            <a href='client_apipayement.php?id_cmd=<?= $row["id_cmd"]; ?>&del=<?= $row["id"]; ?>' class="info btn btn-danger btn-outline-danger waves-effect md-trigger btn-icon" data-modal="modal-info">
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
                                <!-- Basic table card end -->
                                <div class="pcoded-inner-content">
                                    <div class="main-body">
                                        <div class="page-wrapper">
                                            <!-- Page body start -->
                                            <div class="page-body button-page">
                                                <div class="row">
                                                    <!-- Animation modal start / Nifty Modal Window Effects start-->
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-block">
                                                                <div class="animation-model">
                                                                    <!-- animation modal Dialogs start -->
                                                                    <div class="md-modal md-effect-9" id="modal-9">
                                                                        <div class="md-content">
                                                                            <h3>Payement client</h3>
                                                                            <div>
                                                                                <form action="client_apipayement.php" method="POST">
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label">clients</label>
                                                                                        <div class="col-sm-9">
                                                                                            <select name="id_clients" id="id_clients" class="form-control">
                                                                                                <option value="">Selectionner un client</option>
                                                                                                <?php
                                                                                                $sql22 = "select id,nomprenom FROM `clients`";
                                                                                                $result22 = $con->query($sql22);
                                                                                                if ($result22->num_rows > 0) {
                                                                                                    while ($row22 = $result22->fetch_assoc()) {
                                                                                                        echo "<option value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label">Commande</label>
                                                                                        <div class="col-sm-9">
                                                                                            <select name="id_cmd" id="id_cmd" class="form-control">
                                                                                                <option value="">Selectionner une commande</option>
                                                                                                <?php
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label"><b>Montant à payer</b></label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="number" class="form-control" name="montant" id="montant">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label">Montant restant</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="number" class="form-control" id="montant_reste" readonly name="reste">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label">Date</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="date" class="form-control" id="date" name="date">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-3 col-form-label">Temps</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="time" class="form-control" id="temps" name="temps">
                                                                                        </div>
                                                                                    </div>
                                                                                    <button class="btn btn-primary waves-effect" type="submit" value="save_payement" name="save_payement">Enregistrer</button>
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
                                                    </div>
                                                </div>
                                                <!-- Page-body end -->
                                            </div>
                                        </div>
                                        <!-- Main-body end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Required Jquery -->
            <?php include_once('footer.php'); ?>
            <script>
                $(document).ready(function() {
                    montant_reste_global = 0;
                    $('#id_clients').change(function() {
                        $.ajax({
                            url: "client_apipayement.php",
                            method: "POST",
                            data: {
                                'cmds': 'cmds',
                                'id_clients': $('#id_clients').val()
                            },
                            dataType: "HTML",
                            success: function(data) {
                                $('#id_cmd').html(data);
                            }
                        })
                        $('#id_cmd').change(function() {
                            $.ajax({
                                url: "client_apipayement.php",
                                method: "GET",
                                data: {
                                    'cmde_details': 'cmde_details',
                                    'id_cmd': $('#id_cmd').val()
                                },
                                dataType: "json",
                                success: function(data) {
                                    $('#montant').val(0);
                                    $('#montant_reste').val(data.reste);
                                    montant_reste_global = data.reste;
                                }
                            })
                        });
                        $('#montant').keyup(function() {
                            temp = montant_reste_global - $('#montant').val();
                            $('#montant_reste').val(temp);
                            if (temp < 0) {
                                $('#montant_reste').val(0);
                                $('#montant').val(montant_reste_global);
                            }
                        })
                    });
                });
            </script>