<?PHP
/**
 * Liga
 *
 * Bildet das gesammte LigaFile als Objekt ab
 *
 * @package   classLib
 * @version  $Id: liga.class.php 569 2010-09-15 19:53:15Z jokerlmo $
 */
#[\AllowDynamicProperties]
class liga {
    /**
    * Nummer der Liga,
    * @var integer
    * @access private
    */
    var $nr;

    /**
    * @var integer
    * @access private
    */
    var $count;

    /**
    * Mannschaften der Liga,
    * @var array of Team Objects
    * @access public
    */
    var $teams = array();

    /**
    * Name der Liga,
    * @var string|null
    * @access public
    */
    var $name;

    /**
    * Kurzbezeichnung der Liga,
    * @var string
    * @access public
    */
    var $kurz;

    /**
    * @access private
    */
    var $aktSpTag;

    /**
    * Partien der Liga,
    * @var array of Partien Objects
    * @access public
    */
    var $partien = array();

    /**
    * Spieltage der Liga,
    * @var array of Spieltag Objects
    * @access public
    */
    var $spieltage = array();

    /**
    * Vollständiger Pfad und Dateiname der Liga
    * @var string
    * @access public
    */
    var $fileName;

    /**
    * Timestamp des FileDatum
    * @var integer|false Unix-Zeitstempel
    * @access public
    */
    var $ligaDatum;

    /**
    * Inhalt des LigaFiles fileContent[Sektion][key] = value
    * @var array
    * @access private
    */
    var $sections = array();

    /**
    * Spieltage und Tabellenart der Tabelle, die calcTable() gerade sortiert. Der direkte
    * Vergleich (calcTableforTeams) wertet nur diese Partien, wie lmo-calctable1.php.
    * Ausserhalb von calcTable() null: dann zaehlen alle Partien.
    * @var array|null array('rounds' => array(Spieltagsnr => true), 'art' => Tabellenart)
    * @access private
    */
    var $directContext = null;

    /**
    * Einstellungen der Liga (Sektion [Options] der Ligadatei); null, solange keine Liga geladen ist
    * @var optionsSektion|null
    * @access public
    */
    var $options = null;

    /**
    * Konstruktor
    *
    * @param string $name
    * @param string $kurz
    * @return liga
    */
    function __construct($name = '', $kurz = '') {
        $this->name = $name;
        $this->kurz = $kurz;
    }

    /**
    * Datum aus der Ligadatei (TT.MM.JJJJ) als Unix-Zeitstempel um 0 Uhr.
    * Ein fehlendes oder unlesbares Datum ergibt null.
    *
    * @access protected
    * @param mixed $date
    * @return integer|null
    */
    static function dateToTime($date) {
        $parts = explode('.', (string) $date);
        if (count($parts) != 3 || !is_numeric($parts[0]) || !is_numeric($parts[1]) || !is_numeric($parts[2])) {
            return null;
        }
        list($day, $month, $year) = array_map('intval', $parts);
        return checkdate($month, $day, $year) ? mktime(0, 0, 0, $month, $day, $year) : null;
    }

    /**
    * factory
    * die Funktion sucht den Parameter LigaType im Ligafile und gibt passend hierzu ein
    * Object der Klassen liga oder einer der Kindklassen zurück
    *
    * @author markus Doerfling <markus@doerfling.net>
    * @since 2.8 RC2
    * @param string $file Pfad zur Ligadatei (*.l98)
    * @return liga|null ein object passend zum Ligafile, null wenn es die Datei nicht gibt
    */
    static function factory($file) {
        if (!file_exists($file)) {
            return null;
        }
        // LigaType=Handball -> ligaHandball, ohne/unbekannter Typ -> liga
        foreach (file($file) as $configLine) {
            if (preg_match('/^LigaType=(\w+)/', $configLine, $ligaType)) {
                $class = 'liga' . ucfirst(strtolower($ligaType[1]));
                if (class_exists($class) && is_subclass_of($class, 'liga')) {
                    return new $class();
                }
                break;
            }
        }
        return new liga();
    }

    /**
    * Gibt die Anzahl der teilnehmenden Mannschaften zurück
    *
    * @access public
    * @return integer Anzahl der Teilnehmenden Mannschaften
    */
    function teamCount() {
        return count($this->teams);
    }

    /**
    * Fügt ein Teamobjekt zur Liga hinzu
    *
    * @access private
    * @param object $neuesTeam Object des neuen Teams
    */
    function addTeam(&$neuesTeam) {
        $this->teams[] = $neuesTeam; // Das muss so sein
    }

    /**
    * Gibt die Referenz auf das Teamobjekt zu einem Teamnamen zurück
    *
    * @access public
    * @param string $teamName Name des gesuchten Teams
    * @return team|null das gesuchte Team als Object
    */
    function &teamForName($teamName) {
        $count = $this->teamCount();
        $i = 0;
        $found = -1;
        $selectedTeam = null;
        while (($i < $count) && ($found != 0)) {
            $found = strcmp($this->teams[$i]->name, $teamName);
            //     $found = $this->teams[$i]->name == $teamName?0:-1;
            $i++;
        }
        if ($found == 0) {
            return $this->teams[$i - 1];
        }
        return $selectedTeam;
    }

    /**
    * Gibt die Referenz auf das Teamobjekt zu einer Teamnummer zurück
    *
    * @access public
    * @param integer|null $teamNumber Nummer des gesuchten Teams
    * @return team|null
    */
    function &teamForNumber($teamNumber) {
        $result = null;
        if (isset($teamNumber) && $teamNumber > 0 && $teamNumber <= $this->teamCount()) {
            $result = $this->teams[$teamNumber - 1];
        }
        return $result;
    }

    /**
    * Gibt ein Array mit Strings zurück, in dem sämtliche Mannschaftsnamen enthalten sind
    *
    * @access public
    * @return array Alle Namen der Teilnehmenden Mannschaften
    */
    function teamNames() {
        $teamArray = array();
        foreach ((array) $this->teams as $team) {
            $teamArray[] = (string) $team->name;
        }
        return $teamArray;
    }

    /**
    * Gibt die Anzahl der Partien der gesamten Liga
    *
    * @access public
    * @return integer Anzahl der Partien
    */
    function partienCount() {
        return count($this->partien);
    }

    /**
    * Fügt eine Partie zur Liga hinzu
    *
    * @access private
    * @param object $neuePartie Partie die hinzugefügt werden soll
    * @return void
    */
    function addPartie(&$neuePartie) {
        $this->partien[] = $neuePartie;
    }
    /**
    * Gibt die Referenz auf das Partieobjekt zu einer Nummer zurück
    *
    * @access public
    * @param integer|null $number Nummer der gesuchten Partie
    * @return partie|null gesuchte Partie oder null wenn partie nicht gefunden wurde
    */
    function &partieForNumber($number) {
        $result = null;
        // Bugfix 13.10.04    if (isset($number) && $nNumber > 0 && $number <= $this->partienCount())
        if (isset($number) && $number > 0 && $number <= $this->partienCount()) {
            $result = $this->partien[$number - 1];
        }
        return $result;
    }

    /**
    * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
    * aufeinandertreffen
    *
    * @access public
    * @deprecated
    * @see liga::allPartieForTeams
    * @param object $heim TeamObject der Heimmannschaft
    * @param object $gast TeamObject der Gastmannschaft
    * @return partie|null die gesuchte Partie als Object, wenn die Partie nicht gefunden wurde null
    */
    function &partieForTeams(&$heim, &$gast) {
        $partie = $this->allPartieForTeams($heim, $gast, false);
        return $partie[0];
    }

    /**
    * Gibt ein Array von Referenzen auf die Partieobjekte zurück, an denen die Mannschaften
    * aufeinandertreffen - wenn der dritte Parameter both gesetzt ist, werden Partien
    * a vs b UND b vs a zurückgegeben

    * @access public
    * @param object $heim Object der Heimmannschaft
    * @param object $gast Object der Gastmannschaft
    * @param boolean $both Wenn true werden auch Rückspiele zurückgegeben
    * @return array|null Alle gesuchten Partien (Objecte)
    */
    function &allPartieForTeams(&$heim, &$gast, $both = false) {
        $result = array();
        foreach ($this->partien as $aPartie) {
            if (($aPartie->heim == $heim && $aPartie->gast == $gast) || ($both && $aPartie->heim == $gast && $aPartie->gast == $heim)) {
                $result[] = $aPartie;
            }
        }
        if (empty($result[0])) {
            // FIX (PHP 8): "Only variable references should be returned by
            // reference"-Notice bei direktem "return null" in einer
            // function &...().
            $noResult = null;
            return $noResult;
        }
        else {
            return $result;
        }
    }

    /**
    * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
    * mit den anzugebenen Namen aufeinandertreffen
    *
    * @access public
    * @param string $heimName Name der gesuchten Heimmannschaft
    * @param string $gastName Name der gesuchten Gastmannschaft
    * @return partie|null Object der gesuchten Partie
    */
    function &partieForTeamNames($heimName, $gastName) {
        $heimName = strtolower($heimName);
        $gastName = strtolower($gastName);
        $result = null;
        foreach ($this->partien as $aPartie) {
            if ((strtolower($aPartie->heim->name) == $heimName) && (strtolower($aPartie->gast->name) == $gastName)) {
                $result = $aPartie;
                break;
            }
        }
        return $result;
    }

