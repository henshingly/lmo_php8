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
  * $Id$
  */

foreach ($fav_team[$i] as $akt_team) {
  if (isset($multi_cfgarray['modus']) && $multi_cfgarray['modus'] == 1) {
    $spieltag = $mySpieltag->nr;
  }
  $mhp_link_s=$mgp_link_s=$mhp_link_e=$mgp_link_e="";
  if (($akt_team == $myPartie->heim->nr) || ($akt_team == $myPartie->gast->nr)) {

    //Anfang Relevante Daten
    $template->setVariable("Liganame",$akt_liga->name);
    $template->setVariable("Spieltag",$multi_cfgarray['spieltagtext']." ".$spieltag);
    $template->setVariable("Datum",$myPartie->datumString('-',$multi_cfgarray['datumsformat']));
    $template->setVariable("Uhrzeit",$myPartie->zeitString('-',$multi_cfgarray['uhrzeitformat']));
    $template->setVariable("Ligadatum",$akt_liga->ligaDatumAsString());
    $template->setVariable("Tore",$myPartie->hToreString($multi_cfgarray['tordummy'])." : ".$myPartie->gToreString($multi_cfgarray['tordummy']).' '.$myPartie->spielEndeString($text));
    //Heim & Gasttore einzeln
    $template->setVariable("ToreHeim",$myPartie->hToreString($multi_cfgarray['tordummy']));
    $template->setVariable("ToreGast",$myPartie->hToreString($multi_cfgarray['tordummy']));
    //Ende Relevante Daten

    //Neu TeamIcons Heim fuer Bild alt /Anpassung Apache2
    $Heim=$myPartie->heim->name;
    $Gast=$myPartie->gast->name;
    $template->setVariable("Iconheim",HTML_smallTeamIcon($file,$Heim," alt=''"));
    $template->setVariable("Icongast",HTML_smallTeamIcon($file,$Gast," alt=''"));
    $template->setVariable("IconBigheim",HTML_bigTeamIcon($file,$Heim," alt=''"));
    $template->setVariable("IconBiggast",HTML_bigTeamIcon($file,$Gast," alt=''"));
    $template->setVariable("IconBigheimalt",HTML_bigTeamIcon($file,$Heim," alt='TeamIcon $Heim'"));
    $template->setVariable("IconBiggastalt",HTML_bigTeamIcon($file,$Gast," alt='TeamIcon $Gast'"));
    //Ende TeamIcons

    $mhp_link_s="";
    $mhp_link_e="";
    $mgp_link_s="";
    $mgp_link_e="";
    //HP verlinken
    if (isset($multi_cfgarray['mannschaftshomepages_verlinken']) && $multi_cfgarray['mannschaftshomepages_verlinken']==1) {
      if ($myPartie->heim->keyValues["URL"] != "") {
        $mhp_link_s='<a href="'.$myPartie->heim->keyValues["URL"].'" target="_blank">';
        $mhp_link_e='</a>';
      }
      if ($myPartie->gast->keyValues["URL"] != "") {
        $mgp_link_s='<a href="'.$myPartie->gast->keyValues["URL"].'" target="_blank">';
        $mgp_link_e='</a>';
      }
    }//Ende HP verlinken

    //Favteam hervorheben
    if (isset($multi_cfgarray['favteam_highlight']) && $multi_cfgarray['favteam_highlight']==1) {
      if ($myPartie->heim->nr == $akt_liga->options->keyValues['favTeam']) {
        $mhp_link_s='<strong>'.$mhp_link_s;
        $mhp_link_e.='</strong>';
      }
      if ($myPartie->gast->nr == $akt_liga->options->keyValues['favTeam']) {
        $mgp_link_s='<strong>'.$mgp_link_s;
        $mgp_link_e.='</strong>';
      }
    }//Ende Favteam hervorheben

    //Trotz Konfigwert auch andere Variablen zur Verfügung stellen
    $template->setVariable("HeimKurz",$myPartie->heim->kurz);
    $template->setVariable("GastKurz",$myPartie->gast->kurz);
    $template->setVariable("HeimMittel",$myPartie->heim->mittel);
    $template->setVariable("GastMittel",$myPartie->gast->mittel);
    $template->setVariable("HeimLang",$myPartie->heim->name);
    $template->setVariable("GastLang",$myPartie->gast->name);
    //Neu wegen Auswahl Mittellanger Teamnamen
    if ($multi_cfgarray['mannschaftsnamen']==2) {
      $template->setVariable("Heim",$mhp_link_s.$myPartie->heim->mittel.$mhp_link_e);
      $template->setVariable("Gast",$mgp_link_s.$myPartie->gast->mittel.$mgp_link_e);
    } elseif ($multi_cfgarray['mannschaftsnamen']==1) {
      $template->setVariable("Heim",$mhp_link_s.$myPartie->heim->kurz.$mhp_link_e);
      $template->setVariable("Gast",$mgp_link_s.$myPartie->gast->kurz.$mgp_link_e);
    } else {
      $template->setVariable("Heim",$mhp_link_s.$myPartie->heim->name.$mhp_link_e);
      $template->setVariable("Gast",$mgp_link_s.$myPartie->gast->name.$mgp_link_e);
    }	//Ende Mannschaftsnamen

    //Anfang Notitz
    if (trim($myPartie->notiz)!="") {
      $icon=URL_TO_IMGDIR."/viewer/".$multi_cfgarray['notizsymbol'];
      $ntext='<a href="#" title="'.$myPartie->notiz.'" onclick="alert(\''.$text[22].': '.$myPartie->notiz.'\');window.focus();return false;"><img src="'.$icon.'" border="0" alt=""></a>';
      $template->setVariable("Notiz",$ntext);
    }//Ende Notiz

    //Anfang Tabelle verlinken
    $table_link=URL_TO_LMO.'/lmo.php?file='.$fav_liga[$i]."&amp;action=table&amp;st=".$spieltag;
    if ($multi_cfgarray['tabelle_verlinken']=='1' ) {
      $tlink="<a href='".$table_link."' target='_blank' title='".$text['viewer'][35]." (".$text['viewer'][33].")'><img src='".URL_TO_IMGDIR."/viewer/".$multi_cfgarray['tabellensymbol']."' border='0' alt='#'></a>";
    } else {
      $tlink="<a href='".$table_link."' title='".$text['viewer'][35]." (".$text['viewer'][34].")'><img src='".URL_TO_IMGDIR."/viewer/".$multi_cfgarray['tabellensymbol']."' border='0' alt='#'></a>";
    }
    $template->setVariable("Tabellenlink",$tlink);
    //Ende Tabelle

    //Anfang Spielbericht
    $SpBer_link=$myPartie->reportUrl;
    if ($SpBer_link != "") {
      if ($multi_cfgarray['spielberichte_neues_fenster']=='1' ) {
        $tlink="<a href='".$SpBer_link."' target='_blank' title='".$text['viewer'][38]." (".$text['viewer'][33].")'><img src='".URL_TO_IMGDIR."/viewer/".$multi_cfgarray['spielberichtesymbol']."' border='0' alt='§'></a>";
      } else {
        $tlink="<a href='".$SpBer_link."' title='".$text['viewer'][38]." (".$text['viewer'][34].")'><img src='".URL_TO_IMGDIR."/viewer/".$multi_cfgarray['spielberichtesymbol']."' border='0' alt='§'></a>";
      }
      $template->setVariable("Spielbericht", $tlink);
    }//Ende Spielbericht

    //Anfang Spiele Heute hervorheben
    if ($multi_cfgarray['heute_highlight']==1) {
      if ($myPartie->zeit > zeitberechnung("2",-1) && $myPartie->zeit < zeitberechnung("2",0))  {
        $template->setvariable("Zeilenklasse","vRowHighlight");
      } else {
        $template->setvariable("Zeilenklasse","vRow");
      }
    }		//Ende Sp.

  }
}
$template->parseCurrentBlock();
?>