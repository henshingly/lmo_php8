<?
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//
flush();
$addm=$_SERVER['PHP_SELF']."?file=".$file."&amp;action=";
if($file!=""){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(!isset($endtab)){
    $endtab=$anzst;
    $ste=$st;
    $tabdat="";
  }else{
    $tabdat=$endtab.". ".$text[2];
    $ste=$endtab;
  }
  if ($action=="") {
    if($onrun==0){
      $action="results";
    }else{
      $action="table";
    }
  }
}

//Alle Teile für die Startansicht
$output_titel="";
$output_sprachauswahl="";
$output_kalender="";
$output_ergebnisse="";
$output_tabelle="";
$output_spielplan="";
$output_kreuztabelle="";
$output_fieberkurve="";
$output_ligastatistik="";
$output_spielerstatistik="";
$output_info="";
$output_hauptteil="";
$output_archiv="";
$output_ligenuebersicht="";
$output_savehtml="";
$output_letzteauswertung="";
$output_berechnungszeit="";


//Wenn ein Template der Form [liganame].tpl.php existiert, wird dieses benutzt. Das ermöglicht 
// die Nutzung verschiedener Templates für unterschiedliche Ligen 
if (file_exists(PATH_TO_TEMPLATEDIR.'/'.basename($file).".tpl.php")){  
  $template = new LBTemplate(basename($file).".tpl.php"); 
}else{
  $template = new LBTemplate("lmo-standard.tpl.php"); 
}$p0="p1";$$p0=c(1).$addm.c(0);

