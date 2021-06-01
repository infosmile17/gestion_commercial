<?php
include_once('database.php');


if (isset($_POST['enregistrer_modification']) && $_POST['enregistrer_modification'] != '') {
    $id = $_POST['id_mod'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $sql = "UPDATE `model` SET `nom`='$nom',`description`='$description' WHERE `id` = '{$id}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "Model modifié avec succès";
        header("location: models.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
}
if (isset($_POST['enregistrer']) && $_POST['enregistrer'] != '') {

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $sql = "INSERT INTO model (nom, description) VALUES ('$nom','$description')";
    if ($con->query($sql) === TRUE) {
        $msg = "Nouveau model créé avec succès";
        header("location: models.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
} elseif (isset($_GET['del'])) {
    if ($_GET['del'] != '') {
        $id = $_GET['del'];
        $sql = "DELETE FROM `model` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $msg = "Suppression d'un model avec succès";
            $sql_m = "DELETE FROM `articles_model` WHERE `id_model` ='{$id}'";
            if ($con->query($sql_m) === TRUE) {
                header("location: models.php?msg=" . $msg);
            }
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: models.php?msg=" . $msg);
    }
} elseif (isset($_GET['mod'])) {
    if ($_GET['mod'] != '') {
        $id = $_GET['mod'];
        $sql = "select * FROM `articles` WHERE `id` ='{$id}' LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc() .
                header("location: articles.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: articles.php?msg=" . $msg);
    }
}
