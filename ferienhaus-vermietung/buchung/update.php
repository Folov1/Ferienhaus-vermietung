<?php
// Verbindung zur Datenbank herstellen
require dirname(__DIR__) . '/connect/connect.php'; 

// Abrufen der Buchungs-ID aus der URL
$id = $_GET['id'] ?? null;

// Überprüfen, ob eine gültige ID übergeben wurde
if (!$id) {
    die('Keine gültige ID angegeben.');
}

// Abrufen der Buchungsdaten aus der Datenbank
$stmt = $pdo->prepare('SELECT * FROM buchung WHERE id = :id');
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$buchung = $stmt->fetch(PDO::FETCH_ASSOC);

// Überprüfen, ob die Buchung existiert
if (!$buchung) {
    die('Buchung nicht gefunden.');
}

// Daten aktualisieren, wenn das Formular abgesendet wird
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eingabewerte aus dem Formular abrufen
    $gast_id = $_POST['gast_id'];
    $ferienhaus_id = $_POST['ferienhaus_id'];
    $ankunft = $_POST['ankunft'];
    $abfahrt = $_POST['abfahrt'];
    $erstellt_am = $buchung['erstellt_am'];  // Automatisch aus der Datenbank übernommen

    // Validierung der Eingaben
    if (empty($gast_id) || empty($ferienhaus_id) || empty($ankunft) || empty($abfahrt)) {
        $error = 'Bitte alle Felder ausfüllen.';
    } else {
        // SQL-Befehl zum Aktualisieren der Buchung in der Datenbank
        $updateStmt = $pdo->prepare('
            UPDATE buchung 
            SET gast_id = :gast_id, ferienhaus_id = :ferienhaus_id, ankunft = :ankunft, abfahrt = :abfahrt, erstellt_am = :erstellt_am 
            WHERE id = :id
        ');

        // Parameter binden und das Statement ausführen
        $updateStmt->bindParam(':gast_id', $gast_id);
        $updateStmt->bindParam(':ferienhaus_id', $ferienhaus_id);
        $updateStmt->bindParam(':ankunft', $ankunft);
        $updateStmt->bindParam(':abfahrt', $abfahrt);
        $updateStmt->bindParam(':erstellt_am', $erstellt_am);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Fehlerprüfung bei der Ausführung des Updates
        if (!$updateStmt->execute()) {
            die("Fehler beim Update: " . implode(" | ", $updateStmt->errorInfo()));
        }

        // Weiterleitung nach erfolgreicher Aktualisierung
        header('Location: buchung.php');
        exit;
    }
}
?>

</head>
<!-- Einbindung von Google Fonts und einer externen CSS-Datei -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../views/mycss.css">

<body>
    <div class="form-container">
        <h1>Buchung bearbeiten</h1>
        <form method="POST">
            <!-- Fehleranzeige -->
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- Buchungs-ID (schreibgeschützt) -->
            <label for="id">ID</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($buchung['id']); ?>" readonly>

            <!-- Eingabefelder für die Buchungsinformationen -->
            <label for="gast_id">Gast:</label>
            <input type="text" id="gast_id" name="gast_id" value="<?php echo htmlspecialchars($buchung['gast_id']); ?>" required>

            <label for="ferienhaus_id">Ferienhaus:</label>
            <input type="text" id="ferienhaus_id" name="ferienhaus_id" value="<?php echo htmlspecialchars($buchung['ferienhaus_id']); ?>" required>

            <label for="ankunft">Ankunft:</label>
            <input type="date" id="ankunft" name="ankunft" value="<?php echo htmlspecialchars($buchung['ankunft']); ?>" required>

            <label for="abfahrt">Abfahrt:</label>
            <input type="date" id="abfahrt" name="abfahrt" value="<?php echo htmlspecialchars($buchung['abfahrt']); ?>" required>

            <!-- Erstellt-am-Feld (nicht bearbeitbar) -->
            <label for="erstellt_am">Erstellt am</label>
            <input type="text" id="erstellt_am" name="erstellt_am" value="<?php echo htmlspecialchars($buchung['erstellt_am']); ?>" disabled>

            <!-- Buttons für das Formular -->
            <button type="submit">Daten aktualisieren</button>
            <a href="buchung.php" class="back-button">Zurück zur Übersicht</a>
        </form>
    </div>
</body>
</html>
