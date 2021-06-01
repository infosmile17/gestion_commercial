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
    $sql = "UPDATE `fournis` SET `nomprenom`='$nomprenom',`tel1`='$tel1',`tel2`='$tel2',`email`='$email',`adresse`='$adresse',`remarques`='$remarques' WHERE `id` = '{$id}' LIMIT 1";

    if ($con->query($sql) === TRUE) {
        $msg = "Modification avec succée du fournisseur";
        header("location: fourni.php?msg=" . $msg);
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


    $sql = "INSERT INTO fournis (nomprenom, tel1, tel2, email, adresse, remarques) VALUES ('$nomprenom', '$tel1', '$tel2', '$email', '$adresse', '$remarques')";
    if ($con->query($sql) === TRUE) {
        $msg = "Nouveau fournisseur créé avec succès";
        header("location: fourni.php?msg=" . $msg);
    } else {
        header("location: 404.php");
    }
    var_dump($_POST);
} elseif (isset($_POST['id_sup']) && isset($_POST['Supprimer_fournisseur'])) {
    if ($_POST['id_sup'] != '') {
        $id = $_POST['id_sup'];
        $sql = "DELETE FROM `fournis` WHERE `id` ='{$id}' LIMIT 1";
        if ($con->query($sql) === TRUE) {
            $msg = "Suppression d'un fournisseur avec succès";
            header("location: fourni.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: fourni.php?msg=" . $msg);
    }
} elseif (isset($_GET['mod'])) {
    if ($_GET['mod'] != '') {
        $id = $_GET['mod'];
        $sql = "select * FROM `fournis` WHERE `id` ='{$id}' LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc() .
                header("location: fourni.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    } else {
        $msg = 'Ereur de suppression';
        header("location: fourni.php?msg=" . $msg);
    }
} elseif (isset($_GET['id_mod_jq'])) {
    if ($_GET['id_mod_jq'] != '') {
        $id = $_GET['id_mod_jq'];
        $sql = "select * FROM `fournis` WHERE `id` ='{$id}' LIMIT 1";
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
            header("location: fourni.php?msg=" . $msg);
        }
    } else {
        $msg = 'Ereur de selection';
        header("location: fourni.php?msg=" . $msg);
    }
} elseif (isset($_GET['searchtext'])) {
    if ($_GET['searchtext'] != '') {
        $searchtext = $_GET['searchtext'];
        $sql = "SELECT * FROM fournis WHERE nomprenom LIKE '%$searchtext%'
        OR tel1 LIKE '%$searchtext%'
        OR tel2 LIKE '%$searchtext%'
        OR email LIKE '%$searchtext%'
        OR adresse LIKE '%$searchtext%'
        OR remarques LIKE '%$searchtext%'
        ";
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
        echo ("<script src='script_fournis.js'></script>");
    } else {
        $sql = "SELECT * FROM fournis";
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
    }
}
