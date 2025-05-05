<?php
require dirname(__DIR__) . '/connect/connect.php';

$stmt = $pdo->prepare('SELECT * FROM `buchung` ORDER BY id');
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buchung Übersicht</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../views/mycss.css">
</head>
<body>
    <h1 class="main-title">Buchung Übersicht</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gast-Id</th>
                    <th>Ferienhaus_Id</th>
                    <th>Ankunft</th>
                    <th>Abfahrt</th>
                    <th>Erstellt am</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['id']) ?></td>
                        <td><?= htmlspecialchars($result['gast_id']) ?></td>
                        <td><?= htmlspecialchars($result['ferienhaus_id']) ?></td>
                        <td><?= htmlspecialchars($result['ankunft']) ?></td>
                        <td><?= htmlspecialchars($result['abfahrt']) ?></td>
                        <td><?= htmlspecialchars($result['erstellt_am']) ?></td>
                        <td><a href="update.php?id=<?= $result['id'] ?>" class="action-btn btn-update">Update</a></td>
                        <td><a href="delete.php?deleteID=<?= $result['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Möchten Sie diesen Eintrag wirklich löschen?');">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="add-btn-container">
            <a href="insert.php" class="btn">Neue Buchung hinzufügen</a>
        </div>
    </div>
</body>
</html>
