<?
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
  
  

require_once(dirname(__FILE__).'/../../init.php');

$file = isset($_GET['file'])? $_GET['file']: exit;

//Konfiguration laden
require(PATH_TO_ADDONDIR.'/spieler/lmo-statloadconfig.php');
 
$sort = isset($_GET['sort'])? $_GET['sort']: $spieler_standard_sortierung;
if (isset($_GET['begin'])) { 
  $begin = $_GET['begin'];
  $all=false;
} else {
  $begin = 0;
  $all=true;
}
$direction = isset($_GET['direction'])? $_GET['direction']: $spieler_standard_richtung;
$team = isset($_GET['team'])? urldecode($_GET['team']): '';
 
if ($filepointer = fopen($filename, "r+b")) {
  $spalten = array(); //Spaltenbezeichnung
  $data = array(); //Daten
  $typ = array(); //Spaltentyp (TRUE=String)
  $spalten = fgetcsv($filepointer, 10000, "§"); //Zeile mit Spaltenbezeichnern
  $formel = FALSE;
  for ($i = 0; $i < count($spalten); $i++) {
    if (strstr($spalten[$i], "*_*-*")) {
      $formel = TRUE;
      $spalten[$i] = substr($spalten[$i], 0, strlen($spalten[$i])-5);
    }
    if ($spalten[$i] == $text['spieler'][25]) {
      $vereinsspalte = $i;
    }
  }
  if ($formel) fgetcsv($filepointer, 10000, "§"); //Zeile mit Formeln
   
  $linkspalte = array_search($text['spieler'][32], $spalten); //Linkunterstützung aktiviert?
   
  $zeile = 0;
  while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
    if ((isset($vereinsspalte) && isset($data[$zeile][$vereinsspalte]) && $spieler_vereinsweise_anzeigen == 1 && $team == $data[$zeile][$vereinsspalte]) || $team == '') {
      for($i = 0; $i < count($data[$zeile]); $i++) {
        if (!is_numeric($data[$zeile][$i])) $typ[$i] = TRUE;
      }
      $zeile++;
    } else {
      array_pop($data);
    }
  }
  array_pop($data);
  if ($spieler_nullwerte_anzeigen == 0 && !isset($typ[$sort])) $data = array_filter($data, 'filterNullwerte'); //Nullwerte ausfiltern
  if ($direction == 1) {
    if (!isset($typ[$sort])) usort($data, 'cmpInt');
       else usort($data, 'cmpStr2');
  } else {
    if (!isset($typ[$sort])) usort($data, 'cmpInt2');
       else usort($data, 'cmpStr');
  }
   
  $spaltenzahl = count($spalten);
   
  if ($begin+$spieler_anzeige_pro_seite > $zeile) $maxdisplay = $zeile-$begin;
   else $maxdisplay = $spieler_anzeige_pro_seite;
  if ($spieler_anzeige_pro_seite <= 0 || $all==true) {
    $maxdisplay = $zeile;
    $begin = 0;
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
  <head>
    <title><?=$text['spieler'][18]?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
    <style type="text/css">
      body {background:#fff; color:#000; font: sans-serif 10pt; max-width:200mm;max-height:285mm;}
      caption, p, h1 {margin: 3pt auto; text-align:center;}
      table {border:1pt solid #000;margin: 2pt auto;}
      td {padding: 0;white-space:nowrap;}
      th {padding: 1pt;border-bottom: 1px solid #000;border-right: 1px solid #000;}
      h1 {font:14pt bolder;}
      .odd {background:#eee;}
      caption {margin-top:10pt;font-weight:bolder;}
      @media print {
        a {display:none;}
      }
    </style>
  </head>
  <body>
    <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?=$text[562]?><\/a><\/small>');</script>
    <h1><?
      echo $text['spieler'][18];
      if ($team!='') {
        echo ' - '.$team;
      }?>
    </h1>
      <table cellpadding="0" cellspacing="1" border="0">
        <tr>
          <th colspan="2"></th><?
  for ($i=0;$i<$spaltenzahl;$i++) {
    if ($spalten[$i]!=$text['spieler'][32] && ($spalten[$i]!=$text['spieler'][25] || $team=='')){?>
          <th class="nobr" align="center"><?=$spalten[$i]?></th><?
    }
  }?>
        </tr><?
  for ($j1=$begin;$j1<$begin+$maxdisplay;$j1++) {
    $class=fmod($j1,2)!=0?" class='odd'":'';?>
          <tr><?
    for ($j2=0;$j2<$spaltenzahl;$j2++) {
      if ($j2==$sort){ 
        $stat_class=' class="lmoBackMarkierung nobr"';
      } else {
        $stat_class=' class="nobr"';
      }
      if ($j2==0) {?><td align="right"<?=$class?>><strong><?
        if (!isset($data[$j1-1][$sort]) || $data[$j1][$sort] !== $data[$j1-1][$sort] && $j1!=$begin) echo ($j1+1).". ";
        
        if ($j1>0 && $j1==$begin) {
          for ($x=$begin-1; $x>=0; $x--){
            if ($data[$x][$sort]!=$data[$j1][$sort]) {
              echo ($x+2).". ";
              break;
            }
            if ($x==0) echo "1. ";
          }
        }?>
            </strong></td>
            <td align="left"<?=$class?>><?
              //Spielerbild
        if (file_exists(PATH_TO_IMGDIR."/spieler/".$data[$j1][$j2].".jpg")) {
          $imgdata=getimagesize(PATH_TO_IMGDIR."/spieler/".$data[$j1][$j2].".jpg");?>
               <img border="0" src="<?=URL_TO_IMGDIR."/spieler/".rawurlencode($data[$j1][$j2])?>.jpg" <?=$imgdata[3]?> alt="<?=$text['spieler'][26]?>" title="<?=$data[$j1][$j2]?>"><?
        } elseif (file_exists(PATH_TO_IMGDIR."/spieler/".$data[$j1][$j2].".gif")) {
          $imgdata=getimagesize(PATH_TO_IMGDIR."/spieler/".$data[$j1][$j2].".gif");?>
                <img border="0" src="<?=URL_TO_IMGDIR."/spieler/".rawurlencode($data[$j1][$j2])?>.gif" <?=$imgdata[3]?> alt="<?=$text['spieler'][26]?>" title="<?=$data[$j1][$j2]?>"><?
        } ?></td><?
      } ?>
            <td<?
            echo $class;
            
            if ($spalten[$j2]!=$text['spieler'][32] && ($spalten[$j2]!=$text['spieler'][25] || $team=='')){
              if (is_numeric($data[$j1][$j2])) {
                echo " align='center'>";
              } else {
                echo " align='left'>";
              }
              if ($j2==$sort) echo "<strong>";
              echo  $data[$j1][$j2];
              if ($j2==$sort) echo "</strong>";
            }?></td><?
    }?>
          </tr><?
  }?>

      </table>
      <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?=$text[562]?><\/a><\/small>');</script><?
}else{?>
  <?php echo getMessage($text['spieler'][14],TRUE);?><?
}
function cmpInt ($a1, $a2) {
  global $sort;
  if ($a2[$sort]==$a1[$sort]) return 0;
  return ($a1[$sort]>$a2[$sort]) ? -1 : 1;
}
function cmpStr ($a2, $a1) {
  global $sort;
  $a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  $a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  $c = strnatcasecmp($a2[$sort],$a1[$sort]);
  return $c;
}
function cmpInt2 ($a1, $a2) {
  global $sort;
  if ($a2[$sort]==$a1[$sort]) return 0;
  return ($a1[$sort]>$a2[$sort]) ? 1 : -1;
}
function cmpStr2 ($a2, $a1) {
  global $sort;
  $a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  $a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  $c = strnatcasecmp($a2[$sort],$a1[$sort]);
  return -1*$c;
}
function filterNullwerte ($a) {
  global $sort,$zeile;
  if ($a[$sort]==0) $zeile--;
  return ($a[$sort]!=0);
}
?>