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

if($action=="tipp"){
  if(!isset($lmotippername)){$lmotippername="";}
  if(!isset($lmotipperpass)){$lmotipperpass="";}
  if(!isset($lmotipperverein)){$lmotipperverein="";}
  if($_SESSION["lmotipperok"]<1 && $_SESSION["lmotipperok"]>-4){
    $xtippername2="";
    if(isset($xtippername) && isset($xtipperpass)){
      $lmotippername=$xtippername;
      $lmotipperpass=$xtipperpass;
      $dumma = array("");
      $pswfile=$tippauthtxt;
      $datei = fopen($pswfile,"rb");
      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile=chop($zeile);
        if($zeile!=""){array_push($dumma,$zeile);}
        }
      fclose($datei);
      array_shift($dumma);
      $_SESSION["lmotipperok"]=-2;
      for($i=0;$i<count($dumma) && $_SESSION["lmotipperok"]==-2;$i++){
        $dummb = split("[|]",$dumma[$i]);
        if($lmotippername==$dummb[0]){ // Nick gefunden
          $_SESSION["lmotipperok"]=-1;
          if($lmotipperpass==$dummb[1]){ // Passwort richtig
            $lmotipperverein=$dummb[5];
            $_SESSION["lmotipperok"]=$dummb[2];
            if($_SESSION["lmotipperok"]==5){
              array_shift($dumma);
              }
            }
          }
        }
      }
    }
  if($_SESSION["lmotipperok"]==-5){ // Passwort-Anforderung
    require("lmo-tippemailpass.php");
    }
  if($_SESSION["lmotipperok"]<1 && $_SESSION["lmotipperok"]>-4){
    $addw=$PHP_SELF."?action=tipp&amp;todo=wert&amp;file=";
    $adda=$PHP_SELF."?action=tipp&amp;todo=";

    if(($todo=="wert" && $all!=1) || $todo=="fieber" || $todo=="edit"){require("lmo-openfilename.php");}
    elseif($todo=="einsicht"){require("lmo-openfilest.php");}
    elseif($todo=="tabelle"){require("lmo-openfile.php");}
    elseif($todo=="wert" && $all==1){}
?>

<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><nobr>
      <?PHP echo $text[2000]." "; if(isset($titel)){echo $titel;} ?>
    </nobr></td>
  </tr><tr>
    <td class="lmomain1"><nobr>

<?PHP
    if(isset($todo) && $todo!="logout"){echo "<a href=\"".$PHP_SELF."?action=tipp\" title=\"".$text[2053]."\">".$text[2052]."</a>";}
    else{echo $text[2052];}
    echo "&nbsp;&nbsp;";
    if(isset($file) && $file!="" && $file!="viewer"){
      if($tippeinsicht==1){
        if($todo!="einsicht"){echo "<a href=\"".$adda."einsicht&amp;file=".$file."\" title=\"".$text[2157]."\">".$text[2157]."</a>";}
        else{echo $text[2157];}
        echo "&nbsp;&nbsp;";
        }
      if($lmtype==0 && $tipptabelle1==1 && $tipptabelle==1){
        if($todo!="tabelle"){echo "<a href=\"".$adda."tabelle&amp;file=".$file."&amp;endtab=".$endtab."&amp;nick=\" title=\"".$text[2184]."\">".$text[2172]."</a>";}
        else{echo $text[2172];}
        echo "&nbsp;&nbsp;";
        }
      if($tippfieber==1){
        if($todo!="fieber"){echo "<a href=\"".$adda."fieber&amp;file=".$file."\" title=\"".$text[134]."\">".$text[133]."</a>";}
        else{echo $text[133];}
        echo "&nbsp;&nbsp;";
        }
      if($todo!="wert" || $all==1){echo "<a href=\"".$adda."wert&amp;file=".$file."\" title=\"".$text[2054]."\">".$text[2054]."</a>";}
      else{echo $text[2054];}
      echo "&nbsp;&nbsp;";
      }
/*    if($gesamt==1){
      if($todo!="wert" || $all!=1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;all=1\" title=\"".$text[2056]."\">".$text[2056]."</a>";}
      else{echo $text[2056];}
      }
*/    echo "&nbsp;&nbsp;";

?>
    </nobr></td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><nobr>
<?PHP
    if($regeln==1){?>
        <a href='<?=$regelnlink?>' target='regeln' onclick='window.open(this.href,"regeln","resizable=yes");return false;'><?=$text[2185]?></a>&nbsp;&nbsp;<?
      }
    if(isset($todo) && $todo!="logout"){echo "<a href=\"".$PHP_SELF."?action=tipp\" title=\"".$text[2159]."\">".$text[2159]."</a>";}
    else{echo $text[2159];}
    echo "&nbsp;&nbsp;";
    if($todo!="info"){echo "<a href=\"".$adda."info&amp;file=".$file."\" title=\"".$text[21]."\">".$text[20]."</a>";}else{echo $text[20];}
    echo "&nbsp;";
?>
      
    </nobr></td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center">

<?PHP 
  if($todo=="wert"){require("lmo-tippwert.php");}
  elseif($todo=="fieber"){require("lmo-tippfieber.php");}
  elseif($todo=="einsicht"){require("lmo-tippeinsicht.php");}
  elseif($todo=="tabelle"){require("lmo-tipptabelle.php");}
  elseif($todo=="info"){require("lmo-showinfo.php");}
  else{
?>

  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <font color=black><?PHP echo $text[2158]; ?></font>
  </td></tr>
  <tr><td align="center" class="lmost3">
  <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmotippedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  
  <input type="hidden" name="action" value="tipp">
    <tr>
      <td class="lmost4" colspan="2"><nobr><?PHP echo $text[2044]; ?></nobr></td>
    </tr>
<?PHP if($_SESSION["lmotipperok"]==-2){ // Benutzer nicht gefunden ?> 
    <tr>
      <td class="lmost5"  align="right" colspan="2"><font color=red><?PHP echo $text[2043]; ?></font></td>
    </tr>
<?PHP } ?>
<?PHP if(isset($xtippersub) & $_SESSION["lmotipperok"]=="" && !isset($emailbody)){ // Benutzer nicht freigeschaltet ?> 
    <tr>
      <td class="lmost5"  align="right" colspan="2"><font color=red><?PHP echo $text[2148]; ?></font></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost5" align="right"><acronym title="<?PHP echo $text[307] ?>"><?PHP echo " ".$text[2023]; ?></acronym></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[307] ?>"><input class="lmoadminein" type="text" name="xtippername" size="16" maxlength="32" value="<?PHP echo $lmotippername; ?>"></acronym></a>
    </tr>
    <tr>
<?PHP if($_SESSION["lmotipperok"]==-1){ $xtippername2=$lmotippername; // Passwort falsch ?> 
    <tr>
      <td class="lmost5" align="right" colspan="2"><font color=red><?PHP echo $text[2042]; ?></font></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost5" align="right"><acronym title="<?PHP echo $text[309] ?>"><?PHP echo " ".$text[308]; ?></acronym></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[309] ?>"><input class="lmoadminein" type="password" name="xtipperpass" size="16" maxlength="32" value="<?PHP echo $lmotipperpass; ?>"></acronym></a>
    </tr>
    <tr>
      <td class="lmost5">&nbsp;</td>
      <td class="lmost5"><acronym title="<?PHP echo $text[311] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[2012]; ?>"></acronym></td>
    </tr>
  </form>
    <tr>
      <td class="lmost4" colspan="2"><nobr><?PHP echo $text[2045]; ?></nobr></td>
    </tr>
    <tr>
      <td class="lmost5" align="right"><nobr><?PHP echo $text[2046]; ?></nobr></td>
      <form name="lmotippedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
       <input type="hidden" name="action" value="tipp">
       <input type="hidden" name="todo" value="newtipper">
       <td class="lmost5"><acronym title="<?PHP echo $text[2011] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[2011]; ?>" ></acronym></td>
      </form>
    </tr>
    <tr>
      <td class="lmost4" colspan="2"><nobr><?PHP echo $text[2004]; ?></nobr></td>
    </tr>
    <tr>
      <td class="lmost5" colspan="2">
      <ul>
      <?PHP
      $ftype=".l98"; require("lmo-tippnewdir.php");
      $dummy =  split("[|]",$tt1);
      $ftest2 = split("[|]",$tt0);
      if(isset($dummy) && isset($ftest2)){
        for($u=0;$u<count($dummy);$u++){
          if($dummy[$u]!="" && $ftest2[$u]!=""){
            $dummy[$u]=substr($dummy[$u],0,-4);
            $auswertfile=$dirtipp."auswert/".$dummy[$u].".aus";
      ?>
      <li class="lmoadminli"><a href="<?PHP echo $addw.$dirliga.$dummy[$u].".l98"; ?>"><?PHP echo $ftest2[$u];if(file_exists($auswertfile)){echo "<br><small>".$text[2083].": ".date("d.m.Y H:i",filectime($auswertfile))."</small>";}echo "</a>"; ?></li>
      <?PHP
            }
          }
        }
      if($gesamt==1 && $u>2){
        $auswertfile=$dirtipp."auswert/gesamt.aus";
?>
        <li class="lmoadminli"><a href="<?PHP echo $addw."&amp;all=1" ?>"><strong><?PHP echo $text[2025];if(file_exists($auswertfile)){echo "<br><small>".$text[2083].": ".date("d.m.Y H:i",filectime($auswertfile))."</small>";}?> </strong></a></li>
<?PHP   }
        $auswertfile="";
?>
      </ul>
      </td>
    </tr>
    <tr>
      <td class="lmost4" colspan="2"><nobr><?PHP echo $text[2074]; ?></nobr></td>
    </tr>

  <form name="lmotippedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="getpass">
<?PHP if($_SESSION["lmotipperok"]==-3){ // Benutzer nicht gefunden ?> 
    <tr>
      <td class="lmost5"  align="right" colspan="2"><font color=red><?PHP echo $text[2043]; ?></font></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost5" align="right"><?PHP echo " ".$text[2023]." ".$text[2218]." ".$text[2219]; ?></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[307] ?>"><input class="lmoadminein" type="text" name="xtippername2" size="16" maxlength="32" value="<?PHP echo $xtippername2; ?>"></acronym></a>
    </tr>
    <tr>
      <td class="lmost5" align="right"><?PHP echo $text[2075]; ?></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[2076] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[2076]; ?>" ></acronym></td>
    </tr>
  </form>
  </table>
  </table>
<?PHP } ?>
    </td>
  </tr>
<?PHP require("lmo-tippfusszeile.php"); ?>
</table>

<?PHP
    }
  $_SESSION["lmotipperok"]=$_SESSION["lmotipperok"];
  $lmotippername=$lmotippername;
  $_SESSION["lmotipperpass"]=$lmotipperpass;
  }
?>