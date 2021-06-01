<?php
include_once('database.php');


if (isset($_POST['enregistrer_modification']) && $_POST['enregistrer_modification'] != '') {
    $nomprenom = $_POST['nomprenom'];
    $id = $_POST['id_mod'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $remarques = $_POST['remarques'];
    $sql = "UPDATE `clients` SET `nomprenom`='$nomprenom',`tel1`='$tel1',`tel2`='$tel2',`email`='$email',`adresse`='$adresse',`remarques`='$remarques' WHERE `id` = '{$id}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "Modification avec succée du client";
        header("location: clients.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
}
if (isset($_POST['enregistrer']) && $_POST['enregistrer'] != '') {

    $nomprenom = $_POST['nomprenom'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $remarques = $_POST['remarques'];


    $sql = "INSERT INTO clients (nomprenom, tel1, tel2, email, adresse, remarques) VALUES ('$nomprenom', '$tel1', '$tel2', '$email', '$adresse', '$remarques')";
    if ($con->query($sql) === TRUE) {
        $msg = "Nouveau client créé avec succès";
        header("location: clients.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
} elseif (isset($_POST['id_sup'])) {
    if ($_POST['id_sup'] != '') {
        $id = $_POST['id_sup'];
        $sql = "DELETE FROM `clients` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $msg = "Suppression d'un client avec succès";
            header("location: clients.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: clients.php?msg=" . $msg);
    }
} elseif (isset($_GET['mod'])) {
    if ($_GET['mod'] != '') {
        $id = $_GET['mod'];
        $sql = "select * FROM `clients` WHERE `id` ='{$id}' LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc() .
                header("location: clients.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: clients.php?msg=" . $msg);
    }
} elseif (isset($_GET['id_mod_jq'])) {
    if ($_GET['id_mod_jq'] != '') {
        $id = $_GET['id_mod_jq'];
        $sql = "select * FROM `clients` WHERE `id` ='{$id}' LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = [
                'id' => $row['id'],
                'nomprenom' =>  $row['nomprenom'],
                'tel1' =>  $row['tel1'],
                'tel2' =>  $row['tel2'],
                'email' =>  $row['email'],
                'adresse' =>  $row['adresse'],
                'remarques' =>  $row['remarques']
            ];

            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $msg = 'Ereur de selection';
            header("location: clients.php?msg=" . $msg);
        }
    } else {
        $msg = 'Ereur de selection';
        header("location: clients.php?msg=" . $msg);
    }
}
