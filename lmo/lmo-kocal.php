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

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $md
 */
  

if ($file != "") {
  $addk = $_SERVER['PHP_SELF']."?action=cal&amp;file=".$file."&amp;cal=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $me = array("0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $mb = date("mY", strtotime("now"));
  $cal=isset($_GET['cal'])?$_GET['cal']:null;
  
  //Anzeigezeitraum festlegen
  if (isset($cal)) {  //Zeitraum vorgegeben
    if (strlen($cal) > 4) {
      $lmo_month_prev = strtotime("1 ".$me[intval(substr($cal, 0, 2))]." ".substr($cal, 2)." -1 month");
      $lmo_month_this = strtotime("1 ".$me[intval(substr($cal, 0, 2))]." ".substr($cal, 2));
      $lmo_month_next = strtotime("1 ".$me[intval(substr($cal, 0, 2))]." ".substr($cal, 2)." +1 month");
    } else {
      $lmo_month_prev = strtotime("1 ".$me[1]." ".substr($cal, 2)." -1 year");
      $lmo_month_this = strtotime("1 ".$me[1]." ".substr($cal, 2));
      $lmo_month_next = strtotime("1 ".$me[1]." ".substr($cal, 2)." +1 year");
    }
  } else {
    // Anstosszeiten der gewaehlten Runde; Spiele ohne Anstoss zaehlen nicht
    $lmo_termine = array();
    foreach ($lmo_liga->spiele((int)$st) as $lmo_spiel) {
      if ($lmo_spiel->anstoss !== null) {
        $lmo_termine[] = $lmo_spiel->anstoss;
      }
    }
    if (!empty($lmo_termine)) {
      $datum = explode('.', date("d.m.Y",min($lmo_termine)));
      $lmo_month_prev = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." -1 month");
      $lmo_month_this = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      $lmo_month_next = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." +1 month");
    } else {
      $lmo_month_prev = strtotime("-1 month");
      $lmo_month_this = strtotime("now");
      $lmo_month_next = strtotime("+1 month");
    }
  }
  
  //Datenformate generieren
  if ($lmo_month_this != -1) {
    if (!isset($cal)) {
      $cal = date("mY", $lmo_month_this);
    }
    if (strlen($cal) > 4) {  //Monatsanzeige
      $ma = date("mY", $lmo_month_prev);
      $mc = date("mY", $lmo_month_next);
      $md = date("F Y", $lmo_month_this);
      $ml = date("Y", $lmo_month_this);
      $mj = " ".$me[intval(date("m", $lmo_month_this))]." ".date("Y", $lmo_month_this);
      $dat1 = getdate(strtotime("1".$mj));
      $erster = $dat1['wday'];
    } else {  //Jahresanzeige
      $ma = date("Y", $lmo_month_prev);
      $mc = date("Y", $lmo_month_next);
      $md = date("Y", $lmo_month_this);
      $mj = " ".date("Y", $lmo_month_this);
    }
  }
  
  if (strlen($cal) > 4) {   //Monatsanzeige
    $lmo_arrays=32;
    $lmo_daterule="F Y";
    $lmo_daterule2="d";
  } else {                  //Jahresanzeige
    $lmo_arrays=13;
    $lmo_daterule="Y";
    $lmo_daterule2="m";
  }
  
  $lmo_stlink = array_pad(array(), $lmo_arrays, '');
  $lmo_runden = $lmo_liga->einstellungen()->spieltage();
  // $j: Runde ab 0
  for ($j = 0; $j < $lmo_runden; $j++) {
    $lmo_stlink_title = array_pad(array(), $lmo_arrays, '');
      
      //Bezeichnungen generieren
    if ($j == $lmo_runden-1) {
      $text2 = $text[364];
      $text1 = $text[374];
    } elseif ($j == $lmo_runden-2) {
      $text2 = $text[362];
      $text1 = $text[373];
    } elseif ($j == $lmo_runden-3) {
      $text2 = $text[360];
      $text1 = $text[372];
    } elseif ($j == $lmo_runden-4) {
      $text2 = $text[358];
      $text1 = $text[371];
    } else {
      $text1 = ($j+1).". ".$text[370];
      $text2 = ($j+1).". ".$text[376];
    }
      
    // die Paarungen der Runde und ihre Spiele zum Anzeigen (Lmo\Liga\Paarung, Lmo\Liga\Spiel); $n: Spiel ab 0
    foreach ($lmo_liga->paarungen($j + 1) as $lmo_paarung) {
      foreach ($lmo_paarung->spiele as $n => $lmo_spiel) {
        if ($lmo_spiel->anstoss !== null && date($lmo_daterule, $lmo_spiel->anstoss) == $md) { //konkretes Spieldatum vorhanden
          $a = intval(date($lmo_daterule2, $lmo_spiel->anstoss));
          if (($lmo_paarung->heim != 0) && ($lmo_paarung->gast != 0)) {
            if (!empty($lmo_stlink_title[$a])) {
              $lmo_stlink_title[$a] = $lmo_stlink_title[$a].", &#10;";
            } else {
              $lmo_stlink_title[$a] = $text1.": &#10;";
            }
            $lmo_stlink_title[$a] = $lmo_stlink_title[$a].$lmo_paarung->heimMannschaft()->anzeigename()." - ".$lmo_paarung->gastMannschaft()->anzeigename();
            if (count($lmo_paarung->spiele) > 1) {
              $lmo_stlink_title[$a] = $lmo_stlink_title[$a]." &#10;(".($n+1).". ".$text[375].")";
            }
          }
        }
      }
    }

    //Spieltagsdatum: erster und letzter Tag als Zeit, '' wenn er fehlt
    $lmo_spieltag = $lmo_liga->spieltage[$j + 1] ?? new \Lmo\Liga\Rohdaten\Spieltag();
    $lmo_stdatum1 = $lmo_spieltag->ersterTag() ?? '';
    $lmo_stdatum2 = $lmo_spieltag->letzterTag() ?? '';

    $z=array_filter($lmo_stlink_title,"filterZero");      
    if (!empty($lmo_stdatum1) && empty($z) && date($lmo_daterule, $lmo_stdatum1) == $md) {  //Nur Von... vorhanden
      $a = intval(date($lmo_daterule2, $lmo_stdatum1));
      $lmo_stlink_title[$a] = ($j+1).". ".$text[2]." &#10;(".$text[155].")";
      if (!empty($lmo_stdatum2) && $lmo_stdatum2>$lmo_stdatum1) { //Von ... bis ... vorhanden
        for ($k = $a; $k <= intval(date($lmo_daterule2, $lmo_stdatum2)); $k++) {
          $lmo_stlink_title[$k] = ($j+1).". ".$text[2]." &#10;(".$text[155].")";
        }
      }
    }
    if (!empty($lmo_stdatum2) && empty($z) && date($lmo_daterule, $lmo_stdatum2) == $md) {  //Nur ...Bis vorhanden
      $a = intval(date($lmo_daterule2, $lmo_stdatum2));
      $lmo_stlink_title[$a] = ($j+1).". ".$text[2]." &#10;(".$text[155].")";
    }
    
    //Links generieren
    for ($i = 0; $i < count($lmo_stlink_title); $i++) {
      if (!empty($lmo_stlink_title[$i])) { 
        $lmo_stlink[$i] = $lmo_stlink[$i]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$lmo_stlink_title[$i]."\">".($j+1).". ".$text[145]."</a><br>";;
      }
    }
    
  } //for $anzst
  include(PATH_TO_LMO."/lmo-showcal.php");
}?>