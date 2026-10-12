# Liga Manager Online (classic design) Change Log (german)
__Alle wesentlichen Änderungen am PHP Script des LMO werden in dieser Datei dokumentiert.__  

## [Unveröffentlicht] - YYYY-MM-DD

_Hier schreiben wir Changelog Hinweise der nächsten Version._  

### Added  
- Die Rohdaten einer Liga lassen sich über benannte Methoden ändern, die die Schlüssel und Sonderwerte der Ligadatei kennen: an der Partie `setzeMannschaften()`, `setzeErgebnis()` (mit Wertung am grünen Tisch), `setzeZusatz()`, `setzeAnstoss()`, `setzeNotiz()`, `setzeBericht()`, `setzeOhneTippwertung()`; am Spieltag `partie()`, `setzeErstenTag()`, `setzeLetztenTag()`, `setzeTabellenkorrektur()`, `setzeSpieleJePaarung()`; an der Mannschaft `setzeUrl()`, `setzeNotiz()`, `setzeStrafpunkte()`, `setzeStrafminuspunkte()`, `setzeTorkorrektur()`, `setzeStrafeAbSpieltag()`; an der Liga `setzeEinstellung()` und `setzeNews()`.


### Changed  
- Die Seiten des Adminbereichs tragen ihre Änderungen über diese Methoden ein statt über die Schlüssel der Datei (`GA`, `ET`, `HS` …). Die geschriebenen Dateien sind unverändert.
- Die HTML-Ausgabe zum Drucken (`lmo-savehtml.php`, `lmo-savehtml1.php`) rechnet ihre Tabelle über `Lmo\Liga\Tabelle`. Die erzeugten Seiten sind unverändert.


### Deprecated  


### Removed  
- `lmo-calctable.php` gibt es nicht mehr. Die Datei hat die Tabelle zuletzt nur noch aus `Lmo\Liga\Tabelle` in die alten Einzelvariablen (`$punkte`, `$tab0` …) übersetzt; keine Seite braucht das mehr. Eigene Erweiterungen rechnen die Tabelle mit `Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, …)`.


### Fixed  


### Security  


***
## [4.4.0] - 2026-10-12

_Hier hätten wir die Changelogs für 4.4.0._  

### Added  
* `Lmo\Liga\Rohdaten\Liga` (mit `Mannschaft`, `Spieltag`, `Partie`): hält den Inhalt einer Ligadatei so, wie er in der Datei steht, und lädt und speichert ihn als Paar. Nichts wird für die Anzeige umgerechnet, ergänzt oder aufgefüllt; unbekannte Schlüssel und Abschnitte bleiben erhalten. Der Kern des LMO lädt und speichert jede Liga darüber.  
* `Lmo\Liga\Einstellungen`: die Einstellungen einer Liga (`[Options]`) mit ihren Vorgabewerten und den berechneten Größen (Spieltage, Partien), ohne die Rohdaten zu ändern. Je Einstellung gibt es eine Methode mit festem Typ (Schalter `bool`, Zahlen `int`, Namen `string`) – `Rohdaten\Liga::lies($pfad)->einstellungen()->mannschaften()`, `->mitVerlaengerung()`. Dazu an den Rohdaten `Mannschaft::anzeigename()`, `Liga::mannschaftsname()` sowie `Spieltag::ersterTag()` und `letzterTag()`. Damit können Seiten direkt auf den Rohdaten arbeiten; die beiden Tippspiel-Lader tun das bereits.  
* `Lmo\Liga\Spiel`: ein Spiel zum Anzeigen, abgeleitet aus den Rohdaten (Tore mit »nicht gespielt«, Wertung am grünen Tisch, Zusatz, Notiz, Anstoß) – `Spiel::ausRohdaten($liga, $spieltag, $partie)`. An der Mannschaft dazu `kurzname()` und `mittelname()`, die einen fehlenden Namen aus dem Namen bilden. Der Hauptlader stellt die Rohdaten als `$lmo_liga` bereit.  
* Zum Durchlaufen mit `foreach`: `Rohdaten\Liga::alleMannschaften()`, `spiele($spieltag)` und `alleSpiele()` liefern vollständig und in der Reihenfolge der Nummern, auch wenn in der Datei etwas fehlt oder anders sortiert ist; im Pokal je Paarung die Spiele des Modus. `Einstellungen::partienImSpieltag()` nennt die Zahl der Partien einer Runde.  
* `Lmo\Liga\Paarung`: zwei Mannschaften und ihre Spiele in einer Runde, mit `sieger()` (ein Spiel, Hin- und Rückspiel, Best of 3/5/7). `Rohdaten\Liga::paarungen($runde)` liefert sie zum Durchlaufen.  
* `Lmo\Liga\Tabelle`: rechnet die Tabelle einer Liga aus den Spielen der Rohdaten – gesamt, heim, auswärts, Hin- und Rückrunde, bis zu einem Spieltag, mit Strafen ab Stichtag, Wertungen am grünen Tisch, Kegel-Sortierung und direktem Vergleich. Die Zeilen (`Tabellenzeile`) haben feste Typen und tragen auch Serien sowie höchsten Sieg und höchste Niederlage (`Rekord`). Aufruf: `Tabelle::berechne($liga, Tabelle::HEIM, 1, 17)`.  

