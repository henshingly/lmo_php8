<?php
/*
---------------------------------------------------------------
Datei: lmo-adminwap.php
Version: 1.1
Datum: 22.08.2003
Autor: Lord_Helmchen
Release by bastard (Adminpage)
---------------------------------------------------------------
Dies ist die sogenantne Userseite, die auf dem Handy per WAP
die aktuellen Ergebnisse und Tabelle anzeigt
*/

require_once(dirname(__FILE__).'/../../init.php');
$_SERVER['PHP_SELF']=$_SERVER['PHP_SELF']."?wap_file=";
$home=$_SERVER['PHP_SELF'];


function index($dirliga)
{
global $_SERVER['PHP_SELF'], $home;

echo("<card id=\"index\" title=\"Ergebnisdienst\">\n");
echo("<p>\n");

$array = array("");
require("lmo-langload.php");

//echo "Home: ".$home;
//require("./lmo_sms/lmo_sms.php");
//Ligenliste laden
$ftype=".l98";
if($ftype!=""){
  $verz=opendir(substr($dirliga,0,-1));
  $dummy=array();$dummy2=array();
  $r=0;
  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==$ftype){
      $dummy2['"'.(filemtime($dirliga.$files)+$r).'"']=$files;
      $r++;
    }
  }
  closedir($verz);
  krsort($dummy2);
  foreach ($dummy2 as $d) $dummy[]=$d;
  $i=0;
  $j=0;
  for($k=0;$k<count($dummy);$k++){
    $files=$dummy[$k];
    $sekt="";
    $t0="";
    $t1="";
    $t4="";
    $t2=$text[2];
    $datei = fopen($dirliga.$files,"r");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=chop($zeile);
      $zeile=trim($zeile);
      if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
        $sekt=substr($zeile,1,-1);
        }
      elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";") && ($sekt=="Options")){
        $schl=substr($zeile,0,strpos($zeile,"="));
        $wert=substr($zeile,strpos($zeile,"=")+1);
        if($schl=="Name"){$t0=$wert;}
        if($schl=="Actual"){$t1=$wert;}
        if($schl=="Teams"){$t4=$wert;}
        if($schl=="Type"){
          if($wert=="1"){$t2=$text[370];}
          }
        if(($t0!="") && ($t1!="") && ($t4!=""))break;
        }
      }
    fclose($datei);
    $i++;
    if($t0==""){$j++;$t0="Unbenannte Liga ".$j;}
    if($t1!=""){
      if($t2==$text[2]){
        $t3=" / ".$t1.".".$text[145];
        }
      else{
        $t5=strlen(decbin($t4-1));
        if($t1==$t5-1){$t3=" / ".$text[362];}
		    elseif($t1==$t5){$t3=" / ".$text[364];}
        elseif($t1==$t5-2){$t3=" / ".$text[360];}
        elseif($t1==$t5-3){$t3=" / ".$text[358];}
        elseif($t1==$t5-4){$t3=" / ".$text[376].$t1;}
        else{$t3=" / ".$text[376].$t1;}
        }
      }
    else{$t3="";}
	//Ligenliste laden Ende
	
	$t0=str_replace("ä","ä",$t0);
	$t0=str_replace("Ä","Ä",$t0);
	$t0=str_replace("ö","ö",$t0);
	$t0=str_replace("Ö","Ö",$t0);
	$t0=str_replace("ü","ü",$t0);
	$t0=str_replace("Ü","Ü",$t0);
	$t0=str_replace("ß","ß",$t0);
	
?>
<small><<?php echo "a href='{$_SERVER['PHP_SELF']}$dirliga$files&amp;op=nav&amp;st=$t1'>".$t0."</a><br/>".date("d.m.y H:i",filemtime($dirliga.$files)).$t3."</small><br/>\n";  
 }
 if($i==0){echo "".$text[223]."";}
}
  

  
echo("</p>\n");
echo("</card>\n");
} //function index() Ende

