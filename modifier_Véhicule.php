<?php
session_start(); // toujours au début du fichier avant tout echo
require "connexion.php";

// Récupérer l'ID du véhicule depuis l'URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID du véhicule manquant !");
}

// Récupérer les informations actuelles du véhicule
$sql = "SELECT * FROM vehicules WHERE VEHICULE_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vehicule) {
    die("Véhicule introuvable !");
}

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['DATE_IMMATRICULATION'];
    $couleur = $_POST['COULEUR'];
    $modele = $_POST['modele'];

    $update = "UPDATE vehicules 
               SET DATE_IMMATRICULATION = :date, COULEUR = :couleur, modele = :modele
               WHERE VEHICULE_ID = :id";

    $stmt = $pdo->prepare($update);
    $stmt->execute([
        'date' => $date,
        'couleur' => $couleur,
        'modele' => $modele,
        'id' => $id
    ]);
    // Après l'update
    $_SESSION['success'] = "Le véhicule #{$id} a été modifié avec succès !";
    header("Location: Affiche.php"); // redirige vers la liste
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Véhicule</title>
      <link rel="stylesheet" href="style_session.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0f172a;
            color: #e0e7ff;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #3b82f6;
            margin-bottom: 20px;
        }

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #1e293b;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #3b82f6;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #3b82f6;
            background-color: #0f172a;
            color: #e0e7ff;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            background-color: #3b82f6;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2563eb;
        }

        .back-link {
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            color: #FFE600;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link a:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <h1>✏️ Modifier Véhicule #<?= htmlspecialchars($vehicule['VEHICULE_ID']) ?></h1>

    <form method="post">
        <label for="DATE_IMMATRICULATION">Date Mise en Circulation</label>
        <input type="date" name="DATE_IMMATRICULATION" id="DATE_IMMATRICULATION" value="<?= htmlspecialchars($vehicule['DATE_IMMATRICULATION']) ?>" required>

        <label for="COULEUR">Couleur</label>
        <input type="text" name="COULEUR" id="COULEUR" value="<?= htmlspecialchars($vehicule['COULEUR']) ?>" required>

        <label for="modele">Num Type / Modèle</label>
        <input type="text" name="modele" id="modele" value="<?= htmlspecialchars($vehicule['modele']) ?>" required>

        <input type="submit" value="💾 Enregistrer les modifications">
    </form>

    <div class="back-link">
        <a href="Affiche.php">🔙 Retour à la liste des véhicules</a>
    </div>
</body>

</html>