### Changed  
* Die Classlib liest und schreibt Ligadateien über dieselbe Klasse wie der Kern (`Lmo\Liga\Rohdaten\Liga`). Von der Classlib geschriebene Dateien haben dadurch die Abschnittsfolge des Kerns und enthalten immer `[News]`, `[Teamm]` und `[Teamk]`; die Werte sind dieselben. Ob eine Datei Liga oder Pokal ist, entscheidet jetzt auch in der Classlib der Typ der Datei, nicht mehr der Modus der einzelnen Runde.  
* Die Ligalisten (Ligaübersicht, Admin: Öffnen, Löschen, Download, neue Liga, Viewer-Optionen; Tippspiel) lesen Name, Typ und Größe einer Liga über `Lmo\Liga\LigaDatei::liesAbschnitt()` statt über neun eigene Leseschleifen. Leerzeichen um Schlüssel und Wert werden dabei wie beim Laden der Liga entfernt; eine nicht lesbare Datei bricht die Liste nicht mehr ab.  
* Die Spielplanvorlage beim Anlegen einer Liga (»aus Datei übernehmen«) sowie die Tippübersicht und die Erinnerungsmail des Tippspiels lesen Ligadateien über `Lmo\Liga\Rohdaten\Liga` bzw. `Lmo\Liga\LigaDatei` statt über eigene Leseschleifen. Damit liest außer der Classlib und dem Kern niemand mehr eine Ligadatei selbst.  
* Eine Ligadatei wird immer komplett gelesen. Die beiden kleinen Lader des Tippspiels (`lmo-openfilename.php`, `lmo-openfiledat.php`) und der Schalter `$lmo_only_st` lasen bisher nur einzelne Schlüssel bzw. einen Spieltag und hinterließen eine halb gefüllte Liga; jetzt liefern alle Lader dasselbe. Nur die Ligalisten lesen weiterhin allein den Abschnitt `[Options]`. Sichtbar: Eine Liga ohne Namen heißt im Tippspiel nicht mehr »No Name«, sondern hat wie überall sonst keinen Namen. In der Erinnerungsmail für einen Spieltag wird dessen Datum wie im Hauptlader geprüft: `1.9.2024` wird zu `01.09.2024` (bisher leer), ein Datum, das es nicht gibt (`31.02.2025`), wird geleert (bisher auf den 03.03. umgerechnet).  
* Tippübersicht und Erinnerungsmail des Tippspiels führen die anstehenden Spiele als Liste von `Lmo\Tipp\AnstehendesSpiel`. Bisher sammelten sie die Werte mehrerer Ligen als Listen in den Feldern der geladenen Liga (`$ligaDaten->titel`, `->teama` …), die dafür nicht gedacht sind.  
* Die Anzeige-Seiten der Liga arbeiten direkt auf den Rohdaten statt auf `$ligaDaten`: Spielplan einer Mannschaft (`lmo-showprogram.php`), Ergebnisse eines Spieltags (`lmo-showresults.php`), Kalender (`lmo-cal.php`) und Kreuztabelle (`lmo-showcross.php`). Die Ausgabe ist unverändert. `Lmo\Liga\Spiel` hat dafür feste Typen (Tore `?int`, `null` = nicht gespielt) und liefert die Anzeigetexte selbst (`toreHeimText()`, `zusatzText()`).  
* Im Pokal arbeiten der Spielplan einer Mannschaft (`lmo-showkoprogram.php`), die Ergebnisse einer Runde (`lmo-showkoresults.php`) und der Kalender (`lmo-kocal.php`) ebenfalls auf den Rohdaten. Der Kalender richtet seinen Monat jetzt nach dem frühesten Anstoß aller Spiele der gewählten Runde; bisher zählten durch einen Indexfehler nur die Spiele einer einzigen Paarung.  
* Die Tabellenberechnung (`lmo-calctable.php`) rechnet nicht mehr selbst, sondern über `Lmo\Liga\Tabelle` und füllt daraus die bisherigen Variablen. Alle Seiten, die die Tabelle nutzen (Tabelle, Statistik, HTML-Ausgabe, Admin), bekommen dieselben Werte wie zuvor.  
* Adminbereich: Die Seiten tragen ihre Änderungen nach und nach direkt in die Rohdaten der Liga ein und speichern über `lmo-saveliga.php`. `Lmo\Liga\Normalform` ergänzt die Rohdaten dabei zu der vollständigen Datei, die der LMO schreibt (jede Einstellung, jede Mannschaft, jeder Spieltag mit allen Partien); die geschriebene Datei ist dieselbe wie bisher. Schlüssel, die der LMO nicht kennt, bleiben auf diesem Weg auch bei Mannschaften, Spieltagen und Spielen erhalten. Bisher arbeiten so die Tabellenkorrektur (`lmo-admintab.php`, mit ihrer Tabelle über `Lmo\Liga\Tabelle`) die Anzahl der Spieltage und Partien (`lmo-adminanz.php`), die Einstellungen der Liga (`lmo-adminbasic.php`), die Mannschaften (`lmo-adminteams.php`), die Ergebnisse eines Spieltags (`lmo-adminedit.php`) und das Anlegen einer Liga (`lmo-adminnew.php`); eine neue Liga hat damit von Anfang an Mittelnamen für ihre Mannschaften und die (leeren) Einträge für eigene Bezeichnungen von Punkten und Toren, die bisher erst das erste Speichern ergänzte. Die Unternavigation des Adminbereichs liest aus den Rohdaten. Eine Mannschaft anlegen oder aus der Liga nehmen können die Rohdaten selbst (`Rohdaten\Liga::neueMannschaft()`, `entferneMannschaft()`).  
* Die Statistikdatei einer Liga (`lmo-zustat.php`) wird aus den Rohdaten erzeugt. `lmo-savefile.php` rechnet den Stand, der gespeichert wird, einmal in Rohdaten um, gibt ihn an die Statistik weiter und schreibt ihn dann; danach steht er auch in `$lmo_liga`.  
* Das Spieltagsmenü (`lmo-spieltagsmenu.php`), die Spielerstatistik im Adminbereich (`addon/spieler/lmo-statadmin.php`) und die Spielanzeige des Viewer-Addons lesen Spieltage, Art der Liga und Mannschaften aus den Rohdaten bzw. benutzen `$ligaDaten` nicht mehr als Zwischenspeicher.  
* Tippspiel, Erinnerungsmail für eine einzelne Liga (`lmo-tippemail.php`) und der Lader der Tipps eines Spieltags (`lmo-tippopenfile.php`): Spiele, Mannschaften und Einstellungen kommen aus den Rohdaten. Der Lader zählt die Paarungen über `Lmo\Tipp\Tipprunde`, statt sie in `$ligaDaten->anzsp` zu schreiben, und ändert bei einem Tipp mit dem Wert -2 nicht mehr die Wertung des Spiels in der geladenen Liga. Damit greift das Tippspiel nur noch an einer Stelle auf `$ligaDaten` zu: bei der Auswertung direkt nach dem Speichern im Adminbereich.  
* Tippspiel, Speichern der Tipps, Einsicht-Berechnung und Joker-Prüfung (`lmo-tippsavefile.php`, `lmo-tippsaveeinsicht1.php`, `lmo-tippcalceinsicht.php`, `lmo-tippjokeranticheat.php`) nehmen Paarungen, Spiele je Paarung und Anstoßzeiten aus `Lmo\Tipp\Tipprunde`, statt die Paarungen einer Pokalrunde jeweils selbst zu zählen und in `$ligaDaten->anzsp` zu schreiben. Menü, Fußzeile und Überschrift des Tippspiels sowie `lmo-tippopenfileall.php` lesen Art und Name der Liga aus den Rohdaten. Die Ligenliste (`lmo-tippnewdir.php`) bestimmt die Spieltage jeder Liga aus deren eigenen Einstellungen; bisher überschrieb sie damit die Spieltage der geladenen Liga, und eine Liga ohne die Angabe `Rounds` bekam die Zahl der Liga davor.  
* Tippspiel, Tabelle nach den Tipps (`lmo-tipptabelle.php`, `lmo-tippcalctable.php`, `lmo-tippcalctable1.php`, `lmo-tippcalcwertverein.php`): Spiele, Mannschaften, Strafen und Einstellungen kommen aus den Rohdaten. Die Wertung nach Vereinen zählt ihre Vereine selbst, statt die Anzahl der Mannschaften der geladenen Liga zu überschreiben.  
* Tippspiel, Auswertung (`lmo-tippsavewert.php`): Ergebnisse, Wertungen und Einstellungen kommen aus den Rohdaten, die Spiele eines Spieltags über `Lmo\Tipp\Tipprunde`. Nach dem Speichern im Adminbereich wird weiter der gerade eingegebene Stand ausgewertet. Ein Tipp mit dem Wert -2 ändert dabei nicht mehr die Wertung des Spiels (Sieg am grünen Tisch) für diesen und alle folgenden Tipper.  
* Tippspiel, Rangliste und Tipp-Fieberkurve (`lmo-tippwert.php`, `lmo-tippcalcwert.php`, `lmo-tippcalcwertteam.php`, `lmo-tippfieber.php`, `lmo-tippcalcgraph.php`): Die Anzahl der Spieltage kommt aus den Rohdaten. Die Rangliste setzte für die Gesamtwertung bisher die Anzahl der Spieltage der geladenen Liga auf 0, die Fieberkurve schrieb die Nummer des eigenen Tippers in die für die Ligastatistik gewählte Mannschaft; beides entfällt. Die Lader `lmo-openfilename.php` und `lmo-openfiledat.php` stellen dafür wie der Hauptlader `$lmo_liga` bereit.  
* Tippspiel, Tippabgabe für einen Spieltag (`lmo-tippedit.php`, `lmo-tippeditliga.php`, `lmo-tippeditko.php`): Spiele, Mannschaften und Einstellungen kommen aus den Rohdaten. Die Paarungen der Runde liefert `Lmo\Tipp\Tipprunde`, statt dass die Dateien sie über `$ligaDaten->anzsp` teilen. Auch die Einsicht (`lmo-tippeinsicht.php`) arbeitet darauf.  
* Die HTML-Ausgabe zum Drucken (`lmo-savehtml.php`, `lmo-savehtml1.php`) und die Spielerstatistik (`addon/spieler/lmo-statshow.php`) lesen Spiele, Mannschaften und Einstellungen aus den Rohdaten. Die HTML-Ausgabe veränderte dabei bisher die Tore der geladenen Liga im Speicher; das entfällt. Der Inhalt der geschriebenen Dateien ist unverändert und jetzt durch einen eigenen Test (`HtmlExportTest`) festgehalten.  
* Das Ticker-Addon liest seine Ligen direkt als Rohdaten. Bisher lud es jede Liga über den Hauptlader in `$ligaDaten` und überschrieb damit die Liga der Seite, den gewählten Spieltag und bei eigenen Bezeichnungen für Punkte und Tore auch die Sprachtexte.  
* Der Hauptrahmen der öffentlichen Seiten (`lmo-showmain2.php`) liest die Einstellungen der Liga (Menüpunkte, Startseite, Name) aus den Rohdaten. Nur die gewählten Mannschaften im Link zur Statistik kommen weiter aus dem Seitenaufruf.  
* Tabellenseite (`lmo-showtable.php`), der Rahmen für Ergebnisse und Tabelle (`lmo-showrestab.php`) und die Statistik (`lmo-showstats.php`) holen Einstellungen, Mannschaftsnamen, Strafen und Notizen aus den Rohdaten statt aus `$ligaDaten`. Die Tabellenseite arbeitet dabei direkt mit `Lmo\Liga\Tabelle` und ihren Zeilen; der Rahmen rechnet die Tabellen selbst (gewählte Tabelle, Heim- und Auswärtsbilanz, Vorspieltag für die Pfeile) statt viermal `lmo-calctable.php` einzubinden. Auch die Statistik rechnet ihre Tabelle über die Klasse; den Text für höchsten Sieg und höchste Niederlage liefert `Rekord::alsText()`.  
* Die beiden abgespeckten Lader `lmo-openfilename.php` und `lmo-openfiledat.php` benutzen denselben Leser und dieselbe Zuordnung der Schlüssel wie der Hauptlader.  
* Die ganze Ligadatei wird über `Lmo\Liga\LigaDaten` geschrieben; `lmo-savefile.php` enthält nur noch das Öffnen, Sperren und Schreiben der Zeilen. Die geschriebene Datei ist unverändert.  
* News, Spieltage und Partien liest `Lmo\Liga\LigaDaten`; der Lader `lmo-openfile.php` enthält nur noch den Ablauf. Die gelesenen Werte sind unverändert.  
* Auch die Abschnitte der Mannschaften (`[Teams]`, `[Teamk]`, `[Teamm]`, `[Team1]` …) werden über `Lmo\Liga\LigaDaten` gelesen und gespeichert, einschließlich der abgeleiteten Kurz- und Mittelnamen. Gelesene Werte und geschriebene Datei sind unverändert.  
* Welcher Schlüssel des Abschnitts `[Options]` zu welchem Wert der Liga gehört, für Liga oder Pokal gilt und welchen Vorgabewert hat, steht jetzt in einer Tabelle in `Lmo\Liga\LigaDaten`. Der Lader `lmo-openfile.php` und das Speichern in `lmo-savefile.php` benutzen beide diese Tabelle; die geschriebene Datei ist unverändert.  
* Das Format der Ligadatei (Abschnitte, Schlüssel, Werte) liest jetzt eine gemeinsame Klasse (`Lmo\Liga\LigaDatei`), die der Lader `lmo-openfile.php` und die Classlib benutzen.  
* Die Vorgabewerte einer Liga (Punkte je Sieg, Anzahl der Spieltage, Datumsformat …) stehen jetzt in `Lmo\Liga\LigaDaten` statt als rund 60 Einzelzeilen im Lader `lmo-openfile.php`. Am Verhalten ändert sich nichts.  
* Die Werte einer Ligadatei liegen zusätzlich gebündelt in einem Objekt (`Lmo\Liga\LigaDaten`, Variable `$ligaDaten`). Die bisherigen einzelnen Variablen (`$titel`, `$teams`, `$goala` …) bleiben gültig und zeigen auf dieselben Werte. Der gesamte LMO liest und schreibt die Liga jetzt über das Objekt (62 Dateien); an der Ausgabe ändert sich nichts. Eigene Erweiterungen, die die alten Variablen benutzen, funktionieren unverändert.  
* 62 alte Dateien nennen am Dateianfang, welche Variablen sie erwarten. PHPStan prüft damit 33 von ihnen auf Stufe 6 und 31 auf Stufe 1 statt auf Stufe 0.  

