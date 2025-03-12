<?php
require 'world_data_parser.php';

try {
    // Erstellung eines Objekts, um die Funktionen der Klasse WorldDataParser nutzen zu können.
    $parser = new WorldDataParser();

    // Aufruf der Funktion parseCSV($file_path), die als Parameter die Adresse der csv-Datei hat und ein Array
    // mit den Daten der Datei zurückgibt, die in $countries_array gespeichert werden.
    $countries_array = $parser->parseCSV('world_data_v3.csv');

    // Array ($countries_array) in XML umwandeln
    $save_xml = $parser->saveXML($countries_array);

    // XML-Datei (world_data.xml) in HTML-Tabelle umwandeln durch XSL-Datei(world_data.xsl)
    $html_table = $parser->printXML('world_data.xml', 'world_data.xsl');

    if ($save_xml && $html_table !== null) {
        // HTML-Tabelle zeigen, falls erfüllte Bedingungen.
        echo $html_table;
    } else {
        throw new Exception("Fehler beim Speichern der XML-Datei (in saveXML()).");
    }

} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
}

?>