<?php
require 'world_data_parser.php';

try {
    // Erstellung eines Objekts, um die Funktionen der Klasse WorldDataParser nutzen zu können.
    $parser = new WorldDataParser();
    // Aufruf der Funktion parseCSV($file_path), die als Parameter die Adresse der csv-Datei hat und ein Array
    // mit den Daten der Datei zurückgibt, die in $data gespeichert werden.
    $data = $parser->parseCSV('world_data_v3.csv');

    // In den nächsten 3 Zeilen werden die Daten des Arrays $data gezeigt.
    //  Dank <pre> HTMLtag und print_r() können wir die Daten "Menschen Lesbar" machen.
    echo "<pre>";
    print_r($data);
    echo "</pre>";

} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
}
?>