### Removed  
* `Lmo\Liga\LigaDaten` (die Variable `$ligaDaten`), `lmo-ligadaten.php` und `lmo-savefile.php` gibt es nicht mehr. Alle Seiten lesen die Liga aus den Rohdaten (`$lmo_liga`, `Lmo\Liga\Rohdaten\Liga`) und speichern über `lmo-saveliga.php`. Damit entfallen auch die alten einzelnen Variablen einer geladenen Liga (`$titel`, `$anzst`, `$anzteams`, `$teams`, `$teama`, `$goala`, `$msieg`, `$stx` …): Der LMO legt sie nicht mehr an. Eigene Erweiterungen, die sie benutzen, müssen auf `$lmo_liga` umgestellt werden, z. B. `$lmo_liga->einstellungen()->spieltage()` statt `$anzst` oder `Lmo\Liga\Spiel::ausRohdaten()` für ein Spiel.  

### Fixed  
* Ergebnisse im Adminbereich, Pokal: Die Seite einer Runde brach mit einem Fatal Error ab („Unsupported operand types: string + string“ in `gewinn()`), wenn in einer Runde davor mit Hin- und Rückspiel bei einer Paarung nur das Rückspiel eingetragen war. Wer ausgeschieden ist, bestimmt die Seite jetzt über `Lmo\Liga\Paarung::sieger()`.  
* Ergebnisse im Adminbereich: Ohne Newszeilen und bei ausgeschaltetem Newsticker bleibt der Abschnitt `[News]` leer. Bisher schrieb diese Seite `NC=0` hinein und jede andere Seite des Adminbereichs nahm es beim nächsten Speichern wieder heraus.  
* Mannschaft löschen im Adminbereich: Torkorrektur, der Spieltag, ab dem eine Strafe gilt, und der Vermerk „nicht tippen“ eines Spiels wandern jetzt mit der Mannschaft bzw. dem Spiel mit. Bisher blieben sie an der alten Nummer stehen und gehörten danach zur nachgerückten Mannschaft bzw. zum nachgerückten Spiel. Fiel die erste Mannschaft der Fieberkurve weg, behielt die nachrückende zweite ihre alte Nummer. In einem Pokal lief das Löschen mit Warnungen und schrieb leere Werte für die Tore. Eine neu angelegte Mannschaft bekommt Kurz- und Mittelnamen sofort, nicht erst beim nächsten Laden.  
* Einstellungen einer Liga im Adminbereich: Eigene Bezeichnungen für Punkte und Tore bleiben leer, wenn keine vergeben sind. Bisher schrieb jeder Reiter außer „Grunddaten“ den Text der gerade eingestellten Sprache (z. B. „Pkt.“) als eigene Bezeichnung in die Datei; nach einem Wechsel der Sprache blieb er stehen. Zweimal dieselbe Mannschaft für die Fieberkurve wird gleich beim Speichern als eine geführt, nicht erst beim nächsten Laden.  
* Statistikdatei: Bei der Anzahl der Spiele mit den meisten Toren zählen nur noch gespielte Spiele. War noch kein Tor gefallen, wurden bisher nach dem Laden einer Liga alle nicht gespielten Spiele mitgezählt, direkt nach dem Anlegen dagegen keines.  
* Tippspiel, Auswertung: Die Tipper und in der Gesamtauswertung die Ligen werden in fester (alphabetischer) Reihenfolge ausgewertet. Bisher hingen die Reihenfolge in den Auswertungsdateien, die Nummern der Ligen in der Gesamtauswertung und der Zwischenstand in den Dateien der Vereinswertung davon ab, in welcher Reihenfolge das Dateisystem die Dateien lieferte.  
* Tippspiel, Erinnerungsmail für eine einzelne Liga: Die noch nicht getippten Spiele stehen jetzt je in einer eigenen Zeile statt ohne Trennung hintereinander. Für einen einzelnen Spieltag wird nur noch dieser durchsucht; bisher kam auch der folgende dazu und wurde mit den Tipps des gewählten verglichen, sodass Spiele in der Mail landeten, die schon getippt waren, und andere fehlten.  
* Tippspiel, Tabelle nach den Tipps: In Ligen mit direktem Vergleich brach die Seite unter PHP 8 mit einem Fatal Error ab (`lmo-tippcalctable1.php`, „Unsupported operand types: string - string“), sobald Mannschaften gleichauf lagen.  
* Classlib, Pokal: Stand in der Datei ein Wert eines Spiels (z. B. die Notiz des Hinspiels) hinter den Toren des nächsten Spiels, wurde er dem falschen Spiel zugeordnet. Sieht der Modus einer Runde mehr Spiele vor, als die Datei nennt, bricht das Laden nicht mehr ab.  
* Einstellungen in `[Options]`, die der LMO nicht kennt (auch `stats`), und ganze unbekannte Abschnitte einer Ligadatei gingen beim Speichern im Admin-Bereich verloren. Sie bleiben jetzt erhalten.  
* Werden in einem Aufruf mehrere Ligen nacheinander geladen, blieben Werte der vorigen Liga stehen, die die nächste Datei nicht nennt (z. B. Strafpunkte einer Liga beim anschließenden Laden eines Pokals). Vor jedem Laden werden jetzt alle Werte geleert.  
* Ein senkrechter Strich (`|`) in einer Notiz, einem Mannschaftsnamen, einer Adresse oder einer Newszeile schnitt beim Laden alles dahinter ab.  
* Tippspiel: Derselbe Fehler in der Tippübersicht und der Erinnerungsmail – ein `|` im Mannschaftsnamen oder in der Notiz schnitt den Rest ab.  
* Tippspiel, Tippübersicht und Erinnerungsmail: Die Werte eines Spiels hingen von der Reihenfolge der Zeilen in der Ligadatei ab. Fehlte einem Spiel eine Angabe (Notiz, Tore, Mannschaft), galt die des vorigen Spiels weiter; im Pokal konnten die Tore des Rückspiels beim Hinspiel landen. Jetzt hat jedes Spiel seine eigenen Werte, und was eine Liga nicht nennt, bekommt den Vorgabewert statt des Werts der zuvor gelesenen Liga.  
* Tippspiel, Tippabgabe für einen Liga-Spieltag: Der Link zum Spielbericht und der Hinweis »Spiel wird für Tippspiel nicht gewertet« in der Notiz fehlten, und die Seite warf PHP-Warnungen (`Undefined variable $n`), sobald Spielberichte eingeschaltet waren.  
* Tippspiel, Tippübersicht, Hinweis-Symbol am Spiel: Der Zusatz zum Ergebnis (n.V., i.E.) fehlte dort immer, der Torfaktor der Liga wurde nicht angewendet und der Link zum Spielbericht zeigte ins Leere.  
* Spielplan einer Mannschaft, Hinweis-Symbol bei einer Wertung am grünen Tisch gegen beide: Das umgekehrte Ergebnis fehlte dort oder stammte von einer anderen Partie des gerade gewählten Spieltags.  
* Ein Spiel ohne Anstoßzeit wurde bei eingeschalteter Anzeige der Anstoßzeit mit »01.01.1970 01:00« angezeigt: in den Ergebnissen eines Spieltags, im Spielplan einer Mannschaft, im Pokal und in der Spieltagsübersicht des Admin-Bereichs. Jetzt bleibt die Zelle leer. Dasselbe gilt für `datumString()` und `zeitString()` der Classlib, die für `0` nun den Text für »keine Zeit« liefern.  
* Fieberkurve: Sie rechnete den Platz je Spieltag mit einer eigenen, älteren Kopie der Tabellenrechnung und zeigte deshalb in Ligen mit direktem Vergleich oder Strafen an einzelnen Spieltagen einen anderen Platz als die Tabelle. Jetzt nutzt sie dieselbe Rechnung (`Lmo\Liga\Tabelle`); die Kurve stimmt mit der Tabelle des jeweiligen Spieltags überein. `lmo-calctable1.php` entfällt.  
* Ein unlesbares Datum im letzten Spieltag einer Ligadatei (z. B. `D1=ab.cd.efgh`) ließ das Laden der Liga abbrechen; es wird jetzt geleert.  
* Classlib (Addons mini, viewer, ticker): Eine eckige Klammer in einem Liganamen, Mannschaftsnamen oder einer Notiz schnitt den Rest des Abschnitts ab (Name gekürzt, Mannschaft oder Zusatz „n. V.“ fehlten). Kommentarzeilen mit `;` am Anfang wurden als Schlüssel gelesen.  
* Tippspiel und Benutzerverwaltung: Fehlte einer Ligadatei die Anzahl der Spieltage (`Rounds`), brach der abgespeckte Lader `lmo-openfilename.php` mit „Division by zero“ ab. Beide abgespeckten Lader ergänzen fehlende Angaben jetzt wie der Hauptlader.  


***
## [4.3.2] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.2._  

### Changed  
* PHPStan prüft die Klassen und Funktionen der Classlib und die Tests jetzt auf Stufe 5.  
* Classlib: Die Typangaben in den Kommentaren stimmen mit dem Verhalten überein (z. B. `team|null` statt `object` bei den Suchfunktionen, `$` vor den Parameternamen). Am Code selbst ändert sich dadurch nichts.  

### Fixed  
* Classlib: Ein unlesbares Spieltagsdatum in der Ligadatei (z. B. `D1=ab.cd.efgh` oder `D1=23.08.`) ließ das Laden der Liga mit einem Fehler abbrechen; es gilt jetzt als fehlend.  
* Classlib: Das Sortieren einer Tabelle ohne Zeilen (`sortTable()`, `sortDirectTable()`) brach mit einem Fehler ab; `getVerlaufTeam()` und `getVerlaufTeams()` liefern für ein Team außerhalb der Liga ein leeres Array statt einer PHP-Warnung.  


***
## [4.3.1] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.1._  