function navigation($file, $st)
{
global $_SERVER['PHP_SELF'], $home;

echo("<card id=\"auswahl\" title=\"Auswahl\">\n");


$array = array("");
require("lmo-openfile.php");
require("lmo-langload.php");
if($lmtype==0){
echo("<p align='center'>\n");
echo("<a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=day&amp;st=$st\">".$text[10]."</a><br/>\n");
echo("<a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=table&amp;st=$st\">".$text[16]."</a><br/>\n");
echo("<a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=help&amp;st=$st\">".$text[20]."</a>\n");
}
//Ausgabe Pokal
else{
  echo("<p>\n");
  $anzsp=$anzteams;
  for($i=0;$i<$st;$i++){$anzsp=$anzsp/2;}
  if(($klfin==1) && ($st==$anzst)){$anzsp=$anzsp+1;}
  function gewinn ($gst,$gsp,$gmod,$m1,$m2){
    $erg=0;
    if($gmod==1){
      if($m1[0]>$m2[0]){$erg=1;}
      elseif($m1[0]<$m2[0]){$erg=2;}
      }
    elseif($gmod==2){
      if(($m1[0]+$m1[1])>($m2[0]+$m2[1])){$erg=1;}
      elseif(($m1[0]+$m1[1])<($m2[0]+$m2[1])){$erg=2;}
      else{
        if($m2[0]>$m1[1]){$erg=1;}
        elseif($m2[0]<$m1[1]){$erg=2;}
        }
      }
    else{
      $erg1=0;
      $erg2=0;
      for($k=0;$k<$gmod;$k++){
        if(($m1[$k]!="_") && ($m2[$k]!="_")){
          if($m1[$k]>$m2[$k]){$erg1++;}
          elseif($m1[$k]<$m2[$k]){$erg2++;}
          }
        }
      if($erg1>($gmod/2)){$erg=1;}
      elseif($erg2>($gmod/2)){$erg=2;}
      }
    return $erg;
    }

   for($i=1;$i<=$anzst;$i++){

    if($i==$anzst){$j=$text[364];$k=$text[365];}
    elseif($i==$anzst-1){$j=$text[362];}
    elseif($i==$anzst-2){$j=$text[360];}
    elseif($i==$anzst-3){$j=$text[358];}
    else{$j=$i;$k=$text[366];}
    if($i<>$st){
      echo "<a href='".$_SERVER['PHP_SELF'].$file."&amp;op=nav&amp;st=".$i."'>".$j."</a>";
      }
    else{
      echo $j;
      }
    echo "&nbsp;";
    }
  if($st==$anzst){$j=$text[374];}
  elseif($st==$anzst-1){$j=$text[373];}
  elseif($st==$anzst-2){$j=$text[372];}
  elseif($st==$anzst-3){$j=$text[371];}
  else{$j=$st.". ".$text[370];}
   
echo "<br/>";
//echo $j;
if($dats==1){ 
if($datum1[$st-1]!=""){echo "<small>(".$datum1[$st-1];}
if($datum2[$st-1]!=""){echo "-".$datum2[$st-1].")</small>";}
}
echo "<br/>\n";
  for($i=0;$i<$anzsp;$i++){
    for($n=0;$n<$modus[$st-1];$n++){

if(($klfin==1) && ($st==$anzst)){ 
   if($i==1){echo "<br/>\n";} echo $text[419+$i]; 
 } 

if($datm==1){
  if($mterm[$st-1][$i][$n]>0){$dum1=strftime($datf, $mterm[$st-1][$i][$n]);}else{$dum1="";}
echo "<small>$dum1</small>";
 } 

if($n==0){
  $m1=array($goala[$st-1][$i][0],$goala[$st-1][$i][1],$goala[$st-1][$i][2],$goala[$st-1][$i][3],$goala[$st-1][$i][4],$goala[$st-1][$i][5],$goala[$st-1][$i][6]);
  $m2=array($goalb[$st-1][$i][0],$goalb[$st-1][$i][1],$goalb[$st-1][$i][2],$goalb[$st-1][$i][3],$goalb[$st-1][$i][4],$goalb[$st-1][$i][5],$goalb[$st-1][$i][6]);
 $m=call_user_func('gewinn',$st-1,$i,$modus[$st-1],$m1,$m2);
  if(($klfin==1) && ($st==$anzst)){
    if($i==0){
      if($m==1){echo "<br/>\n";}elseif($m==2){echo "<br/>\n";}else{echo "<br/>\n";}
      }
    elseif($i==1){
      if($m==1){echo "<br/>\n";}else{echo "<br/>\n";}
      }
    }
  else{
    if($m==1){echo "<br/>\n";}else{echo "<br/>\n";}
    }

  if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "<b>";}
  $teamname=$teamk[$teama[$st-1][$i]];
  $teamname=str_replace("ä","ä",$teamname);
	$teamname=str_replace("Ä","Ä",$teamname);
	$teamname=str_replace("ö","ö",$teamname);
	$teamname=str_replace("Ö","Ö",$teamname);
	$teamname=str_replace("ü","ü",$teamname);
	$teamname=str_replace("Ü","Ü",$teamname);
	$teamname=str_replace("ß","ß",$teamname);
	echo $teamname;
  if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "</b>";}


  if(($klfin==1) && ($st==$anzst)){
    if($i==0){
      if($m==2){echo "test3";}elseif($m==1){echo "test4";}else{echo "test5";}
      }
    elseif($i==1){
      if($m==2){echo "test6";}else{echo "test7";}
      }
    }
  else{
    if($m==2){echo "&nbsp;-&nbsp;";}else{echo "&nbsp;-&nbsp;";}
    }
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "<b>";}
  $teamname=$teamk[$teamb[$st-1][$i]];
  $teamname=str_replace("ä","ä",$teamname);
	$teamname=str_replace("Ä","Ä",$teamname);
	$teamname=str_replace("ö","ö",$teamname);
	$teamname=str_replace("Ö","Ö",$teamname);
	$teamname=str_replace("ü","ü",$teamname);
	$teamname=str_replace("Ü","Ü",$teamname);
	$teamname=str_replace("ß","ß",$teamname);
	echo $teamname;
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "</b>";}

}
else{ echo "&nbsp;";}
echo "&nbsp;";
echo $goala[$st-1][$i][$n];
echo "&nbsp;-&nbsp;";
echo $goalb[$st-1][$i][$n]; 

