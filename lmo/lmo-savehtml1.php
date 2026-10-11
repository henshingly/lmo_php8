<?php
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
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


if (!isset($ligaDaten->namepkt)) {$ligaDaten->namepkt = "";}
if (!isset($ligaDaten->nametor)) {$ligaDaten->nametor = "";}

if ($st > 0) {
  $actual = $ligaDaten->anzst;
} else {
  $actual = $ligaDaten->stx;
}

if ($ligaDaten->lmtype == 0) {
  for ($i1 = 0; $i1 < $ligaDaten->anzsp; $i1 ++) {
    if ($ligaDaten->goala[$actual - 1][$i1] == "-1") $ligaDaten->goala[$actual - 1][$i1] = "_";
    if ($ligaDaten->goalb[$actual - 1][$i1] == "-1") $ligaDaten->goalb[$actual - 1][$i1] = "_";
  }
  $endtab = $actual;
  include_once(PATH_TO_LMO . "/lmo-calctable.php");

  for ($i1 = 0; $i1 < $ligaDaten->anzsp; $i1++) {
    if ($ligaDaten->goala[$actual - 1][$i1] == "_") $ligaDaten->goala[$actual - 1][$i1] = "-1";
    if ($ligaDaten->goalb[$actual - 1][$i1] == "_") $ligaDaten->goalb[$actual - 1][$i1] = "-1";
  }
}
if ($ligaDaten->lmtype == 0) {
  isset($tab0) ? $table1=$tab0 : $table1 = $tab1;
  if (isset($table1)) {
    $wmlfile= fopen(PATH_TO_LMO . '/' . $diroutput.basename($file) . "-sp.html","wb");
    ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $ligaDaten->titel;?></title>
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
  <h1><?php echo $ligaDaten->titel;?></h1>
  <table>
    <tr>
      <td>
<?php
    for ($y1 = 1; $y1 < $ligaDaten->anzst + 1; $y1 ++) {
      $spielfreiaa = $spielfreibb = array();
      $datumanz = $y1 - 1;
      $z = array_filter($ligaDaten->teama[$y1 - 1], "filterZero");
      if (!empty($z)) {
?>
        <table>
        <caption><?php echo $y1;?>.  <?php echo $text[2];?><?php if ($ligaDaten->datum1[$datumanz]!='') { echo ' - ' . $ligaDaten->datum1[$datumanz] . ' ' . $text[4] . ' ' . $ligaDaten->datum2[$datumanz];}?></caption>
<?php
        $datsort = $ligaDaten->mterm[$y1 - 1];
        asort($datsort);
        reset($datsort);
        foreach($datsort as $key => $val) {
          $i1 = $key;
          if (($ligaDaten->teama[$y1 - 1][$i1] > 0) && ($ligaDaten->teamb[$y1 - 1][$i1] > 0)) {
            $heimteam = $ligaDaten->teams[$ligaDaten->teama[$y1 - 1][$i1]];
            $gastteam = $ligaDaten->teams[$ligaDaten->teamb[$y1 - 1][$i1]];
            $heimtore = applyFactor($ligaDaten->goala[$y1 - 1][$i1], $ligaDaten->goalfaktor);
            $gasttore = applyFactor($ligaDaten->goalb[$y1 - 1][$i1], $ligaDaten->goalfaktor);
            if ($gasttore < 0) $gasttore = "_";
            if ($heimtore < 0) $heimtore = "_";
            //  * Spielfrei-Hack-Beginn1 - Autor: Bernd Hoyer - eMail: info@salzland-info.de
            if (($ligaDaten->anzteams - ($ligaDaten->anzst / 2 + 1)) != 0) {
              $spielfreiaa[$i1] = $ligaDaten->teama[$y1 - 1][$i1];
              $spielfreibb[$i1] = $ligaDaten->teamb[$y1 - 1][$i1];
            }
            //  * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de
            if ($ligaDaten->mterm[$y1 - 1][$i1] > 0) {
              $dum1 = strtr(date($ligaDaten->datf, $ligaDaten->mterm[$y1-1][$i1]), $trans_lang);
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
            if ($ligaDaten->msieg[$y1 - 1][$i1] == 3) {
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
      if (($ligaDaten->anzteams - ($ligaDaten->anzst / 2 + 1)) != 0) {
        $spielfreicc = array_merge($spielfreiaa, $spielfreibb);
        unset($spielfreiaa);
        unset($spielfreibb);
        $i = 1;
        for ($j = 1; $j < $ligaDaten->anzteams + 1; $j ++) {
          if (!in_array($j, $spielfreicc)) {
            if ($i == 1) {?>
      <p><small><?php echo $text[4004];?>: <?php
            }
            echo $ligaDaten->teams[$j];?>&nbsp;&nbsp;<?php
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
      <th colspan=2><?php echo $ligaDaten->namepkt;?>&nbsp;</th>
      <th><?php echo $ligaDaten->nametor;?>&nbsp;</th>
      <th align="right" >&nbsp;&nbsp;<?php echo $text[39];?></th>
    </tr>
<?php
    for ($i1 = 0; $i1 < $ligaDaten->anzteams; $i1 ++) {
      $platz = $i1 + 1;
      $i4 = (int)substr($table1[$i1], 35, 7);
      $teamname = $ligaDaten->teams[$i4];
      $pluspunkte = applyFactor($punkte[$i4], $ligaDaten->pointsfaktor);
      $minuspunkte = applyFactor($negativ[$i4], $ligaDaten->pointsfaktor);
      $kegelnholz = applyFactor($dtore[$i4], $ligaDaten->goalfaktor);
      $plustore = applyFactor($etore[$i4], $ligaDaten->goalfaktor);
      $minustore = applyFactor($atore[$i4], $ligaDaten->goalfaktor);
      $torverhaeltnis = applyFactor($dtore[$i4], $ligaDaten->goalfaktor);
      $spieleteam = $spiele[$i4];
?>
    <tr>
      <td align="right"><?php echo $platz;?>&nbsp;</td>
      <td><?php echo HTML_icon($teamname, 'teams');?>&nbsp;</td>
      <td><?php echo $teamname;?>&nbsp;</td>
      <td align="right"><?php echo $spieleteam;?>&nbsp;</td>
      <td align="right"><?php echo $pluspunkte;
      if ($ligaDaten->minus == 2) {?>:</td>
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