if ($action!="tipp") {

  //Titel
  $output_titel=$file==""?$text[53]:$titel; 
  
  //Sprachauswahl
  $handle=opendir (PATH_TO_LMO);
  while (false!==($f=readdir($handle))) {
    if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {
      if ($lang[1]=="") $lang[1]=$text[505];
      $output_sprachauswahl.="<a href='{$_SERVER['PHP_SELF']}?lmouserlang={$lang[1]}&amp;action={$action}&amp;file={$file}&amp;archiv={$archiv}' title='{$lang[1]}'>";
      $imgfile=URL_TO_IMGDIR.'/'.$lang[1].".gif";
      
      if (!@fopen($imgfile,"rb")) {
        $output_sprachauswahl.=$lang[1];
      }else{
        $c=@getimagesize($imgfile);
        $output_sprachauswahl.="<img src='{$imgfile}' border='1' title='{$lang[1]}' {$c[3]} alt='{$lang[1]}'>";
      }
      $output_sprachauswahl.="</a> ";
    } 
  }
  closedir($handle);
  ob_start();
  if ($file!="") {
  
    //Für normale Ligen
    if($lmtype==0){
  
      //Kalenderlink
      $output_kalender.=$action!='cal'?         "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>":   $text[140];
      $output_kalender.='&nbsp;&nbsp;';
  
      //Ergebnis/Tabelle
      if($tabonres==0){
        $output_ergebnisse.=$action!='results'? "<a href='{$addm}results&amp;st={$ste}' title='{$text[11]}'>{$text[10]}</a>": $text[10];
        $output_ergebnisse.="&nbsp;&nbsp;";
  
        $output_tabelle.=$action!='table'?      "<a href='{$addm}table' title='{$text[17]}'>{$text[16]}</a>":                 $text[16];
        $output_tabelle.="&nbsp;&nbsp;";
      //Kombinierte Ansicht
      }else{
        $output_ergebnisse.=$action!='results'? "<a href='{$addm}results' title='{$text[104]}'>{$text[10]}/{$text[16]}</a>":  $text[10].'/'.$text[16];
        $output_ergebnisse.="&nbsp;&nbsp;";
      }
      
      //Kreuztabelle
      $output_kreuztabelle.=$action!="cross"?   "<a href='{$addm}cross' title='{$text[15]}'>{$text[14]}</a>":                 $text[14];
      $output_kreuztabelle.="&nbsp;&nbsp;";
      
      //Spielplan
      $output_spielplan.=$action!="program"?    "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>":               $text[12];
      $output_spielplan.="&nbsp;&nbsp;";
      
      //Fieberkurve
      $output_fieberkurve.=$action!="graph"?    "<a href='{$addm}graph&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[134]}'>{$text[133]}</a>": $text[133];
      $output_fieberkurve.="&nbsp;&nbsp;";
      
      //Ligastatistiken
      $output_ligastatistik.=$action!="stats"?  "<a href='{$addm}stats&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[19]}'>{$text[18]}</a>":   $text[18];
      $output_ligastatistik.="&nbsp;&nbsp;";
      
      //Spielerstatistiken
      if ($einspieler==1) {
    	  include(PATH_TO_LMO."/lmo-statloadconfig.php");
   	    $output_spielerstatistik.=$action!="spieler"?"<a href='{$addm}spieler' title='{$text[3012]}'>{$ligalink}</a>":           $ligalink;
        $output_spielerstatistik.="&nbsp;&nbsp;";
    	}
    // Pokalligen
    }else{
      //Kalenderlink
      $output_kalender.=$action!='cal'?         "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>":     $text[140];
      $output_kalender.='&nbsp;&nbsp;';
      
      //Ergebnisse
      $output_ergebnisse.=$action!='results'?   "<a href='{$addm}results&amp;st={$ste}' title='{$text[11]}'>{$text[10]}</a>":  $text[10];
      $output_ergebnisse.="&nbsp;&nbsp;";
      
      //Spielplan
      $output_spielplan.=$action!="program"?    "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>":                $text[12];
      $output_spielplan.="&nbsp;&nbsp;";
    }
    $output_info.=$action!="info"?              "<a href='{$addm}info' title='{$text[21]}'>{$text[20]}</a>":                   $text[20];
    
    $druck=0;
    if($lmtype==0){
      //Normal
      switch($action) {
        case "cal":      if($datc==1)                     {require(PATH_TO_LMO."/lmo-showcal.php");}break;
        case "results":  if ($ergebnis==1) {
                           if ($tabonres==0)              {require(PATH_TO_LMO."/lmo-showresults.php");}
                           else                           {require(PATH_TO_LMO."/lmo-showrestab.php");}
                           if(file_exists("lmo-savehtml.php")){$druck=1;}
                         }
                         break;
        case "table":    if ($tabonres==0 && $tabelle==1) {require(PATH_TO_LMO."/lmo-showtable.php");}
                         elseif ($tabonres==1)            {require(PATH_TO_LMO."/lmo-showrestab.php");}
                         break;
        case "cross":    if ($kreuz==1)                   {require(PATH_TO_LMO."/lmo-showcross.php");}break;
        case "program":  if ($plan==1)                    {require(PATH_TO_LMO."/lmo-showprogram.php");}break;
        case "graph":    if ($kurve==1)                   {require(PATH_TO_LMO."/lmo-showgraph.php");}break;
        case "stats":    if ($ligastats==1)               {require(PATH_TO_LMO."/lmo-showstats.php");}break;
        case "spieler":  if ($mittore==1)                 {require(PATH_TO_LMO."/lmo-statshow.php");}break;
      }
    //Pokal
    }else{
      switch($action) {
        case "cal":      if ($datc==1)                    {require(PATH_TO_LMO."/lmo-showcal.php");}break;
        case "results":  if ($ergebis==1)                 {require(PATH_TO_LMO."/lmo-showresults.php");}break;
        case "program":  if ($plan==1)                    {require(PATH_TO_LMO."/lmo-showprogram.php");}break;
        case "spieler":  if ($mittore==1)                 {require(PATH_TO_LMO."/lmo-statshow.php");}break;
      }
  	}
    if($action=="info")                                   {require(PATH_TO_LMO."/lmo-showinfo.php");}
  }elseif ($backlink==1)                                  {require(PATH_TO_LMO."/lmo-showdir.php");}
  $output_hauptteil.=ob_get_contents();ob_end_clean();
  
  if ($file!="") { 
    //Letzte Auswertung
    $output_letzteauswertung.=$text[406].':&nbsp;'.$stand;
    
    //SaveHTML
    ob_start();
    if ($einsavehtml==1) { ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr><? 
      if($lmtype==0 || $druck==1){include(PATH_TO_LMO."/lmo-savehtml.php");}?> 
           <td class="lmomain1" align="center"><? 
      if($lmtype==0 && $druck==1){echo "<a href='".PATH_TO_LMO.'/'.$diroutput.basename($file)."-st.html' target='_blank' title='{$text[477]}'>{$text[478]}</a>&nbsp;";}?>
            </td>  
            <td class="lmomain1" align="center"><? 
      if($lmtype==0 && $druck==1){echo "<a href='".PATH_TO_LMO.'/'.$diroutput.basename($file)."-sp.html' target='_blank' title='{$text[479]}'>{$text[480]}</a>&nbsp;";}?>
            </td>
          </tr>
        </table><? 
    }
    $output_savehtml.=ob_get_contents();ob_end_clean();
    
    //Ligenübersicht
    if($backlink==1){
      $output_ligenuebersicht.="<a href='{$_SERVER['PHP_SELF']}' title='{$text[392]}'>{$text[391]}</a>&nbsp;&nbsp;&nbsp;";
    }
  }else{
    if($archivlink==1){
      if (isset($archiv) && $archiv!=""){
        $output_archiv.="<a href=\"".$_SERVER["PHP_SELF"]."\">{$text[391]}</a><br>";
      }
      if (!isset($archiv) || $archiv!="dir"){
        $output_archiv.="<a href=\"".$_SERVER["PHP_SELF"]."?archiv=dir\">{$text[508]}</a><br>";
      }
      
    }
  }
  //Berechnungszeit
  if($calctime==1){
     $output_berechnungszeit.=$text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";
  }
  
  //Ticker-Addon
  $output_newsticker="";
  if($file!="" && $nticker==1){ 
    ob_start();
    $ticker_path=PATH_TO_ADDONDIR."/ticker/";
    $tickerligen=basename($file);
    $tickerart=1;
    include(PATH_TO_ADDONDIR."/ticker/ticker.php");    
    $output_newsticker.=ob_get_contents();ob_end_clean();
  }
  //Ticker-Addon
  //Tippspiel-Addon
  $output_tippspiel="";
  if ($eintippspiel==1) {
    if(($tipp_immeralle==1 || strpos($tipp_ligenzutippen, substr($file,strrpos($file,"//")+1,-4))>-1)){
      $output_tippspiel.="<a href='{$_SERVER['PHP_SELF']}?action=tipp&amp;file={$file}'>{$text['tipp'][0]}</a>&nbsp;&nbsp;";
    }
  }
  d($template->toString());
  //Tippspiel-Addon
  
  //Template ausgeben
  $template->replace("Ligenuebersicht", $output_ligenuebersicht);  
  $template->replace("Berechnungszeit", $output_berechnungszeit);  
  $template->replace("LetzteAuswertung", $output_letzteauswertung);  
  $template->replace("Archiv", $output_archiv);  
  $template->replace("Savehtml", $output_savehtml); 
  $template->replace("Hauptteil", $output_hauptteil);  
  $template->replace("Tabelle", $output_tabelle); 
  $template->replace("Kreuztabelle", $output_kreuztabelle); 
  $template->replace("Fieberkurve", $output_fieberkurve); 
  $template->replace("Spielerstatistik", $output_spielerstatistik); 
  $template->replace("Ligastatistik", $output_ligastatistik); 
  $template->replace("Kalender", $output_kalender); 
  $template->replace("Ergebnisse", $output_ergebnisse); 
  $template->replace("Spielplan", $output_spielplan); 
  $template->replace("Info", $output_info); 
  $template->replace("Infolink", $p1); 
  $template->replace("Sprachauswahl", $output_sprachauswahl); 
  $template->replace("Titel", $output_titel); 
  //Ticker-Addon
  $template->replace("Newsticker", $output_newsticker);  
  //Ticker-Addon
  //Tippspiel-Addon
  $template->replace("Tippspiel", $output_tippspiel);  
  //Tippspiel-Addon
  $template->show();
  
  
}else {require(PATH_TO_ADDONDIR."/tipp/lmo-tippstart.php");d($template->toString());}
?>