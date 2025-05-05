<?php
require dirname(__DIR__) . '/connect/connect.php';

// Prüfen, ob die ID über die URL übergeben wurde
if (isset($_GET['deleteID'])) {
    $id = intval($_GET['deleteID']);

    try {
        // Transaktion starten
        $pdo->beginTransaction();

        // Löschen der zugehörigen Daten aus der 'verleih' Tabelle
        $stmt = $pdo->prepare('DELETE FROM `buchung` WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Löschen des Skier-Eintrags aus der 'skier' Tabelle
        $stmt = $pdo->prepare('DELETE FROM buchung WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Transaktion abschließen
        $pdo->commit();

        // Nach dem Löschen auf die Hauptseite weiterleiten
        header("Location: buchung.php?success=1");
        exit;
    } catch (PDOException $e) {
        // Fehlerbehandlung bei Problemen
        $pdo->rollBack();
        die("Fehler beim Löschen: " . $e->getMessage());
    }
} else {
    // Falls keine ID übergeben wurde, Weiterleitung zur Hauptseite
    header("Location: ferienhaus-Vermietung.php?error=1");
    exit;
}
?>
