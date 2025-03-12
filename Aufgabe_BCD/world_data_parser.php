<?php
// PHP-Klasse 'WorldDataParser' für Funktionalität
class WorldDataParser{

    /*
       Funktion parseCSV($file_path) empfängt den Pfad($file_path) eines csv-Dokuments und extrahiert
       die Dokumentdaten, um sie in einem Array ($data) zu speichern und zurückzugeben.
    */
    public function parseCSV($file_path): array
    {
        $data = [];
        // "If" Kontrol für den Öffnung der csv-Datei
        if (($file = fopen($file_path, "r"))) {
            $add_data = false;
            $key_array = [];
            // Die Funktion fgetcsv() parst eine Zeile aus der geöffneten Datei($file)
            while (($row = fgetcsv($file, 1000, ','))) {

                if ($add_data){
                    // Generierung von individuellen Arrays($data_aux) für jede Zeile, dort werden die Daten jedes
                    // Landes gespeichert, ein Array pro Land, dann wird jedes individueles Array in einer Position
                    // des Arrays $data gespeichert.
                    $data_aux = [];
                    for($i = 0; $i < count($key_array) ; $i++){
                        // Array der Art von Elementen [(key,value)]
                        $data_aux[$key_array[$i]] = $row[$i];
                    }
                    $data[] = $data_aux;
                }else{
                    // Extraktion und Speicherung der ersten Zeile des csv-Datei, wobei die Attribute
                    // der Datei als „Keys“ im Array "$data" gespeichert werden.
                    $key_array = $row;
                    $add_data = true;
                }
            }
            // csv-Datei schließen nach der Nutzung und extraktion den Daten.
            fclose($file);
        } else {
            throw new Exception("Fehler beim Öffnen der Datei: $file_path");
        }
        // Zurückgeben von Array mit den Daten von csv-Datei, Array der Art [(key,value)]
        // wobei key=Positionsnummer/index im Array und value=Array mit den Daten von jedem Land.
        return $data;
    }

    /*
        Funktion saveXML($countries_array) empfängt einen Array, der Daten vom einem csv-Datei beinhält.
        In diesem Fall der Array $countries_array beinhält Daten von Ländern aus world_data_v3.csv.
        Die Aufgabe von der Funktion ist zu speichern der Datenstruktur als XML-Datei.
    */
    public function saveXML($countries_array): false|int
    {
        try {
            // Erstellung der Name des neuen XML-Dokuments
            $xml_file = "world_data.xml";
            // Wurzel des XML erstellen
            $xml = new SimpleXMLElement('<Countries/>');

            //Iterieren über die Array von Ländern mit ihren Daten um jeden Element auf den XML zu hinzufügen
            foreach ($countries_array as $country){

                //Hinzüfugen von jedes Land als Kind vom Wurzel "<Countries>"
                $element = $xml->addChild('Country');
                //Hinzüfugen von alle Daten dieses Land als Kind vom Tag "<Country>"
                foreach ($country as $key => $value){

                    // Eliminierung von Leerzeichen dank trim()
                    $clean_value = trim($value);
                    $clean_key = trim($key);

                    // Ersetzung der Zeichen „-“ durch Leerzeichen „/ /“
                    $clean_key = preg_replace('/ /', '_', $clean_key);

                    // Suche nach diesen Mustern in den Keys, um die Anforderungen der Aufgabe zu erfüllen.
                    $pattern_array = array(
                        '_rate_per_1000','_phones_per_100','_per_woman','_consumption_per_capita',
                        '_annual' , '_user_per_100','_expectancy','_expenditure_percent_of_gdp',
                    );
                    // Eliminierung von den Muster im Key($clean_key)
                    $clean_key = str_replace ($pattern_array, '', $clean_key);

                    //Hinzüfugen von Daten des Landes als Kind vom Tag"<Country>"
                    $element->addChild($clean_key , htmlspecialchars($clean_value, ENT_QUOTES, 'UTF-8'));
                }
            }

            // XML Datei konfigurieren
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->encoding = 'UTF-8';

            // XML Datei speichern und bestätigung, "true" falls XML gespecihert ist oder "false"
            // falls Fehler speichern, in $result.
            $result = $dom->save($xml_file);

            // Boolean Wert zurück liefern ($result), je nachdem ob das Schreiben erfolgreich war
            // (true) oder nicht (false)
            return $result;

        }catch (Exception $e){
            echo "Fehler: " . $e->getMessage();
            return false;
        }
    }

    /*
        Funktion printXML($xml_file_path, $xslt_file_path) empfängt zwei Datei Adresse(Adresse von
        XML-Datei und XSL-Datei).
        Die Aufgabe von der Funktion ist Einlesen einer XML-Datei und Transformation in valides HTML.
    */
    public function printXML($xml_file_path, $xslt_file_path): ?string
    {
        try {
            // XML-Datei herunterladen und im $xml zu speicher.
            $xml = new DOMDocument;
            if (!$xml->load($xml_file_path)) {
                throw new Exception("Fehler beim Laden der XML-Datei: $xml_file_path");
            }

            // XSL-Datei herunterladen und im $xsl zu speicher.
            $xsl = new DOMDocument;
            if (!$xsl->load($xslt_file_path)) {
                throw new Exception("Fehler beim Laden der XSLT-Datei: $xslt_file_path");
            }

            // Erstellung einer neuen Instanz der Klasse XSLTProcessor. Dieser Prozessor wird verwendet,
            // um XSLT-Stylesheets (XSL) anzuwenden und XML-Daten zu transformieren.
            $xsltProcessor = new XSLTProcessor;
            // Die Methode "importStylesheet()" lädt das Stylesheet in den XSLT-Prozessor und bereitet es
            // für die Transformation vor.
            $xsltProcessor->importStylesheet($xsl);

            // Transformation XML zu HTML durch XSLTProcessor.
            $html = $xsltProcessor->transformToXML($xml);
            if ($html === false) {
                throw new Exception("Fehler bei der XSLT-Transformation");
            }

            // Zurückgegebene HTML-Tabelle als String
            return $html;

        } catch (Exception $e) {
            echo "Fehler: " . $e->getMessage();
            return null;
        }
    }
}
?>
