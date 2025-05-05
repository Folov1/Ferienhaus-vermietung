<?php

/*Erzeugt ein neue Instanz ($pdo) der Klasse PDO; baut Verbindung zur Datenbank auf
Problematik
Fehler beim Verbindungsaufbau zur DB werden dem Anwender angezeit, 
wenn nicht mit "try/cahtch" gearbeitet wird
*/

/*PDO:: ERRMODE_EXCEPTION ist eine Konstante, die bei PHP8 nicht unbedingt gesetzt werden musss
jedoch bei der Migration der DB auf einen anderen Server (bz. PHP-Version) gesetzt werden sollte
*/
try {
 
    $pdo = new PDO('mysql:host=localhost;dbname=ferienhaus-vermietung','root','', [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
    ]);
    }
    catch (PDOExeption $e) {
        echo "Fehler beim Verbindungsaufbau zu Datenbank";
        die();
    }