    /**
    * Gibt ein multidim Array zurück, das die sortierten partien enthält,
    * Aufbau array[0..n](
    *     'date' [timestamp des Spieldatums]
    *     'spTag' [integer],
    *     'spieltag' [Object spieltag]
    *     'partie' [Object partie]
    * )
    *
    * @access public
    * @param boolean $roundSort gibr an ob nach Spieltag sortiert werden soll
    * @param integer $sortDir Sortier Richtung (SORT_ASC oder SORT_DESC)
    * @param object $team
    * @return Array
    */
    function gamesSorted($roundSort = true, $sortDir = SORT_ASC, &$team = null) {
        $games = array();
        $sort_1 = array();  // FIX: initialisieren, sonst Undefined variable wenn keine Spiele vorhanden
        $sort_2 = array();  // FIX: initialisieren, sonst Undefined variable wenn keine Spiele vorhanden
        foreach ($this->spieltage as $spieltag) {
            foreach ($spieltag->partien as $partie) {
                if ($partie->heim == $team || $partie->gast == $team || is_null($team)) {
                    $sort_1[] = $partie->zeit;
                    $sort_2[] = $spieltag->nr;
                    $games[] = array(
                      'date' => $partie->zeit,
                      'spTag' => $spieltag->nr,
                      'spieltag' => $spieltag,
                      'partie' => $partie
                    );
                }
            }
        }
        if (empty($games)) {  // FIX: array_multisort auf leere Arrays vermeiden
            return $games;
        }
        if ($roundSort) {
            array_multisort($sort_2, $sortDir, $sort_1, $sortDir, $games);
        }
        else {
            array_multisort($sort_1, $sortDir, $games);
        }
        return $games;
    }

    /**
    * Gibt ein multidim Array zurück, das die sortierten partien einer bestimmten Mannschaft enthält,
    * Aufbau array[0..n](
    *     'spieltag' [Object spieltag]
    *     'partie' [Object partie]
    * )
    *
    * @access public
    * @return Array
    */

    function gamesSortedForTeam($team = null, $roundSort = true, $sortDir = SORT_ASC) {
        if (!is_a($team, 'team')) {  // Wurde nichts angegeben wird das Fav. Team verwendet
            $team = $this->teamForNumber($this->options->keyValues['favTeam']);
        }
        return $this->gamesSorted($roundSort, $sortDir, $team);
    }

    /**
    * Fügt einen Spieltag zur Liga hinzu
    *
    * @access private
    * @param object $neuerSpieltag Object des neuen Spieltags
    * @return void
    */
    function addSpieltag(&$neuerSpieltag) {
        $this->spieltage[] = $neuerSpieltag;
    }

    /**
    * Gibt die Anzahl der Spieltage der Liga zurück
    *
    * @access public
    * @return integer Anzahl der Spieltage
    */
    function spieltageCount() {
        return count($this->spieltage);
    }

    /**
    * Gibt die Referenz des Spieltags mit der angegebenen Nummer zurück
    *
    * @access public
    * @param integer $spTagNr gesuchter Spieltag
    * @return spieltag|null Spieltag der Nummer
    */
    function &SpieltagForNumber($spTagNr) {
        $count = $this->spielTageCount();
        if ($spTagNr > $count) {
            $spTagNr = $count;
        }
        $i = -1;
        $found = -1;
        $selectedTag = null;
        while (($i < $count) && ($found != 0)) {
            $i++;
            if (isset($this->spieltage[$i])) {
                $found = strcmp((string) $this->spieltage[$i]->nr, (string) $spTagNr);
            }
        }
        if ($found == 0) {
            return $this->spieltage[$i];
        }
        // FIX (PHP 8): "Only variable references should be returned by
        // reference"-Notice bei direktem "return null" - $selectedTag ist
        // bereits oben mit null vorinitialisiert.
        return $selectedTag;
    }

    /**
    * Gibt die Referenz des aktuellen Spieltags zurück
    *
    * @access public
    * @return spieltag|null aktueller Spieltag
    */
    function &aktuellerSpieltag() {
        $result = null;
        if (array_key_exists('Actual', $this->options->keyValues)) {
            // Actual zaehlt ab 1, $this->spieltage ab 0
            $aktSpTagNr = (int) $this->options->keyValues['Actual'];
            if ($aktSpTagNr >= 1 && isset($this->spieltage[$aktSpTagNr - 1])) {
                $result = $this->spieltage[$aktSpTagNr - 1];
            }
        }
        return $result;
    }

    /**
    * Gibt Partienen HTML Formatiert direkt aus
    *
    * @access public
    * @return void
    */
    function showPartienHTML() {
        echo "<BR>Liga = $this->name";
        foreach ($this->partien as $partie) {
            $partie->showDetailsHTML();
        }
    }

    /**
    * DEBUGGING: Gibt Details des Spieltages aus
    *
    * @access public
    * @return void
    */
    function showDetails() {
        echo "LigaName = $this->name\n";
        foreach ($this->spieltage as $spTag) {
            $spTag->showDetails();
        }
    }

    /**
    * Gibt Details des Spieltages HTML Formatiert direkt aus
    *
    * @access public
    * @return void
    */
    function showDetailsHTML() {
        echo "<BR>Liga = $this->name";
        foreach ($this->spieltage as $spTag) {
            $spTag->showDetailsHTML();
        }
    }

    /**
    * Gibt das FileDatum als String zurück. Wird keine Formatierung angegeben,
    * wird die Standardformatierung aus den Ligaoptionen verwendet
    *
    * @access public
    * @see date()
    * @param string $dateFormat gewünschtes Ausgabeformat (siehe date())
    * @return String
    */
    function ligaDatumAsString($dateFormat = null) {
        $dateFormat = !is_null($dateFormat) ? $dateFormat : $this->options->keyValues['DatF'];
        return date($dateFormat, $this->ligaDatum);
    }

    /**
    * Prüft ob die Option exestiert und gibt diese zurück
    *
    * Prüft ob die Option exestiert und wenn ja wird diese Option zurückgegeben
    * und aus dem Array gelöscht
    *
    * @access public
    * @param string $key gewünschte Option
    * @param array|null $array array mit den Optionen
    * @return string
    */
    function getIniData($key, &$array, $partie = null) {
        $result = '';
        if (is_array($array)) {
            if (!is_null($partie) && array_key_exists($key, $array[$partie])) {
                $result = $array[$partie][$key];
                unset($array[$partie][$key]); // löschen da jetzt bekannt
            }
            elseif (array_key_exists($key, $array)) {
                $result = $array[$key];
                unset($array[$key]); // löschen da jetzt bekannt
            }
        }
        return $result;
    }


