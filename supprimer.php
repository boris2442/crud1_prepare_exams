<?php
session_start(); // toujours au début du fichier avant tout echo
require_once "connexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM vehicules WHERE VEHICULE_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $_SESSION['success'] = "Le véhicule #{$id} a été supprimé avec succès !";
    header("location: Affiche.php");
} else {
    $_SESSION['error'] = "Impossible de supprimer ce véhicule !";
    header("location: Affiche.php");
}
