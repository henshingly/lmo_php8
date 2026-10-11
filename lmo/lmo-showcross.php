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
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}


/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var array<int|string, mixed> $text Sprachtexte
 */
if (($file!="") && $lmo_liga->einstellungen()->mitKreuztabelle()){
  $addc=$_SERVER['PHP_SELF']."?action=cross&amp;file=".$file."&amp;croteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $croteam=!empty($_GET['croteam'])?$_GET['croteam']:0;
  // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen)
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_anzteams = $lmo_einstellungen->mannschaften();
  // Namen und Kurznamen zum Anzeigen, mit einem leeren Platz davor und dahinter (Kopf- und Fusszeile der Tabelle)
  $lmo_namen = array_fill(0, $lmo_anzteams + 2, '');
  $lmo_kurz = array_fill(0, $lmo_anzteams + 2, '');
  foreach ($lmo_liga->alleMannschaften() as $lmo_nr => $lmo_mannschaft) {
    $lmo_namen[$lmo_nr] = $lmo_mannschaft->anzeigename();
    $lmo_kurz[$lmo_nr] = $lmo_mannschaft->kurzname();
  }
  // alle Spiele zum Anzeigen (Lmo\Liga\Spiel), geordnet nach Heim- und Gastmannschaft
  $lmo_begegnungen = array();
  foreach ($lmo_liga->alleSpiele() as $lmo_spiel) {
    $lmo_begegnungen[$lmo_spiel->heim][$lmo_spiel->gast][] = $lmo_spiel;
  }
?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
<tr>
<td class="lmoKreuz">
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">

<?php
for ($i = 0; $i <= ($lmo_anzteams+1); $i++) {
  for ($j = 0; $j <= ($lmo_anzteams+1); $j++) {
    $dummy = "";
    if ($j == 0) {
      echo "<tr>";
    }
    if ($j == 0){
      echo "<th align='right'>";
    } elseif ($j == ($lmo_anzteams+1)) {
      echo "<th align='left'>";
    } elseif ($i == 0 || $i == ($lmo_anzteams+1)){
      echo "<th align='center'>";
    } elseif ($croteam != 0 && ($j == $croteam || $i == $croteam)) {
      echo "<td align='center' class='lmoBackMarkierung'>";
    } elseif ($j == $i) {
      echo "<td class='lmoLeer'>";
    } else {
      echo "<td align='center'>";
    }

    if (($j == 0) && ($i > 0) && ($i <= $lmo_anzteams)) {
      if (($croteam != 0) && (($j == $croteam) || ($i == $croteam))) {
        echo $lmo_namen[$i];
      } else {
        echo "<a href=\"".$addc.$i."\" title=\"".$text[26]."\">".$lmo_namen[$i]."</a>";
      }
    }
    if ($i == 0 && $j > 0 && $j <= $lmo_anzteams) {
      echo "<a href=\"".$addc.$j."\" title=\"".$lmo_namen[$j].": ".$text[26]."\">"."".$lmo_kurz[$j].""."</a>";
    }
    if ($j == $lmo_anzteams+1 && $i > 0 && $i <= $lmo_anzteams || $i == $lmo_anzteams+1 && $j > 0 && $j <= $lmo_anzteams) {
      $lmo_namen[$j] = str_replace( "'", "´", $lmo_namen[$j] ); //an attribute value literal can occur in an attribute specification list only after a VI delimiter because Team names with an apostrophe inside
      echo "<acronym title='".$lmo_namen[$j]."'>";
      echo HTML_smallTeamIcon($file,$lmo_namen[$j]," alt='{$lmo_kurz[$j]}'");
      echo "</acronym>";
      
    }
    if ($j == $lmo_anzteams+1 && $i > 0 && $i <= $lmo_anzteams) {
      $lmo_namen[$i] = str_replace( "'", "´", $lmo_namen[$i] ); //an attribute value literal can occur in an attribute specification list only after a VI delimiter because Team names with an apostrophe inside
      echo "<acronym title='".$lmo_namen[$i]."'>";
      echo HTML_smallTeamIcon($file,$lmo_namen[$i]," alt='{$lmo_kurz[$i]}'");
      echo "</acronym>";
    }

    if (($i > 0) && ($i <= $lmo_anzteams) && ($j > 0) && ($j <= $lmo_anzteams) && ($j != $i)) {
      $l = 0;
      // jedes Spiel dieser Heim- gegen diese Gastmannschaft
      foreach ($lmo_begegnungen[$i][$j] ?? array() as $lmo_spiel) {
        if (($lmo_spiel->notiz != "") || ($lmo_spiel->wertung > 0)) {
          if ($lmo_spiel->wertung == 1) {
            $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$lmo_namen[$i]." ".$text[211];
          }
          if ($lmo_spiel->wertung == 2) {
            $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$lmo_namen[$j]." ".$text[211];
          }
          if ($lmo_spiel->wertung == 3) {
            $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$text[212];
          }
          if ($lmo_spiel->notiz != "") {
            $dummy = $dummy."&#10;&#10;".$text[22].":&#10;".$lmo_spiel->notiz;
          }
        } else {
          $dummy = "";
        }
        if ($l > 0) {
          echo "<br>";
        }
        if ($lmo_spiel->anstoss > 0) {
          $lmo_kreuz_longtime = ", ".date("D. d.m.Y H:i", $lmo_spiel->anstoss);
          $lmo_kreuz_shorttime = date("d.m.", $lmo_spiel->anstoss);
        } else {
          $lmo_kreuz_longtime = "";
          $lmo_kreuz_shorttime = "";
        }
        echo "<a href=\"".$addr.$lmo_spiel->spieltag."\" title=\"".$lmo_namen[$i]." - ".$lmo_namen[$j]." &#10;(".$lmo_spiel->spieltag.". ".$text[2].$lmo_kreuz_longtime.$dummy.")\">";
        if ($lmo_spiel->toreHeim === null && $lmo_kreuz_shorttime!="") {
          echo $lmo_kreuz_shorttime;
        } else {
          if ($lmo_spiel->toreHeim !== null) echo "<strong>";
          echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()).":".$lmo_spiel->toreGastText($lmo_einstellungen->torfaktor());
          if ($lmo_spiel->toreHeim !== null) echo "</strong>";
        }
        if ($lmo_einstellungen->mitVerlaengerung()) {
          echo " ".$lmo_spiel->zusatzText($text[0], $text[1]);
        }
        if (($lmo_spiel->notiz != "") || ($lmo_spiel->wertung > 0)) {
          echo " !";
        }
        echo "</a>";
        $l++;
      }
    }
    if ($j==$i) echo "&nbsp;";
    if ($i == 0 || $i == ($lmo_anzteams+1) || $j == 0 || $j == ($lmo_anzteams+1)) {
      echo "</th>\n";
    } else {
      echo "</td>\n";
    }
    if ($j == ($lmo_anzteams+1)) {
      echo "</tr>\n";
    }
  }
  }?>
</table>
</td>
</tr>
</table><?php
}?>