### Added  
* Statische Analyse mit PHPStan (`composer phpstan` bzw. `docker compose run --rm phpstan`, auch in der GitHub-Action): gesamter Code auf Stufe 0, neuer Code auf Stufe 8.  

### Fixed  
* Update-Prüfung: Erlaubt der Server keine Abfragen nach außen (`allow_url_fopen` aus), wird nichts mehr versucht und keine Merkdatei geschrieben; eine beschädigte Merkdatei wird ignoriert.  
* `lmo-install` findet den Autoloader auch beim direkten Aufruf im Git-Checkout (`vendor/` neben `lmo/`).  
* Kalender im Admin-Bereich: Im Mai erschien im Kopf die Abkürzung statt des ausgeschriebenen Monatsnamens.  


***
## [4.3.0] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.0._  

### Added  
* Installation per Composer: `composer require lmo/lmo_php8`, danach richtet `vendor/bin/lmo-install` den LMO im Ordner `lmo` ein. `composer update` aktualisiert ihn dort automatisch; Einstellungen, Ligen und Tipps bleiben erhalten (siehe README).  

### Changed  
* Nur noch eine `composer.json` (im Hauptordner). Lizenz und PHP-Mindestversion liest der LMO jetzt aus `lmo/version.json`; die alte `lmo/composer.json` kann nach einem Update gelöscht werden.  
* Die Versionsnummer kommt aus dem Git-Tag des Composer-Pakets und steht in keiner Datei mehr. Ohne getaggte Version (Git-Checkout) zeigt der LMO `dev`.  
* Die Suche nach einer neuen Version fragt Packagist statt der Prüfdatei auf vest-sport.de: nur noch im Admin-Bereich für den Hauptadmin und höchstens einmal am Tag, nicht mehr bei jedem Seitenaufruf.  
* `pear/html_template_it` in der stabilen Version 1.3.3 statt `dev-master`.  
* Die Update-Seite im Admin-Bereich nennt bei einer neuen Version `composer update` statt eines Download-Links; der Link zur Ankündigung im Forum entfällt.  

### Removed  
* Installation per FTP-Upload des Ordners `lmo`: Der LMO wird nur noch per Composer installiert. Bestehende Installationen lassen sich mit `lmo-install` übernehmen (siehe README).  

### Security  
* Die Composer-Abhängigkeiten liegen nicht mehr im LMO-Ordner (bisher `lmo/vendor`); `lmo-install` sperrt den Ordner `vendor` per `.htaccess`.  


***
## [4.2.1] - 2026-10-10

_Hier hätten wir die Changelogs für 4.2.1._  

### Added  
* Automatische Tests für „Rückrundenspielplan erstellen“ und das Verschieben von Partien im Admin-Bereich.  
* Automatische Tests für das Addon „mini“: Die Minitabelle muss dieselbe Tabelle zeigen wie die Haupttabelle.  
* Automatische Tests für die Addons „viewer“ (Ansicht speichern, Spiele nach Datum und Spieltag, Cache) und „ticker“ (Lauftext mit Wertungen, News).  
* Automatische Tests für das Addon „spieler“ (Spielerstatistik): Spieler und Spalten verwalten, Formelspalten, öffentliche Seite und Druckansicht.  
* Automatische Tests für den Mailversand (Liga per E-Mail, Passwort vergessen im Tippspiel).  
* Automatische Tests für Ticker, Viewer und Mini-Spielplan über mehrere Ligen.  

### Changed  
* PHPMailer wird jetzt über Composer installiert (`phpmailer/phpmailer` 7.1) statt als veränderte Kopie in `lmo/includes`.  
* Entwicklungsumgebung (Docker): lokales Postfach für alle Mails von LMO, Übersichtsseite der Addons mit zwei Beispielligen, Doku in `docker/README.md`.  
* GitHub Action: Die Tests laufen mit PHP 8.0, 8.3, 8.4 und 8.5.  
* PHP 8.5 wird unterstützt (README: PHP 8.0 bis 8.5).  

### Deprecated  

### Removed  
* Reste des PDF-Addons (PDF-Erzeuger der Anleitung unter `help/`, auskommentierte Einbindung) und die unbenutzte Datei `lmo-paintgraph.php`. Das separat erhältliche PDF-Addon lässt sich weiterhin einbinden.  

### Fixed  
* „Rückrundenspielplan erstellen“ bei einer Liga mit ungerader Anzahl Spieltage: Die Fehlermeldung erschien nicht, und die Liga wurde trotzdem neu gespeichert und als erfolgreich gemeldet. Jetzt erscheint die Meldung, gespeichert wird nichts.  
* Minitabelle: Der Aufruf mit den mitgelieferten Standardeinstellungen brach unter PHP 8 mit einem Fehler ab (leere Werte für „Plätze darüber/darunter“). Ohne Liga erscheint jetzt die Meldung „Liga nicht gefunden“ ohne PHP-Warnung.  
* Minitabelle: Am ersten Spieltag wurde eine Tendenz angezeigt, obwohl es keinen Vorspieltag gibt. Jetzt ist sie dort für alle Mannschaften 0.  
* Ticker: Der Hinweis „… bekam den Sieg zugesprochen“ stand nach einem gewerteten Spiel auch bei allen folgenden Spielen des Spieltags.  
* Ticker: Breite und Geschwindigkeit ließen sich beim Einbinden nicht übergeben; die Einstellung „Notizen anzeigen“ wirkte bei Pokal-Ligen nicht.  
* Ticker mit mehreren Ligen: Die Spiele der ersten Liga standen bei jeder weiteren Liga noch einmal. Eine fehlende Liga in der Liste zeigte die Spiele der vorigen statt der Meldung „keine passenden Ligen gefunden“.  
* Mini-Spielplan: PHP-Warnung, wenn die beiden Mannschaften in einer Liga nie aufeinandertreffen. Bei den früheren Begegnungen aus dem Archiv konnte die falsche Mannschaft erscheinen, wenn sich zwei Namen nur in Ziffern unterscheiden (z.B. „TSV Muster“ und „TSV Muster 2“).  
* Viewer: PHP-Warnung beim ersten Aufruf einer Ansicht (Cache-Datei noch nicht vorhanden); im Admin-Formular eine PHP-Warnung, wenn das Ligenverzeichnis nicht `ligen/` heißt.  
* classlib: Werte einer Partie (z.B. Verlängerung, beidseitiges Ergebnis) werden im Ligamodus auch gelesen, wenn sie in der Ligadatei vor den Mannschaften der Partie stehen. Minitabelle und Statistik zeigten für solche Dateien andere Punkte als die Haupttabelle.  
* classlib: Bei völligem Gleichstand (gleiche Punkte und Tore) war die Reihenfolge zufällig. Jetzt steht wie in der Haupttabelle die Mannschaft mit der höheren Nummer vorn.  
* classlib: Die Handicap-Reihenfolge (Option „HandS“) wird jetzt wie in der Haupttabelle auf die Gesamttabelle angewendet. Minitabelle und Statistik zeigten bei solchen Ligen bisher andere Plätze.  
* Spielerstatistik: Eine ungültige Formel erzeugte PHP-Warnungen statt des Fehlertexts, eine unvollständige Formel (z.B. `Tore/`) brach die Admin-Seite ab; außerdem erschienen Reste der Formel als Debug-Ausgabe in der Seite.  
* Spielerstatistik: Die öffentliche Seite und die Druckansicht brachen bei einem nicht-numerischen Seitenanfang ab und warnten bei einer unbekannten Sortierspalte; die Druckansicht warnte, wenn es zur Liga keine Statistik gibt.  
* Mailversand: Ein fehlgeschlagener Versand (Liga per E-Mail; Tippspiel: Rundmail, Freischaltung, Benachrichtigung) endete mit einem Fatal Error statt einer Meldung; bei der Rundmail brach schon eine ungültige Adresse den ganzen Lauf ab.  
* Tippspiel: Links in Mails waren fehlerhaft, wenn der Webserver `REQUEST_SCHEME` nicht liefert, und konnten die Parameter der aktuellen Anfrage enthalten.  
* „Liga per E-Mail“ ohne die PHP-Erweiterung `zip` brach mit einem Fehler ab; jetzt erscheint eine Meldung.  
* „Alle Ligen herunterladen“ brach ohne die PHP-Erweiterung `zip` ebenfalls ab; jetzt erscheint eine Meldung. Das Archiv entsteht im Ausgabeordner statt im Programmverzeichnis.  
* Spielerstatistik: Das Löschen einer Spalte, die es nicht gibt, erzeugte eine PHP-Warnung.  
* Zufallsspielplan: Beim Mischen der Mannschaften wurde gelegentlich neben die Liste gegriffen (bei 6 Mannschaften in etwa jedem siebten Aufruf); im erzeugten Spielplan fehlte dann eine Mannschaft.  
* Admin-Bereich ohne Anmeldung: Die Sprachauswahl erzeugte je Sprache eine PHP-Warnung.  
* Admin-Bereich: Der Aufruf der PDF-Optionen ohne installiertes PDF-Addon endete mit einem Fatal Error.  
* Liga aus einer Vorlage mit mehr Mannschaften anlegen: PHP-Warnungen beim Erzeugen der Statistikdatei; Partien mit Mannschaften, die es in der Liga nicht gibt, wurden mitgezählt.  
* Admin-Bereich: Rief ein Hilfsadmin ohne erweiterte Rechte die Mannschaftsverwaltung auf, erschien der Ergebnis-Editor für einen Spieltag, den es nicht gibt (PHP-Warnungen, unbrauchbares Formular). Jetzt öffnet sich der aktuelle Spieltag.  

### Security  
* Spielerstatistik: Die Parameter für Sortierung, Seite und Mannschaft wurden unmaskiert in die Seite geschrieben (Cross-Site-Scripting).  
* Dateien, die LMO nur einbindet (131 Dateien in `lmo/` und den Addons), beenden sich bei direktem Aufruf im Browser sofort. Bisher liefen sie ohne Konfiguration und Rechteprüfung los und gaben Warnungen, Seitenbruchstücke und teils Fehlermeldungen mit Dateipfaden aus.  