    /**
    * Lädt das angegebene LigaFile und erstellt den Objektbaum
    *
    * @access public
    * @param string $fileName Pfad zum Ligafile (*.l98)
    * @return Boolean
    */
    function loadFile($fileName = '') {
        $iniData = array();
        $status = false;  // FIX: initialisieren, sonst Undefined variable wenn Datei nicht existiert
        if (file_exists($fileName) && !empty($fileName) && !is_dir($fileName)) {
            $this->ligaDatum = filemtime($fileName);
            // ligaFile in einen kompletten String einlesen
            $ligaFile = implode('', file($fileName));
            // sectionen suchen und die einzelnen Sectionen in Array $sections speichern
            preg_match_all('/^\[([^\]]+)+\][^\[]+/m', $ligaFile, $sections, PREG_PATTERN_ORDER);
            for ($y = 0; $y < count($sections[0]); $y++) {
                // Parameter und werte trennen
                preg_match_all('/^([^=\[]+)=(.*)/m', $sections[0][$y], $parameter, PREG_PATTERN_ORDER);
                // Modus des Spieltags (MO): 0/leer = Liga, sonst Pokal mit mehreren Spielen je Paarung
                $roundModus = 0;
                foreach ($parameter[1] as $moIndex => $moKey) {
                    if (trim($moKey) == 'MO') {
                        $roundModus = (int) trim($parameter[2][$moIndex]);
                    }
                }
                for ($i = 0, $partieNumber = 0; $i < count($parameter[0]); $i++) {
                    // Spieltagswerte ohne Partienummer: D1, D2 und Schluessel nur aus Buchstaben (MO, HS)
                    if (!str_contains(strtolower($sections[1][$y]), 'round') || preg_match('/^D[12]$|^[A-Za-z]+$/', trim($parameter[1][$i]))) {
                        // andere Section oder SpieltagParameter
                        $iniData[$sections[1][$y]][trim($parameter[1][$i])] = trim($parameter[2][$i]);
                    }
                    else {
                        // Partie Filtern
                        if (!preg_match('/([a-zA-Z]+)([\d]+)/', trim($parameter[1][$i]), $infoPerPartie)) {
                            continue; // Parameter passt nicht zum erwarteten Format
                        }
                        // $infoPerPartie -> 0 kompletter treffer / 1 Art des Parameters (GA/GB ...) / 2 Nummer der Partie
                        if ($roundModus < 1) {
                            // Liga: die Nummer im Schluessel ist die Partie (SP3 gehoert zu TA3), unabhaengig
                            // von der Reihenfolge der Zeilen - wie lmo-openfile.php
                            $ligaPartie = (int) $infoPerPartie[2];
                            if (preg_match('/^T[AB]$/', $infoPerPartie[1])) {
                                $iniData[$sections[1][$y]][$ligaPartie][$infoPerPartie[1]] = trim($parameter[2][$i]);
                            }
                            else {
                                if ($infoPerPartie[1] == 'GA') {
                                    $iniData[$sections[1][$y]][$ligaPartie][1]['SpNr'] = $infoPerPartie[2];
                                }
                                $iniData[$sections[1][$y]][$ligaPartie][1][$infoPerPartie[1]] = trim($parameter[2][$i]);
                            }
                            continue;
                        }
                        // Pokal: GA11, GA12 ... die Nummer ist mehrdeutig, zugeordnet wird ueber die Reihenfolge
                        if (!isset($gameNumber)) $gameNumber = 0;
                        if ($infoPerPartie[1] == 'TA') {
                            $partieNumber++;
                            $gameNumber = 0;
                        }
                        if (preg_match('/^T[AB]$/', $infoPerPartie[1])) {
                            $iniData[$sections[1][$y]][$partieNumber][$infoPerPartie[1]] = trim($parameter[2][$i]);
                        }
                        else {
                            if ($infoPerPartie[1] == 'GA') {
                                $gameNumber++;
                                $iniData[$sections[1][$y]][$partieNumber][$gameNumber]['SpNr'] = $infoPerPartie[2];
                            }
                            $iniData[$sections[1][$y]][$partieNumber][$gameNumber][$infoPerPartie[1]] = trim($parameter[2][$i]);
                        }
                    }
                }
            }

            $tCounter = 1;
            foreach ($iniData['Teams'] as $key => $value) {
                if (isset($iniData['Team' . $tCounter]) && $iniData['Team' . $tCounter] != '') {
                    $teamKurz = $iniData['Teamk'][$key];
                    $teamMittel = isset($iniData['Teamm'][$key]) ? $iniData['Teamm'][$key] : '';
                    $team = new team($value, $teamKurz, $key, $teamMittel);
                    $teamDetails = $iniData['Team' . $tCounter];
                    foreach ($teamDetails as $detailsKey => $detailsValue) {
                        if ($detailsKey != '') {
                            $team->keyValues[$detailsKey] = $detailsValue;
                        }
                    }
                    $this->addTeam($team);
                    unset($iniData['Team' . $tCounter]);  // weg damit weil bekannt
                    $tCounter++;
                }
            }
            unset($iniData['Teams']);  // weg damit weil bekannt
            unset($iniData['Teamk']);  // weg damit weil bekannt
            unset($iniData['Teamm']);  // weg damit weil bekannt
            if (isset($_GET['clibd']) && $_GET['clibd'] == 1) {
                echo '<pre>classlib ' . CLASSLIB_VERSION_NR
                    . " loadFile($fileName) call from File " . $_SERVER['PHP_SELF'] . '<pre>';
            }
            // Partien einlesen
            $rCounter = 1;
            while (!empty($iniData['Round' . $rCounter])) {
                $roundSektion = 'Round' . $rCounter;
                $startTime = self::dateToTime($this->getIniData('D1', $iniData[$roundSektion]));
                $endTime = self::dateToTime($this->getIniData('D2', $iniData[$roundSektion]));

                $spieltag = new spieltag($rCounter, $startTime, $endTime);
                // Modus des Spieltags
                $spieltag->setModus($this->getIniData('MO', $iniData[$roundSektion]));
                // weitere Spieltagswerte (z.B. HS = Handicap-Reihenfolge) unveraendert merken
                foreach ($iniData[$roundSektion] as $roundKey => $roundValue) {
                    if (is_string($roundKey)) {
                        $spieltag->setParameter($roundValue, $roundKey);
                        unset($iniData[$roundSektion][$roundKey]);
                    }
                }
                for ($pCounter = 1; isset($iniData[$roundSektion][$pCounter]['TA']); $pCounter++) {
                    $heimTeam = &$this->teamForNumber((int) $this->getIniData('TA', $iniData[$roundSektion], $pCounter));
                    $gastTeam = &$this->teamForNumber((int) $this->getIniData('TB', $iniData[$roundSektion], $pCounter));
                    $partienNumber = 0;
                    do {  // if ($spieltag->getModus() < 1)
                        $theim = $this->getIniData('GA', $iniData[$roundSektion][$pCounter], ++$partienNumber);
                        $tgast = $this->getIniData('GB', $iniData[$roundSektion][$pCounter], $partienNumber);
                        $notiz = $this->getIniData('NT', $iniData[$roundSektion][$pCounter], $partienNumber);
                        $zeit  = $this->getIniData('AT', $iniData[$roundSektion][$pCounter], $partienNumber);

                        if (!$spielNr = $this->getIniData('SpNr', $iniData[$roundSektion][$pCounter], $partienNumber)) {
                            $spielNr = strval($pCounter) . strval($partienNumber);
                        }

                        if ($partienNumber % 2) {
                            $partie = new partie($spielNr, $zeit, $notiz, $heimTeam, $gastTeam, $theim, $tgast);
                        }
                        else {
                            $partie = new partie($spielNr, $zeit, $notiz, $gastTeam, $heimTeam, $theim, $tgast);
                        }

                        // Spielbericht
                        $partie->setreportUrl($this->getIniData('BE', $iniData[$roundSektion][$pCounter], $partienNumber));
                        // Spielende (normal / n.V. / n.E ...)
                        // aus der Datei kommt ein String, setSpielEnde() erwartet int
                        $partie->setSpielEnde((int) $this->getIniData('SP', $iniData[$roundSektion][$pCounter], $partienNumber));
                        // Alle Anderen bisher unbekannten Parameter
                        $partie->setParameter($iniData[$roundSektion][$pCounter][$partienNumber]);
                        $this->addPartie($partie);  // Partien werden zusätzlich zu der Liga hinzugefügt
                        $spieltag->addPartie($partie);
                    }
                    while ($partienNumber < $spieltag->getModus());
                }
                $this->addSpieltag($spieltag);
                unset($iniData[$roundSektion]); // weg damit weil bekannt
                $rCounter++;
            }
            // Options einlesen erst zum schluss um teams,rounds zu setzen
            $optionDetails = $iniData['Options'];
            $options = new optionsSektion($this, $optionDetails);

            // Liganame setzen
            if (isset($optionDetails['Name']) && $optionDetails['Name'] != '') {
                if ($this->name == '') {
                    $this->name = $optionDetails['Name'];
                }
                else {
                    $optionDetails['Name'] = $this->name;
                }
            }
            foreach ($optionDetails as $detailsKey => $detailsValue) {
                if ($detailsKey != '') {
                    $options->keyValues[$detailsKey] = $detailsValue;
                }
            }
            $this->options = &$options;
            unset($iniData['Options']);  // weg damit weil bekannt
            $this->sections = $iniData;  // unbekannte Sectionen speichern
            $this->fileName = $fileName;
            $this->ligaDatum = filemtime($fileName);
            $status = true;
        }
        return $status;
    }

