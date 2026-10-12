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
 * @var array<int|string, mixed> $atore
 * @var array<int|string, mixed> $dtore
 * @var array<int|string, mixed> $etore
 * @var array<int|string, mixed> $negativ
 * @var array<int|string, mixed> $punkte
 * @var array<int|string, mixed> $spiele
 * @var mixed $tab1
 * @var mixed $trans_lang
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
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
  $actual = $lmo_html_e->spieltage();
} else {
  $actual = $lmo_html_e->aktuellerSpieltag();
}

// Die Tabelle hat lmo-savehtml.php schon gerechnet; laeuft diese Datei allein, wird sie hier gerechnet.
if (!$lmo_html_e->istPokal()) {
  $endtab = $actual;
  include_once(PATH_TO_LMO . "/lmo-calctable.php");
}
if (!$lmo_html_e->istPokal()) {
  isset($tab0) ? $table1=$tab0 : $table1 = $tab1;
  if (isset($table1)) {
    $wmlfile= fopen(PATH_TO_LMO . '/' . $diroutput.basename($file) . "-sp.html","wb");
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
    table {margin:auto; max-width:200mm;}
    #tabelle{border:1pt solid #000; border-radius:6px; margin:2pt auto;}
    table table {border:1pt solid #000; margin:20pt 0 2pt; border-radius:6px; auto; width:100%;}
    td {padding:10; white-space:nowrap;}
    th {border-bottom:1px solid #000;}
    h1 {font:14pt bolder;}
    caption {font-weight:bolder; white-space:nowrap;}
  </style>
</head>
<body>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562];?><\/a><\/small>');</script>
  <h1><?php echo $lmo_html_e->name();?></h1>
  <table>
    <tr>
      <td>
<?php
    for ($y1 = 1; $y1 < $lmo_html_e->spieltage() + 1; $y1 ++) {
      $spielfreiaa = $spielfreibb = array();
      $datumanz = $y1 - 1;
      $lmo_spieltag = $lmo_liga->spieltage[$y1] ?? new \Lmo\Liga\Rohdaten\Spieltag();
      // gibt es an diesem Spieltag ueberhaupt eine Partie?
      $z = array_filter($lmo_html_spiele($y1), static fn (\Lmo\Liga\Spiel $lmo_s): bool => $lmo_s->heim > 0);
      if (!empty($z)) {
?>
        <table>
        <caption><?php echo $y1;?>.  <?php echo $text[2];?><?php if ($lmo_spieltag->ersterTagText()!='') { echo ' - ' . $lmo_spieltag->ersterTagText() . ' ' . $text[4] . ' ' . $lmo_spieltag->letzterTagText();}?></caption>
<?php
        foreach ($lmo_html_spiele($y1) as $lmo_spiel) {
          $i1 = $lmo_spiel->partie - 1;
          if (($lmo_spiel->heim > 0) && ($lmo_spiel->gast > 0)) {
            $heimteam = $lmo_spiel->heimMannschaft()->anzeigename();
            $gastteam = $lmo_spiel->gastMannschaft()->anzeigename();
            $heimtore = $lmo_spiel->toreHeimText($lmo_html_faktor);
            $gasttore = $lmo_spiel->toreGastText($lmo_html_faktor);
            //  * Spielfrei-Hack-Beginn1 - Autor: Bernd Hoyer - eMail: info@salzland-info.de
            if ($lmo_html_spielfrei) {
              $spielfreiaa[$i1] = $lmo_spiel->heim;
              $spielfreibb[$i1] = $lmo_spiel->gast;
            }
            //  * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de
            if ($lmo_spiel->anstoss !== null) {
              $dum1 = strtr(date($lmo_html_e->datumsformat($defdateformat), $lmo_spiel->anstoss), $trans_lang);
            } else {
              $dum1 = "";
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
            <td align="left"><?php echo $gasttore;?></td>
<?php
            if ($lmo_spiel->wertung == 3) {
?>
            <td width="2">/</td>
            <td align="right"><?php echo $gasttore;?></td>
            <td align="center" width="8">:</td>
            <td align="left"><?php echo $heimtore;?></td>
<?php
            }
?>
          </tr>
<?php
          }
        }
        $actual = $actual + 1;
      }
      if (!empty($z)) {
?>
        </table>
<?php
      }
      if ($lmo_html_spielfrei) {
        $spielfreicc = array_merge($spielfreiaa, $spielfreibb);
        unset($spielfreiaa);
        unset($spielfreibb);
        $i = 1;
        foreach ($lmo_liga->alleMannschaften() as $j => $lmo_mannschaft) {
          if (!in_array($j, $spielfreicc)) {
            if ($i == 1) {?>
      <p><small><?php echo $text[4004];?>: <?php
            }
            echo $lmo_mannschaft->anzeigename();?>&nbsp;&nbsp;<?php
            $i ++;
          }
        }
?>
      </small></p>
<?php
        unset($spielfreicc);
      }
    }
    $datumanz = $actual - 1;
?>
      </td>
    </tr>
  </table>
  <table id="tabelle">
  <caption><?php echo $text[16];?></caption>
    <tr>
      <th colspan=3>&nbsp;</th>
      <th><?php echo $text[33];?></th>
      <th colspan=2><?php echo $text[37];?>&nbsp;</th>
      <th><?php echo $text[38];?>&nbsp;</th>
      <th align="right" >&nbsp;&nbsp;<?php echo $text[39];?></th>
    </tr>
<?php
    for ($i1 = 0; $i1 < $lmo_html_e->mannschaften(); $i1 ++) {
      $platz = $i1 + 1;
      $i4 = (int)substr($table1[$i1], 35, 7);
      $teamname = $i4 == 0 ? '___' : $lmo_liga->mannschaftsname($i4);
      $pluspunkte = applyFactor($punkte[$i4], $lmo_html_e->punktfaktor());
      $minuspunkte = applyFactor($negativ[$i4], $lmo_html_e->punktfaktor());
      $kegelnholz = applyFactor($dtore[$i4], $lmo_html_faktor);
      $plustore = applyFactor($etore[$i4], $lmo_html_faktor);
      $minustore = applyFactor($atore[$i4], $lmo_html_faktor);
      $torverhaeltnis = applyFactor($dtore[$i4], $lmo_html_faktor);
      $spieleteam = $spiele[$i4];
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
      } else {?>
      </td>
      <td align="left">&nbsp;</td><?php
      }
?>
      <td align="right"><?php echo "$plustore:$minustore";?>&nbsp;</td>
      <td align="right">&nbsp;&nbsp;<?php echo $torverhaeltnis;?></td>
    </tr>
<?php
    }
?>
  </table>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562];?><\/a><\/small>');</script>
</body>
</html>
<?php
  }
  fwrite($wmlfile, ob_get_contents());
  ob_end_clean();
  fclose($wmlfile);
}
?>