***
## [4.2.0] - 2026-10-10

_Hier hätten wir die Changelogs für 4.2.0._  

### Added  
* Ersteinrichtung ohne Installer: Beim ersten Aufruf wird die Konfiguration aus `config-default/` angelegt, das erste Admin-Konto wird über ein Formular erstellt (Texte dafür in allen Sprachen).  
* Sprachauswahl im Fuß des Admin-Bereichs.  
* Automatische Tests (PHPUnit, Docker, GitHub Action), siehe TESTING.md: Golden-Master-Tests für öffentliche Seiten und Admin-Bereich, Unit-Tests für die classlib, Tabellenvergleich mit 75 echten Ligen (OpenLigaDB, Abschlusstabellen aus Wikipedia) und 10 konstruierten Ligen.  
* classlib: Spieltage merken sich weitere Werte der Ligadatei (`spieltag::setParameter()` / `getParameter()`), z.B. die Handicap-Reihenfolge.  

### Changed  
* Die Mindestanforderung des Webservers beträgt jetzt PHP 8.0 (bisher 7.4). Der Admin-Bereich weist bei älteren PHP-Versionen darauf hin.  
* Seitenquelltextausgabe der beiden Datein lmo-savehtml.php und lmo-savehtml1.php verbessert. Außerdem den Tabellen der beiden Seiten runde Ecken verpasst.  
* Template-System über Composer (`pear/html_template_it`, neue Klasse `LMO_Template`) statt der mitgelieferten Dateien IT.php und ITX.php.  
* Addon-Reiter, Viewer-Vorlagen und Ligalisten im Admin-Bereich erscheinen in fester (alphabetischer) Reihenfolge statt in der des Dateisystems.  
* Wertung „beidseitiges Ergebnis“: Das Ergebnis zählt für beide Mannschaften vollständig aus Sicht der Heimmannschaft (Sieg/Unentschieden/Niederlage, Punkte, Minuspunkte). Bisher wurden nur Spiel und Tore gezählt.  
* Straf-/Bonuspunkte und -tore „ab Spieltag X“ zählen erst, wenn Spieltag X Ergebnisse hat. Bisher wurden sie in der Gesamttabelle sofort eingerechnet.  
* Die classlib rechnet Tabellen jetzt wie die Haupttabelle (direkter Vergleich, Strafen, beidseitiges Ergebnis). Minitabelle und Statistik zeigen damit dieselbe Tabelle.  

### Deprecated  


### Removed  
* Installer (`install/`) entfernt, ebenso die nicht mehr benötigten PEAR-Dateien für FTP, Socket und Cache.  

### Fixed  
* Direkter Vergleich: Gleichstand wurde nur an der letzten Ziffer der Punkte erkannt (59 und 49 Punkte galten als gleich).  
* Direkter Vergleich mit zehn und mehr punktgleichen Teams und Minuspunkten: Das beste Team stand am Ende der Gruppe.  
* classlib: Spielende (n.V./i.E.) wurde aus der Ligadatei nicht gelesen und ging beim Speichern verloren.  
* classlib, direkter Vergleich: Gleichstand am Tabellenende wurde nicht ausgewertet, ein zugesprochener Auswärtssieg falsch gebucht, und es wurden immer alle Spiele der Saison gewertet statt nur die der angezeigten Tabelle (Spieltag, Heim/Auswärts).  
* classlib, Strafen: Strafe entfiel, wenn die Mannschaft am Spieltag des Strafbeginns spielfrei war; Bonus-Gegentore wurden mit falschem Vorzeichen verrechnet; Strafen zählten auch in Heim- und Auswärtstabelle.  
* classlib, Speichern (`writeFile()`, genutzt von „Rückrunde erzeugen“ und „Spieltage verschieben“): Handicap-Reihenfolge, Titel und aktueller Spieltag gingen verloren; ein zweites Speichern im selben Aufruf brach ab; Ligen in Unterordnern wurden danach nicht gefunden (HTML-Export und Statistik ohne Daten).  
* classlib, Statistik: Es wurden auch nicht gespielte Partien gezählt; die Serienanzeige überschrieb ihren eigenen Text.  
* classlib: `ligaFussball::sortTable()` lief unter PHP 8 nur mit Warnungen, `liga::factory()` war nicht aufrufbar, `aktuellerSpieltag()` lieferte den folgenden Spieltag, `strAfterChar()`, `readLigaDir()` (Endung `.L98`) und `HTML_icon()` (Suche nach .jpg/.png mit Alternativtext) korrigiert.  

### Security  
* Cross Site Scripting/XSS Lücke geschlossen   
* `lmo-rueckrunde.php` ließ sich ohne Anmeldung direkt aufrufen und schrieb dann die angegebene Ligadatei neu. Jetzt nur noch für angemeldete Admins.  
* Tippspiel: Neue Passwörter werden mit Argon2id bzw. bcrypt gespeichert.  


***
## [4.1.4] - 2024-10-20

_Hier hätten wir die Changelogs für 4.1.4._  