echo $mspez[$st-1][$i][$n];
echo "<br/>\n";
}} 
echo("<a href='".$_SERVER['PHP_SELF'].$file."&amp;op=help&amp;st=$st'>".$text[20]."</a>\n");
}
//Ausgabe Pokal Ende

echo("<br/><small><a href=\"".$home."\">Home</a></small>\n");
echo("</p>\n");
echo("</card>\n");
} //function navigation Ende

function show_day($file, $st)
{

global $_SERVER['PHP_SELF'], $home;

echo("<card id=\"day\" title=\"$st. Spieltag\">\n");


$array = array("");

require("lmo-langload.php");
require("lmo-openfile.php");

//Anzeige Spieltag
//Anzeige Spieltag
if($file!=""){?>
  <table colums="2" align="LC"><?
  $st_next=$st+1;
  $st_before=$st-1;

  for($i=0;$i<$anzsp;$i++){ if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)){ 
    echo "<tr><td>";
    if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "<b>";}
    $teamname=$teamk[$teama[$st-1][$i]];
    $teamname=str_replace("ä","ä",$teamname);
  	$teamname=str_replace("Ä","Ä",$teamname);
  	$teamname=str_replace("ö","ö",$teamname);
  	$teamname=str_replace("Ö","Ö",$teamname);
  	$teamname=str_replace("ü","ü",$teamname);
  	$teamname=str_replace("Ü","Ü",$teamname);
  	$teamname=str_replace("ß","ß",$teamname);
  	echo $teamname;
    if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "</b>";}
  
  	echo "-";
  
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "<b>";}
    $teamname=$teamk[$teamb[$st-1][$i]];
    $teamname=str_replace("ä","ä",$teamname);
  	$teamname=str_replace("Ä","Ä",$teamname);
  	$teamname=str_replace("ö","ö",$teamname);
  	$teamname=str_replace("Ö","Ö",$teamname);
  	$teamname=str_replace("ü","ü",$teamname);
  	$teamname=str_replace("Ü","Ü",$teamname);
  	$teamname=str_replace("ß","ß",$teamname);
  	echo $teamname;
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "</b>";}
    $heim_tore=$goala[$st-1][$i];
  	$gast_tore=$goalb[$st-1][$i];
    
    echo "</td><td>".$heim_tore.":".$gast_tore;
    echo "</td></tr>";
  }
}
echo "</table><p>";
if($st>1){
  		echo "<a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=day&amp;st=".$st_before."\">«</a>&nbsp;\n";
	}if($st<$anzst){
  	echo "<a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=day&amp;st=".$st_next."\">»</a>\n";
  }
  echo "<br/>";	?>
<br/><a href="<?=$_SERVER['PHP_SELF'].$file;?>&amp;op=table&amp;st=<?=$st?>"><?=$text[16];?></a> | <a href="<?=$_SERVER['PHP_SELF'].$file;?>&amp;op=help&amp;st=<?=$st?>"><?=$text[20];?></a><?
} 
echo("<br/><a href='$home'><small>Home</small></a>");
// Anzeige Spieltag Ende

echo("</p>\n");
echo("</card>\n");
}//function show_day Ende



