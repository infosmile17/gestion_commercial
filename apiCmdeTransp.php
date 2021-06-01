<?php
session_start();
include_once('database.php');
include_once('functions.php');
if (!isset($_SESSION['total_qte'])) {
    $_SESSION['total_qte'] = 0;
}
if (!isset($_SESSION['total_prix'])) {
    $_SESSION['total_prix'] = 0;
}
function update_qte_article_model($id_article, $id_model, $qte, $con)
{
    $sqlUpdate = "update `articles_model` set qte = qte + '{$qte}' WHERE id_article='{$id_article}' && id_model='{$id_model}'";
    $con->query($sqlUpdate);
}
function update_prix_achat_article_model($amid, $prix, $con)
{
    $sqlu = "update `articles_model` set prix_achat = '{$prix}' WHERE id='{$amid}'";
    $con->query($sqlu);
}
function update_prix_ligne_cmde($id, $new_prix, $con)
{
    $sqlu = "update `cmd_achat_ligne` set prix_achat = '{$new_prix}' WHERE id='{$id}'";
    var_dump($sqlu);
    $con->query($sqlu);
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
    $id_fournis = $_POST['id_fournis'];
    $qte = $_POST['qte'];
    $prix_achat = $_POST['prix_achat'];
    $sql = "INSERT INTO commande_fournis (id_article, id_fournis, qte, prix_achat) VALUES ('$id_article', '$id_fournis', '$qte', '$prix_achat')";

    if ($con->query($sql) === TRUE) {
        $msg = "Mise à jour du stock";
        $sqlUpdate = "update `articles` set qte = qte + '{$qte}' WHERE id='{$id_article}'";
        if ($con->query($sqlUpdate) === TRUE) {
            header("location: articles.php?msg=" . $msg);
        }
        $_SESSION['total_qte'] = 0;
        $_SESSION['total_prix'] = 0;


        header("location: commandes.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
} elseif (isset($_GET['enregistrer_ligne']) && $_GET['enregistrer_ligne'] != '') {
    $id_cmd = $_GET['id_cmd'];
    $id_article = $_GET['id_article'];
    $qte = $_GET['qte'];
    $prix_achat = $_GET['prix_achat'];
    $id_model = $_GET['id_model'];
    $sql = "INSERT INTO cmd_achat_ligne (id_cmd, id_article, qte, prix_achat,id_model) VALUES ($id_cmd,$id_article, $qte, $prix_achat,$id_model)";
    if ($con->query($sql) === TRUE) {
        $last_id = $con->insert_id;
        $total_ligne = (int) $prix_achat * (int) $qte;
        $temp_qte = (int) $_SESSION['total_qte'] + (int) $qte;
        $temp_prix = (int) $_SESSION['total_prix'] + (int) $total_ligne;;
        $_SESSION['total_qte'] = $temp_qte;
        $_SESSION['total_prix'] = $temp_prix;
        $data = [
            'article' => get_product($id_article, $con),
            'qte' =>  $qte,
            'prix_achat' => $prix_achat,
            'total_ligne' => strval((int) $prix_achat * (int) $qte),
            'id_ligne' => strval($last_id),
            'model' => get_model($id_model, $con),
            'total_qte' => strval($_SESSION['total_qte']),
            'total_prix' => strval($_SESSION['total_prix']),
        ];
        header('Content-type: application/json');
        echo json_encode($data);
        update_qte_article_model($id_article, $id_model, $qte, $con);
        //echo "<tr><td>" . get_product($id_article, $con) . "</td><td>" . $qte . "</td><td>" . $prix_achat . "</td><td>" . ($prix_achat * $qte) . "</td><td>" . $last_id . "</td></tr>";
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
        $sql = "DELETE FROM `cmd_achat` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $sql2 = "DELETE FROM `cmd_achat_ligne` WHERE `id_cmd` ='{$id}'";
            if ($con->query($sql2) === TRUE) {
                $msg = "Supression avec succées";
                header("location: commandes.php?msg=" . $msg);
            }
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: commandes.php?msg=" . $msg);
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
    $id_fournis = $_POST['id_fournis'];
    $date_cmd = $_POST['date_cmd'];
    $total_prix_php = $_SESSION['total_prix'];
    $transport = $_POST['transport'];
    $id_transp = $_POST['id_transp'];

    $sql = "UPDATE `cmd_achat` SET `id_fourni`='$id_fournis',`id_transp`='$id_transp',`transport`='$transport',`date_ajout`='$date_cmd',`total`='$total_prix_php' WHERE `id` = '{$id_cmd}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "Commande ajoutée avec succès";
        if (!isset($_SESSION['total_prix']) || $total_prix_php == 0) {
            $sql = "DELETE FROM cmd_achat WHERE id=" . $id_cmd . "";
            $con->query($sql);
            $msg = "Commande non ajoutée";
        }

        // update all price for all products in cmd
        $sql_update_products_price = "select id,id_cmd,id_article,qte,id_model,prix_achat, qte*prix_achat as prix from cmd_achat_ligne where id_cmd = $id_cmd";
        $result_update_products_price = $con->query($sql_update_products_price);

        if ($result_update_products_price->num_rows > 0) {
            while ($row = $result_update_products_price->fetch_assoc()) {
                $pourcentage = round($row['prix'] / $total_prix_php, 2);
                $new_prix = (($pourcentage * $transport) + $row['prix']) / (int) $row['qte'];
                update_prix_ligne_cmde($row['id'], $new_prix, $con);
                // var_dump($new_prix);
            }
            //die;
        } else {
            echo "erreur";
        }
        /*
        select id,id_cmd,id_article,qte,id_model,prix_achat, qte*prix_achat as prix from cmd_achat_ligne where id_cmd =100
        SELECT * FROM articles_model
        id	id_article	id_model	qte	prix_achat	
       */
        $sql_update_prix_achat = "select al.id as alid,al.id_cmd as alid_cmd,al.id_article as alid_article,al.qte as alqte,al.id_model as alid_model,al.prix_achat as alprix_achat, am.id as amid, am.id_article as amid_article, am.id_model as amid_model, am.qte as amqte, am.prix_achat as amprix_achat from cmd_achat_ligne al, articles_model am where al.id_cmd = $id_cmd and al.id_article = am.id_article and al.id_model = am.id_model";
        //select al.id as id_cmd, ac.id as id_am from cmd_achat_ligne al , articles_model ac
        $result_update_prix_achat = $con->query($sql_update_prix_achat);
        if ($result_update_prix_achat->num_rows > 0) {
            while ($row = $result_update_prix_achat->fetch_assoc()) {
                $prix = round(((int) $row['alqte'] * (int) $row['alprix_achat'] + ((int) $row['amqte'] - (int) $row['alqte']) * (int) $row['amprix_achat']) / ((int) $row['amqte']), 2);
                update_prix_achat_article_model($row['amid'], $prix, $con);
            }
        } else {
            echo "erreur";
        }
        header("location:commandes.php?msg=" . $msg);
    } else {
        $sql = "DELETE FROM cmd_achat WHERE id='" . $id_cmd . "'";
        if ($con->query($sql) === TRUE) {
            $msg = "Commande non ajoutée";
            header("location:commandes.php?msg=" . $msg);
        }
    }
} elseif (isset($_GET['get_model']) && $_GET['get_model'] != '') {

    $id_article = $_GET['id_art'];
    $sql27 = "select id,nom FROM `model` where id IN ( SELECT id_model
    FROM articles_model where id_article=$id_article
    GROUP BY id_model
    HAVING COUNT(*) > 0)";
    $result27 = $con->query($sql27);
    $data = "";
    var_dump($sql27);
    if ($result27->num_rows > 0) {
        while ($row27 = $result27->fetch_assoc()) {
            $data .= "<option value='" . $row27['id'] . "'>" . $row27["nom"] . "</option>";
        }
        echo $data;
    } else {
        echo "erreur";
    }
} elseif (isset($_GET['id_info_cmd']) && $_GET['id_info_cmd'] != '') {
    $sql = "SELECT * FROM cmd_achat where id=" . $_GET['id_info_cmd'];
    $result = $con->query($sql);

    $row = $result->fetch_assoc();

    $data = [
        'id' => $row['id'],
        'nom_fourni' =>  getNomFourni($row["id_fourni"], $con),
        'date_ajout' =>   $row["date_ajout"],
        'total' =>  $row["total"],
        'payee' =>  $row["payee"],
        'reste' => strval(($row["total"] - $row["payee"]))
    ];

    header('Content-type: application/json');
    echo json_encode($data);
}
