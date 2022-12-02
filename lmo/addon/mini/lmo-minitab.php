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
  * $Id$
  */

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
$cfgarray['mini']['classFavorit']='';
$LastClass='';

//4-stufiges Fallback für diese Variablen
//1.GET-Parameter(IFRAME)->2.Variable vorhanden(include)->3.Configwert->4. Standardwert
$m_template = !empty($_GET['mini_template'])? str_replace('..','',$_GET['mini_template']):
                (isset($mini_template)? str_replace('..','',$mini_template):$cfgarray['mini']['standardTemplate'] );
if (!is_readable(PATH_TO_TEMPLATEDIR."/mini/$m_template.tpl.php") ) $m_template = "standard";

$m_liga = !empty($_GET['mini_liga'])? urldecode($_GET['mini_liga']):
            (isset($mini_liga)? $mini_liga:
              (isset($mini_standardLiga)? $cfgarray['mini']['standardLiga']: '') );
$m_ueber= !empty($_GET['mini_ueber'])? urldecode($_GET['mini_ueber']):
            (isset($mini_ueber)? $mini_ueber:
              (isset($cfgarray['mini']['standardAnzahlueber'])?$cfgarray['mini']['standardAnzahlueber']: 2) );
$m_unter= !empty($_GET['mini_unter'])? urldecode($_GET['mini_unter']):
            (isset($mini_unter) ? $mini_unter:
              (isset($cfgarray['mini']['standardAnzahlunter'])? $cfgarray['mini']['standardAnzahlunter']: 2) );
$m_platz= !empty($_GET['mini_platz'])? urldecode($_GET['mini_platz']):
            (isset($mini_platz)? $mini_platz:
              (!empty($cfgarray['mini']['standardTabellenPlatz'])? $cfgarray['mini']['standardTabellenPlatz']: NULL) );

//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-minitab.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
          "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Minitab</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="//cdn.jsdelivr.net/npm/bootstrap@<?php echo $cfgarray['bootstrap']; ?>/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" >
</head>
<body><?php
}

