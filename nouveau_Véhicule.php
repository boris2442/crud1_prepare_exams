<?php
require_once 'connexion.php';

try {

    if (isset($_POST['valider'])) {

        // $id = $_POST['vehicule_id'];
        $modele = $_POST['modele'];
        $date = $_POST['date_immatriculation'];
        $couleur = $_POST['couleur'];

        $sql = "INSERT INTO vehicules ( modele, DATE_IMMATRICULATION, COULEUR)
                VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$modele, $date, $couleur]);

        $message = "✅ Véhicule ajouté avec succès !";
        header("location: Affiche.php");
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter Véhicule</title>
    <link rel="stylesheet" href="style_session.css">

    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {
            background: #1e293b;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            background: #3b82f6;
            border: none;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="form">
        <h2>🚗 Nouveau Véhicule</h2>

        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <form method="POST">
           

            <input type="text" name="modele" placeholder="Modèle" required>

            <input type="date" name="date_immatriculation" required>

            <input type="text" name="couleur" placeholder="Couleur" required>

            <button type="submit" name="valider">Valider</button>
        </form>
    </div>

</body>

</html>