function show_table($file, $st)
{

global $_SERVER['PHP_SELF'], $home;

echo("<card id=\"tab\" title=\"$st. Spieltag\">\n");
echo("<p>\n");
$array = array("");
require("lmo-langload.php");
require("lmo-openfile.php");

if($st>0){$actual=$st;}else{$actual=$stx;}
if($lmtype==0){
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
		if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
	}
	$endtab=$anzst;
	include("lmo-calctable.php");
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$endtab-1][$i1]=="_") $goala[$endtab-1][$i1]="-1";
		if ($goalb[$endtab-1][$i1]=="_") $goalb[$endtab-1][$i1]="-1";
	}
}
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
	if (isset($table1)) {
		
		
		$wmloutput="<table title=\"tabelle\" columns=\"4\" align=\"LLCR\">\n<tr><td><b>Pl.</b></td><td><b>Team</b></td><td><b>P+</b></td><td><b>+/-</b></td></tr>\n";
		
		for ($i1=0;$i1<$anzteams;$i1++){
			$platz=$i1+1;
			$i4=(int)substr($table1[$i1],35,6);
			$teamname=$teamk[$i4];
			$teamname=str_replace("ä","ä",$teamname);
			$teamname=str_replace("Ä","Ä",$teamname);
			$teamname=str_replace("ö","ö",$teamname);
			$teamname=str_replace("Ö","Ö",$teamname);
			$teamname=str_replace("ü","ü",$teamname);
			$teamname=str_replace("Ü","Ü",$teamname);
			$teamname=str_replace("ß","ß",$teamname);
			$pluspunkte=$punkte[$i4];
			$minuspunkte=$negativ[$i4];
			$kegelnholz=$dtore[$i4];
			$torverhaeltnis=$dtore[$i4];
			
			
			$wmloutput.="<tr><td>$platz.&nbsp;</td><td>$teamname&nbsp;</td><td>$pluspunkte";
			if ($torverhaeltnis>0) $torverhaeltnis = "+".$torverhaeltnis;
			$wmloutput.="</td><td>$torverhaeltnis</td>";
			
			$wmloutput.="</tr>\n";
		}
		$wmloutput.="</table>\n";
		
		echo $wmloutput;

	}
}?>
<br/><a href="<?=$_SERVER['PHP_SELF'].$file;?>&amp;op=day&amp;st=<?php echo $st; ?>"><?=$text[10];?></a> | <a href="<?=$_SERVER['PHP_SELF'].$file;?>&amp;op=help&amp;st=<?php echo $st; ?>"><?=$text[20];?></a><?
echo("<br/><a href='$home'><small>Home</small></a>");

echo("</p>\n");
echo("</card>\n");
}//function show_table Ende

function help($file, $st)
{
global $_SERVER['PHP_SELF'], $home;

echo("<card id=\"help\" title=\"Hilfe\">\n");
echo("<p><small>");

$array = array("");
require("lmo-openfile.php");
require("lmo-langload.php");

for($j=0;$j<$anzteams;$j++){
	$j1=$j+1;
  $teamk[$j1]=str_replace("ä","&#xE4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ä","&#xC4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ö","&#xF6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ö","&#xD6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ü","&#xFC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ü","&#xDC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ß","&#xDF;",$teamk[$j1]);
	
	$teams[$j1]=str_replace("ä","&#xE4;",$teams[$j1]);
	$teams[$j1]=str_replace("Ä","&#xC4;",$teams[$j1]);
	$teams[$j1]=str_replace("ö","&#xF6;",$teams[$j1]);
	$teams[$j1]=str_replace("Ö","&#xD6;",$teams[$j1]);
	$teams[$j1]=str_replace("ü","&#xFC;",$teams[$j1]);
	$teams[$j1]=str_replace("Ü","&#xDC;",$teams[$j1]);
	$teams[$j1]=str_replace("ß","&#xDF;",$teams[$j1]);
	echo "<b>".$teamk[$j1]."</b>=<br/>".$teams[$j1]."<br/>---<br/>\n";
}
echo "</small>";
echo("<br/><a href=\"".$_SERVER['PHP_SELF'].$file."&amp;op=nav&amp;st=$st\">zurück</a>");
echo("</p>\n");
echo("</card>\n");
}//function help Ende


if (!isset($_REQUEST['st'])) $_REQUEST['st']="1";
if (!isset($_REQUEST['op'])) $_REQUEST['op']="";
header("Content-type: text/vnd.wap.wml");                // Sag dem Browser, dass jetzt WML kommt
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Ein Datum der Vergangenheit um nicht gecached zu werden
header("Last-Modified: " . gmdate("D, d M Y H:i:s"). " GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
echo("<?xml version=\"1.0\"?>\n");
echo("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n");
echo("<wml>\n");
switch($_REQUEST['op']) {

    case "nav":
    navigation($file, $_REQUEST['st']);
    break;
    
    case "day":
    show_day($file, $_REQUEST['st']);
    break;
    
	case "table":
    show_table($file, $_REQUEST['st']);
    break;
	
	case "help":
    help($file, $_REQUEST['st']);
    break;
	
    default:
    index($dirliga);
    break;

}
echo("</wml>\n");
?>