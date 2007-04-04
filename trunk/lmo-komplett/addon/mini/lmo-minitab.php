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

// Durch Get bestimmter Parameter (für IFRAME)
$m_liga=       isset($_GET['mini_liga'])?             urldecode($_GET['mini_liga']):       ''; 
$m_ueber=      isset($_GET['mini_ueber'])?            urldecode($_GET['mini_ueber']):      2;  
$m_unter=      isset($_GET['mini_unter'])?            urldecode($_GET['mini_unter']):      2; 
$m_template=   isset($_GET['mini_template'])?         urldecode($_GET['mini_template']):   "standard"; 
$m_platz=      !empty($_GET['mini_platz'])?           urldecode($_GET['mini_platz']):      NULL; 

// Direkt bestimmte Parameter (für include/require)
$m_liga=       isset($mini_liga)?             $mini_liga:       $m_liga;  
$m_ueber=      isset($mini_ueber)?            $mini_ueber:      $m_ueber;  
$m_unter=      isset($mini_unter)?            $mini_unter:      $m_unter; 
$m_template=   isset($mini_template)?         $mini_template:   $m_template; 
$m_platz=      isset($mini_platz)?            $mini_platz:      $m_platz; 

//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-minitab.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Minitab</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<style type="text/css">
  html,body {margin:0;padding:0;background:transparent;}
</style>
</head>
<body><?
}

/**Format of CSV-File:
  *       0     |      1            |   2   |   3   |  4   |  5   |  6  | 7 | 8  |  9 |    10    |  11       |     12
  * TeamLongName|TeamnameAbbrevation|Points+|Points-|Goals+|Goals-|Games|Win|Draw|Loss|Marking   |           |TeamShortName
  *  Teamname   |  Kurzname         |Pkt.+  | Pkt.- |Tore+ | Tore-|Sp.  | + | o  | -  |Markierung| TeamNotiz | Mittelname  
  */
if (file_exists(PATH_TO_LMO.'/'.$diroutput.$m_liga.'-tab.csv')) {
  $template = new HTML_Template_IT( PATH_TO_TEMPLATEDIR.'/mini' );
  $template->loadTemplatefile($m_template.".tpl.php"); 
  
  $m_tabelle=array();

  $handle = fopen (PATH_TO_LMO.'/'.$diroutput.$m_liga.'-tab.csv',"rb");              
  while ( ($data = fgetcsv ($handle, 1000, "|")) !== FALSE ) { 
    $m_tabelle[]=$data;
  }
  fclose($handle);
  $m_anzteams=count($m_tabelle);
  
  for ($i=0;$i<$m_anzteams;$i++) {
    if (empty($m_platz)) {
      if (strpos($m_tabelle[$i][10],"F")!==FALSE) {
        break;
      }  
    } else {
      $i=$m_platz-1;
      break;
    }
  }  
  $nach_unten=$m_anzteams-$i-1-$m_unter;
  $nach_oben=$i-$m_ueber;

  if ($nach_unten<0) {
    $end=$m_anzteams;
    $nach_oben=$nach_oben-(-1)*$nach_unten;
    $nach_unten=0;
  }
  
  if ($nach_oben<0) {
    $nach_unten=$nach_unten-(-1)*$nach_oben;
    if ($nach_unten<0) {
      $nach_unten=0;
    }
    $nach_oben=0;
  }

  for ($j=$nach_oben;$j<$m_anzteams-$nach_unten;$j++) {
    $template->setCurrentBlock("Inhalt");
    $template->setVariable(array("Platz"=>"<strong>".($j+1)."</strong>"));
    $template->setVariable(array("TeamBild"=>getSmallImage($m_tabelle[$j][0])));
    $template->setVariable(array("TeamLang"=>$m_tabelle[$j][0]));
    $template->setVariable(array("TeamMittel"=>(isset($m_tabelle[$j][12])?$m_tabelle[$j][12]:'')));
    $template->setVariable(array("Teamnotiz"=>$m_tabelle[$j][11]));
    $template->setVariable(array("Team"=>$m_tabelle[$j][1]));
    if ($m_tabelle[$j][3]=='') {
      $template->setVariable(array("Punkte"=>$m_tabelle[$j][2]));
    } else {
      $template->setVariable(array("Punkte"=>$m_tabelle[$j][2].':'.$m_tabelle[$j][3]));
    }
    $template->setVariable(array("PlusTore"=>$m_tabelle[$j][4]));
    $template->setVariable(array("MinusTore"=>$m_tabelle[$j][5]));
    if (($m_diff=$m_tabelle[$j][4]-$m_tabelle[$j][5])>0) $m_diff='+'.$m_diff;
    $template->setVariable(array("Tordifferenz"=>$m_diff));
    $template->setVariable(array("Spiele"=>$m_tabelle[$j][6]));
    $template->setVariable(array("Siege"=>$m_tabelle[$j][7]));
    $template->setVariable(array("Unentschieden"=>$m_tabelle[$j][8]));
    $template->setVariable(array("Niederlagen"=>$m_tabelle[$j][9]));
    $style='';
    if ($m_tabelle[$j][10]!='') {
      if (strpos($m_tabelle[$j][10],'M')!==FALSE){  //Meister
        $style="background: $lmo_tabelle_background1 repeat;";
        $style.=empty($lmo_tabelle_color1)?'':"color: $lmo_tabelle_color1;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'C')!==FALSE){  //CL
        $style="background: $lmo_tabelle_background2 repeat;";
        $style.=empty($lmo_tabelle_color2)?'':"color: $lmo_tabelle_color2;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'Q')!==FALSE){  //CL-Quali
        $style="background: $lmo_tabelle_background3 repeat;";
        $style.=empty($lmo_tabelle_color3)?'':"color: $lmo_tabelle_color3;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'U')!==FALSE){   //UEFA
        $style="background: $lmo_tabelle_background4 repeat;";
        $style.=empty($lmo_tabelle_color4)?'':"color: $lmo_tabelle_color4;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'R')!==FALSE){  //Relegation
        $style="background: $lmo_tabelle_background5 repeat;";
        $style.=empty($lmo_tabelle_color5)?'':"color: $lmo_tabelle_color5;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'A')!==FALSE){  //Absteiger
        $style="background: $lmo_tabelle_background6 repeat;";
        $style.=empty($lmo_tabelle_color6)?'':"color: $lmo_tabelle_color6;";
        $template->setVariable(array("Style"=>$style));
      }
    }
    if (strpos($m_tabelle[$j][10],'F')!==FALSE){  //FavTeam
      $style.="font-weight:bolder;";
      $template->setVariable(array("Style"=>$style));
    }
    /*
    if ($j%2==0) {
      $style.="background-color:#ccc;";
      $template->setVariable(array("Style"=>$style));
    } else {
      $style.="background-color:#fff;";
      $template->setVariable(array("Style"=>$style));
    }*/
    $template->parseCurrentBlock();
  }
  $template->setVariable("Link", URL_TO_LMO.'/?action=table&amp;file='.$m_liga); 
  //$template->parse();
  $template->show();
} else {
  echo getMessage($text['mini'][5]." ".$mini_liga,TRUE);
}
  
//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-minitab.php") {?>
</body>
</html><?
}?>