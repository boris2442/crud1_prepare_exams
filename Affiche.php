<?php
session_start(); // toujours au début du fichier avant tout echo
require "connexion.php";

$search = $_GET['search'] ?? '';

if ($search) {
    $sql = "SELECT * FROM vehicules 
            WHERE VEHICULE_ID LIKE :search 
               OR COULEUR LIKE :search 
               OR modele LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $sql = "SELECT * FROM vehicules";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des véhicules</title>
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

        .top-actions {
            text-align: center;
            margin-bottom: 20px;
        }

        .top-actions a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            background-color: #3b82f6;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .top-actions a:hover {
            background-color: #2563eb;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            border-radius: 6px;
            border: 1px solid #3b82f6;
        }

        input[type="submit"] {
            padding: 10px 15px;
            background-color: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 5px;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2563eb;
        }

        table {
            width: 90%;
            margin: 0 auto 30px;
            border-collapse: collapse;
            background-color: #1e293b;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #3b82f6;
        }

        th {
            background-color: #3b82f6;
            color: #fff;
        }

        tr:hover {
            background-color: #0f172a;
        }

        td a {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            transition: 0.3s;
        }

        .edit-btn {
            background-color: #10b981; /* vert */
        }

        .edit-btn:hover {
            background-color: #059669;
        }

        .delete-btn {
            background-color: #ef4444; /* rouge */
        }

        .delete-btn:hover {
            background-color: #b91c1c;
        }

        .empty {
            text-align: center;
            margin-top: 20px;
            color: #FFE600;
        }
    </style>
</head>

<body>
    <?php if(isset($_SESSION['success'])): ?>
    <div style="text-align:center; padding:10px; background-color:#10b981; color:#fff; border-radius:5px; margin-bottom:15px;">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div style="text-align:center; padding:10px; background-color:#ef4444; color:#fff; border-radius:5px; margin-bottom:15px;">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
    <h1>🚗 Liste des Véhicules</h1>

    <div class="top-actions">
        <a href="nouveau_Véhicule.php">➕ Ajouter un véhicule</a>
        <a href="Affiche.php">🔄 Réinitialiser</a>
    </div>

    <!-- Formulaire de recherche -->
    <form method="get">
        <input type="text" name="search" placeholder="Rechercher par ID, couleur ou modèle..." value="<?= htmlspecialchars($search) ?>">
        <input type="submit" value="🔍 Rechercher">
    </form>

    <p style="text-align:center;">Il y a <?= count($vehicules) ?> véhicule(s)</p>

    <?php if (count($vehicules) > 0): ?>
        <table>
            <tr>
                <th>Immatriculation</th>
                <th>Date Mise en Circulation</th>
                <th>Couleur</th>
                <th>Num Type</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($vehicules as $v): ?>
                <tr>
                    <td>#<?= htmlspecialchars($v['VEHICULE_ID'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($v['DATE_IMMATRICULATION']) ?></td>
                    <td><?= htmlspecialchars($v['COULEUR']) ?></td>
                    <td><?= htmlspecialchars($v['modele']) ?></td>
                    <td>
                        <a class="edit-btn" href="modifier_Véhicule.php?id=<?= htmlspecialchars($v['VEHICULE_ID']) ?>">Modifier</a>
                        <a class="delete-btn" href="supprimer.php?id=<?= htmlspecialchars($v['VEHICULE_ID']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="empty">Aucun véhicule trouvé 🚫</p>
    <?php endif; ?>
</body>

</html>