$CacheOutput='';
$TableCacheFile = PATH_TO_LMO.'/'.$diroutput.basename($m_liga)."-".$m_template.".cache";
// Wenn Cache File vorhanden und auf Aktuellen Stand, gib dies aus.
if (is_readable($TableCacheFile) && $cfgarray['mini']['CacheTable'] == 1) {
  $CacheFile= file ($TableCacheFile);
  if (trim(array_shift($CacheFile)) == (filemtime(PATH_TO_LMO.'/'.$dirliga.$m_liga)."-".$m_template."|$m_ueber|$m_unter|$m_platz")  ) {
    // echo "Cache Ausgabe: <br>";
    $CacheOutput= print implode("",$CacheFile);
  }
}
if (empty($CacheOutput)) {
  //"Direkte Ausgabe: <br>";
  $liga = new liga();
  if (is_readable(PATH_TO_LMO.'/'.$dirliga.$m_liga) && $m_liga && $liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$m_liga) ) {
    $template = new HTML_Template_IT( PATH_TO_TEMPLATEDIR.'/mini' );
    $template->loadTemplatefile($m_template.".tpl.php");

    $AnzahlTeams= $liga->teamCount();
    $LigaTabelle= $liga->calcTable($liga->options->keyValues['Rounds']);
    $LastGameDay= $liga->calcTable($liga->options->keyValues['Actual']-1);
    $Favorit = $liga->teamForNumber($liga->options->keyValues['favTeam']);
    $viewPosition = 1;
    if ( is_null($m_platz) || $m_platz <= 0 || $m_platz > $AnzahlTeams ) {
      if (is_object($Favorit)) {
        foreach ($LigaTabelle as $value) {
          if ($Favorit->nr == $value['team']->nr ) {
            $viewPosition= $value['pos'];
          }
        }
      }
    } else {
      $viewPosition = $m_platz;
    }
    $beginTabellenPlatz= $viewPosition-$m_unter;
    $endTabellenPlatz= $viewPosition+$m_ueber;
    if ($beginTabellenPlatz<=0) {
      $beginTabellenPlatz = 1;
      $endTabellenPlatz = $m_unter+1+$m_ueber<$AnzahlTeams? $m_unter+1+$m_ueber:$AnzahlTeams;
    }
    if ($endTabellenPlatz>$AnzahlTeams ) {
      $endTabellenPlatz = $AnzahlTeams;
      $beginTabellenPlatz = $AnzahlTeams-$m_unter-1-$m_ueber>0? $AnzahlTeams-$m_unter-1-$m_ueber:1 ;
    }

    for ($j=0; $j<$AnzahlTeams ; $j++) {
      if ($LigaTabelle[$j]['pos'] >= $beginTabellenPlatz && $LigaTabelle[$j]['pos'] <= $endTabellenPlatz ) {

        $template->setCurrentBlock("Inhalt");
        $template->setVariable('Platz',"<strong>".$LigaTabelle[$j]['pos']."</strong>");
        $template->setVariable('TeamBild',HTML_icon($LigaTabelle[$j]['team']->name,'teams','small'));
        $template->setVariable('TeamBildMiddle',HTML_icon($LigaTabelle[$j]['team']->name,'teams','middle'));
        $template->setVariable('TeamBildBig',HTML_icon($LigaTabelle[$j]['team']->name,'teams','big'));
        $template->setVariable('TeamLang',$LigaTabelle[$j]['team']->name);
        $template->setVariable('TeamMittel',(isset($LigaTabelle[$j]['team']->mittel)?$LigaTabelle[$j]['team']->mittel:''));
        $template->setVariable('Team',$LigaTabelle[$j]['team']->kurz);
        $template->setVariable('Teamnotiz',$LigaTabelle[$j]['team']->valueForKey("NOT"));
        if ($liga->options->keyValues['MinusPoints'] == 1) {
          $template->setVariable('Punkte',$LigaTabelle[$j]['pPkt']);
        } else {
          $template->setVariable('Punkte',$LigaTabelle[$j]['pPkt'].':'.$LigaTabelle[$j]['mPkt']);
        }
        $template->setVariable('PlusTore',$LigaTabelle[$j]['pTor']);
        $template->setVariable('MinusTore',$LigaTabelle[$j]['mTor']);
        if (($m_diff=$LigaTabelle[$j]['pTor']-$LigaTabelle[$j]['mTor'])>0) {
          $m_diff='+'.$m_diff;
        }
        $template->setVariable('Tordifferenz',$m_diff);
        // Dart Liga
        if (isset($m_tabelle)) {
          //not sure if this code is still functional
          $template->setVariable('PlusSaetze',$m_tabelle[$j][12]);
          $template->setVariable('MinusSaetze',$m_tabelle[$j][13]);
          if (( $satzDiff = $m_tabelle[$j][12]-$m_tabelle[$j][13]) > 0 ) {
            $satzDiff = "+".$satzDiff;
          }
          $template->setVariable('SatzDifferenz',$satzDiff);
        }
        // Dart Liga
        $template->setVariable('Spiele',$LigaTabelle[$j]['spiele']);
        $template->setVariable('Siege',$LigaTabelle[$j]['s']);
        $template->setVariable('Unentschieden',$LigaTabelle[$j]['u']);
        $template->setVariable('Niederlagen',$LigaTabelle[$j]['n']);
        foreach ($LastGameDay as $LetzterSpieltag) {
          if ($LigaTabelle[$j]['team']->nr == $LetzterSpieltag['team']->nr) {
            $Tendenz = $LetzterSpieltag['pos']-$LigaTabelle[$j]['pos'];
            $template->setVariable('Tendenz',($Tendenz>0?'+'.$Tendenz:$Tendenz) );
            break;
          }
        }
        // Style Classes anhand der liga Options errechnen  -- um Alte Templates zu nutzen wird auch style mit ausgegeben
        $style= "";$css_class= "";

        // Striped Tables
        if (!empty($cfgarray['mini']['stripedTable'])) {
          $stripedColor = explode(";",trim($cfgarray['mini']['stripedTable']) );
          $style.= $j%2==0?"background-color: ".$stripedColor[0].";\n":"background-color: ".$stripedColor[1].";\n";
        }

        if ($LigaTabelle[$j]['pos'] <= $liga->options->keyValues['Champ']) {
          // Meister
          $css_class = isset($cfgarray['mini']['tabelle_classMeister'])?$cfgarray['mini']['tabelle_classMeister']:'';
          $style = isset($cfgarray['lmo_tabelle_background1'])?"background: ".$cfgarray['lmo_tabelle_background1']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color1'])?"color: ".$cfgarray['lmo_tabelle_color1'].";":'';
        } elseif ($LigaTabelle[$j]['pos'] <= ($liga->options->keyValues['Champ']+$liga->options->keyValues['CL']) ) {
          // Champions League
          $css_class = isset($cfgarray['mini']['tabelle_classCLAufsteiger'])?$cfgarray['mini']['tabelle_classCLAufsteiger']:'';
          $style = isset($cfgarray['lmo_tabelle_background2'])?"background: ".$cfgarray['lmo_tabelle_background2']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color2'])?"color: ".$cfgarray['lmo_tabelle_color2'].";":'';
        } elseif ($LigaTabelle[$j]['pos'] <= ($liga->options->keyValues['Champ']+$liga->options->keyValues['CL']+$liga->options->keyValues['CK']) ) {
          // CL Qualifikation
          $css_class = isset($cfgarray['mini']['tabelle_classCLQuali'])?$cfgarray['mini']['tabelle_classCLQuali']:'';
          $style = isset($cfgarray['lmo_tabelle_background3'])?"background: ".$cfgarray['lmo_tabelle_background3']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color3'])?"color: ".$cfgarray['lmo_tabelle_color3'].";":'';
        } elseif ($LigaTabelle[$j]['pos'] <= ($liga->options->keyValues['Champ']+$liga->options->keyValues['CL']+$liga->options->keyValues['CK']+$liga->options->keyValues['UC']) ) {
          // UEFA Cup
          $css_class = isset($cfgarray['mini']['tabelle_classUEFA'])?$cfgarray['mini']['tabelle_classUEFA']:'';
          $style = isset($cfgarray['lmo_tabelle_background4'])?"background: ".$cfgarray['lmo_tabelle_background4']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color4'])?"color: ".$cfgarray['lmo_tabelle_color4'].";":'';
        } elseif ($LigaTabelle[$j]['pos'] > ($AnzahlTeams-$liga->options->keyValues['AB']) ) {
          // Abstiegsplaetze
          $css_class = isset($cfgarray['mini']['tabelle_classAbsteiger'])?$cfgarray['mini']['tabelle_classAbsteiger']:'';
          $style = isset($cfgarray['lmo_tabelle_background6'])?"background: ".$cfgarray['lmo_tabelle_background6']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color6'])?"color: ".$cfgarray['lmo_tabelle_color6'].";":'';
        } elseif ($LigaTabelle[$j]['pos'] > ($AnzahlTeams-$liga->options->keyValues['AB']-$liga->options->keyValues['AR']) ) {
          // Abstiegs Relegation
          $css_class = isset($cfgarray['mini']['tabelle_classAbstiegsRelegation'])?$cfgarray['mini']['tabelle_classAbstiegsRelegation']:'';
          $style = isset($cfgarray['lmo_tabelle_background5'])?"background: ".$cfgarray['lmo_tabelle_background5']." repeat;":'';
          $style .= isset($cfgarray['lmo_tabelle_color5'])?"color: ".$cfgarray['lmo_tabelle_color5'].";":'';
        } else {
          $css_class = "";     // "Normale Tabellenplaetze
        }

        // Lined Style Tables
        if ($j && $LastClass != $css_class && !empty($cfgarray['mini']['StyleStripLine'])) {
          $style.= "border-top: ".$cfgarray['mini']['StyleStripLine'].";";
        }
        $LastClass = $css_class;

        //FavTeam
        if (is_object($Favorit) && $LigaTabelle[$j]['team']->nr == $Favorit->nr ){
          $style.="font-weight:bolder;";
          $css_class.= $cfgarray['mini']['classFavorit'];
        }

        $template->setVariable(array("Style"=>$style,"Class"=>$css_class));
        $template->parseCurrentBlock();
      }
    }
    $template->setVariable("LigaBild",HTML_icon(basename($m_liga),'liga','small'));
    $template->setVariable("LigaBildMiddle",HTML_icon(basename($m_liga),'liga','middle'));
    $template->setVariable("LigaBildBig",HTML_icon(basename($m_liga),'liga','big'));
    $template->setVariable("ligaDatum",$text['mini'][14].": ".$liga->ligaDatumAsString("d.m.Y"));
    $template->setVariable("URL_TO_LMO", URL_TO_LMO);
    $template->setVariable("URL_TO_TEMPLATEDIR", URL_TO_TEMPLATEDIR."/mini/");
    $template->setVariable("Link", URL_TO_LMO.'/?action=table&amp;file='.$m_liga);
    $template->setVariable("Tabelle",$text[16]);
    // cache File schreiben
    if ( is_writable(dirname($TableCacheFile)) && $cfgarray['mini']['CacheTable'] == 1 ) {
      $CacheOutput = filemtime(PATH_TO_LMO.'/'.$dirliga.$m_liga)."-".$m_template."|$m_ueber|$m_unter|$m_platz\n".$template->get();
      if ($fileHandle = @fopen($TableCacheFile,"wb") ) {
        fwrite($fileHandle,$CacheOutput);
        fclose($fileHandle);
      }
    }
    $template->show();
  } else {
    echo getMessage($text['mini'][5]." ".$mini_liga,TRUE);
  }
}
//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-minitab.php") {?>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/bootstrap@<?php echo $cfgarray['bootstrap']; ?>/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html><?php
}?>