    /**
    * Lädt eine Liga aus der MySQL/MariaDB-Datenbank und erstellt denselben
    * Objektbaum wie loadFile() (teams, spieltage, partien, options).
    *
    * Drop-in-Ersatz für loadFile() im Viewer-Addon (DB-Migration):
    *   $liga = new liga();
    *   $liga->loadFromDb($pdo, 'bundesliga.l98');           // subdir=''
    *   $liga->loadFromDb($pdo, 'bundesliga.l98', 'archiv/'); // mit subdir
    *
    * @access public
    * @param mixed $pdo bestehende Datenbankverbindung (PDO); alles andere ergibt false
    * @param string $fileName Dateiname der Liga (z.B. "bundesliga.l98"),
    *                          ENTSPRICHT lmo_ligen.file_name. Kann auch einen
    *                          Pfad wie "archiv/bundesliga.l98" enthalten,
    *                          dann wird $subdir daraus abgeleitet.
    * @param string $subdir Unterordner relativ zu dirliga (z.B. "archiv/"),
    *                        entspricht lmo_ligen.subdir
    * @return Boolean
    */
    function loadFromDb($pdo, $fileName = '', $subdir = '') {
        $status = false;
        if (!($pdo instanceof PDO) || $fileName === '') {
            return $status;
        }

        // FIX: Alle DB-Zugriffe in try/catch - eine fehlende Tabelle
        // (z.B. unvollständiges Schema) oder ein DB-Fehler durfte hier nicht
        // als unbehandelte PDOException bis zum Aufrufer durchschlagen
        // (Fatal Error -> HTTP 500). loadFromDb() liefert in diesem Fall
        // analog zu loadFile() bei fehlender Datei einfach false zurück.
        try {

        // Pfadanteil aus $fileName herauslösen, falls vorhanden
        // (z.B. "archiv/bundesliga.l98" -> subdir="archiv/", file="bundesliga.l98")
        $file = $fileName;
        if (str_contains($file, '/')) {
            $subdir = rtrim(dirname($file), '/') . '/';
            $file   = basename($file);
        }
        $subdir = ($subdir === '' || $subdir === '/') ? '' : $subdir;

        // ── Liga-Datensatz laden ─────────────────────────────────────────────
        $stmtLiga = $pdo->prepare("
            SELECT * FROM lmo_ligen
            WHERE subdir = ? AND file_name = ?
            LIMIT 1
        ");
        $stmtLiga->execute([$subdir, $file]);
        $row = $stmtLiga->fetch();

        if (!$row && $subdir !== '') {
            // Fallback: ohne Subdir versuchen (wie lmo-openfile-db.php)
            $stmtLiga->execute(['', $file]);
            $row = $stmtLiga->fetch();
        }

        if (!$row) {
            return $status;
        }

        $ligaId = (int) $row['id'];
        $lmtype = (int) $row['lmtype'];

        // ── Teams laden ──────────────────────────────────────────────────────
        $stmtTeams = $pdo->prepare("
            SELECT * FROM lmo_teams WHERE liga_id = ? ORDER BY team_nr
        ");
        $stmtTeams->execute([$ligaId]);
        $teamRows = $stmtTeams->fetchAll();

        // Map team_nr -> team-Objekt (für Verweise aus den Spielen)
        $teamsByNr = array();
        foreach ($teamRows as $t) {
            $nr     = (int) $t['team_nr'];
            $name   = stripslashes($t['name_lang']);
            $kurz   = $t['name_kurz']   ?: '';
            $mittel = $t['name_mittel'] ?: '';

            $team = new team($name, $kurz, $nr, $mittel);

            // Strafen / Bonuswerte aus lmo_teams (nur Liga-Modus relevant,
            // siehe optionsSektion-Defaults SP/SM/TOR1/TOR2/STDA)
            $team->keyValues['SP']   = (int) ($t['strafp'] ?? 0);
            $team->keyValues['SM']   = (int) ($t['strafm'] ?? 0);
            $team->keyValues['TOR1'] = (int) ($t['torkorrektur1'] ?? 0);
            $team->keyValues['TOR2'] = (int) ($t['torkorrektur2'] ?? 0);
            $team->keyValues['STDA'] = $t['strafdat'] ?: 0;
            $team->keyValues['URL']  = $t['url']      ?: '';
            $team->keyValues['NOT']  = $t['notiz']    ?: '';

            $this->addTeam($team);
            $teamsByNr[$nr] = &$this->teams[count($this->teams) - 1];
        }

        // ── Spieltage + Spiele laden ─────────────────────────────────────────
        $stmtRunden = $pdo->prepare("
            SELECT * FROM lmo_spieltage WHERE liga_id = ? ORDER BY runde_nr
        ");
        $stmtRunden->execute([$ligaId]);
        $rundenRows = $stmtRunden->fetchAll();

        if ($lmtype == 0) {
            $stmtSpiele = $pdo->prepare("
                SELECT * FROM lmo_spiele WHERE liga_id = ? ORDER BY runde_nr, match_nr
            ");
        } else {
            $stmtSpiele = $pdo->prepare("
                SELECT * FROM lmo_spiele WHERE liga_id = ? ORDER BY runde_nr, match_nr, ko_slot
            ");
        }
        $stmtSpiele->execute([$ligaId]);
        $spielRows = $stmtSpiele->fetchAll();

        // Spiele nach runde_nr gruppieren
        $spieleByRunde = array();
        foreach ($spielRows as $sp) {
            $spieleByRunde[(int) $sp['runde_nr']][] = $sp;
        }

        foreach ($rundenRows as $rd) {
            $rundeNr = (int) $rd['runde_nr'];

            // Start-/Endzeit der Runde als Unix-Timestamp (analog loadFile():
            // dort wird D1/D2 im Format dd.mm.yyyy erwartet; in der DB liegen
            // datum1/datum2 als Y-m-d vor)
            $startTime = null;
            if (!empty($rd['datum1'])) {
                $ts = strtotime($rd['datum1']);
                if ($ts !== false) $startTime = $ts;
            }
            $endTime = null;
            if (!empty($rd['datum2'])) {
                $ts = strtotime($rd['datum2']);
                if ($ts !== false) $endTime = $ts;
            }

            $spieltag = new spieltag($rundeNr, $startTime, $endTime);
            if ($lmtype == 0) {
                $spieltag->setModus(0);
            } else {
                $spieltag->setModus((int) ($rd['modus'] ?? 1));
            }

            foreach ($spieleByRunde[$rundeNr] ?? array() as $sp) {
                $heimNr = (int) $sp['team_a'];
                $gastNr = (int) $sp['team_b'];

                // KO-Modus: Spiele mit team_a=NULL und team_b=NULL sind noch nicht
                // vergeben (z.B. Halbfinale bevor die Paarungen feststehen).
                // Diese Platzhalter-Slots werden übersprungen, analog zum
                // loadFile()-Verhalten (dort werden TA=0/TB=0-Zeilen nie als
                // Partie angelegt).
                if ($lmtype !== 0 && $heimNr === 0 && $gastNr === 0) {
                    continue;
                }

                // FIX: teamForNumber() liefert null, falls Team-Nr unbekannt
                // (z.B. noch nicht angelegte Slots) - dann Platzhalter-Team
                // verwenden, damit $partie->heim/->gast nie null sind und
                // spätere ->name/->nr Zugriffe nicht mit
                // "Attempt to read property on null" abbrechen.
                if (isset($teamsByNr[$heimNr])) {
                    $heimTeam = &$teamsByNr[$heimNr];
                } else {
                    $placeholder = new team('', '', $heimNr, '');
                    $heimTeam = $placeholder;
                }
                if (isset($teamsByNr[$gastNr])) {
                    $gastTeam = &$teamsByNr[$gastNr];
                } else {
                    $placeholder = new team('', '', $gastNr, '');
                    $gastTeam = $placeholder;
                }

                $goalA = $sp['goal_a'];
                $goalB = $sp['goal_b'];
                $hTore = ($goalA === '_' || $goalA === '' || $goalA === null) ? -1 : (int) $goalA;
                $gTore = ($goalB === '_' || $goalB === '' || $goalB === null) ? -1 : (int) $goalB;

                $zeit = !empty($sp['anstoss_ts']) ? (int) $sp['anstoss_ts'] : null;
                $notiz = $sp['notiz'] ?? '';

                $spielNr = (int) $sp['match_nr'];

                $partie = new partie($spielNr, $zeit, $notiz, $heimTeam, $gastTeam, $hTore, $gTore);
                $partie->setreportUrl($sp['bericht'] ?? '');

                // 'spez' in lmo_spiele kodiert n.V./i.E. (1/2), entspricht
                // SP im .l98-Format -> spielEnde
                $spezVal = (int) ($sp['spez'] ?? 0);
                $partie->setSpielEnde($spezVal);

                $this->addPartie($partie);
                $spieltag->addPartie($partie);
            }

            $this->addSpieltag($spieltag);
        }

        // ── Options-Sektion aufbauen ──────────────────────────────────────────
        // Mapping lmo_ligen-Spalten -> .l98-Options-Keys (siehe optionsSektion
        // Default-keyValues sowie lmo-openfile-db.php für dieselbe Zuordnung)
        $optionDetails = array(
            'Title'         => "<acronym title='Liga Manager Online " . (defined('CLASSLIB_VERSION') ? CLASSLIB_VERSION : '') . "'>LMO</acronym>",
            'Name'          => $row['liga_name'],
            'Type'          => $lmtype,
            'Teams'         => (int) $row['anz_teams'],
            'Rounds'        => count($rundenRows),
            'Matches'       => $this->spieltageMaxPartien(),
            'Actual'        => (int) $row['aktueller_st'],
            'Kegel'         => (int) $row['kegel'],
            'HandS'         => (int) $row['hands'],
            'PointsForWin'  => (int) $row['pns'],
            'PointsForDraw' => (int) $row['pnu'],
            'PointsForLost' => (int) $row['pnn'],
            'XtraS'         => (int) $row['pxs'],
            'XtraU'         => (int) $row['pxu'],
            'XtraV'         => (int) $row['pxn'],
            'SpezS'         => (int) $row['pps'],
            'SpezU'         => (int) $row['ppu'],
            'SpezV'         => (int) $row['ppn'],
            'Spez'          => (int) $row['spez'],
            'HideDraw'      => (int) $row['hidr'],
            'OnRun'         => (int) $row['onrun'],
            'MinusPoints'   => (int) $row['minus'],
            'Direct'        => (int) $row['direkt'],
            'Champ'         => (int) $row['champ'],
            'CL'            => (int) $row['anzcl'],
            'CK'            => (int) $row['anzck'],
            'UC'            => (int) $row['anzuc'],
            'AR'            => (int) $row['anzar'],
            'AB'            => (int) $row['anzab'],
            'namePkt'       => $row['name_pkt'] ?: 'Pkt.',
            'nameTor'       => $row['name_tor'] ?: 'Tore',
            'DatC'          => (int) $row['datc'],
            'DatS'          => (int) $row['dats'],
            'DatM'          => (int) $row['datm'],
            'DatF'          => $row['datf'] ?: 'd.m.Y H:i',
            'urlT'          => (int) $row['urlt'],
            'urlB'          => (int) $row['urlb'],
            'Graph'         => (int) $row['kurve'],
            'Kreuz'         => (int) $row['kreuz'],
            'Tabelle'       => (int) $row['tabelle'],
            'Ligastats'     => (int) $row['ligastats'],
            'Plan'          => (int) $row['plan'],
            'Ergebnis'      => (int) $row['ergebnis'],
            'mittore'       => (int) $row['mittore'],
            'favTeam'       => (int) $row['favteam'],
            'selTeam'       => (int) $row['selteam'],
            'kurve1'        => (int) $row['stat1'],
            'kurve2'        => (int) $row['stat2'],
            'tableHinRueck' => (int) $row['ein_hinrueck'],
            'tableHeimAusw' => (int) $row['ein_heimausw'],
            'ticker'        => (int) $row['nticker'],
            'klfin'         => (int) ($row['klfin']      ?? 0),
            'playdown'      => (int) ($row['playdown']   ?? 0),
            'playoffmode'   => (int) ($row['playoffmode'] ?? 0),
            'goalfaktor'    => (float) ($row['goalfaktor']   ?: 1),
            'pointsfaktor'  => (float) ($row['pointsfaktor'] ?: 1),
            'enableGameSort'=> (int) ($row['enablegamesort'] ?? 1),
        );

        // Liganame setzen (analog loadFile())
        if (isset($optionDetails['Name']) && $optionDetails['Name'] != '') {
            if ($this->name == '') {
                $this->name = $optionDetails['Name'];
            } else {
                $optionDetails['Name'] = $this->name;
            }
        }

        $options = new optionsSektion($this, $optionDetails);
        foreach ($optionDetails as $detailsKey => $detailsValue) {
            $options->keyValues[$detailsKey] = $detailsValue;
        }
        $this->options = &$options;

        // ── Sonstige Metadaten ────────────────────────────────────────────────
        $this->kurz     = $row['file_name'] ?? '';
        $this->fileName = $fileName;
        // ligaDatum entspricht filemtime() bei loadFile(); hier: Zeitpunkt
        // der letzten DB-Aktualisierung
        $this->ligaDatum = !empty($row['updated_at']) ? strtotime($row['updated_at']) : time();

        $status = true;
        return $status;

        } catch (\Throwable $e) {
            // Sowohl PDOExceptions (DB-Fehler) als auch sonstige Fehler
            // (z.B. undefinierte Konstanten bei unvollständigem Setup)
            // werden hier abgefangen, damit loadFromDb() im Fehlerfall
            // immer nur false zurückgibt - analog zu loadFile() bei
            // fehlender/ungültiger Datei - statt eines Fatal Errors (HTTP 500).
            if (function_exists('error_log')) {
                error_log('liga::loadFromDb() PDOException: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
    * Hilfsfunktion für loadFromDb(): ermittelt die maximale Anzahl an
    * Partien über alle bisher geladenen Spieltage (entspricht der
    * "Matches"-Ermittlung in loadFile()/writeFile()).
    *
    * @access private
    * @return integer
    */
    function spieltageMaxPartien() {
        $max = 0;
        foreach ($this->spieltage as $spieltag) {
            if ($spieltag->partienCount() > $max) {
                $max = $spieltag->partienCount();
            }
        }
        return $max;
    }

    /**
    * schreibt das LigaFile
    *
    * if there is a need for any update functionality for special addons, you should define them
    * inside of the function updateAddons() located in update_addons.php file.
    *
    * @access public
    * @param string $fileName Pfad zum ligafile
    * @param integer $message
    * @param integer $deleteEmptyRounds
    * @return boolean Ergebniss des Speicherns
    */
    function writeFile($fileName = '', $message = 0, $deleteEmptyRounds = 0) {

        // if there is a need for any update functionality for special addons,
        // you should define them inside of the function updateAddons() located
        // in update_addons.php file.
        // require_once: die Datei deklariert updateAddons(); ein zweites writeFile() im selben
        // Request brach mit include ab ("Cannot redeclare updateAddons()")
        require_once PATH_TO_ADDONDIR . '/classlib/update_addons.php';
        $iniData = array(); // Inhalt des LigaFiles
        $aktSpTag = 1;
        $maxSp = 0;
        // Key "Matches" bestimmen
        foreach ($this->spieltage as $spieltag) {
            if ($spieltag->partienCount() > $maxSp) {
                $maxSp = $spieltag->partienCount();
            }
            // aktuellen Spieltag bestimmen
            foreach ($spieltag->partien as $partie) {
                if ($partie->hTore + $partie->gTore > -1) {  // aktueller Spieltag muss min. ein Ergebnis enthalten
                    $aktSpTag = $spieltag->nr;
                }
            }
        }
        // aktualisierte Optionen setzen. Titel und aktuellen Spieltag aus der Oberflaeche nicht
        // ueberschreiben: nur setzen, wenn sie fehlen bzw. kein gueltiger Spieltag sind
        if (empty($this->options->keyValues['Title'])) {
            $this->options->keyValues['Title'] = "<acronym title='Liga Manager Online " . CLASSLIB_VERSION . "'>LMO</acronym>";
        }
        $this->options->keyValues['Matches'] = $maxSp;
        $actual = isset($this->options->keyValues['Actual']) ? (int) $this->options->keyValues['Actual'] : 0;
        if ($actual < 1 || $actual > $this->spieltageCount()) {
            $this->options->keyValues['Actual'] = $aktSpTag;
        }
        foreach ($this->options->keyValues as $key => $value) {
            $iniData['Options'][$key] = $value;
        }

        foreach ($this->teams as $team) {
            $iniData['Teams'][$team->nr] = $team->name;
            $iniData['Teamk'][$team->nr] = $team->kurz;
            // Sektion Mittellange Teamnamen nur anlegen wenn vorhanden
            if (isset($team->mittel)) {
                $iniData['Teamm'][$team->nr] = $team->mittel;
            }

            // Team Optionen schreiben (z.B. Strafen)
            foreach ($team->keyValues as $key => $value) {
                $iniData['Team' . $team->nr][$key] = $value;
            }
        }

        // Jetzt die unbekannten Sectionen einfügen
        foreach ($this->sections as $section => $keys) {
            foreach ($keys as $key => $val) {
                $iniData[$section][$key] = $val;
            }
        }

        // Jetzt die Spieltage schreiben
        for ($roundCount = 1; $roundCount <= $this->spieltageCount(); $roundCount++) {
            $spieltag = $this->spieltage[$roundCount - 1];
            if ($spieltag->partienCount() > 0 or $deleteEmptyRounds == 0) {
                $iniData['Round' . $roundCount]['D1'] = $spieltag->vonString();
                $iniData['Round' . $roundCount]['D2'] = $spieltag->bisString();
                $iniData['Round' . $roundCount]['MO'] = $spieltag->getModus();
                foreach ($spieltag->getParameter() as $roundKey => $roundValue) {  // z.B. HS
                    $iniData['Round' . $roundCount][$roundKey] = $roundValue;
                }
                for ($teamCounter = 1, $pCounter = 0; $pCounter < $spieltag->partienCount(); $teamCounter++) {
                    $partienCounter = 0;
                    $iniData['Round' . $roundCount]['TA' . $teamCounter] = $spieltag->partien[$pCounter]->heim->nr;
                    $iniData['Round' . $roundCount]['TB' . $teamCounter] = $spieltag->partien[$pCounter]->gast->nr;
                    do {
                        if ($spieltag->getModus() > 0)
                            $partienNumber = strval($teamCounter) . strval(++$partienCounter);
                        else
                            $partienNumber = $teamCounter;
                        $iniData['Round' . $roundCount]['GA' . $partienNumber] = $spieltag->partien[$pCounter]->hTore;
                        $iniData['Round' . $roundCount]['GB' . $partienNumber] = $spieltag->partien[$pCounter]->gTore;
                        $iniData['Round' . $roundCount]['SP' . $partienNumber] = $spieltag->partien[$pCounter]->getSpielEnde();
                        $iniData['Round' . $roundCount]['AT' . $partienNumber] = $spieltag->partien[$pCounter]->zeit;
                        $iniData['Round' . $roundCount]['NT' . $partienNumber] = $spieltag->partien[$pCounter]->notiz;
                        $iniData['Round' . $roundCount]['BE' . $partienNumber] = $spieltag->partien[$pCounter]->reportUrl;
                        foreach ($spieltag->partien[$pCounter]->getParameter() as $otherKey => $otherParameter) {
                            $iniData['Round' . $roundCount][$otherKey . $partienNumber] = $otherParameter;
                        }
                        if ($pCounter > 10000)
                            die('Script Error');
                        $pCounter++;
                    }
                    // while (is_object($spieltag->partien[$pCounter]) && $partienCounter < $spieltag->getModus() && $pCounter<$spieltag->partienCount());
                    while ($partienCounter < $spieltag->getModus() && $pCounter < $spieltag->partienCount());
                }
            }
        }

        // fileContent schreiben
        $datei = @fopen($fileName, 'w');
        if (!$datei) {
            echo '<font color="#ff0000">Cannot open file for writing (write permissions?) CLASS liga function writeFile()</font>';
            return false;
        }
        elseif ($datei && $message == 1) {
            echo '<font color="#008800">Writing File $fileName (".$datei.")</font>';
        }
        flock($datei, LOCK_EX);
        foreach ($iniData as $sek => $keys) {
            fputs($datei, "[$sek]\n");
            foreach ($keys as $key => $val) {
                fputs($datei, "$key=$val\n");
            }
            fputs($datei, "\n");
        }
        flock($datei, LOCK_UN);
        fclose($datei);
        // start the update function
        updateAddons($fileName);
        return true;
    }

    /**
    * Zeigt den Inhalt des Ligafiles an
    *
    * Wird nur zum debuggen verwendet.
    *
    * @access private
    * @param boolean $htmlContent
    */
    function fileContent($htmlContent = false) {
        $lf = ($htmlContent == false) ? '\n' : '<BR>';
        // Key "Matches" bestimmen
        foreach ($this->spieltage as $spieltag) {
            if ($spieltag->partienCount() > $this->options->keyValues['Matches']) {
                $this->options->keyValues['Matches'] = $spieltag->partienCount();
            }
        }
        echo $lf . '[Options]';
        foreach ($this->options->keyValues as $key => $value) {
            echo $lf . "$key=$value";
        }
        echo $lf . '[Teams]';
        foreach ($this->teams as $team) {
            echo $lf . $team->nr . '=' . $team->name;
        }
        echo $lf . '[Teamk]';
        foreach ($this->teams as $team) {
            echo $lf . $team->nr . '=' . $team->kurz;
        }
        foreach ($this->teams as $team) {
            echo $lf . '[Team' . $team->nr . ']';
            foreach ($team->keyValues as $key => $value) {
                echo $lf . "$key=$value";
            }
        }
        // unbekannte Sektionen ausgeben
        foreach ($this->sections as $section) {
            echo $lf . "[$section]";
            foreach ($section as $key => $value) {
                echo $lf . "$key=$value";
            }
        }

        $roundCount = 1;
        foreach ($this->spieltage as $spieltag) {
            echo $lf . '[Round' . $roundCount . ']';
            echo $lf . 'D1=' . $spieltag->vonString();
            echo $lf . 'D2=' . $spieltag->bisString();
            $x = 1;
            foreach ($spieltag->partien as $partie) {
                $x = $partie->spNr;
                echo $lf . 'TA' . $x . '=' . $partie->heim->nr;
                echo $lf . 'TB' . $x . '=' . $partie->gast->nr;
                echo $lf . 'GA' . $x . '=' . $partie->hTore;
                echo $lf . 'GB' . $x . '=' . $partie->gTore;
                echo $lf . 'AT' . $x . '=' . $partie->zeit;
                echo $lf . 'NT' . $x . '=' . $partie->notiz;
                $x++;
            }
            $roundCount++;
        }
    }

    /**
    * Strafen
    *
    * Wird von calcTable verwende
    *
    * <BR>SP Straf-/Bonuspunkte links
    * <BR>SM Straf-/Bonuspunkte rechts (nur wenn es Minuspunkte gibt)
    * <BR>TOR1 Straf-/Bonustore links
    * <BR>TOR2 Straf-/Bonustore rechts
    * <BR>STDA ab wann zählt Strafe/Bonus
    *
    * @author Tim Schumacher <webobjects@gmx.net>
    * @package classLib
    * @access privat
    */
    function strafen(&$team) {
        $keyValues = $team['team']->keyValues;
        $team['pPkt'] -= isset($keyValues['SP']) ? $keyValues['SP'] : 0;
        // TOR1/TOR2 wie in der Ligadatei: lmo-adminteams.php speichert "+x" als -x
        $team['pTor'] -= isset($keyValues['TOR1']) ? $keyValues['TOR1'] : 0;
        $team['mTor'] -= isset($keyValues['TOR2']) ? $keyValues['TOR2'] : 0;
        if ($this->options->keyValues['MinusPoints'] == 2 && isset($keyValues['SM'])) {
            $team['mPkt'] -= $keyValues['SM'];
        }
    }

    /**
    * Ob die Strafe eines Teams in dieser Tabelle zaehlt (wie lmo-calctable.php):
    * nicht in Heim-/Auswaertstabelle, in der Hinrunde nur Strafen ab einem Spieltag der Hinrunde,
    * in der Rueckrunde nur solche ab einem Spieltag der Rueckrunde, und erst wenn der Spieltag
    * STDA erreicht ist (Ergebnisse hat).
    *
    * @access private
    * @param array $team Tabellenzeile
    * @param string $tableArt Art der Tabelle
    * @param integer $lastPlayed letzter Spieltag mit einem Ergebnis
    * @return boolean
    */
    function strafeFaellig($team, $tableArt, $lastPlayed) {
        $stda = isset($team['team']->keyValues['STDA']) ? (int) $team['team']->keyValues['STDA'] : 0;
        $half = (int) ($this->spieltageCount() / 2);
        if ($tableArt == 'heim' || $tableArt == 'gast') {
            return false;
        }
        if (($tableArt == 'hin' && $stda > $half) || ($tableArt == 'rueck' && $stda <= $half)) {
            return false;
        }
        return $stda <= $lastPlayed;
    }

    /**
    * Bucht ein Ergebnis fuer ein Team: Tore, Spiele, Sieg/Remis/Niederlage und Punkte.
    *
    * @access private
    */
    function addResult(&$row, $own, $other, $pointsForWin, $pointsForDraw, $pointsForLost) {
        $row['pTor'] += $own;
        $row['mTor'] += $other;
        $row['spiele']++;
        if ($own > $other) {
            $result = array('s', $pointsForWin, $pointsForLost);
        }
        elseif ($own < $other) {
            $result = array('n', $pointsForLost, $pointsForWin);
        }
        else {
            $result = array('u', $pointsForDraw, $pointsForDraw);
        }
        if (isset($row[$result[0]])) {
            $row[$result[0]]++;
        }
        $row['pPkt'] += $result[1];
        $row['mPkt'] += $result[2];
    }

    /**
    * Berechnet den Tabellenstand für einen Spieltag
    *
    * Berechnet den Tabellenstand für einen Spieltag und gibt
    * ein mehrdimensionales Array zurück:
    *    mit n = anzahlTeams - 1;
    *    $myArray[0..n]["pos"]        Tabellenposition
    *    $myArray[0..n]["team"]       Referenz auf Team
    *    $myArray[0..n]["spiele"]     gespielte Partien
    *    $myArray[0..n]["s"]          Anzahl Spiege
    *    $myArray[0..n]["u"]          Anzahl Unendschieden
    *    $myArray[0..n]["n"]          Anzahl Niederlagen
    *    $myArray[0..n]["pTor"]       Erzielte Tore
    *    $myArray[0..n]["mTor"]       Erzielte Gegentore
    *    $myArray[0..n]["dTor"]       Tordifferenz
    *    $myArray[0..n]["pPkt"]       Pluspunkte
    *    $myArray[0..n]["mPkt"]       Minuspunkte
    * $myArray[0..n]["possp"] Position an dem $key Spieltag
    *
    * @access public
    * @param integer $spTag Spieltag für den die Tabelle berechnet werden soll.
    * @param string $tableArt Art der Tabelle "all","heim","gast","hin","rueck"
    * @param boolean $possp wenn true wird für jeden Spieltag die Position bestimmt (Statistik)
    * @return array Tabelle des Angegebenen Spieltages
    */
    function calcTable($spTag = 1, $tableArt = 'all', $possp = false) {

        $actual = $this->options->keyValues['Actual'];
        $spTag = ($spTag < 1) ? $actual : $spTag;
        $spTagCount = 1;

        // FIX (PHP 8): vorinitialisieren, sonst "Undefined variable"
        // falls $this->teams leer ist.
        $tableArray = array();
        foreach ($this->teams as $team) {
            $tableArray[] = array(
              'pos' => -1,
              'team' => $team,
              'spiele' => 0,
              's' => 0,
              'u' => 0,
              'n' => 0,
              'pTor' => 0,
              'mTor' => 0,
              'dTor' => 0,
              'pPkt' => 0,
              'mPkt' => 0,
              'possp' => array()
            );
        }
        // Strafen: einmal je Team, sobald faellig - auch wenn das Team an dem Spieltag spielfrei ist
        $lastPlayed = 0;
        $bestraft = array();
        $strafenBuchen = function () use (&$tableArray, &$bestraft, &$lastPlayed, $tableArt) {
            foreach ($tableArray as $index => $row) {
                if (empty($bestraft[$index]) && $this->strafeFaellig($row, $tableArt, $lastPlayed)) {
                    $this->strafen($tableArray[$index]);
                    $bestraft[$index] = true;
                }
            }
        };
        $strafenBuchen();  // Strafen ab Spieltag 0
        $processed = array();  // gewertete Spieltage, fuer den direkten Vergleich
        foreach ($this->spieltage as $spieltag) {
            if ($spieltag->getModus() > 0) {
                continue;
            }
            if ($tableArt == 'hin' && ($spieltag->nr > ($this->spieltageCount() / 2))) {
                if ($spTagCount < $spTag) {
                    $spTagCount++;
                }
                else {
                    break;
                }
                continue;
            }
            elseif ($tableArt == 'rueck' && ($spieltag->nr <= $this->spieltageCount() / 2)) {
                if ($spTagCount < $spTag) {
                    $spTagCount++;
                }
                else {
                    break;
                }
                continue;
            }
            $processed[$spieltag->nr] = true;
            foreach ($spieltag->partien as $partie) {
                $heimCount = -1;
                $gastCount = -1;
                $count = 0;
                if ($partie->spielEnde == 2) {  // Nach Verlängerung
                    $pointsForWin = $this->options->keyValues['XtraS'];
                    $pointsForDraw = $this->options->keyValues['XtraU'];
                    $pointsForLost = $this->options->keyValues['XtraV'];
                }
                elseif ($partie->spielEnde == 1) {  // Nach Elfmetersch. oder nach Penalty
                    $pointsForWin = $this->options->keyValues['SpezS'];
                    $pointsForDraw = $this->options->keyValues['SpezU'];
                    $pointsForLost = $this->options->keyValues['SpezV'];
                }
                else {  // normales Spielende
                    $pointsForWin = $this->options->keyValues['PointsForWin'];
                    $pointsForDraw = $this->options->keyValues['PointsForDraw'];
                    $pointsForLost = $this->options->keyValues['PointsForLost'];
                }
                for ($count = 0; $count < count($tableArray) && ($heimCount == -1 || $gastCount == -1); $count++) {  // Teams der Partie finden
                    if ($tableArray[$count]['team'] === $partie->heim) {
                        $heimCount = $count;
                    }
                    if ($tableArray[$count]['team'] === $partie->gast) {
                        $gastCount = $count;
                    }
                }
                if ($partie->valuateGame() != -1) {
                    $lastPlayed = $spieltag->nr;
                }
                // ET=3: beidseitiges Ergebnis, gilt fuer beide Teams aus Sicht der Heimmannschaft
                if ($partie->getParameter('ET') == 3 && $partie->hTore > -1 && $partie->gTore > -1) {
                    if ($tableArt != 'gast') {
                        $this->addResult($tableArray[$heimCount], $partie->hTore, $partie->gTore, $pointsForWin, $pointsForDraw, $pointsForLost);
                    }
                    if ($tableArt != 'heim') {
                        $this->addResult($tableArray[$gastCount], $partie->hTore, $partie->gTore, $pointsForWin, $pointsForDraw, $pointsForLost);
                    }
                    continue;
                }

                if ($partie->hTore > -1) {
                    // Tore für Heim hinzufügen
                    $tableArray[$heimCount]['pTor'] += $tableArt != 'gast' ? $partie->hTore : 0;
                    $tableArray[$gastCount]['mTor'] += $tableArt != 'heim' ? $partie->hTore : 0;
                }
                if ($partie->gTore > -1) {
                    // Tore für Gast hinzufügen
                    $tableArray[$gastCount]['pTor'] += $tableArt != 'heim' ? $partie->gTore : 0;
                    $tableArray[$heimCount]['mTor'] += $tableArt != 'gast' ? $partie->gTore : 0;
                }
                if ($partie->hTore > -1 && $partie->gTore > -1) {  // Ein normales Ergebnis?
                    if ($partie->gTore == $partie->hTore) {  // Unendschieden
                        if ($tableArt != 'gast') {
                            $tableArray[$heimCount]['pPkt'] += $pointsForDraw;
                            $tableArray[$heimCount]['mPkt'] += $pointsForDraw;
                            $tableArray[$heimCount]['u']++;
                            $tableArray[$heimCount]['spiele']++;
                        }
                        if ($tableArt != 'heim') {
                            $tableArray[$gastCount]['pPkt'] += $pointsForDraw;
                            $tableArray[$gastCount]['mPkt'] += $pointsForDraw;
                            $tableArray[$gastCount]['u']++;
                            $tableArray[$gastCount]['spiele']++;
                        }
                    }
                    elseif ($partie->gTore > $partie->hTore) {  // Gast hat gewonnen
                        if ($tableArt != 'gast') {
                            $tableArray[$heimCount]['mPkt'] += $pointsForWin;
                            $tableArray[$heimCount]['pPkt'] += $pointsForLost;
                            $tableArray[$heimCount]['n']++;
                            $tableArray[$heimCount]['spiele']++;
                        }
                        if ($tableArt != 'heim') {
                            $tableArray[$gastCount]['pPkt'] += $pointsForWin;
                            $tableArray[$gastCount]['mPkt'] += $pointsForLost;
                            $tableArray[$gastCount]['s']++;
                            $tableArray[$gastCount]['spiele']++;
                        }
                    }
                    elseif ($partie->gTore < $partie->hTore) {  // Heim hat gewonnen
                        if ($tableArt != 'gast') {
                            $tableArray[$heimCount]['pPkt'] += $pointsForWin;
                            $tableArray[$heimCount]['mPkt'] += $pointsForLost;
                            $tableArray[$heimCount]['s']++;
                            $tableArray[$heimCount]['spiele']++;
                        }
                        if ($tableArt != 'heim') {
                            $tableArray[$gastCount]['mPkt'] += $pointsForWin;
                            $tableArray[$gastCount]['pPkt'] += $pointsForLost;
                            $tableArray[$gastCount]['n']++;
                            $tableArray[$gastCount]['spiele']++;
                        }
                    }
                    else {  // nur während der Entwicklung
                        echo 'Fehler in Punkteermittlung (Normales Ergebnis)';
                        echo $partie->showDetailsHTML();
                    }
                }
                elseif ($partie->hTore == -2) {  // O:0 Tore Heim gewinnt
                    if ($tableArt != 'gast') {
                        $tableArray[$heimCount]['pPkt'] += $pointsForWin;
                        $tableArray[$heimCount]['mPkt'] += $pointsForLost;
                        $tableArray[$heimCount]['s']++;
                        $tableArray[$heimCount]['spiele']++;
                    }
                    if ($tableArt != 'heim') {
                        $tableArray[$gastCount]['mPkt'] += $pointsForWin;
                        $tableArray[$gastCount]['pPkt'] += $pointsForLost;
                        $tableArray[$gastCount]['n']++;
                        $tableArray[$gastCount]['spiele']++;
                    }
                }
                elseif ($partie->gTore == -2) {  // O:0 Tore Gast gewinnt
                    if ($tableArt != 'gast') {
                        $tableArray[$heimCount]['mPkt'] += $pointsForWin;
                        $tableArray[$heimCount]['pPkt'] += $pointsForLost;
                        $tableArray[$heimCount]['n']++;
                        $tableArray[$heimCount]['spiele']++;
                    }
                    if ($tableArt != 'heim') {
                        $tableArray[$gastCount]['pPkt'] += $pointsForWin;
                        $tableArray[$gastCount]['mPkt'] += $pointsForLost;
                        $tableArray[$gastCount]['s']++;
                        $tableArray[$gastCount]['spiele']++;
                    }
                }
            } // foreach Partien
            $strafenBuchen();
            //Zusätzliche Berechnung der Position für den jeweiligen Spieltag (Statisktik)
            if ($possp == true) {
                for ($i = 0; $i < count($tableArray); $i++) {  // Tordiff.
                    $tableArray[$i]['dTor'] = $tableArray[$i]['pTor'] - $tableArray[$i]['mTor'];
                }
                $this->directContext = array('rounds' => $processed, 'art' => $tableArt);
                $tableArray = $this->sortTable($tableArray);
                for ($i = 0; $i < count($tableArray); $i++) {
                    $tableArray[$i]['possp'][$spTagCount - 1] = $tableArray[$i]['pos'];
                }
            }
            if ($spTagCount < $spTag) {
                $spTagCount++;
            }
            else {
                break;
            }
        } // foreach Spieltage

        for ($i = 0; $i < count($tableArray); $i++) {  // Tordiff.
            $tableArray[$i]['dTor'] = $tableArray[$i]['pTor'] - $tableArray[$i]['mTor'];
        }
        $this->directContext = array('rounds' => $processed, 'art' => $tableArt);
        $tableArray = $this->sortTable($tableArray);
        $this->directContext = null;
        if ($this->options->keyValues['HandS'] == 1 && $tableArt == 'all') {
            $tableArray = $this->sortHandicap($tableArray, $spTag);
        }
        return $tableArray;
    }

    /**
    * Handicap-Reihenfolge (Option HandS, nur Gesamttabelle), wie lmo-calctable.php:
    * Der Wert HS des Spieltags enthaelt je Platz der errechneten Tabelle zwei Ziffern mit dem
    * Platz, auf den das dort stehende Team gesetzt wird. Bei gleichen Ziffern stehen die Teams
    * in umgekehrter Reihenfolge der errechneten Tabelle.
    * Fuer die Tabelle der ganzen Saison gilt die Reihenfolge des aktuellen Spieltags (Actual),
    * sonst die des angegebenen Spieltags.
    *
    * @access protected
    * @param array $tableArray sortierte Tabelle
    * @param integer $spTag Spieltag der Tabelle
    * @return array
    */
    function sortHandicap($tableArray, $spTag) {
        if ($spTag >= $this->spieltageCount()) {
            $spTag = max(1, (int) $this->options->keyValues['Actual']);
        }
        $spieltag = $this->spieltagForNumber($spTag);
        $handicap = is_object($spieltag) ? (string) $spieltag->getParameter('HS') : '';
        if ($handicap === '' || $handicap == 0) {
            return $tableArray;
        }
        $order = array_keys($tableArray);
        usort($order, function ($a, $b) use ($handicap) {
            return array(intval(substr($handicap, $a * 2, 2)), $b) <=> array(intval(substr($handicap, $b * 2, 2)), $a);
        });
        $sorted = array();
        foreach ($order as $pos => $index) {
            $sorted[$pos] = $tableArray[$index];
            $sorted[$pos]['pos'] = $pos + 1;
        }
        return $sorted;
    }

    /**
    * Sortiert die errechnete Tabelle und gibt diese als Array zurück
    * Reihenfolge :
    * ->keyValues['Kegel'] = 0 -> PlusPunkte - NegativPunkte - Tor Differenz - erziehlte Tore - Gegentore
    * ->keyValues['Kegel'] = 1 -> Pluspunkte - NegativPunkte - erziehlte Tore - Tor Differenz
    *
    * @access protected
    * @param array $tableArray Die zu sortierende Tabelle
    * @return array
    */
    function sortTable($tableArray) {
        // auch fuer eine leere Tabelle definiert
        $sort_pPkt = $sort_mPkt = $sort_pTor = $sort_mTor = $sort_dTor = $sort_nr = array();
        foreach ($tableArray as $table) {
            $sort_pPkt[] = $table['pPkt'];
            $sort_mPkt[] = $this->options->keyValues['MinusPoints'] == 2 ? $table['mPkt'] : 0;
            $sort_pTor[] = $table['pTor'];
            $sort_mTor[] = $table['mTor'];
            $sort_dTor[] = $table['dTor'];
            $sort_nr[] = (int) $table['team']->nr;
        }
        // ASC = auf-, DESC = absteigend
        // Bei voelligem Gleichstand steht das Team mit der hoeheren Nummer vorn (wie lmo-calctable.php)
        if ($this->options->keyValues['Kegel'] == 1) {  // Sortierung Punkte,erzielte Tore
            array_multisort($sort_pPkt, SORT_DESC, $sort_mPkt, SORT_ASC, $sort_pTor, SORT_DESC, $sort_dTor, SORT_DESC, $sort_nr, SORT_DESC, $tableArray, SORT_DESC);
        }
        else {  // Sortierung PlusPkt,Tordiff
            array_multisort($sort_pPkt, SORT_DESC, $sort_mPkt, SORT_ASC, $sort_dTor, SORT_DESC, $sort_pTor, SORT_DESC, $sort_mTor, SORT_ASC, $sort_nr, SORT_DESC, $tableArray, SORT_DESC);
        }
        // BEGIN Direkter Vergleich
        if ($this->options->keyValues['Direct'] == 1) {
            // Minuspunkte zaehlen nur bei der Zwei-Punkte-Regel (wie lmo-calctable.php)
            $keys = $this->options->keyValues['MinusPoints'] == 2 ? array('pPkt', 'mPkt') : array('pPkt');
            $tableArray = $this->sortTiedGroups($tableArray, $keys);
        }  // END Direkter Vergleich
        for ($i = 0; $i < count($tableArray); $i++) {  // Position setzen
            $tableArray[$i]['pos'] = $i + 1;
        }
        return $tableArray;
    }

    /**
    * Direkter Vergleich: Gruppen gleichauf liegender Teams (gleiche Werte in $keys) werden
    * nach der Tabelle ihrer Partien untereinander (calcTableforTeams) sortiert, siehe
    * compareDirect(). Bleiben Teams auch dort gleichauf, behalten sie ihre bisherige
    * Reihenfolge (z.B. nach Tordifferenz) - wie lmo-calctable.php.
    *
    * @access protected
    * @param array $tableArray sortierte Tabelle
    * @param array $keys Spalten, die für einen Gleichstand übereinstimmen müssen
    * @return array
    */
    function sortTiedGroups($tableArray, $keys) {
        $count = count($tableArray);
        $start = 0;
        for ($i = 1; $i <= $count; $i++) {
            $tied = $i < $count;
            foreach ($keys as $key) {
                $tied = $tied && $tableArray[$i][$key] == $tableArray[$start][$key];
            }
            if ($tied) {
                continue;
            }
            $size = $i - $start;
            if ($size > 1) {
                $group = array_slice($tableArray, $start, $size);
                $subteams = array();
                foreach ($group as $row) {
                    $subteams[$row['team']->nr] = $row['team'];
                }
                $direct = array();
                foreach ($this->calcTableforTeams($subteams) as $directRow) {
                    $direct[$directRow['team']->nr] = $directRow;
                }
                $order = array_keys($group);
                usort($order, function ($a, $b) use ($group, $direct) {
                    $result = $this->compareDirect($direct[$group[$a]['team']->nr], $direct[$group[$b]['team']->nr]);
                    return $result != 0 ? $result : $a - $b;  // sonst bisherige Reihenfolge
                });
                foreach ($order as $b => $index) {
                    $tableArray[$start + $b] = $group[$index];
                }
            }
            $start = $i;
        }
        return $tableArray;
    }

    /**
    * Vergleich zweier Zeilen der Tabelle des direkten Vergleichs (calcTableforTeams):
    * Punkte, Minuspunkte (nur bei der Zwei-Punkte-Regel), Tordifferenz, Tore;
    * bei Kegelwertung Tore vor Tordifferenz. Negativ: $a steht vor $b.
    *
    * @access protected
    * @return integer
    */
    function compareDirect($a, $b) {
        $minus = $this->options->keyValues['MinusPoints'] == 2;
        $goals = $this->options->keyValues['Kegel'] == 1 ? array('pTor', 'dTor') : array('dTor', 'pTor');
        return array($b['pPkt'], $minus ? $a['mPkt'] : 0, $b[$goals[0]], $b[$goals[1]])
           <=> array($a['pPkt'], $minus ? $b['mPkt'] : 0, $a[$goals[0]], $a[$goals[1]]);
    }

    /**
    * Errechnet eine Tabelle für den Direkten vergleich von mehreren Mannschaften
    *
    * @access protected
    * @param array $subteams Alle Teams die Miteinander verglichen werden sollen
    * @return array
    */
    function calcTableforTeams($subteams) {
        $spTagCount = 1;
        // FIX (PHP 8): vorinitialisieren, sonst "Undefined variable"
        // falls $subteams leer ist.
        $tableArray = array();
        foreach ($subteams as $team) {
            $tableArray[] = array(
              'pos' => -1,
              'team' => $team,
              'spiele' => 0,
              'pTor' => 0,
              'mTor' => 0,
              'dTor' => 0,
              'pPkt' => 0,
              'mPkt' => 0
            );
        }
        // nur die Partien der Tabelle, die calcTable() gerade sortiert (Spieltage, Heim/Gast)
        $context = $this->directContext;
        $art = $context === null ? 'all' : $context['art'];
        foreach ($this->spieltage as $spieltag) {
            if ($spieltag->getModus() > 0 || ($context !== null && empty($context['rounds'][$spieltag->nr]))) {
                continue;
            }
            foreach ($spieltag->partien as $partie) {
                if ($partie->spielEnde == 2) {  // Nach Verlängerung
                    $pointsForWin = $this->options->keyValues['XtraS'];
                    $pointsForDraw = $this->options->keyValues['XtraU'];
                    $pointsForLost = $this->options->keyValues['XtraV'];
                }
                elseif ($partie->spielEnde == 1) {  // Nach Elfmetersch. oder nach Penalty
                    $pointsForWin = $this->options->keyValues['SpezS'];
                    $pointsForDraw = $this->options->keyValues['SpezU'];
                    $pointsForLost = $this->options->keyValues['SpezV'];
                }
                else {  // normales Spielende
                    $pointsForWin = $this->options->keyValues['PointsForWin'];
                    $pointsForDraw = $this->options->keyValues['PointsForDraw'];
                    $pointsForLost = $this->options->keyValues['PointsForLost'];
                }
                $heimCount = -1;
                $gastCount = -1;
                for ($count = 0; $count < count($tableArray) && ($heimCount == -1 || $gastCount == -1); $count++) {  // Teams der Partie finden
                    if ($tableArray[$count]['team'] === $partie->heim)
                        $heimCount = $count;
                    if ($tableArray[$count]['team'] === $partie->gast)
                        $gastCount = $count;
                }
                if ($heimCount == -1 OR $gastCount == -1)
                    continue;
                // Heim-/Auswaertstabelle: die andere Seite der Partie wird danach zurueckgesetzt
                $before = array($heimCount => $tableArray[$heimCount], $gastCount => $tableArray[$gastCount]);
                // ET=3: beidseitiges Ergebnis, gilt fuer beide Teams aus Sicht der Heimmannschaft
                if ($partie->getParameter('ET') == 3 && $partie->hTore > -1 && $partie->gTore > -1) {
                    $this->addResult($tableArray[$heimCount], $partie->hTore, $partie->gTore, $pointsForWin, $pointsForDraw, $pointsForLost);
                    $this->addResult($tableArray[$gastCount], $partie->hTore, $partie->gTore, $pointsForWin, $pointsForDraw, $pointsForLost);
                    $this->keepSide($tableArray, $before, $heimCount, $gastCount, $art);
                    continue;
                }
                if ($partie->hTore > -1) {
                    // Tore für Heim hinzufügen
                    $tableArray[$heimCount]['pTor'] += $partie->hTore;
                    $tableArray[$gastCount]['mTor'] += $partie->hTore;
                }
                if ($partie->gTore > -1) {
                    // Tore für Gast hinzufügen
                    $tableArray[$gastCount]['pTor'] += $partie->gTore;
                    $tableArray[$heimCount]['mTor'] += $partie->gTore;
                }
                if ($partie->hTore > -1 && $partie->gTore > -1) {  // Ein normales Ergebnis?
                    $tableArray[$heimCount]['spiele']++;
                    $tableArray[$gastCount]['spiele']++;
                    if ($partie->gTore == $partie->hTore) {  // Unendschieden
                        $tableArray[$heimCount]['pPkt'] += $pointsForDraw;
                        $tableArray[$heimCount]['mPkt'] += $pointsForDraw;
                        $tableArray[$gastCount]['pPkt'] += $pointsForDraw;
                        $tableArray[$gastCount]['mPkt'] += $pointsForDraw;
                    }
                    elseif ($partie->gTore > $partie->hTore) {  // Gast hat gewonnen
                        $tableArray[$heimCount]['mPkt'] += $pointsForWin;
                        $tableArray[$gastCount]['pPkt'] += $pointsForWin;
                        $tableArray[$heimCount]['pPkt'] += $pointsForLost;
                        $tableArray[$gastCount]['mPkt'] += $pointsForLost;
                    }
                    elseif ($partie->gTore < $partie->hTore) {  // Heim hat gewonnen
                        $tableArray[$heimCount]['pPkt'] += $pointsForWin;
                        $tableArray[$gastCount]['mPkt'] += $pointsForWin;
                        $tableArray[$heimCount]['mPkt'] += $pointsForLost;
                        $tableArray[$gastCount]['pPkt'] += $pointsForLost;
                    }
                    else {  // nur während der Entwicklung
                        echo 'Fehler in Punkteermittlung (Normales Ergebnis)';
                        echo $partie->showDetailsHTML();
                    }
                }
                elseif ($partie->hTore == -2) {  // O:0 Tore Heim gewinnt
                    $tableArray[$heimCount]['pPkt'] += $pointsForWin;
                    $tableArray[$gastCount]['mPkt'] += $pointsForWin;
                    $tableArray[$heimCount]['mPkt'] += $pointsForLost;
                    $tableArray[$gastCount]['pPkt'] += $pointsForLost;
                }
                elseif ($partie->gTore == -2) {  // O:0 Tore Gast gewinnt
                    $tableArray[$heimCount]['mPkt'] += $pointsForWin;
                    $tableArray[$gastCount]['pPkt'] += $pointsForWin;
                    $tableArray[$heimCount]['pPkt'] += $pointsForLost;
                    $tableArray[$gastCount]['mPkt'] += $pointsForLost;
                }
                $this->keepSide($tableArray, $before, $heimCount, $gastCount, $art);
            }  // foreach Partien
        }  // foreach Spieltage
        for ($i = 0; $i < count($tableArray); $i++) {  // Tordiff.
            $tableArray[$i]['dTor'] = $tableArray[$i]['pTor'] - $tableArray[$i]['mTor'];
        }
        return $this->sortDirectTable($tableArray);
    }

    /**
    * Heimtabelle: nur die Heimmannschaft einer Partie wird gewertet, Auswaertstabelle nur die
    * Gastmannschaft. Setzt die Zeile der anderen Seite auf den Stand vor der Partie zurueck.
    *
    * @access private
    */
    function keepSide(&$tableArray, $before, $heimCount, $gastCount, $art) {
        if ($art == 'heim') {
            $tableArray[$gastCount] = $before[$gastCount];
        }
        elseif ($art == 'gast') {
            $tableArray[$heimCount] = $before[$heimCount];
        }
    }

    /**
    * Sortiert die errechnete Tabelle bei Direktem Vergleich und gibt diese als Array zurück
    * Ist seperat da bei vielen Ligen die Sortierung bei Direktem Vergleich
    * von der Sortierung der Kompletten Tabelle abweicht
    *
    * @access protected
    * @param array $tableArray Die zu sortierende Tabelle
    * @return array
    */
    function sortDirectTable($tableArray) {
        // ohne erneuten direkten Vergleich: sortTiedGroups() wertet nur einmal aus
        // (wie lmo-calctable.php), sonst rechnet sortTable() die Gruppe endlos weiter
        $direct = $this->options->keyValues['Direct'];
        $this->options->keyValues['Direct'] = 0;
        $tableArray = liga::sortTable($tableArray);
        $this->options->keyValues['Direct'] = $direct;
        return $tableArray;
    }

} // End Class Liga

?>
