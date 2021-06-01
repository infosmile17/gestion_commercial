<?php

require_once 'connexion.php';

class ProfClass {

    var $id, $nom_prenom, $specialite, $remarque, $connex;

    function __construct() {
        $conn = new Connexion();
        $this->connex = $conn->conn;
    }

    function init($nom_prenom, $specialite, $remarque) {
        $this->nom_prenom = $nom_prenom;
        $this->specialite = $specialite;
        $this->remarque = $remarque;
    }

    function Ajouter() {

        $sql = "INSERT INTO prof (nom_prenom, specialite, remarque) VALUES ('$this->nom_prenom', '$this->specialite', '$this->remarque')";

        if ($this->connex->query($sql) === TRUE) {
            $msg = "Nouveau professeur créé avec succès";
            header("location: professeurs.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    }

    function Supprimer($idsupprof) {
        $sql = "DELETE FROM prof WHERE id=$idsupprof";

        if ($this->connex->query($sql) === TRUE) {
            $msg = "Professeur supprimé avec succès";
            header("location: professeurs.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    }

    function Modifier($idd) {
        $sql = "UPDATE prof SET nom_prenom='$this->nom_prenom',specialite='$this->specialite',remarque='$this->remarque' WHERE id=$idd";
        if ($this->connex->query($sql) === TRUE) {
            $msg = "Professeur modifié avec succès";
            header("location: professeurs.php?msg=" . $msg);
        } else {
            header("location: 404.php");
        }
    }

}
