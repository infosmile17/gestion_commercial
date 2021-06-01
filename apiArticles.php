<?php
include_once('database.php');

if (isset($_POST['enregistrer_modification']) && $_POST['enregistrer_modification'] != '') {

    $id = $_POST['id_mod'];
    $reference = $_POST['reference'];
    $titre = $_POST['titre'];
    $qte_min = $_POST['qte_min'];
    $description = $_POST['description'];

    $sql = "UPDATE `articles` SET `reference`='$reference',`titre`='$titre',`qte_min`='$qte_min',`description`='$description' WHERE `id` = '{$id}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "un article modifié avec succès";

        for ($x = 1; $x <= 5; $x++) {
            $nom = 'model_' . strval($x);
            if (isset($_POST[$nom])) {
                $te = $_POST[$nom];
                $sql12 = "INSERT INTO articles_model (id_article, id_model) VALUES ($id, $te)";
                $con->query($sql12);
            }
        }
        header("location: articles.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
} elseif (isset($_POST['enregistrer']) && $_POST['enregistrer'] != '') {

    $reference = $_POST['reference'];
    $titre = $_POST['titre'];
    $qte_min = $_POST['qte_min'];
    $description = $_POST['description'];

    $sql = "INSERT INTO articles (reference, titre, qte_min, description) VALUES ('$reference', '$titre', '$qte_min', '$description')";

    //'model_1'
    //'model_2'

    if ($con->query($sql) === TRUE) {
        $last_id = $con->insert_id;
        $msg = "Nouveau article créé avec succès";
        for ($x = 1; $x <= 10; $x++) {
            $nom = 'model_' . strval($x);
            if (isset($_POST[$nom])) {
                $te = $_POST[$nom];
                $sql12 = "INSERT INTO articles_model (id_article, id_model) VALUES ($last_id, $te)";
                $con->query($sql12);
            }
        }
        header("location: articles.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
} elseif (isset($_GET['del']) || isset($_POST['id_sup'])) {
    $id = '';
    if ($_GET['del'] != '') {
        $id = $_GET['del'];
    } elseif ($_POST['id_sup'] != '') {
        $id = $_POST['id_sup'];
    }
    if ($id != '') {
        $sql = "DELETE FROM `articles` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $sql_m = "DELETE FROM `articles_model` WHERE `id_article` ='{$id}'";
            if ($con->query($sql_m) === TRUE) {
                $msg = "Suppression d'un article avec succès";
                header("location: articles.php?msg=" . $msg);
            } else {
                $msg = 'Ereur de suppression';
                header("location: articles.php?msg=" . $msg);
            }
        } else {
            $msg = 'Ereur de suppression';
            header("location: articles.php?msg=" . $msg);
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: articles.php?msg=" . $msg);
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
} elseif (isset($_POST['id_model_del']) && isset($_POST['id_article_del'])) {
    $id_model_del = $_POST['id_model_del'];
    $id_article_del = $_POST['id_article_del'];

    $sql_m = "DELETE FROM `articles_model` WHERE `id_article` ='{$id_article_del}' AND `id_model` ='{$id_model_del}'";
    if ($con->query($sql_m) === TRUE) {
        return true;
    } else {
        return false;
    }
}

//id_model_del: id_model_del,
//id_article_del: id_article_del