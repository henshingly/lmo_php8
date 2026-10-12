<?php
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 *
 * Weitere Variablen des einbindenden Codes:
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var array<int|string, mixed> $spielfreiaa
 * @var array<int|string, mixed> $spielfreibb
 * @var mixed $wmlfile
 */
  /*
  * lmo-savehtml1.php: HTML-Ausgabe von Tabelle, aktuellem Spieltag und folgenden Spieltag
  * In der Datei lmo-savefile.php muss über der Zeile
  *  $datei = fopen($file,"w");
  *
  * folgende Zeile hinzugefügt werden:
  *
  *  include(PATH_TO_LMO."/lmo-savehtml1.php");
  *
  *
  * Autor: Bernd Hoyer, basierend auf dem LMO3.02
  * ////Verbesserungen, Bugs etc. bitte nur in das Forum bei Hollwitz.net\\\\  obsolet, Forum nicht mehr vorhanden
  *
  *
  *
  * 10/02/2023 - Please post any improvements, bugs or suggestions in the forum at https://www.liga-manager-online.org/forum
  * 02.10.2023 - Verbesserungen, Bugs oder Vorschläge bitte nun in das Forum auf https://www.liga-manager-online.org/forum
  */


$trans_lang = array( 'Monday' => $text['date'][0], 'Tuesday' => $text['date'][1], 'Wednesday' => $text['date'][2], 'Thursday' => $text['date'][3], 'Friday' => $text['date'][4], 'Saturday' => $text['date'][5], 'Sunday' => $text['date'][6], 'Mon' => $text['date'][7], 'Tue' => $text['date'][8], 'Wed' => $text['date'][9], 'Thu' => $text['date'][10], 'Fri' => $text['date'][11], 'Sat' => $text['date'][12], 'Sun' => $text['date'][13], 'January' => $text['date'][14], 'February' => $text['date'][15], 'March' => $text['date'][16], 'April' => $text['date'][17], 'June' => $text['date'][19], 'July' => $text['date'][20], 'August' => $text['date'][21], 'September' => $text['date'][22], 'October' => $text['date'][23], 'November' => $text['date'][24], 'December' => $text['date'][25], 'Jan' => $text['date'][26], 'Feb' => $text['date'][27], 'Mar' => $text['date'][28], 'Apr' => $text['date'][29], 'May' => $text['date'][30], 'Jun' => $text['date'][31], 'Jul' => $text['date'][32], 'Aug' => $text['date'][33], 'Sep' => $text['date'][34], 'Oct' => $text['date'][35], 'Nov' => $text['date'][36], 'Dec' => $text['date'][37] );

// Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen)
$lmo_html_e = $lmo_liga->einstellungen();
$lmo_html_faktor = $lmo_html_e->torfaktor();
// spielen nicht alle Mannschaften an jedem Spieltag, wird genannt, wer spielfrei ist
$lmo_html_spielfrei = ($lmo_html_e->mannschaften() - ($lmo_html_e->spieltage() / 2 + 1)) != 0;
// die Spiele eines Spieltags zum Anzeigen (Lmo\Liga\Spiel), sortiert nach Anstoss; ohne Anstoss vorn
$lmo_html_spiele = static function (int $lmo_runde) use ($lmo_liga): array {
  $lmo_spiele = iterator_to_array($lmo_liga->spiele($lmo_runde), false);
  usort($lmo_spiele, static fn (\Lmo\Liga\Spiel $a, \Lmo\Liga\Spiel $b): int => ($a->anstoss ?? 0) <=> ($b->anstoss ?? 0));
  return $lmo_spiele;
};

if ($st > 0) {
  $actual = $st;
} else {
  $actual = $lmo_html_e->aktuellerSpieltag();
}

