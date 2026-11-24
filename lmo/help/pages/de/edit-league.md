# Liga bearbeiten

1. [Liga erstellen](#1-liga-erstellen)
2. [Liga öffnen](#2-liga-oeffnen)
3. [Der Ergebniseditor](#3-der-ergebniseditor)
4. [Grundeinstellungen](#4-grundeinstellungen)
5. [Manuelle Tabellensortierung](#5-manuelle-tabellensortierung)
6. [Der Mannschaftseditor](#6-der-mannschaftseditor)

---

## 1. Liga erstellen

Klicke im Menü auf **Neu**, um eine neue Liga anzulegen. Der Prozess läuft in 4 Schritten ab:

**Schritt 1:** Lege den **Dateinamen** der Liga fest – ohne Pfad und Dateiendung, die sind bereits vorgegeben. Die Eingabe darf max. 28 Zeichen lang sein. Gib der Liga einen aussagekräftigen **Namen**, der in den Auflistungen und als Überschrift im Besucher-Bereich erscheint. Neben dem Titel solltest du auch die Saison erwähnen, z. B. `1. Kreisklasse Hinterwelt 2001/02`. Wähle außerdem, ob du eine **Liga** (mit Punkten, Tabelle usw.) oder ein **KO-Turnier** (Playoff o. Ä.) anlegst. Klicke auf **Weiter**.

**Schritt 2:** Lege die **Anzahl der Mannschaften** fest. Bei einer Liga gibst du außerdem die **Anzahl der Spieltage** und die **Spiele pro Spieltag** an. Bei KO-Turnieren entfällt das, da sich diese Werte aus der Mannschaftsanzahl ergeben. Klicke auf **Weiter**.

**Schritt 3:** Bei Ligen folgt jetzt die **Spielplanerstellung**. Du kannst einen Spielplan aus einer anderen Liga übernehmen (das geht nur bei Ligen mit der gleichen Anzahl an Mannschaften, Spielen und Spieltagen), einen **zufälligen Spielplan** generieren (entspricht dem aus dem LM98Free bekannten System und geht nur bei einer „normalen“ Liga, in der jedes Team ein Hin- und ein Rückspiel gegen jeden Gegner hat, wie in der Fußball-Bundesliga) oder ganz darauf verzichten. Bei KO-Turnieren legst du hier den **Spielmodus** der einzelnen Runden fest. Klicke auf **Weiter**.

**Schritt 4:** Die **Liga ist gespeichert!** Als nächstes solltest du die [Mannschaften](#6-der-mannschaftseditor) bearbeiten – sie sind zunächst nur durchnummeriert. Falls du den Spielplan aus einer anderen Liga übernommen hast, wirf vorher einen Blick in den Besucherbereich, um die richtige Zuordnung der Mannschaften herauszufinden.

---

## 2. Liga öffnen

Nach dem [Login](#getting-started/6-login-logout) siehst du direkt eine Übersicht aller verfügbaren Ligen. Alternativ klickst du im Menü auf **Öffnen**. Wähle die Liga aus, die du bearbeiten möchtest. [Hilfs-Admins](#options/hilfs-admins) sehen nur die Ligen, die für sie freigegeben wurden.

---

## 3. Der Ergebniseditor

Nach dem [Öffnen einer Liga](#2-liga-oeffnen) landest du automatisch im Ergebniseditor mit dem aktuellen Spieltag. Über das Auswahlmenü unterhalb des Menüs kannst du auch andere Spieltage aufrufen.

**Datum:** Ganz oben kannst du das **Start- und Enddatum** des Spieltags festlegen. Das Format ist `TT.MM.JJJJ`. Achte darauf, dass das Datum zweistellig für Tag und Monat und vierstellig für das Jahr, durch Punkte getrennt, eingegeben wird. Neben den Datumsfeldern öffnet ein Button einen Popup-Kalender, in dem du das Datum per Klick auswählst. Diese Datumsangaben werden Besuchern nur angezeigt, wenn die [Einstellung](#4-grundeinstellungen) **Spieltagsdatum** aktiv ist.

**Anstoßtermine:** Jedem Spiel kann ein **Anstoßtermin** zugewiesen werden – ebenfalls im Format `TT.MM.JJJJ`, und auch hier gibt es einen Button für den Popup-Kalender. Gibst du ein Datum, aber keine Zeit ein, wird die [Standard-Anstoßzeit](#options/1-globale-optionen) übernommen. Zeitangaben bitte im Format `HH:MM` (zweistellige Stunde und Minute, durch `:` getrennt).

**Mannschaften:** Die Teams wählst du über die Comboboxen aus.

**Ergebnisse eingeben:** Am einfachsten geht's mit den Pfeilbuttons neben den Ergebnisfeldern. Du kannst aber auch direkt Zahlen eintippen oder die Pfeiltasten nutzen, solange der Cursor im Feld steht. Bei aktivierten Nachkommastellen gibst du die Ergebnisse weiterhin als ganze Zahlen ein – die Umrechnung erfolgt erst bei der Ausgabe.

**Spielende:** Bei Ligen mit [offenem Spielende](#4-grundeinstellungen) oder KO-Turnieren gibst du an, wie das Spiel endete: Normal (\_), nach Verlängerung/Overtime (n.V.) oder im Elfmeter-/Penaltyschießen (i.E.).

> **Hinweis:** Bei Sportgerichtsentscheidungen, die sowohl Punkte als auch Tore betreffen (z. B. Aberkennung eines Sieges), brauchst du das folgende Feld nicht zu nutzen.

**Grüne-Tisch-Entscheidung:** Dieses Feld wird normalerweise nicht benötigt. Es gibt aber immer wieder Sportgerichtsentscheidungen, die Spielergebnisse auf den Kopf stellen. Unabhängig vom eingegebenen Ergebnis kannst du hier eine Siegentscheidung einstellen. Die Tore zählen für die Tabelle wie eingegeben, die Punkte richten sich aber nach dieser Einstellung. In der Regel sagt das Sportgericht dann z. B.: 0:0 Tore und Team X gewinnt. Die Option **beidseitiges Erg.** gilt, wenn das Gericht das Spiel für beide Mannschaften gleich entscheidet (z. B. 2:0 für beide).

**Notiz:** Hier kannst du eine Notiz zum Spiel eingeben, z. B. den Spielort. Auch eine normale Sportgerichtsentscheidung kannst du hier erwähnen. Die Sonderfälle der Grüne-Tisch-Entscheidungen musst du nicht nochmal erwähnen, sie werden automatisch als Notiz eingefügt.

**Spielbericht-URL:** Optional kannst du einen Link zum Spielbericht einfügen – er wird nur angezeigt, wenn **Spielberichte verlinken** in den [Einstellungen](#4-grundeinstellungen) aktiv ist.

**Tippspiel:** Falls du das [Tippspiel](#addon-betting-game) nutzt, kannst du einzelne Spiele von der Wertung ausschließen.

**Spieltagsunabhängige Einstellungen:** Unterhalb der Spiele findest du weitere Einstellungen, die du direkt hier anpassen kannst.

**Aktueller Spieltag:** Hier musst du nur etwas ändern, wenn der Spieltag, den du bearbeitest, *nicht* als aktueller Spieltag markiert werden soll, z. B. wenn du ein verlegtes Spiel bearbeitest oder ein älteres Ergebnis korrigierst. Wähle dann den Spieltag aus, der als aktueller gelten soll. Sonst lass das Feld bitte unverändert.

**Newsticker:** Aktiviere den Ticker und trage Meldungen ein – immer eine pro Zeile, ohne Leerzeilen.

Klicke auf **Spieltag und Ticker speichern**, um alles zu übernehmen. Deine Änderungen sind sofort für Besucher sichtbar – also lieber einmal mehr nachschauen!

> Wenn die [manuelle Tabellensortierung](#5-manuelle-tabellensortierung) aktiv ist: Eine vorherige manuelle Sortierung dieses oder späterer Spieltage wird nach dem Speichern aufgehoben.

---

## 4. Grundeinstellungen

Hier legst du alle Einstellungen der Liga fest. Bei KO-Turnieren werden nur die relevanten Optionen angezeigt.

**Grundwerte**
Der **Name der Liga** erscheint in den Auflistungen und als Überschrift im Besucher-Bereich – inkl. Saison, z. B. `1. Kreisklasse Hinterwelt 2001/02`. Außerdem legst du die **Bezeichnung für Punkte und Tore** fest (je nach Sportart anpassbar) und kannst **Kommapunkte/-tore** aktivieren. Wähle auch die **Lieblingsmannschaft** sowie die **Standardmannschaften für Spielplan, Fieberkurve und Statistik**.

**Verlinkungen**
Lege fest, ob [Mannschaftshomepages](#6-der-mannschaftseditor) (in der Tabelle) und [Spielberichte](#3-der-ergebniseditor) (in Ergebnissen und Spielplänen) verlinkt werden sollen.

**Anzeigen/Darstellung**
Hier legst du fest, was du deinen Besuchern anbieten willst. Mit **Startanzeige** bestimmst du, was Besucher beim Laden der Liga zuerst sehen. Du kannst **Spieltagsdatum** und **Anstoßtermine** aktivieren – ohne beides gibt es auch keinen Kalender. Den **Kalender** kannst du aber auch separat deaktivieren. Bei aktiven Anstoßterminen wähle das gewünschte **Anzeigeformat**.

**Spiel um Platz 3** und **Playdown ermöglichen** stehen nur bei KO-Turnieren zur Verfügung. Hier legst du fest, ob ein kleines Finale stattfindet und ob (wie bei Playdowns üblich) auch der Verlierer eine Runde weiterkommen kann.

**Kreuztabelle** und **Fieberkurve** lassen sich deaktivieren. Die Fieberkurve wird im Browser gezeichnet und braucht keine Serverbibliothek. Die Kreuztabelle macht wenig Sinn, wenn es keine Rückspiele gibt (z. B. bei WM-Gruppenspielen).

**Spielsystem**
Das Spielsystem enthält alle Einstellungen, die den Modus der Liga betreffen.

- **Minus-Punkte** gibt es in 2-Punkt-Ligen, in 3-Punkt-Ligen nicht mehr.
- **Spielende offen** musst du nur aktivieren, wenn nach einem Remis eine Verlängerung bzw. Overtime und gegebenenfalls ein Elfmeter-/Penaltyschießen folgt.
- Die Tabellenspalte **Unentschieden** brauchst du nur auszublenden, wenn es in deiner Liga generell kein Unentschieden gibt.
- **Direkter Vergleich** bedeutet, dass bei Punktgleichheit der direkte Vergleich der punktgleichen Mannschaften untereinander berücksichtigt wird.
- **Erzielte Tore zählen vor Tordifferenz** aktivierst du nur, wenn in deiner Liga die erzielten Tore schwerer wiegen als die Tordifferenz, was eher selten der Fall ist.
- Die **Handsortierung der Tabelle** solltest du wirklich nur im Ausnahmefall ermöglichen, z. B. bei Sonderregelungen, die diese Software nicht berücksichtigt. Dann kannst du die [Tabelle manuell korrigieren](#5-manuelle-tabellensortierung).

**Tabelle**
Lege fest, welche Einträge deiner Tabelle (und der Fieberkurve) hervorgehoben oder angezeigt werden sollen:
- Hin-/Rückrundentabellen
- Heim-/Auswärtstabellen
- Meister, Aufsteiger, Absteiger
- Sonstige Markierungen (z. B. UEFA-Cup-Plätze)

Ein Wert von `0` deaktiviert die jeweilige Markierung.

**Punktsystem**
Hier konfigurierst du die Punktevergabe. Bei aktivierten Minuspunkten sind Siegpunkte gleichzeitig negative Niederlagenpunkte und umgekehrt; Remis-Punkte werden zu beiden Seiten gezählt.

**Spieltags- und Spiel-Anzahl**
Diese Funktion brauchst du in der Regel nicht. Falls du die Anzahl der Spieltage oder Spiele nachträglich ändern musst, kannst du das hier tun. Leg dir aber vorher unbedingt [eine Sicherheitskopie](#file-functions/3-download-mailen-einer-liga) an! Bei KO-Turnieren nicht verfügbar.

---

## 5. Manuelle Tabellensortierung

Wenn du die [Einstellung](#4-grundeinstellungen) **Handsortierung der Tabelle ermöglichen** aktiviert hast, erscheint am unteren Rand des [Ergebniseditors](#3-der-ergebniseditor) die Option **Tabelle**. Klicke darauf, um die Tabelle zu prüfen und bei Bedarf manuell zu korrigieren.

Wähle unterhalb des Menüs den Spieltag aus, dessen Tabelle du bearbeiten möchtest. Die Tabelle wird so angezeigt, wie die Software sie berechnet hat. Wenn alles stimmt, musst du nichts tun.

Andernfalls weise den Mannschaften neue Platzierungen zu – jede Platzierung darf nur einmal vorkommen (eine JavaScript-Funktion verhindert Dopplungen normalerweise automatisch).

Klicke anschließend auf **manuelle Tabelle speichern**. Im Besucherbereich wird die Tabelle (und die Fieberkurve) deinen Korrekturen entsprechend angezeigt.

---

## 6. Der Mannschaftseditor

Hier kannst du **Mannschaftsnamen** eingeben und ändern. Das **Kürzel** darf max. 5 Zeichen lang sein.

Falls der Verband Straf- oder Bonuspunkte und Tore vergibt, kannst du diese hier eintragen – sie fließen in die Tabellenberechnung ein. Du kannst auch festlegen, ab welchem Spieltag die Änderung wirksam wird.

Wenn du Mannschaftshomepages verlinken möchtest, trag die URLs in der entsprechenden Spalte ein. Die Links erscheinen in der Tabelle, sofern **Mannschafts-Homepages verlinken** in den [Einstellungen](#4-grundeinstellungen) aktiv ist.

> **Achtung:** Für jede Mannschaft gibt es Funktionen zum **Zurückziehen** aus der Liga und zum **Nachträglichen Hinzufügen** einer neuen Mannschaft. *Leg dir vorher unbedingt [eine Sicherheitskopie](#file-functions/3-download-mailen-einer-liga) an!* Falls du das Tippspiel für diese Liga nutzt, können diese Funktionen zu Fehlfunktionen führen. Bei KO-Turnieren sind diese Optionen nicht verfügbar.

---

© 2026 [Liga Manager Online](https://www.liga-manager-online.org/lmo/)
