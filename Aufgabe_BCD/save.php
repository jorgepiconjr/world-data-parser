<?php
require 'world_data_parser.php';

try {
    // Erstellung eines Objekts, um die Funktionen der Klasse WorldDataParser nutzen zu können.
    $parser = new WorldDataParser();
    // Aufruf der Funktion parseCSV($file_path), die als Parameter die Adresse der csv-Datei hat und ein Array
    // mit den Daten der Datei zurückgibt, die in $data gespeichert werden.
    $data = $parser->parseCSV('world_data_v3.csv');

    // Array ($data) in XML umwandeln
    $success = $parser->saveXML($data);

    // Menschen lesbare verständliche Statusmeldung der Umwandlung ausgeben
    if ($success){
        echo "XML Savestatus: erfolgreich (1)";
    }else{
        echo "XML Savestatus: FEHLER (0)";
    }
}catch (Exception $e){
    echo "Fehler beim Speichern der XML-Datei (in saveXML())." . $e->getMessage();
}

?>