if (!$lmo_html_e->istPokal()) {
  // Tabelle bis zu diesem Spieltag (Lmo\Liga\Tabelle); fuehrt die Liga ein Handicap, gilt die
  // Reihenfolge der Tabellenkorrektur des aktuellen Spieltags
  $lmo_html_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, \Lmo\Liga\Tabelle::GESAMT, (int)$actual);
  $lmo_html_reihenfolge = $lmo_html_tabelle->reihenfolge;
  if ($lmo_html_e->mitHandicap()) {
    $lmo_html_korrektur = $lmo_liga->spieltage[$lmo_html_e->aktuellerSpieltag()]->werte['HS'] ?? '0';
    $lmo_html_reihenfolge = $lmo_html_tabelle->reihenfolgeNachHandicap($lmo_html_korrektur);
  }
}
$actual = $st;
$datumanz = $actual - 1;
if (!$lmo_html_e->istPokal() && $st > 0) {
    $wmlfile = fopen(PATH_TO_LMO . '/' . $diroutput . basename($file) . "-st.html", "wb");
    ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $lmo_html_e->name();?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <style type="text/css">
    body {background:#fff; color:#000; font:10pt sans-serif;}
    caption, p, h1 {margin:3pt auto; text-align:center;}
    table {border:1pt solid #000; border-radius:6px; margin:2pt auto;}
    td {padding:10; white-space:nowrap;}
    th {border-bottom:1px solid #000;}
    h1 {font:14pt bolder;}
    caption {margin-top:10pt; font-weight:bolder; white-space:nowrap;}
    @media print {
      a {display:none;}
    }
  </style>
</head>
<body>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562];?><\/a><\/small>');</script>
  <h1><?php echo $lmo_html_e->name();?></h1><?php
    $lmo_spieltag = $lmo_liga->spieltage[(int)$st] ?? new \Lmo\Liga\Rohdaten\Spieltag();
    $lmo_folgetag = $lmo_liga->spieltage[(int)$st + 1] ?? new \Lmo\Liga\Rohdaten\Spieltag();
    // gibt es an diesem Spieltag ueberhaupt eine Partie?
    $z = array_filter($lmo_html_spiele((int)$st), static fn (\Lmo\Liga\Spiel $lmo_s): bool => $lmo_s->heim > 0);
    if (!empty($z)) {?>

  <table>
  <caption><?php echo $actual . ". " . $text[2];?> <?php if ($lmo_spieltag->ersterTagText()!='') { echo ' - ' . $lmo_spieltag->ersterTagText() . ' ' . $text[4] . ' ' . $lmo_spieltag->letzterTagText();}?></caption><?php
      foreach ($lmo_html_spiele((int)$st) as $lmo_spiel) {
        $i1 = $lmo_spiel->partie - 1;
        if (($lmo_spiel->heim > 0) && ($lmo_spiel->gast > 0)) {
          $heimteam = $lmo_spiel->heimMannschaft()->anzeigename();
          $gastteam = $lmo_spiel->gastMannschaft()->anzeigename();
          $heimtore = $lmo_spiel->toreHeimText($lmo_html_faktor);
          $gasttore = $lmo_spiel->toreGastText($lmo_html_faktor);
          if ($lmo_html_spielfrei) {
            $spielfreiaa[$i1] = $lmo_spiel->heim;
            $spielfreibb[$i1] = $lmo_spiel->gast;
          }
          if ($lmo_spiel->anstoss !== null) {
            $dum1 = strtr(date($lmo_html_e->datumsformat($defdateformat), $lmo_spiel->anstoss), $trans_lang);
          } else {
            $dum1 = "";
          } // Anstosszeit einblenden
?>

    <tr>
      <td><?php echo $dum1;?>&nbsp;</td>
      <td align="right"><?php echo $heimteam;?></td><td><?php echo HTML_icon($heimteam, 'teams');?></td>
      <td>-</td>
      <td><?php echo HTML_icon($gastteam, 'teams');?></td><td><?php echo $gastteam;?>&nbsp;</td>
      <td align="right"><?php echo $heimtore;?></td>
      <td>:</td>
      <td align="left"><?php echo $gasttore;?></td><?php
          if ($lmo_spiel->wertung == 3) {?>
      <td width="2">/</td>
      <td align="right"><?php echo $gasttore;?></td>
      <td align="center" width="8">:</td>
      <td align="left"><?php echo $heimtore;?></td><?php
          }?>

    </tr><?php
        }
      }?>

  </table><?php

      if ($lmo_html_spielfrei) {
        $spielfreicc = array_merge($spielfreiaa, $spielfreibb);
        $i = 1;
        foreach ($lmo_liga->alleMannschaften() as $j => $lmo_mannschaft) {
          if (!in_array($j, $spielfreicc)) {
            if ($i == 1) {?>
      <p><small><?php echo $text[4004];?>: <?php
            }
            echo $lmo_mannschaft->anzeigename();?>&nbsp;&nbsp;<?php
            $i ++;
          }
        }?>
      </small></p><?php
      }
    } //if empty?>

  <table>
    <caption><?php echo $text[16];?> - <?php echo $actual;?>. <?php echo $text[2];?></caption>
    <tr>
      <th colspan=3>&nbsp;</th>
      <th><?php echo $text[33];?></th>
      <th colspan=2><?php echo $text[37];?></th>
      <th><?php echo $text[38];?>&nbsp;</th>
      <th align="right" >&nbsp;&nbsp;<?php echo $text[39];?></th>
    </tr>
<?php
    for ($i1 = 0; $i1 < $lmo_html_e->mannschaften(); $i1 ++) {
      $platz = $i1 + 1;
      $i4 = $lmo_html_reihenfolge[$i1] ?? 0;
      $lmo_zeile = $lmo_html_tabelle->zeilen[$i4] ?? new \Lmo\Liga\Tabellenzeile(0);
      $teamname = $i4 == 0 ? '___' : $lmo_liga->mannschaftsname($i4);
      $pluspunkte = applyFactor($lmo_zeile->punkte, $lmo_html_e->punktfaktor());
      $minuspunkte = applyFactor($lmo_zeile->minuspunkte, $lmo_html_e->punktfaktor());
      $kegelnholz = applyFactor($lmo_zeile->tordifferenz(), $lmo_html_faktor);
      $plustore = applyFactor($lmo_zeile->tore, $lmo_html_faktor);
      $minustore = applyFactor($lmo_zeile->gegentore, $lmo_html_faktor);
      $torverhaeltnis = applyFactor($lmo_zeile->tordifferenz(), $lmo_html_faktor);
      $spieleteam = $lmo_zeile->spiele;
?>
    <tr>
      <td align="right"><?php echo $platz;?>&nbsp;</td>
      <td><?php echo HTML_icon($teamname, 'teams');?>&nbsp;</td>
      <td><?php echo $teamname;?>&nbsp;</td>
      <td align="right"><?php echo $spieleteam;?>&nbsp;</td>
      <td align="right"><?php echo $pluspunkte;
      if ($lmo_html_e->mitMinuspunkten()) {?>:</td>
      <td align="left"><?php echo $minuspunkte;?>&nbsp;</td>
<?php
      } else {?></td>
      <td align="left">&nbsp;</td><?php
      }
?>
      <td align="right"><?php echo "$plustore:$minustore";?>&nbsp;</td>
      <td align="right">&nbsp;&nbsp;<?php echo $torverhaeltnis;?></td>
    </tr>
<?php
    }?>
  </table>
  <p><small><?php echo $text[576];?></small></p>
<?php
    if ($actual == $lmo_html_e->spieltage()) {?>
  <p><strong><?php echo $text[568];?></strong></p>
<?php
    } else {
      if (!empty($z)) {?>
  <table>
  <caption><?php echo $actual+1;?>. <?php echo $text[2];?><?php if ($lmo_folgetag->ersterTagText()!='') { echo ' - ' . $lmo_folgetag->ersterTagText() . ' ' . $text[4] . ' ' . $lmo_folgetag->letzterTagText();}?></caption><?php
        foreach ($lmo_html_spiele((int)$st + 1) as $lmo_spiel) {
          $i1 = $lmo_spiel->partie - 1;
          if (($lmo_spiel->heim > 0) && ($lmo_spiel->gast > 0)) {
            $heimteam = $lmo_spiel->heimMannschaft()->anzeigename();
            $gastteam = $lmo_spiel->gastMannschaft()->anzeigename();
            $heimtore = $lmo_spiel->toreHeimText($lmo_html_faktor);
            $gasttore = $lmo_spiel->toreGastText($lmo_html_faktor);
            if ($lmo_html_spielfrei) {
              $spielfreiaa[$i1] = $lmo_spiel->heim;
              $spielfreibb[$i1] = $lmo_spiel->gast;
            }
            if ($lmo_spiel->anstoss !== null) {
              $dum1 = strtr(date($lmo_html_e->datumsformat($defdateformat), $lmo_spiel->anstoss), $trans_lang);
            } else {
              $dum1 = "&nbsp;";
            } // Anstosszeit einblenden
?>
    <tr>
      <td><?php echo $dum1;?>&nbsp;</td>
      <td align="right"><?php echo $heimteam;?></td>
      <td><?php echo HTML_icon($heimteam, 'teams');?></td>
      <td>-</td>
      <td><?php echo HTML_icon($gastteam, 'teams');?></td>
      <td><?php echo $gastteam;?>&nbsp;</td>
      <td align="right"><?php echo $heimtore;?></td>
      <td>:</td>
      <td align="left"><?php echo $gasttore;?></td><?php
            if ($lmo_spiel->wertung == 3) {?>
      <td width="2">/</td>
      <td align="right"><?php echo $gasttore;?></td>
      <td align="center" width="8">:</td>
      <td align="left"><?php echo $heimtore;?></td>
<?php
            }?>

    </tr>
<?php
          }
        }?>
  </table>
<?php
        if ($lmo_html_spielfrei) {
          $spielfreicc = array_merge($spielfreiaa, $spielfreibb);
          $i = 1;
          foreach ($lmo_liga->alleMannschaften() as $j => $lmo_mannschaft) {
            if (!in_array($j, $spielfreicc)) {
              if ($i == 1) {?>
  <p><small><?php echo $text[4004];?>: <?php
              }
              echo $lmo_mannschaft->anzeigename();?>&nbsp;&nbsp;<?php
              $i ++;
            }
          }?>
  </small></p><?php
        }
      }//if empty
    }?>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562];?><\/a><\/small>');</script>
</body>
</html>
<?php
  fwrite($wmlfile, ob_get_contents());
  ob_end_clean();
  fclose($wmlfile);
}
?>
