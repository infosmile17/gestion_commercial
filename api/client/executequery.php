<?php

require_once 'connexion.php';
require_once 'MaterielClass.php';
require_once 'ProfClass.php';
require_once 'ClasseClass.php';
require_once 'SectionClass.php';
require_once 'SuiviClass.php';
$env = $_POST['env'];
if ($env == 'ajoutermateriel') { // Les ajouts
    $nom = $_POST['nom'];
    $quantite = $_POST['quantite'];
    $description = $_POST['description'];

    $mat = new MaterielClass();
    $mat->init($nom, $quantite, $description);
    $mat->Ajouter();
} elseif ($env == 'ajouterprofesseur') {
    $nom_prenom = $_POST['nom_prenom'];
    $specialite = $_POST['specialite'];
    $remarque = $_POST['remarque'];

    $prof = new ProfClass();
    $prof->init($nom_prenom, $specialite, $remarque);
    $prof->Ajouter();
} elseif ($env == 'ajouterclasse') {


    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $description = $_POST['description'];
    $cla = new ClasseClass();
    $cla->init($nom, $niveau, $description);
    $cla->Ajouter();
    var_dump($cla);
    die();
} elseif ($env == 'ajoutersection') {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $login = $_POST['login'];
    $pwd = $_POST['pwd'];

    $sec = new SectionClass();
    $sec->init($nom, $type, $description, $login, $pwd);
    $sec->Ajouter();
} elseif (isset($_GET['idsupmateriel'])) { //Les suppressions
    $idsupmateriel = $_GET['idsupmateriel'];
    $mat = new MaterielClass();
    $mat->Supprimer($idsupmateriel);
} elseif (isset($_GET['idsupprofesseur'])) {
    $idsupprofesseur = $_GET['idsupprofesseur'];
    $prof = new ProfClass();
    $prof->Supprimer($idsupprofesseur);
} elseif (isset($_GET['idsupclasse'])) {
    $idsupclasse = $_GET['idsupclasse'];
    $cla = new ClasseClass();
    $cla->Supprimer($idsupclasse);
} elseif (isset($_GET['idsupsection'])) {
    $idsupsection = $_GET['idsupsection'];
    $sec = new SectionClass();
    $sec->Supprimer($idsupsection);
} elseif (isset($_GET['idsupsuivi'])) {
    $idsupsuivi = $_GET['idsupsuivi'];
    $sec = new SuiviClass();
    $sec->Supprimer($idsupsuivi);
} elseif ($env == 'modifmateriel') { //Les Modifications 
    $idd = $_POST['idd'];
    $nom = $_POST['nom'];
    $quantite = $_POST['quantite'];
    $description = $_POST['description'];

    $mat = new MaterielClass();
    $mat->init($nom, $quantite, $description);
    $mat->Modifier($idd);
} elseif ($env == 'modifprof') {
    $idd = $_POST['idd'];
    $nom_prenom = $_POST['nom_prenom'];
    $specialite = $_POST['specialite'];
    $remarque = $_POST['remarque'];

    $mat = new ProfClass();
    $mat->init($nom_prenom, $specialite, $remarque);
    $mat->Modifier($idd);
} elseif ($env == 'modifclasse') {
    $idd = $_POST['idd'];
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $description = $_POST['description'];

    $cla = new ClasseClass();
    $cla->init($nom, $niveau, $description);
    $cla->Modifier($idd);
} elseif ($env == 'modifsection') {
    $idd = $_POST['idd'];

    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $login = $_POST['login'];
    $pwd = $_POST['pwd'];

    $sec = new SectionClass();
    $sec->init($nom, $type, $description, $login, $pwd);

    $sec->Modifier($idd);
} elseif ($env == 'ajoutersuivi') {
    $technicien = $_POST['technicien'];
    $materiel = $_POST['materiel'];
    $qte_demande = $_POST['qte_demande'];
    $classe = $_POST['classe'];
    $professeur = $_POST['professeur'];
    $datedemande = $_POST['datedemande'];
    $timedemande = $_POST['timedemande'];
    $dateretour = $_POST['dateretour'];
    $timeretour = $_POST['timeretour'];
    $description = $_POST['description'];

    $sui = new SuiviClass();

    $sui->init($materiel, $qte_demande, $classe, $professeur, $datedemande, $timedemande, $dateretour, $timeretour, $technicien, $description);
    //test dates
    // les dates sont les memes
    if ($datedemande != $dateretour) {
        $msg = "Merci de choisir la meme journée !";
        header("location: suivi.php?msg=" . $msg);
    } else {
        //$interval = $timeretour - $timedemande;

        $time1 = new DateTime($timeretour);
        $time2 = new DateTime($timedemande);
        $interval = $time1->diff($time2);
        //die();
        if ($time1 < $time2) {
            $msg = "Merci de bien vérifier les dates !";
            header("location: suivi.php?msg=" . $msg);
        } else {

            if ($interval->h > 4 || ($interval->h == 4 and $interval->i > 0)) {
                $msg = "Vous ne pouvez pas dépassé 4 heurs !";
                header("location: suivi.php?msg=" . $msg);
            } else {
                $dispo = $sui->test_qte_disponible();
                if (!$dispo) {
                    $sui->Ajouter();
                } else {
                    $msg = "Quantité demandée n'est pas disponible";
                    header("location: suivi.php?msg=" . $msg);
                }
            }
        }
    }
}