### Added  
* Grundeinstellung des LMO's geändert. Die Mindestanforderung des Webservers beträgt PHP 7.4.xxx - besser wäre einer größer 8.0.0  
* Erstellung eines KO-Turniers mit 24 Teams möglich (neuer UEFA Modus Champions League, Europa League)  
* Erstellung eines Rückrundenspielplans in einer Liga hinzugefügt (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff Modus kann nun bei KO-Turnieren besser dargestellt und eingestellt werden ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-Up Kalender im Admin Backend auf Mehrsprachig geändert (war vorher fest auf deutsch)  
* TabSprünge bei Eingabe von Daten in KO-Turnieren nach Hinweis von DwB optimiert. 
* Verwendung von [PHPMailer()](https://github.com/PHPMailer/PHPMailer) anstelle von [mail()](https://www.php.net/manual/de/function.mail.php)  
* Sprachdateien aktualisiert (doppelte entfernt bzw. in neue Bezeichnung geändert)  
* Die Flaggen der Sprachauswahl geändert (GIF -> SVG)  
* Ticker Addon nun mit JQuery-Plugin anstelle von eigenem JS >>by [DwB](https://github.com/babbisch)  


### Deprecated  
* utf8_decode() entfernt (mit PHP 8.2.xx deprecated) stattdessen iconv()  



### Removed  
* alte Dateien des Addons Limporter entfernt  


### Fixed  
* Fehler in der Ligastatistik [gefixt](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB
* null-Zugriff vermeiden [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Vermeinden von outOfIndex-Zugriff in liga.class mit Handsortierung [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message für Tipp-Reminder wird als 0 vorbelegt. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP-Warnings im Addon Tippspiel [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Fehler, wenn Passwörter Sonderzeichen wie '@!$' enthalten und diese dann in cfg-Dateien gespeichert werden (z.B. in einem FTP Zugang eines Addons). >>thx [DwB](https://github.com/babbisch)  
* diverse Fehler im Addon Tippspiel gefixt (Dank an alle Helfer)


### Security  


***
## [4.1.2] - 2023-10-26

_Hier hätten wir die Changelogs für 4.1.2.  
Wenn ich Sie mir alle gemerkt hätte, deswegen nur ein Auszug_  

### Added  

### Changed  
* Wechselnde Ausgabe der Heimmannschaft in Best-of-3-, Best-of-5- oder Best-of-7-Playoff-Spielen.  
* Bosnische und kroatische Sprachdateien hinzugefügt (thx franjo)  

### Deprecated  

### Removed  

### Fixed  
* Sprachdateien aktualisiert bzw. geändert
* weitere Fehler im Addon Tippspiel gefixt (leider immer noch nicht fehlerfrei)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Fehler beim erstellen einer NICHT STANDARD Liga  

### Security 


***
***
# League Manager Online (classic design) Change Log (english)  
__All significant changes to the LMO PHP script are documented in this file.__  

## [Unreleased] - YYYY-MM-DD

_Here we write changelog notes for the next version._  

### Added  
- The raw data of a league can be changed through named methods that know the keys and special values of the league file: on the pairing `setzeMannschaften()`, `setzeErgebnis()` (with awarded results), `setzeZusatz()`, `setzeAnstoss()`, `setzeNotiz()`, `setzeBericht()`, `setzeOhneTippwertung()`; on the round `partie()`, `setzeErstenTag()`, `setzeLetztenTag()`, `setzeTabellenkorrektur()`, `setzeSpieleJePaarung()`; on the team `setzeUrl()`, `setzeNotiz()`, `setzeStrafpunkte()`, `setzeStrafminuspunkte()`, `setzeTorkorrektur()`, `setzeStrafeAbSpieltag()`; on the league `setzeEinstellung()` and `setzeNews()`.


### Changed  
- The admin pages enter their changes through these methods instead of the keys of the file (`GA`, `ET`, `HS` …). The written files are unchanged.
- The HTML output for printing (`lmo-savehtml.php`, `lmo-savehtml1.php`) computes its table through `Lmo\Liga\Tabelle`. The generated pages are unchanged.


### Deprecated  


### Removed  
- `lmo-calctable.php` is gone. Lately the file only translated the table from `Lmo\Liga\Tabelle` into the old individual variables (`$punkte`, `$tab0` …); no page needs that any more. Custom extensions compute the table with `Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, …)`.


### Fixed  


### Security  


***
## [4.4.0] - 2026-10-12

_Here we had the changelogs for 4.4.0._  

### Added  
* `Lmo\Liga\Rohdaten\Liga` (with `Mannschaft`, `Spieltag`, `Partie`): holds the content of a league file exactly as it is in the file and loads and saves it as a pair. Nothing is converted for display, added or padded; unknown keys and sections are kept. The core of LMO loads and saves every league through it.  
* `Lmo\Liga\Einstellungen`: the settings of a league (`[Options]`) with their defaults and the computed sizes (rounds, matches), without changing the raw data. Every setting has a method with a fixed type (switches `bool`, numbers `int`, names `string`) – `Rohdaten\Liga::lies($pfad)->einstellungen()->mannschaften()`, `->mitVerlaengerung()`. In addition `Mannschaft::anzeigename()`, `Liga::mannschaftsname()` as well as `Spieltag::ersterTag()` and `letzterTag()` on the raw data. Pages can thereby work directly on the raw data; the two loaders of the prediction game already do.  
* `Lmo\Liga\Spiel`: a game for display, derived from the raw data (goals with "not played", decision at the green table, addition, note, kick-off) – `Spiel::ausRohdaten($liga, $spieltag, $partie)`. In addition `kurzname()` and `mittelname()` on the team, which build a missing name from the name. The main loader provides the raw data as `$lmo_liga`.  
* For iterating with `foreach`: `Rohdaten\Liga::alleMannschaften()`, `spiele($spieltag)` and `alleSpiele()` deliver completely and in the order of the numbers, even if something is missing or sorted differently in the file; in a cup the games of the mode for each pairing. `Einstellungen::partienImSpieltag()` gives the number of matches of a round.  
* `Lmo\Liga\Paarung`: two teams and their games in a round, with `sieger()` (one game, two legs, best of 3/5/7). `Rohdaten\Liga::paarungen($runde)` delivers them for iterating.  
* `Lmo\Liga\Tabelle`: computes the table of a league from the games of the raw data – overall, home, away, first and second half, up to a round, with penalties from their effective round, decisions at the green table, skittles sorting and direct comparison. The rows (`Tabellenzeile`) have fixed types and also carry streaks as well as highest win and highest defeat (`Rekord`). Call: `Tabelle::berechne($liga, Tabelle::HEIM, 1, 17)`.  

### Changed  
* The classlib reads and writes league files through the same class as the core (`Lmo\Liga\Rohdaten\Liga`). Files written by the classlib thereby have the section order of the core and always contain `[News]`, `[Teamm]` and `[Teamk]`; the values are the same. Whether a file is a league or a cup is now decided by the file type in the classlib too, no longer by the mode of the single round.  
* The league lists (league overview, admin: open, delete, download, new league, viewer options; prediction game) read name, type and size of a league through `Lmo\Liga\LigaDatei::liesAbschnitt()` instead of nine reading loops of their own. Blanks around key and value are removed as when loading the league; an unreadable file no longer aborts the list.  
* The schedule template when creating a league ("take over from file") as well as the prediction overview and the reminder mail of the prediction game read league files through `Lmo\Liga\Rohdaten\Liga` or `Lmo\Liga\LigaDatei` instead of reading loops of their own. Apart from the classlib and the core, nothing reads a league file by itself any more.  
* A league file is always read completely. The two small loaders of the prediction game (`lmo-openfilename.php`, `lmo-openfiledat.php`) and the switch `$lmo_only_st` used to read only single keys or one round and left a half-filled league; now all loaders deliver the same. Only the league lists still read just the `[Options]` section. Visible: a league without a name is no longer called "No Name" in the prediction game but has no name, as everywhere else. In the reminder mail for one round its date is checked as in the main loader: `1.9.2024` becomes `01.09.2024` (empty before), a date that does not exist (`31.02.2025`) is cleared (converted to 03.03. before).  
* Prediction overview and reminder mail of the prediction game keep the upcoming games as a list of `Lmo\Tipp\AnstehendesSpiel`. So far they collected the values of several leagues as lists in the fields of the loaded league (`$ligaDaten->titel`, `->teama` …), which are not meant for that.  
* The display pages of a league work directly on the raw data instead of `$ligaDaten`: schedule of a team (`lmo-showprogram.php`), results of a round (`lmo-showresults.php`), calendar (`lmo-cal.php`) and cross table (`lmo-showcross.php`). The output is unchanged. `Lmo\Liga\Spiel` has fixed types for that (goals `?int`, `null` = not played) and delivers the display texts itself (`toreHeimText()`, `zusatzText()`).  
* In a cup the schedule of a team (`lmo-showkoprogram.php`), the results of a round (`lmo-showkoresults.php`) and the calendar (`lmo-kocal.php`) work on the raw data as well. The calendar now picks its month by the earliest kick-off of all games of the selected round; so far, because of an index error, only the games of a single pairing counted.  
* The table calculation (`lmo-calctable.php`) no longer computes by itself but through `Lmo\Liga\Tabelle` and fills the previous variables from it. All pages using the table (table, statistics, HTML output, admin) get the same values as before.  
* Admin area: the pages are moved one by one to entering their changes directly into the raw data of the league and saving through `lmo-saveliga.php`. `Lmo\Liga\Normalform` completes the raw data to the full file LMO writes (every setting, every team, every round with all games); the written file is the same as before. Keys LMO does not know are now kept for teams, rounds and games as well on this path. So far the table correction (`lmo-admintab.php`, computing its table through `Lmo\Liga\Tabelle`) the number of rounds and games (`lmo-adminanz.php`), the league settings (`lmo-adminbasic.php`), the teams (`lmo-adminteams.php`), the results of a round (`lmo-adminedit.php`) and creating a league (`lmo-adminnew.php`) work this way; a new league therefore has medium names for its teams and the (empty) entries for custom point and goal labels from the start, which used to be added by the first save; the sub navigation of the admin area reads from the raw data. Adding a team or taking one out of the league is done by the raw data itself (`Rohdaten\Liga::neueMannschaft()`, `entferneMannschaft()`).  
* The statistics file of a league (`lmo-zustat.php`) is generated from the raw data. `lmo-savefile.php` converts the state being saved to raw data once, hands it to the statistics and then writes it; afterwards it is also available in `$lmo_liga`.  
* The round menu (`lmo-spieltagsmenu.php`), the player statistics in the admin area (`addon/spieler/lmo-statadmin.php`) and the game display of the viewer addon read rounds, league type and teams from the raw data and no longer use `$ligaDaten` as scratch storage.  
* Prediction game, reminder mail for a single league (`lmo-tippemail.php`) and the loader for the predictions of one round (`lmo-tippopenfile.php`): games, teams and settings come from the raw data. The loader counts the pairings through `Lmo\Tipp\Tipprunde` instead of writing them to `$ligaDaten->anzsp`, and a prediction with the value -2 no longer changes the verdict of the game in the loaded league. The prediction game now touches `$ligaDaten` in one place only: the evaluation right after saving in the admin area.  
* Prediction game, saving predictions, the insight calculation and the joker check (`lmo-tippsavefile.php`, `lmo-tippsaveeinsicht1.php`, `lmo-tippcalceinsicht.php`, `lmo-tippjokeranticheat.php`) take pairings, games per pairing and kick-off times from `Lmo\Tipp\Tipprunde` instead of each counting the pairings of a cup round and writing them to `$ligaDaten->anzsp`. Menu, footer and heading of the prediction game and `lmo-tippopenfileall.php` read type and name of the league from the raw data. The league list (`lmo-tippnewdir.php`) determines the rounds of each league from its own settings; it used to overwrite the rounds of the loaded league, and a league without `Rounds` got the number of the league before it.  
* Prediction game, table by predictions (`lmo-tipptabelle.php`, `lmo-tippcalctable.php`, `lmo-tippcalctable1.php`, `lmo-tippcalcwertverein.php`): games, teams, penalties and settings come from the raw data. The ranking by clubs counts its clubs itself instead of overwriting the number of teams of the loaded league.  
* Prediction game, evaluation (`lmo-tippsavewert.php`): results, verdicts and settings come from the raw data, the games of a round through `Lmo\Tipp\Tipprunde`. After saving in the admin area the state just entered is still the one that gets evaluated. A prediction with the value -2 no longer changes the verdict of the game (awarded win) for this and all following tippers.  
* Prediction game, ranking and prediction fever chart (`lmo-tippwert.php`, `lmo-tippcalcwert.php`, `lmo-tippcalcwertteam.php`, `lmo-tippfieber.php`, `lmo-tippcalcgraph.php`): the number of rounds comes from the raw data. For the overall ranking the ranking page used to set the number of rounds of the loaded league to 0, and the fever chart wrote the number of the own tipper into the team chosen for the league statistics; both are gone. The loaders `lmo-openfilename.php` and `lmo-openfiledat.php` now provide `$lmo_liga` like the main loader.  
* Prediction game, entering predictions for one round (`lmo-tippedit.php`, `lmo-tippeditliga.php`, `lmo-tippeditko.php`): games, teams and settings come from the raw data. The pairings of the round come from `Lmo\Tipp\Tipprunde` instead of being shared between the files through `$ligaDaten->anzsp`. The insight page (`lmo-tippeinsicht.php`) works on it as well.  
* The HTML output for printing (`lmo-savehtml.php`, `lmo-savehtml1.php`) and the player statistics (`addon/spieler/lmo-statshow.php`) read games, teams and settings from the raw data. The HTML output used to modify the goals of the loaded league in memory; that is gone. The content of the written files is unchanged and now pinned by a test of its own (`HtmlExportTest`).  
* The ticker addon reads its leagues directly as raw data. So far it loaded every league through the main loader into `$ligaDaten` and thereby overwrote the league of the page, the selected round and, with custom names for points and goals, the language texts as well.  
* The main frame of the public pages (`lmo-showmain2.php`) reads the settings of the league (menu items, start page, name) from the raw data. Only the selected teams in the link to the statistics still come from the request.  
* Table page (`lmo-showtable.php`), the frame for results and table (`lmo-showrestab.php`) and the statistics (`lmo-showstats.php`) take settings, team names, penalties and notes from the raw data instead of `$ligaDaten`. The table page works directly with `Lmo\Liga\Tabelle` and its rows; the frame computes the tables itself (selected table, home and away record, previous round for the arrows) instead of including `lmo-calctable.php` four times. The statistics compute their table through the class as well; the text for highest win and highest defeat comes from `Rekord::alsText()`.  
* The two reduced loaders `lmo-openfilename.php` and `lmo-openfiledat.php` use the same reader and the same key mapping as the main loader.  
* The whole league file is written through `Lmo\Liga\LigaDaten`; `lmo-savefile.php` only contains opening, locking and writing the lines. The written file is unchanged.  
* News, rounds and matches are read by `Lmo\Liga\LigaDaten`; the loader `lmo-openfile.php` only contains the sequence. The values read are unchanged.  
* The team sections (`[Teams]`, `[Teamk]`, `[Teamm]`, `[Team1]` …) are now read and saved through `Lmo\Liga\LigaDaten` as well, including the derived short and medium names. Values read and the written file are unchanged.  
* Which key of the `[Options]` section belongs to which league value, applies to league or cup and has which default now is kept in one table in `Lmo\Liga\LigaDaten`. The loader `lmo-openfile.php` and saving in `lmo-savefile.php` both use this table; the written file is unchanged.  
* The format of the league file (sections, keys, values) is now read by one shared class (`Lmo\Liga\LigaDatei`) that the loader `lmo-openfile.php` and the classlib use.  
* The default values of a league (points per win, number of rounds, date format …) now live in `Lmo\Liga\LigaDaten` instead of about 60 single lines in the loader `lmo-openfile.php`. The behaviour does not change.  
* The values of a league file are additionally bundled in an object (`Lmo\Liga\LigaDaten`, variable `$ligaDaten`). The existing single variables (`$titel`, `$teams`, `$goala` …) stay valid and point to the same values. All of LMO now reads and writes the league through the object (62 files); the output does not change. Own extensions that use the old variables keep working unchanged.  
* 62 old files state at the top which variables they expect. PHPStan thereby checks 33 of them on level 6 and 31 on level 1 instead of level 0.  

### Removed  
* `Lmo\Liga\LigaDaten` (the variable `$ligaDaten`), `lmo-ligadaten.php` and `lmo-savefile.php` are gone. All pages read the league from the raw data (`$lmo_liga`, `Lmo\Liga\Rohdaten\Liga`) and save through `lmo-saveliga.php`. This also removes the old individual variables of a loaded league (`$titel`, `$anzst`, `$anzteams`, `$teams`, `$teama`, `$goala`, `$msieg`, `$stx` …): LMO no longer creates them. Custom extensions using them have to switch to `$lmo_liga`, e.g. `$lmo_liga->einstellungen()->spieltage()` instead of `$anzst`, or `Lmo\Liga\Spiel::ausRohdaten()` for a game.  

### Fixed  
* Results in the admin area, cup: the page of a round aborted with a fatal error ("Unsupported operand types: string + string" in `gewinn()`) when, in an earlier round with two legs, only the second leg of a pairing had been entered. The page now determines who is eliminated through `Lmo\Liga\Paarung::sieger()`.  
* Results in the admin area: without news lines and with the news ticker switched off the `[News]` section stays empty. Until now this page wrote `NC=0` into it and every other admin page removed it again on the next save.  
* Deleting a team in the admin area: goal correction, the round from which a penalty applies and the "do not predict" flag of a game now move with the team or the game. Until now they stayed at the old number and then belonged to the team or game that moved up. If the first team of the fever chart was removed, the second one moving up kept its old number. In a cup the deletion ran with warnings and wrote empty goal values. A newly added team gets its short and medium name right away, not only on the next load.  
* League settings in the admin area: custom labels for points and goals stay empty when none are set. Until now every tab except the basic one wrote the text of the current language (e.g. "Pkt.") into the file as a custom label; it stayed after switching the language. Choosing the same team twice for the fever chart is stored as one right when saving, not only on the next load.  
* Statistics file: only played games count towards the number of games with the most goals. With no goal scored yet, all unplayed games used to be counted after loading a league, but none right after creating it.  
* Prediction game, evaluation: tippers, and in the overall evaluation the leagues, are evaluated in a fixed (alphabetical) order. Until now the order in the evaluation files, the numbers of the leagues in the overall evaluation and the intermediate state in the club ranking files depended on the order in which the file system returned the files.  
* Prediction game, reminder mail for a single league: the games not yet predicted are now listed one per line instead of run together. For a single round only that round is searched; until now the following round was added as well and compared with the predictions of the chosen one, so the mail listed games that had already been predicted and missed others.  
* Prediction game, table by predictions: in leagues with head-to-head comparison the page aborted under PHP 8 with a fatal error (`lmo-tippcalctable1.php`, "Unsupported operand types: string - string") as soon as teams were level.  
* Classlib, cup: if a value of a game (e.g. the note of the first leg) stood in the file after the goals of the next game, it was assigned to the wrong game. If the mode of a round expects more games than the file contains, loading no longer aborts.  
* Settings in `[Options]` that LMO does not know (including `stats`) and whole unknown sections of a league file were lost when saving in the admin area. They are now kept.  
* When several leagues are loaded in one request, values of the previous league remained that the next file does not mention (e.g. penalty points of a league when a cup is loaded afterwards). All values are now cleared before each load.  
* A vertical bar (`|`) in a note, a team name, an address or a news line cut off everything after it when loading.  
* Prediction game: the same bug in the prediction overview and the reminder mail – a `|` in a team name or a note cut off the rest.  
* Prediction game, prediction overview and reminder mail: the values of a game depended on the order of the lines in the league file. If a game lacked a value (note, goals, team), the one of the previous game stayed in effect; in a cup the goals of the second leg could end up at the first leg. Now every game has its own values, and what a league does not state gets the default instead of the value of the league read before.  
* Prediction game, entering predictions for a league round: the link to the match report and the hint that a game does not count for the prediction game were missing, and the page raised PHP warnings (`Undefined variable $n`) as soon as match reports were switched on.  
* Prediction game, prediction overview, hint icon at a game: the addition to the result (a.e.t., on penalties) was always missing there, the goal factor of the league was not applied and the link to the match report led nowhere.  
* Schedule of a team, hint icon for a decision at the green table against both: the reversed result was missing there or came from another match of the currently selected round.  
* A game without kick-off time was shown as "01.01.1970 01:00" when the display of kick-off times was switched on: in the results of a round, in the schedule of a team, in a cup and in the round overview of the admin area. Now the cell stays empty. The same applies to `datumString()` and `zeitString()` of the classlib, which now return the text for "no time" for `0`.  
* Fever chart: it computed the position per round with its own, older copy of the table calculation and therefore showed a different position than the table on single rounds in leagues with direct comparison or penalties. Now it uses the same calculation (`Lmo\Liga\Tabelle`); the chart matches the table of the respective round. `lmo-calctable1.php` is removed.  
* An unreadable date in the last round of a league file (e.g. `D1=ab.cd.efgh`) aborted loading the league; it is now cleared.  
* Classlib (addons mini, viewer, ticker): a square bracket in a league name, team name or note cut off the rest of the section (name shortened, team or the "a.e.t." marker missing). Comment lines starting with `;` were read as keys.  
* Tip game and user administration: if a league file lacked the number of rounds (`Rounds`), the reduced loader `lmo-openfilename.php` aborted with "Division by zero". Both reduced loaders now fill in missing values like the main loader.  


***
## [4.3.2] - 2026-10-11

_Here we had the changelogs for 4.3.2._  

### Changed  
* PHPStan now checks the classes and functions of the classlib and the tests on level 5.  
* Classlib: the types in the comments match the behaviour (e.g. `team|null` instead of `object` for the lookup functions, `$` in front of parameter names). The code itself does not change.  

### Fixed  
* Classlib: an unreadable round date in the league file (e.g. `D1=ab.cd.efgh` or `D1=23.08.`) aborted loading the league with an error; it now counts as missing.  
* Classlib: sorting a table without rows (`sortTable()`, `sortDirectTable()`) aborted with an error; `getVerlaufTeam()` and `getVerlaufTeams()` return an empty array for a team outside the league instead of a PHP warning.  


***
## [4.3.1] - 2026-10-11

_Here we had the changelogs for 4.3.1._  

### Added  
* Static analysis with PHPStan (`composer phpstan` or `docker compose run --rm phpstan`, also in the GitHub action): all code on level 0, new code on level 8.  

### Fixed  
* Update check: if the server does not allow outgoing requests (`allow_url_fopen` off), nothing is tried and no cache file is written; a damaged cache file is ignored.  
* `lmo-install` also finds the autoloader when called directly in a Git checkout (`vendor/` next to `lmo/`).  
* Calendar in the admin area: in May the header showed the abbreviation instead of the full month name.  


***
## [4.3.0] - 2026-10-11

_Here we had the changelogs for 4.3.0._  

### Added  
* Installation with Composer: `composer require lmo/lmo_php8`, then `vendor/bin/lmo-install` sets LMO up in the folder `lmo`. `composer update` keeps it up to date automatically; settings, leagues and tips are kept (see README).  

### Changed  
* Only one `composer.json` is left (in the main folder). LMO now reads license and minimum PHP version from `lmo/version.json`; the old `lmo/composer.json` can be deleted after an update.  
* The version number comes from the Git tag of the Composer package and is no longer kept in a file. Without a tagged version (Git checkout) LMO shows `dev`.  
* The search for a new version asks Packagist instead of the check file on vest-sport.de: only in the admin area for the main admin and at most once a day, no longer on every page request.  
* `pear/html_template_it` in the stable version 1.3.3 instead of `dev-master`.  
* The update page in the admin area names `composer update` for a new version instead of a download link; the link to the forum announcement is gone.  

### Removed  
* Installation by uploading the `lmo` folder via FTP: LMO is now installed with Composer only. Existing installations can be taken over with `lmo-install` (see README).  

### Security  
* The Composer dependencies are no longer inside the LMO folder (previously `lmo/vendor`); `lmo-install` blocks the `vendor` folder with an `.htaccess`.  


***
## [4.2.1] - 2026-10-10

_Here we had the changelogs for 4.2.1._  

### Added  
* Automated tests for "create second half of season" and for moving matches in the admin area.  
* Automated tests for the "mini" addon: the mini table must show the same table as the main table.  
* Automated tests for the addons "viewer" (saving a view, matches by date and by match day, cache) and "ticker" (ticker text with ratings, news).  
* Automated tests for the "spieler" addon (player statistics): managing players and columns, formula columns, public page and print view.  
* Automated tests for sending mail (league by e-mail, forgotten password in the betting game).  
* Automated tests for ticker, viewer and mini schedule across several leagues.  

### Changed  
* PHPMailer is now installed via Composer (`phpmailer/phpmailer` 7.1) instead of the modified copy in `lmo/includes`.  
* Development environment (Docker): local mailbox for all mails sent by LMO, overview page of the addons with two sample leagues, documentation in `docker/README.md`.  
* GitHub Action: the tests run with PHP 8.0, 8.3, 8.4 and 8.5.  
* PHP 8.5 is supported (README: PHP 8.0 to 8.5).  

### Deprecated  

### Removed  
* Remains of the PDF addon (PDF generator of the manual under `help/`, commented-out includes) and the unused file `lmo-paintgraph.php`. The separately available PDF addon can still be plugged in.  

### Fixed  
* "Create second half of season" for a league with an odd number of match days: the error message was not shown, and the league was saved again anyway and reported as successful. Now the message is shown and nothing is saved.  
* Mini table: the call with the shipped default settings aborted with an error under PHP 8 (empty values for "places above/below"). Without a league the message "league not found" is now shown without a PHP warning.  
* Mini table: on the first match day a trend was shown although there is no previous match day. Now it is 0 for all teams there.  
* Ticker: after a match decided by ruling, the note "… was awarded the win" also appeared on all following matches of the match day.  
* Ticker: width and speed could not be passed when including the ticker; the setting "show notes" had no effect for cup leagues.  
* Ticker with several leagues: the matches of the first league were repeated for every further league. A missing league in the list showed the matches of the previous one instead of the message "no matching leagues found".  
* Mini schedule: PHP warning when the two teams never meet in a league. For previous meetings from the archive the wrong team could appear when two names differ only in digits (e.g. "TSV Muster" and "TSV Muster 2").  
* Viewer: PHP warning on the first call of a view (cache file not yet present); a PHP warning in the admin form when the league directory is not named `ligen/`.  
* classlib: values of a match (e.g. extra time, result for both sides) are now also read in league mode when they precede the teams of the match in the league file. For such files the mini table and the statistics showed different points than the main table.  
* classlib: with a complete tie (same points and goals) the order was arbitrary. Now, as in the main table, the team with the higher number comes first.  
* classlib: the handicap order (option "HandS") is now applied to the overall table as in the main table. Until now the mini table and the statistics showed different places for such leagues.  
* Player statistics: an invalid formula produced PHP warnings instead of the error text, an incomplete formula (e.g. `Tore/`) aborted the admin page; in addition, remains of the formula appeared in the page as debug output.  
* Player statistics: the public page and the print view aborted on a non-numeric page start and warned on an unknown sort column; the print view warned when there are no statistics for the league.  
* Sending mail: a failed dispatch (league by e-mail; betting game: circular mail, activation, notification) ended with a fatal error instead of a message; with the circular mail a single invalid address aborted the whole run.  
* Betting game: links in mails were broken when the web server does not provide `REQUEST_SCHEME`, and could contain the parameters of the current request.  
* "League by e-mail" without the PHP extension `zip` aborted with an error; now a message is shown.  
* "Download all leagues" also aborted without the PHP extension `zip`; now a message is shown. The archive is created in the output folder instead of the program directory.  
* Player statistics: deleting a column that does not exist produced a PHP warning.  
* Random schedule: shuffling the teams occasionally accessed an entry outside the list (with 6 teams in about every seventh call); the generated schedule then lacked a team.  
* Admin area without login: the language selection produced a PHP warning per language.  
* Admin area: calling the PDF options without the PDF addon installed ended with a fatal error.  
* Creating a league from a template with more teams: PHP warnings while generating the statistics file; matches with teams that do not exist in the league were counted.  
* Admin area: when a helper admin without extended rights opened the team administration, the result editor appeared for a match day that does not exist (PHP warnings, unusable form). Now the current match day opens.  

### Security  
* Player statistics: the parameters for sorting, page and team were written into the page unescaped (cross-site scripting).  
* Files that LMO only includes (131 files in `lmo/` and the addons) now exit immediately when called directly in the browser. Until now they started without configuration and permission check and printed warnings, page fragments and in some cases error messages with file paths.  


***
## [4.2.0] - 2026-10-10

_Here we had the changelogs for 4.2.0._  

### Added  
* First-time setup without the installer: on the first request the configuration is created from `config-default/`, and the first admin account is created through a form (texts available in all languages).  
* Language selection in the footer of the admin area.  
* Automated tests (PHPUnit, Docker, GitHub Action), see TESTING.md: golden master tests for public pages and the admin area, unit tests for the classlib, table comparison against 75 real leagues (OpenLigaDB, final tables from Wikipedia) and 10 constructed leagues.  
* classlib: match days keep additional values of the league file (`spieltag::setParameter()` / `getParameter()`), e.g. the handicap order.  

### Changed  
* The minimum requirement for the web server is now PHP 8.0 (previously 7.4). The admin area shows a notice on older PHP versions.  
* Improved the page source output of lmo-savehtml.php and lmo-savehtml1.php; the tables on both pages now have rounded corners.  
* Template system via Composer (`pear/html_template_it`, new class `LMO_Template`) instead of the bundled files IT.php and ITX.php.  
* Addon tabs, viewer templates and league lists in the admin area appear in a fixed (alphabetical) order instead of the file system order.  
* Rating "result for both sides": the result counts completely for both teams from the home team's point of view (win/draw/loss, points, minus points). Previously only the match and the goals were counted.  
* Penalty/bonus points and goals "from match day X" only count once match day X has results. Previously they were included in the overall table immediately.  
* The classlib now calculates tables like the main table (head-to-head comparison, penalties, result for both sides). The mini table and the statistics therefore show the same table.  

### Deprecated  


### Removed  
* Removed the installer (`install/`) and the PEAR files for FTP, socket and cache that are no longer needed.  

### Fixed  
* Head-to-head comparison: a tie was detected by the last digit of the points only (59 and 49 points were treated as equal).  
* Head-to-head comparison with ten or more tied teams and minus points: the best team was placed last in its group.  
* classlib: the end of a match (after extra time / penalties) was not read from the league file and was lost when saving.  
* classlib, head-to-head comparison: ties at the bottom of the table were not evaluated, an awarded away win was booked incorrectly, and all matches of the season were counted instead of only those of the displayed table (match day, home/away).  
* classlib, penalties: a penalty was dropped if the team had no match on the match day the penalty starts; bonus goals against were applied with the wrong sign; penalties also counted in the home and away tables.  
* classlib, saving (`writeFile()`, used by "create second half of season" and "move match days"): handicap order, title and current match day were lost; a second save in the same request aborted; leagues in subfolders were not found afterwards (HTML export and statistics without data).  
* classlib, statistics: unplayed matches were counted as well; the streak output overwrote its own text.  
* classlib: `ligaFussball::sortTable()` only ran with warnings under PHP 8, `liga::factory()` could not be called, `aktuellerSpieltag()` returned the following match day; fixed `strAfterChar()`, `readLigaDir()` (extension `.L98`) and `HTML_icon()` (search for .jpg/.png with alternative text).  

### Security  
* Closed a cross site scripting (XSS) vulnerability.  
* `lmo-rueckrunde.php` could be called directly without login and then rewrote the given league file. Now restricted to logged-in admins.  
* Prediction game: new passwords are stored with Argon2id or bcrypt.  


***
## [4.1.4] - 2024-10-20

_Here we had the changelogs for 4.1.4._  

### Added  
* Basic setting of the LMO changed. The minimum requirement of the web server is PHP 7.4.xxx - one higher than 8.0.0 would be better  
* Creation of a knockout tournament with 24 teams possible (new UEFA mode Champions League, Europa League)  
* Added creation of a second half game plan in a league (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff mode can now be displayed and set better in knockout tournaments ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-up calendar in the admin backend changed to multilingual (was previously fixed in German)  
* Optimized tab jumps when entering data in knockout tournaments following advice from DwB.  
* Using [PHPMailer()](https://github.com/PHPMailer/PHPMailer) instead of [mail()](https://www.php.net/manual/de/function.mail.php)  
* Language files updated (duplicate ones removed or changed to new name)  
* Changed the language selection flags (GIF -> SVG)  
* Ticker addon now with JQuery plugin instead of its own JS >>by [DwB](https://github.com/babbisch)


### Deprecated  
* utf8_decode() removed (with PHP 8.2.xx deprecated) iconv() instead  


### Removed  
* Removed old files from the Limporter addon  


### Fixed  
* Bug in league statistics [fixed](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB  
* avoid null access [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Avoid outOfIndex access in liga.class with hand sorting [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message for tip reminder is preset as 0. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP warnings in the addon betting game [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Error when passwords contain special characters like '@!$' and these are then saved in cfg files (e.g. in an FTP access of an addon). >>thx [DwB](https://github.com/babbisch)  
* various errors in the addon betting game fixed (thanks to all helpers)  


### Security  


***
## [4.1.2] - 2023-10-26

_Here we have the changelogs for 4.1.2.  
If only I had remembered them all. So just an excerpt from it._  

### Added  


### Changed  
* Alternating edition of the home team in best-of-3, best-of-5 or best-of-7 playoff games.  
* Added Bosnian and Croatian language files (thx franjo)  


### Deprecated  


### Removed  


### Fixed  
* Language files updated or changed  
* further errors fixed in the addon betting game (unfortunately still not error-free)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Error when creating a NON-STANDARD league  


### Security  
