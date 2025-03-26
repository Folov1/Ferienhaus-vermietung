<?php
// Fehlermeldungen aktivieren (zum Debuggen)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
require dirname(__DIR__) . '/connect/connect.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = trim($_POST["id"]);
    $gast_id = trim($_POST['gast_id']);
    $ferienhaus_id = trim($_POST['ferienhaus_id']);
    $ankunft = trim($_POST['ankunft']);
    $abfahrt = trim($_POST['abfahrt']);
    $erstellt_am = date('Y-m-d H:i:s'); // Automatisch aktuelles Datum setzen

    // Überprüfen, ob alle Felder außer `erstellt_am` ausgefüllt sind
    if (!empty($gast_id) && !empty($ferienhaus_id) && !empty($ankunft) && !empty($abfahrt)) {
        try {
            // Einfügen der Daten in die Tabelle buchung
            $stmt = $pdo->prepare("INSERT INTO buchung (id, gast_id, ferienhaus_id, ankunft, abfahrt, erstellt_am) 
                                   VALUES (:id, :gast_id, :ferienhaus_id, :ankunft, :abfahrt, :erstellt_am)");

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(':gast_id', $gast_id, PDO::PARAM_STR);
            $stmt->bindValue(':ferienhaus_id', $ferienhaus_id, PDO::PARAM_STR);
            $stmt->bindValue(':ankunft', $ankunft, PDO::PARAM_STR);
            $stmt->bindValue(':abfahrt', $abfahrt, PDO::PARAM_STR);
            $stmt->bindValue(':erstellt_am', $erstellt_am, PDO::PARAM_STR);
            $stmt->execute();

            // Erfolgreiche Umleitung
            header('Location: buchung.php?success=1');
            exit;
        } catch (PDOException $e) {
            die("Fehler beim Einfügen: " . $e->getMessage());
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Bitte alle Felder korrekt ausfüllen!</p>";
    }
}
?>

</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../views/mycss.css">
<body>
    <div class="form-container">
        <h1>Neue Buchung hinzufügen</h1>
        <form action="" method="POST">
            <label for="id">ID</label>  
            <input type="text" id="id" name="id" required>  

            <label for="gast_id">Gast:</label>
            <input type="text" id="gast_id" name="gast_id" required>

            <label for="ferienhaus_id">Ferienhaus:</label>
            <input type="text" id="ferienhaus_id" name="ferienhaus_id" required>

            <label for="ankunft">Ankunft:</label>
            <input type="date" id="ankunft" name="ankunft" required>

            <label for="abfahrt">Abfahrt:</label>
            <input type="date" id="abfahrt" name="abfahrt" required>

            <button type="submit">Buchung hinzufügen</button>
        </form>
        <a href="buchung.php" class="back-button">Zurück zur Übersicht</a>
    </div>
</body>
</html>
