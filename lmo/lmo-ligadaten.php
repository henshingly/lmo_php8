<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

// Stellt $ligaDaten bereit (Lmo\Liga\LigaDaten): alle Werte einer Ligadatei als ein Objekt.
// Jede Eigenschaft ist dieselbe Stelle im Speicher wie die gleichnamige alte Variable
// ($ligaDaten->titel und $titel), deshalb sehen alter und neuer Code immer dasselbe.
//
// Wird von init.php eingebunden und von den Ladern (lmo-openfile.php ...), die auch innerhalb
// einer Funktion laufen koennen: dort gelten eigene Variablen, also auch ein eigenes Objekt.
// Mehrfaches Einbinden ist unschaedlich.
if (!isset($ligaDaten) || !($ligaDaten instanceof \Lmo\Liga\LigaDaten)) {
    $ligaDaten = new \Lmo\Liga\LigaDaten();
}
foreach (\Lmo\Liga\LigaDaten::felder() as $lmo_feld) {
    $ligaDaten->$lmo_feld = &$$lmo_feld;
}
unset($lmo_feld);
