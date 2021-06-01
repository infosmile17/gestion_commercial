<?php
include_once('database.php');

if (isset($_POST['clients'])) {
    $sql22 = "select id,nomprenom FROM `clients`";
    $result22 = $con->query($sql22);
    if ($result22->num_rows > 0) {
        while ($row22 = $result22->fetch_assoc()) {
            echo "<option value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
        }
    }
} elseif (isset($_POST['id_cmd'])) {
    $sql22 = "select id,nomprenom FROM `clients` where id='" . $_POST['id_cmd'] . "'";
    $result22 = $con->query($sql22);
    if ($result22->num_rows > 0) {
        while ($row22 = $result22->fetch_assoc()) {
            echo "<option value='" . $row22['id'] . "'>" . $row22["nomprenom"] . "</option>";
        }
    }
} elseif (isset($_POST['id_clients'])) {
    $sql22 = "select * FROM `cmd_vente` where `total` != `payee` and id_client='" . $_POST['id_clients'] . "'";
    $result22 = $con->query($sql22);
    if ($result22->num_rows > 0) {
        echo "<option value='0'> Selectionner une commande  </option>";
        while ($row22 = $result22->fetch_assoc()) {
            echo "<option value='" . $row22['id'] . "'> Cmde : " . $row22["id"] . " , Reste : " . ($row22["total"] - $row22["payee"])  . "</option>";
        }
    } else {
        echo "<option value=''> Tous les commandes sont réglés </option>";
    }
} elseif (isset($_GET['cmde_details'])) {
    $sql22 = "select total,payee FROM `cmd_vente` where id=" . $_GET['id_cmd'] . "";

    $result22 = $con->query($sql22);
    $data = [
        'total' => '0',
        'reste' =>  '0'
    ];
    if ($result22->num_rows > 0) {
        $row22 = $result22->fetch_assoc();
        $data = [
            'total' => strval($row22['total']),
            'reste' =>  strval($row22['total'] - $row22['payee'])
        ];
    }
    header('Content-type: application/json');
    echo json_encode($data);
}
if (isset($_POST['save_payement'])) {

    $id_cmd = $_POST['id_cmd'];
    $montant = $_POST['montant'];
    $date = $_POST['date'];
    $temps = $_POST['temps'];

    $sql = "INSERT INTO payement_client (id_cmd, montant,date,temps) VALUES ($id_cmd, $montant,'$date','$temps')";
    if ($con->query($sql) === TRUE) {
        $msg = "Une payement à été ajouter avec succès";
        $sqlUpdate = "update `cmd_vente` set payee = payee + '{$montant}' WHERE id='{$id_cmd}'";
        if ($con->query($sqlUpdate) === TRUE) {
            header("location: client_payement.php?msg=" . $msg);
        }
    } else {
        $msg = "la payement n'à pas été ajoutée";
    }
    header("location: client_payement.php?msg=" . $msg);
} elseif (isset($_GET['del']) && isset($_GET['id_cmd'])) {
    if ($_GET['del'] != '' && $_GET['id_cmd'] != '') {
        $id = $_GET['del'];
        $id_cmd = $_GET['id_cmd'];

        $sql22 = "select montant FROM `payement_client` where id=" . $id . "";

        // var_dump($sql22);
        $result22 = $con->query($sql22);

        $row = $result22->fetch_assoc();


        $montant = $row['montant'];
        // var_dump($montant);

        $sql = "UPDATE `cmd_vente` SET  payee = payee - '{$montant}' WHERE `id` = '{$id_cmd}' LIMIT 1";

        // var_dump($sql);
        if ($con->query($sql) === TRUE) {
            $sql_del = "DELETE FROM `payement_client` WHERE `id` ='{$id}' LIMIT 1";
            if ($con->query($sql_del) === TRUE) {
                $msg = "Supression avec succées";
                header("location: client_payement.php?msg=" . $msg);
            }
        }
    }
}
