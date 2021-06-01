<?php
session_start();
include_once('database.php');
include_once('client_functions.php');
if (!isset($_SESSION['total_qte'])) {
    $_SESSION['total_qte'] = 0;
}
if (!isset($_SESSION['total_prix'])) {
    $_SESSION['total_prix'] = 0;
}


function update_qte_article_model($id_article, $id_model, $qte, $con)
{
    $sqlUpdate = "update `articles_model` set qte = qte - '{$qte}' WHERE id_article='{$id_article}' && id_model='{$id_model}'";
    $con->query($sqlUpdate);
}
if (isset($_POST['enregistrer_modification']) && $_POST['enregistrer_modification'] != '') {
    $id = $_POST['id_mod'];
    $reference = $_POST['reference'];
    $titre = $_POST['titre'];
    $qte_min = $_POST['qte_min'];
    $id_model = $_POST['id_model'];
    $description = $_POST['description'];

    $sql = "UPDATE `articles` SET `reference`='$reference',`titre`='$titre',`qte_min`='$qte_min',`id_model`='$id_model',`description`='$description' WHERE `id` = '{$id}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "un article modifié avec succès";
        header("location: articles.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
} elseif (isset($_POST['enregistrer']) && $_POST['enregistrer'] != '') {


    //var_dump($_POST);die();

    $id_article = $_POST['id_article'];
    $id_clients = $_POST['id_clients'];
    $qte = $_POST['qte'];
    $prix_vente = $_POST['prix_vente'];
    $sql = "INSERT INTO commande_clients (id_article, id_clients, qte, prix_vente) VALUES ('$id_article', '$id_clients', '$qte', '$prix_vente')";

    if ($con->query($sql) === TRUE) {
        $msg = "Mise à jour du stock";
        $sqlUpdate = "update `articles` set qte = qte - '{$qte}' WHERE id='{$id_article}'";
        var_dump($sqlUpdate);
        die;
        if ($con->query($sqlUpdate) === TRUE) {
            header("location: articles.php?msg=" . $msg);
        }
        $_SESSION['total_qte'] = 0;
        $_SESSION['total_prix'] = 0;


        header("location: client_commandes.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
} elseif (isset($_GET['enregistrer_ligne']) && $_GET['enregistrer_ligne'] != '') {

    $id_cmd = $_GET['id_cmd'];
    $id_article = $_GET['id_article'];
    $qte = $_GET['qte'];
    $prix_vente = $_GET['prix_vente'];
    $id_model = $_GET['id_model'];

    $sql = "INSERT INTO cmd_vente_ligne (id_cmd, id_article, qte, prix_vente,id_model) VALUES ($id_cmd,$id_article, $qte, $prix_vente,$id_model)";


    if ($con->query($sql) === TRUE) {
        $last_id = $con->insert_id;
        $total_ligne = (int) $prix_vente * (int) $qte;
        $temp_qte = (int) $_SESSION['total_qte'] + (int) $qte;
        $temp_prix = (int) $_SESSION['total_prix'] + (int) $total_ligne;;
        $_SESSION['total_qte'] = $temp_qte;
        $_SESSION['total_prix'] = $temp_prix;
        $data = [
            'article' => get_product($id_article, $con),
            'qte' =>  $qte,
            'prix_vente' => $prix_vente,
            'total_ligne' => strval((int) $prix_vente * (int) $qte),
            'id_ligne' => strval($last_id),
            'model' => get_model($id_model, $con),
            'total_qte' => strval($_SESSION['total_qte']),
            'total_prix' => strval($_SESSION['total_prix']),
        ];

        header('Content-type: application/json');
        echo json_encode($data);

        update_qte_article_model($id_article, $id_model, $qte, $con);


        //echo "<tr><td>" . get_product($id_article, $con) . "</td><td>" . $qte . "</td><td>" . $prix_vente . "</td><td>" . ($prix_vente * $qte) . "</td><td>" . $last_id . "</td></tr>";
    } else {
        echo "erreur";
    }
} elseif (isset($_GET['del_cmde']) || isset($_POST['id_sup'])) {
    if ($_GET['del_cmde'] != '' || $_POST['id_sup'] != '') {
        if ($_GET['del_cmde'] != '') {
            $id =  $_GET['del_cmde'];
        } else {
            $id =  $_POST['id_sup'];
        }
        $sql = "DELETE FROM `cmd_vente` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $sql2 = "DELETE FROM `cmd_vente_ligne` WHERE `id_cmd` ='{$id}'";
            if ($con->query($sql2) === TRUE) {
                $msg = "Supression avec succées";
                header("location: client_commandes.php?msg=" . $msg);
            }
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: client_commandes.php?msg=" . $msg);
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
} elseif (isset($_POST['save_cmde']) && $_POST['save_cmde'] != '') {

    $id_cmd = $_POST['id_cmd'];
    $id_clients = $_POST['id_clients'];
    $date_cmd = $_POST['date_cmd'];
    $total_prix_php = $_SESSION['total_prix'];

    $sql = "UPDATE `cmd_vente` SET `id_client`='$id_clients',`date_ajout`='$date_cmd',`total`='$total_prix_php' WHERE `id` = '{$id_cmd}' LIMIT 1";

    // var_dump($sql);
    // die();
    if ($con->query($sql) === TRUE) {
        $msg = "Commande ajoutée avec succès";
        if (!isset($_SESSION['total_prix']) || $total_prix_php == 0) {
            $sql = "DELETE FROM cmd_vente WHERE id=" . $id_cmd . "";
            $con->query($sql);
            $msg = "Commande non ajoutée";
            header("location:client_commandes.php?msg=" . $msg);
        }
        header("location:client_commandes.php?msg=" . $msg);
    } else {
        $sql = "DELETE FROM cmd_vente WHERE id='" . $id_cmd . "'";
        if ($conn->query($sql) === TRUE) {
            $msg = "Commande non ajoutée";
            header("location:client_commandes.php?msg=" . $msg);
        }
    }
} elseif (isset($_GET['get_model']) && $_GET['get_model'] != '') {

    $id_article = $_GET['id_art'];
    $sql27 = "select m.id,m.nom, am.id_model, am.prix_achat ,am.qte FROM model m , articles_model am where m.id = am.id_model and id_article=$id_article and am.qte > 0";
    $result27 = $con->query($sql27);
    $data = "";
    var_dump($sql27);
    if ($result27->num_rows > 0) {
        while ($row27 = $result27->fetch_assoc()) {
            $data .= "<option value='" . $row27['id'] . "'>" . $row27["nom"] . " : achat : " . $row27['prix_achat'] . " - qte : " . $row27['qte'] . "</option>";
        }
        echo $data;
    } else {
        echo "erreur";
    }
} elseif (isset($_GET['id_info_cmd']) && $_GET['id_info_cmd'] != '') {
    $sql = "SELECT * FROM cmd_vente where id=" . $_GET['id_info_cmd'];
    $result = $con->query($sql);

    $row = $result->fetch_assoc();

    $data = [
        'id' => $row['id'],
        'nom_client' =>  getNomclient($row["id_client"], $con),
        'date_ajout' =>   $row["date_ajout"],
        'total' =>  $row["total"],
        'payee' =>  $row["payee"],
        'reste' => strval(($row["total"] - $row["payee"]))
    ];

    header('Content-type: application/json');
    echo json_encode($data);
}
