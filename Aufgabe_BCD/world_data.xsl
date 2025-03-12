<?xml version="1.0" encoding="UTF-8"?>
<!--XSLT-Stylesheet zur Umwandlung der Datei 'world_data.xml' in eine HTML-Tabelle -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <!--
        Anweisung xsl:output definiert die Ausgabeformatierung des Transformationsprozesses.
        Gibt an, dass die Ausgabe HTML sein soll.
     -->
    <xsl:output method="html" indent="yes" />
    <!--
        Anweisung xsl:template definiert ein XSLT-Template, das auf den Wurzelknoten (/) eines XML-Datei
        angewendet wird.
     -->
    <xsl:template match="/">
        <html>
            <head>
                <title>World Data</title>
                <style>
                    th,td {
                    padding: 0 5px 0 5px;
                    }
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        <tr>
                            <!--
                                'xsl:for-each' iteriert über die Menge von XML-Knoten.
                                'select="Countries/Country[1]/*"' wählt alle Kindknoten (*) innerhalb
                                des ersten <Country> Knoten ([1]) innerhalb den Wurzel <Countries>.

                                Die gesamte Schleife wurde so gestaltet, dass das richtige Ausgabeformat für den
                                'thead' angezeigt wird, um die in der Aufgabestellung angegebene Antwort zu zeigen
                                (z.b. statt name -> Country).
                            -->
                            <xsl:for-each select="Countries/Country[1]/*">
                                <!--
                                    xsl:choose festlegt, welche Option für die Erstellung des <th>-Tags auf der
                                    Grundlage der Übereinstimmung mit 'name()' verwendet werden soll.
                                    Wobei name() auf den Namen des XML-Tags verweist.
                                 -->
                                <xsl:choose>
                                    <xsl:when test="name()='id'"><th>ID</th></xsl:when>
                                    <xsl:when test="name()='name'"><th>Country</th></xsl:when>
                                    <xsl:when test="name()='birth'"><th>rate/1000</th></xsl:when>
                                    <xsl:when test="name()='cell'"><th>cellphones/1000</th></xsl:when>
                                    <xsl:when test="name()='children'"><th>children/woman</th></xsl:when>
                                    <xsl:when test="name()='electricity'"><th>electricity usage</th></xsl:when>
                                    <xsl:otherwise><th><xsl:value-of select="name()"/></th></xsl:otherwise>
                                </xsl:choose>
                            </xsl:for-each>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- For each für Füllen der Tabelle mit den jeweiligen Länderdaten aus dem XML-Dokument -->
                        <xsl:for-each select="Countries/Country">
                            <tr>
                                <xsl:for-each select="*">
                                    <td ><xsl:value-of select="." /></td>
                                </xsl:for-each>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>