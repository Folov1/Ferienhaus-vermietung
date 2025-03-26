<?php
require dirname(__DIR__) . '/connect/connect.php';

// Abrufen der Daten aus der Datenbank
$stmt = $pdo->prepare('SELECT * FROM `buchung` ORDER BY id');
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunden Übersicht</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../views/mycss.css">
    
</head>
<body>
    <h1>Buchung Übersicht</h1>
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
                    <td><?php echo htmlspecialchars($result['id']); ?></td>
                    <td><?php echo htmlspecialchars($result['gast_id']); ?></td>
                    <td><?php echo htmlspecialchars($result['ferienhaus_id']); ?></td>
                    <td><?php echo htmlspecialchars($result['ankunft']); ?></td>
                    <td><?php echo htmlspecialchars($result['abfahrt']); ?></td>
                    <td><?php echo htmlspecialchars($result['erstellt_am']); ?></td>
                    <td><a href="update.php?id=<?php echo $result['id']; ?>" class="action-btn btn-update">Update</a></td>
                    <td><a href="delete.php?deleteID=<?php echo $result['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Möchten Sie diesen Eintrag wirklich löschen?');">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="add-btn-container">
        <a href="insert.php" class="btn">Neuen Gast hinzufügen</a>
    </div>
</body>
</html>
