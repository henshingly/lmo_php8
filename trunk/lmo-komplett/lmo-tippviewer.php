<?PHP
// 
// LigaManager Online 3.02
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
require_once("lmo-tipptest.php");
if($viewertipp==1 && $file=="viewer"){
  require_once("lmo-tippcalcpkt.php");
  require_once("lmo-tippaenderbar.php");

  $verz=opendir(substr($dirliga,0,-1));
  $dateien=array("");
  while($files=readdir($verz)){
    if(file_exists($dirtipp.substr($files,0,-4)."_".$lmotippername.".tip")){
      $ftest=1;
      if($immeralle!=1){
        $ftest=0;
        $ftest1="";
        $ftest1=split("[,]",$ligenzutippen);
        if(isset($ftest1)){
          for($u=0;$u<count($ftest1);$u++){
            if($ftest1[$u]==substr($files,0,-4)){$ftest=1;}
            }
          }
        }
      if($ftest==1){array_push($dateien,$files);}
      }
    }
  closedir($verz);
  array_shift($dateien);
  sort($dateien);
  
  $anzligen=count($dateien);

  $teams=array_pad($array,65,"");
  $teams[0]="___";
  $liga=array("");
  $titel=array("");
  $lmtype=array("");
  $anzst=array("");
  $hidr=array("");
  $dats=array("");
  $datm=array("");
  $spieltag=array("");
  $modus=array("");
  $datum1=array("");
  $datum2=array("");
  $spiel=array("");
  $teama=array("");
  $teamb=array("");
  $goala=array("");
  $goalb=array("");
  $mspez=array("");
  $mtipp=array("");
  $mnote=array("");
  $msieg=array("");
  $mterm=array("");
  $tippa=array("");
  $tippb=array("");
  $jksp=array("");
  $jokertippaktiv=array("0");
  
  $anzspiele=0;

  if(!isset($save)){$save=0;}
  if($save==1){
    $start=trim($_POST["xstart"]);
    $now1=trim($_POST["xnow"]);
    $then1=trim($_POST["xthen"]);
    }
  else{
    if(!isset($start)){$start=0;}
    $now1=strtotime("+".$start." day");
    $then1=strtotime("+".($start+$viewertage)." day");
    }

  $now1=strftime("%d.%m.%Y", $now1);
  $now=mktime(0, 0, 0, substr($now1,3,2), substr($now1,0,2), substr($now1,-4));
  $then=strftime("%d.%m.%Y", $then1);
  $then=mktime(0, 0, 0, substr($then,3,2), substr($then,0,2), substr($then,-4));
  $then1=strftime("%d.%m.%Y", ($then-1));
  
  for($liganr=0;$liganr<$anzligen;$liganr++){
    $file=$dirliga.$dateien[$liganr];
    $tippfile=$dirtipp.substr($dateien[$liganr],0,-4)."_".$lmotippername.".tip";
    require("lmo-tippopenfileviewer.php");
    }
  array_shift($liga);
  array_shift($titel);
  array_shift($lmtype);
  array_shift($anzst);
  array_shift($hidr);
  array_shift($dats);
  array_shift($datm);
  array_shift($spieltag);
  array_shift($modus);
  array_shift($datum1);
  array_shift($datum2);
  array_shift($spiel);
  array_shift($teama);
  array_shift($teamb);
  array_shift($goala);
  array_shift($goalb);
  array_shift($mspez);
  array_shift($mtipp);
  array_shift($mnote);
  array_shift($msieg);
  array_shift($mterm);
  array_shift($tippa);
  array_shift($tippb);

  if($save==1){
    $now=time();
    $start1=0;
    $start2=0;
    for($i=0;$i<$anzspiele;$i++){
      $btip=tippaenderbar($mterm[$i],$datum1[$i],$datum2[$i]);
      if($btip==true){
        if($jokertipp==1 && isset($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]])){
          $jksp[$i]=trim($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]]);
          if($jokertippaktiv[$i]>0 && $jokertippaktiv[$i]<$now){$jksp[$i]=0;} // jokeranticheat
          }
        if($tippmodus==1){
          $tippa[$i]=trim($_POST["xtippa".$i]);
          if($tippa[$i]=="" || $tippa[$i]<0){$tippa[$i]=-1;}
          elseif($tippa[$i]=="_"){$tippa[$i]=-1;}
          else{
            $tippa[$i]=intval(trim($tippa[$i]));
            if($tippa[$i]==""){$tippa[$i]="0";}
            }
          $tippb[$i]=trim($_POST["xtippb".$i]);
          if($tippb[$i]=="" || $tippb[$i]<0){$tippb[$i]=-1;}
          elseif($tippb[$i]=="_"){$tippb[$i]=-1;}
          else{
            $tippb[$i]=intval(trim($tippb[$i]));
            if($tippb[$i]==""){$tippb[$i]="0";}
            }
          }
        elseif($tippmodus==0){
          if(!isset($_POST["xtipp".$i])){$_POST["xtipp".$i]=0;}
          if($_POST["xtipp".$i]==1){
            $tippa[$i]="1";
            $tippb[$i]="0";
            }
          elseif($_POST["xtipp".$i]==2){
            $tippa[$i]="0";
            $tippb[$i]="1";
            }
          elseif($_POST["xtipp".$i]==3){
            $tippa[$i]="0";
            $tippb[$i]="0";
            }
          else{
            $tippa[$i]="-1";
            $tippb[$i]="-1";
            }
          }
        }
      if($i==($anzspiele-1) || $liga[$i]!=$liga[$i+1]){
        $tippfile=$dirtipp.$liga[$i]."_".$lmotippername.".tip";
        require("lmo-tippsavefileviewer.php");
        $start1=$i+1;
        }
      if($akteinsicht==1 && ($i==($anzspiele-1) || $spieltag[$i]!=$spieltag[$i+1] || $liga[$i]!=$liga[$i+1])){
        $einsichtfile=$dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein"; 
        require("lmo-tippsaveeinsichtviewer.php");
        $start2=$i+1;
        }
      }
    }

  if($showtendenzabs==1 || $showtendenzpro==1 || ($showdurchschntipp==1 && $tippmodus==1)){
    $tendenz1 = array_pad(array("0"),$anzspiele+1,"0");
    $tendenz0 = array_pad(array("0"),$anzspiele+1,"0");
    $tendenz2 = array_pad(array("0"),$anzspiele+1,"0");
    $toregesa = array_pad(array("0"),$anzspiele+1,"0");
    $toregesb = array_pad(array("0"),$anzspiele+1,"0");
    $anzgetippt = array_pad(array("0"),$anzspiele+1,"0");
    $btip = array_pad(array("false"),$anzspiele+1,"0");
    $start2=0;
    for($i=0;$i<$anzspiele;$i++){
      if($i==($anzspiele-1) || $spieltag[$i]!=$spieltag[$i+1] || $liga[$i]!=$liga[$i+1]){
        $einsichtfile=$dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein";
        require("lmo-tippcalceinsichtviewer.php");
        $start2=$i+1;
        }
      }
    }

  $addr=$PHP_SELF."?action=tipp&amp;todo=edit&amp;file=viewer&amp;start=";
  $breite=17;
  if($tippmodus==1 && $pfeiltipp==1){$breite+=2;}
  if($showtendenzabs==1){$breite+=2;}
  if($showtendenzpro==1){$breite+=2;}
  if($showdurchschntipp==1){$breite+=2;}
  if($jokertipp==1){$breite++;}
  $savebutton=0;
  $file="viewer";
  $nw=0;
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <font color=black><?PHP echo $lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></font>
  </td></tr>
  <tr>
    <td class="lmost4" align="center">
    <?PHP if($tippbis>0){echo $text[2087]." ".$tippbis." ".$text[2088];} ?>
    </td>
  </tr>
  <tr><td align="center" class="lmost1">
    <?PHP echo $text[2258]." ".$now1." ".$text[4]." ".$then1; ?>
  </td></tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="edit">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="viewer">
  <input type="hidden" name="xstart" value="<?PHP echo $start; ?>">
  <input type="hidden" name="xnow" value="<?PHP echo $now; ?>">
  <input type="hidden" name="xthen" value="<?PHP echo $then; ?>">
