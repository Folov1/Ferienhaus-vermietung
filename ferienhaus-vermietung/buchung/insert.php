<?php
// Fehlermeldungen aktivieren (zum Debuggen)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbinden mit Datenbank
require dirname(__DIR__) . '/connect/connect.php';

// Überprüfen, ob das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $buchung_id = trim($_POST["id"]);
    $gastID = trim($_POST['gast_id']);
    $ferienhausID = trim($_POST['ferienhaus_id']);
    $ankunftsdatum = trim($_POST['ankunft']);
    $abfahrtsdatum = trim($_POST['abfahrt']);
    $erstellungsdatum = date('Y-m-d H:i:s'); // Automatisch aktuelles Datum setzen

    // Überprüfen, ob alle Felder ausgefüllt sind
    if (!empty($gastID) && !empty($ferienhausID) && !empty($ankunftsdatum) && !empty($abfahrtsdatum)) {
        try {
            // Einfügen der Daten in die Tabelle buchung
            $stmt = $pdo->prepare("INSERT INTO buchung (id, gast_id, ferienhaus_id, ankunft, abfahrt, erstellt_am) 
                                   VALUES (:id, :gast_id, :ferienhaus_id, :ankunft, :abfahrt, :erstellt_am)");

            $stmt->bindValue(":id", $buchung_id, PDO::PARAM_INT);
            $stmt->bindValue(':gast_id', $gastID, PDO::PARAM_STR);
            $stmt->bindValue(':ferienhaus_id', $ferienhausID, PDO::PARAM_STR);
            $stmt->bindValue(':ankunft', $ankunftsdatum, PDO::PARAM_STR);
            $stmt->bindValue(':abfahrt', $abfahrtsdatum, PDO::PARAM_STR);
            $stmt->bindValue(':erstellt_am', $erstellungsdatum, PDO::PARAM_STR);
            $stmt->execute();

            // Erfolgreiche Umleitung nach der Eintragung
            header('Location: buchung.php?success=1');
            exit;
        } catch (PDOException $e) {
            echo "<p style='color:blue; text-align:center;'>Fehler beim Einfügen: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color:blue; text-align:center;'>Bitte alle Felder korrekt ausfüllen!</p>";
    }
}
?>

</head>
<!-- Einbindung von Google Fonts und einer externen CSS-Datei -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../views/mycss.css">

<body>
    <div class="form-container">
        <h1>Neue Buchung hinzufügen</h1>
        <?php if (isset($_GET['success'])) { echo "<p style='color:green; text-align:center;'>Buchung erfolgreich hinzugefügt!</p>"; } ?>
        <form action="" method="POST">
            <!-- Eingabefelder für die Buchungsinformationen -->
            <label for="id">Buchungs-ID:</label>  
            <input type="text" id="id" name="id" required>  

            <label for="gast_id">Gast:</label>
            <input type="text" id="gast_id" name="gast_id" required>

            <label for="ferienhaus_id">Ferienhaus:</label>
            <input type="text" id="ferienhaus_id" name="ferienhaus_id" required>

            <label for="ankunft">Ankunftsdatum:</label>
            <input type="date" id="ankunft" name="ankunft" required>

            <label for="abfahrt">Abfahrtsdatum:</label>
            <input type="date" id="abfahrt" name="abfahrt" required>

            <button type="submit">Buchung hinzufügen</button>
        </form>
        <a href="buchung.php" class="back-button">Zurück zur Übersicht</a>
    </div>
</body>
</html>