<?PHP
if($anzspiele==0){
?>
    <tr>
    <td class="lmost4" colspan="<?PHP echo $breite; ?>"><nobr><?PHP echo $text[2262]; ?></nobr></td>
    </tr>
<?PHP
  }
for($i=0;$i<$anzspiele;$i++){
  if($i==0 || $liga[$i]!=$liga[$i-1]){
?>
    <tr>
    <td class="lmost4" colspan="<?PHP echo $breite; ?>"><nobr><?PHP echo $titel[$i]; ?></nobr></td>
    </tr>
<?PHP
    }
  if($i==0 || $liga[$i]!=$liga[$i-1] || $spieltag[$i]!=$spieltag[$i-1]){
    if($datum1[$i]!=""){
      $datum = split("[.]",$datum1[$i]);
      $dum1=$me[intval($datum[1])]." ".$datum[2];
      }
    else{
      $dum1="";
      }
    if($datum2[$i]!=""){
      $datum = split("[.]",$datum2[$i]);
      $dum2=$me[intval($datum[1])]." ".$datum[2];
      }
    else{
      $dum2="";
      }
    if($lmtype[$i]==1){
      if($spieltag[$i]==$anzst[$i]){$j=$text[374];}
      elseif($spieltag[$i]==$anzst[$i]-1){$j=$text[373];}
      elseif($spieltag[$i]==$anzst[$i]-2){$j=$text[372];}
      elseif($spieltag[$i]==$anzst[$i]-3){$j=$text[371];}
      else{$j=$spieltag[$i].". ".$text[370];}
      }
?>
  <tr>
    <td class="lmost4" colspan="6"><nobr>
<?PHP if($tippeinsicht==1){echo "<a href=\"".$PHP_SELF."?action=tipp&amp;todo=einsicht&amp;file=".$dirliga.$liga[$i].".l98&amp;st=".$spieltag[$i]."\">";} ?>
<?PHP if($lmtype[$i]==0){echo $spieltag[$i].". ".$text[2];}else{echo $j;} ?>
<?PHP if($tippeinsicht==1){echo "</a>";} ?>
<?PHP if($dats[$i]==1){ ?>
  <?PHP if($datum1[$i]!=""){echo " ".$text[3]." ".$datum1[$i];} ?>
  <?PHP if($datum2[$i]!=""){echo " ".$text[4]." ".$datum2[$i];} ?>
<?PHP } ?>
    </nobr></td>
<?PHP if($showtendenzabs==1 || $showtendenzpro==1){ ?>
    <td class="lmost4" align="center" colspan="<?PHP if($showtendenzabs==1 && $showtendenzpro==1){echo "4";}else{echo "2";} ?>"><nobr><?PHP echo $text[2188]; // Tipptendenz absolut ?></nobr></td>
<?PHP } ?>
<?PHP if($tippmodus==1){ ?>
<?PHP if($showdurchschntipp==1){ ?>
    <td class="lmost4" align="center" colspan="2"><nobr><?PHP echo "&Oslash;-".$text[2030]; // DurchschnittsTipp ?></nobr></td>
<?PHP } ?>
    <td class="lmost4" align="center" colspan="<?PHP if($pfeiltipp==1){echo "5";}else{echo "3";} ?>"><nobr><?PHP echo $text[2209]; // Dein Tipp ?></nobr></td>
<?PHP } ?>
<?PHP if($tippmodus==0){ ?>
    <td class="lmost4" align="center"><nobr><?PHP echo "1"; ?></nobr></td>
<?PHP if($hidr[$i]==0){ ?>
    <td class="lmost4" align="center"><nobr><?PHP echo "0"; ?></nobr></td>
<?PHP }else{ ?>
    <td class="lmost4">&nbsp;</td>
<?PHP } ?>
    <td class="lmost4" align="center"><nobr><?PHP echo "2"; ?></nobr></td>
<?PHP } ?>
<?PHP if ($jokertipp==1){ ?>
    <td class="lmost4" align="center"><nobr><?PHP echo $text[2289]; ?>
<?PHP } ?>
    <td class="lmost4" colspan="3" align="center"><nobr><?PHP echo $text[2031]; // Ergebnis ?></nobr></td>
    <td class="lmost4" colspan="2">&nbsp;</td>
    <td class="lmost4" colspan="2" align="right"><nobr><?PHP echo $text[37]; // PP ?></nobr></td>
    <td class="lmost4">&nbsp;</td>
 </tr>
<?PHP
    }
  if($einsichterst==2){
    if($goala[$i]!="_" && $goalb[$i]!="_"){$btip1=false;}
    else{$btip1=true;}
    }
  else{$btip1=false;}

  if($datm[$i]==1){
  if($mterm[$i]>0){$datf="%d.%m. %H:%M";$dum1=strftime($datf, $mterm[$i]);}else{$dum1="";}
?>
  <tr>
    <td class="lmost5"><nobr><?PHP echo $dum1; ?></nobr></td>
<?PHP } ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><nobr>
<?PHP
  echo $teama[$i];
?>
    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>
<?PHP
  echo $teamb[$i];

  if($tippa[$i]=="_"){$tippa[$i]="";}
  if($tippb[$i]=="_"){$tippb[$i]="";}
  if($tippa[$i]=="-1"){$tippa[$i]="";}
  if($tippb[$i]=="-1"){$tippb[$i]="";}
?>
    </nobr></td>
    <td class="lmost5">&nbsp;</td>
<?PHP if($showtendenzabs==1){ ?>
    <td align="center" class="lmost5"><nobr>
    <?PHP 
    if($btip1==false){
      if(!isset($tendenz1[$i])){$tendenz1[$i]=0;}
      if(!isset($tendenz0[$i])){$tendenz0[$i]=0;}
      if(!isset($tendenz2[$i])){$tendenz2[$i]=0;}
      echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
      }
    ?>
    </nobr></td>
    <td class="lmost5">&nbsp;</td>
<?PHP } ?>
<?PHP if($showtendenzpro==1){ ?>
    <td align="center" class="lmost5"><nobr>
    <?PHP 
    if($btip1==false){
      if(!isset($anzgetippt[$i])){$anzgetippt[$i]=0;}
      if($anzgetippt[$i]>0){
        if(!isset($tendenz1[$i])){$tendenz1[$i]=0;}
        if(!isset($tendenz0[$i])){$tendenz0[$i]=0;}
        if(!isset($tendenz2[$i])){$tendenz2[$i]=0;}
        echo number_format(($tendenz1[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz0[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz2[$i]/$anzgetippt[$i]*100),0,".",",")."%";
        }
      else{echo "&nbsp;";}
      }
    ?>
    </nobr></td>
    <td class="lmost5">&nbsp;</td>
<?PHP }
$plus=1;
$btip=tippaenderbar($mterm[$i],$datum1[$i],$datum2[$i]);
if($btip==true){ $savebutton=1;}
if($tippmodus==1){
if($showdurchschntipp==1){ ?>
    <td align="center" class="lmost5"><nobr>
    <?PHP 
    if($btip1==false){
      if(!isset($anzgetippt[$i])){$anzgetippt[$i]=0;}
      if($anzgetippt[$i]>0){
        if(!isset($toregesa[$i])){$toregesa[$i]=0;}
        if(!isset($toregesb[$i])){$toregesb[$i]=0;}
        if($toregesa[$i]<10 && $toregesb[$i]<10){$nachkomma=1;}
        else{$nachkomma=0;}
        echo number_format(($toregesa[$i]/$anzgetippt[$i]),$nachkomma,".",",").":".number_format(($toregesb[$i]/$anzgetippt[$i]),$nachkomma,".",",");
        }
      else{echo "&nbsp;";}
      }
    ?>
    </nobr></td>
    <td class="lmost5">&nbsp;</td>
<?PHP }
   if($btip==true){ ?>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[2241] ?>"><input class="lmoadminein" type="text" name="xtippa<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $tippa[$i]; ?>" onKeyDown="lmotorclk('a','<?PHP echo $i; ?>',event.keyCode)"></acronym></td>
<?PHP if($pfeiltipp==1){ ?>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?PHP echo $i; ?>\",1);" title="<?PHP echo $text[2243]; ?>" onMouseOver="lmoimg(\"<?PHP echo $i; ?>a\",img1)" onMouseOut="lmoimg(\"<?PHP echo $i; ?>a\",img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i; ?>a" width="7" height="7" border="0"></a>'</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?PHP echo $i; ?>\",-1);" title="<?PHP echo $text[2243]; ?>" onMouseOver="lmoimg(\"<?PHP echo $i; ?>b\",img3)" onMouseOut="lmoimg(\"<?PHP echo $i; ?>b\",img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i; ?>b" width="7" height="7" border="0"></a>'</script></td></tr></table></td>
<?PHP } 
    }else{
   if($pfeiltipp==1){ ?>
    <td class="lmost5">&nbsp;</td>
<?PHP } ?>
    <td class="lmost5" align="right"><?PHP echo $tippa[$i]; ?></td>
<?PHP } ?>
    <td class="lmost5" width="2">:</td>
<?PHP if($btip==true){ ?>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[2242] ?>"><input class="lmoadminein" type="text" name="xtippb<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $tippb[$i]; ?>" onKeyDown="lmotorclk('b','<?PHP echo $i; ?>',event.keyCode)"></acronym></td>
<?PHP if($pfeiltipp==1){ ?>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?PHP echo $i; ?>\",1);" title="<?PHP echo $text[2244]; ?>" onMouseOver="lmoimg(\"<?PHP echo $i; ?>f\",img1)" onMouseOut="lmoimg(\"<?PHP echo $i; ?>f\",img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i; ?>f" width="7" height="7" border="0"></a>'</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?PHP echo $i; ?>\",-1);" title="<?PHP echo $text[2244]; ?>" onMouseOver="lmoimg(\"<?PHP echo $i; ?>d\",img3)" onMouseOut="lmoimg(\"<?PHP echo $i; ?>d\",img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i; ?>d" width="7" height="7" border="0"></a>'</script></td></tr></table></td>
<?PHP } ?>
<?PHP }else{ ?>
    <td class="lmost5"><?PHP echo $tippb[$i]; ?></td>
<?PHP if($pfeiltipp==1){ ?>
    <td class="lmost5">&nbsp;</td>
<?PHP } ?>
<?PHP } ?>
<?PHP } // ende ($tippmodus==1) ?>
<?PHP if($tippmodus==0){ $tipp=-1;
        if($tippa[$i]=="" || $tippb[$i]==""){$tipp=-1;}
        elseif($tippa[$i]>$tippb[$i]){$tipp=1;}
        elseif($tippa[$i]==$tippb[$i]){$tipp=0;}
        elseif($tippa[$i]<$tippb[$i]){$tipp=2;}
?>
    <td class="lmost5" align="center"><acronym title="<?PHP echo $text[2095] ?>"><input type="radio" name="xtipp<?PHP echo $i; ?>" value="1" <?PHP if($tipp==1){echo " checked";} if($btip==false){echo " disabled";} ?>></acronym></td>
<?PHP if($hidr[$i]==0){ ?>
    <td class="lmost5" align="center"><acronym title="<?PHP echo $text[2096] ?>"><input type="radio" name="xtipp<?PHP echo $i; ?>" value="3" <?PHP if($tipp==0){echo " checked";} if($btip==false){echo " disabled";} ?>></acronym></td>
<?PHP }else{ ?>
    <td class="lmost5">&nbsp;</td>
<?PHP } ?>
    <td class="lmost5" align="center"><acronym title="<?PHP echo $text[2097] ?>"><input type="radio" name="xtipp<?PHP echo $i; ?>" value="2" <?PHP if($tipp==2){echo " checked";} if($btip==false){echo " disabled";} ?>></acronym></td>
<?PHP } // ende ($tippmodus==0) ?>
<?PHP if($jokertipp==1){ if($jokertippaktiv[$i]>0 && $jokertippaktiv[$i]<time()){$btip=false;} ?>
    <td class="lmost5" align="center"><acronym title="<?PHP echo $text[2290] ?>"><input type="radio" name="xjokerspiel_<?PHP echo $liga[$i]."_".$spieltag[$i]; ?>" value="<?PHP echo $spiel[$i]; ?>" <?PHP if($jksp[$i]==$spiel[$i]){echo " checked";} if($btip==false){echo " disabled";} ?>></acronym></td>
<?PHP } ?>                                                                                                                   
    <td class="lmost7" align="right"><?PHP echo $goala[$i]; ?></td>
    <td class="lmost7" width="2">:</td>
    <td class="lmost7" align="left"><?PHP echo $goalb[$i]; ?></td>
    <td class="lmost7" width="2">&nbsp;</td>
    <td class="lmost7"><?PHP echo $mspez[$i]; ?></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><strong>
<?PHP 
      if ($jokertipp==1 && $jksp[$i]==$spiel[$i]){$jkspfaktor=$jokertippmulti;}   
      else{$jkspfaktor=1;}
      $punktespiel=-1;
      if($tippa[$i]!="" && $tippb[$i]!="" && $goala[$i]!="_" && $goalb[$i]!="_"){
        $punktespiel=tipppunkte($tippa[$i], $tippb[$i], $goala[$i], $goalb[$i], $msieg[$i], $mspez[$i], $text[0], $text[1], $jkspfaktor, $mtipp[$i]);
        }
      if($punktespiel==-1){echo "-";}
      elseif($punktespiel==-2){echo $text[2230];$nw=1;}
      else{
        if($tippmodus==1){
          echo $punktespiel;
          }
        else{
          if($punktespiel>0){
            echo "<img src=\"right.gif\" width=\"16\" height=\"16\" border=\"0\">";
            if($punktespiel>1){echo "+".($punktespiel-1);}
            }
          else{echo "<img src=\"wrong.gif\" width=\"16\" height=\"16\" border=\"0\">";}
          }
        }
?>
    </b></td>
    <td class="lmost5">

<?PHP
  if(($mnote[$i]!="") || ($msieg[$i]>0) || ($mtipp[$i]>0)){
    $dummy=addslashes($teama[$i]." - ".$teamb[$i]." ".$goala[$i].":".$goalb[$i]);
    if($msieg[$i]==3){$dummy.=" / ".$goalb[$i].":".$goala[$i];}
    $dummy.=" ".$mspez[$i];
    if($msieg[$i]==1){$dummy.="\\n\\n".$text[219].":\\n".addslashes($teama[$i]." ".$text[211]);}
    if($msieg[$i]==2){$dummy.="\\n\\n".$text[219].":\\n".addslashes($teamb[$i]." ".$text[211]);}
    if($msieg[$i]==3){$dummy.="\\n\\n".$text[219].":\\n".addslashes($text[212]);}
    if($mnote[$i]!=""){$dummy.="\\n\\n".$text[22].":\\n".$mnote[$i];}
    if($mtipp[$i]==1){$dummy.="\\n\\n".$text[2231]."\\n";}
    echo "<a href=\"javascript:alert('".$dummy."');\" title=\"".str_replace("\\n","&#10;",$dummy)."\"><img src=\"lmo-st2.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
    }
  else{
    echo "&nbsp;";
    }
?>
    </td>
  </tr>
<?PHP } ?>

  <tr>
    <td class="lmost4" colspan="<?PHP echo $breite; ?>" align="right"><nobr>
<?PHP if($savebutton==1){ ?>
    <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[2008]; ?>"></acronym>
<?PHP } ?>
    </nobr></td>
  </tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost2\"><a href=\"".$addr.($start-$viewertage)."&amp;PHPSESSID=".$PHPSESSID."\" title=\"".$viewertage." ".$text[2257]."\">".$text[5]."</a></td>";
  echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addr.($start+$viewertage)."&amp;PHPSESSID=".$PHPSESSID."\" title=\"".$viewertage." ".$text[2256]."\">".$text[7]."</a></td>";
?>
    </tr></table></td>
  </tr>
</table>

<?PHP 
}
$einsichtfile="";
$tippfile="";
?>