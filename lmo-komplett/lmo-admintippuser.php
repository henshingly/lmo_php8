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
require_once("lmo-admintest.php");
if($HTTP_SESSION_VARS["lmouserok"]==2){
  $users = array("");
  if(!isset($del)){$del="";}
  if(!isset($save)){$save=0;}
  $pswfile=$tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){array_push($users,$zeile);}
    }
  fclose($datei);
  if($save==-1){ /// neuen User speichern
    array_push($users,trim($HTTP_POST_VARS["xnickx"])."|".trim($HTTP_POST_VARS["xpassx"])."|5|||||||1|1|EOL");
    require("lmo-tippsaveauth.php");
    }
  elseif($del!=""){
    $gef=0;
    for($i=1;$i<count($users) && $gef==0;$i++){
      $dummb = split("[|]",$users[$i]);
      if($del==$dummb[0]){ // Nick gefunden
        $gef=1;
        $del=$i;
        }
      }
    if($gef==1){
      $userf3=split("[|]",$users[$del]);
      $verz=opendir(substr($dirtipp,0,-1));
      $dummy=array("");
      while($files=readdir($verz)){
        if(substr($files,-4-strlen($userf3[0]))==$userf3[0].".tip"){array_push($dummy,$files);}
        }
      closedir($verz);
      array_shift($dummy);
      $anztippfiles=count($dummy);
      for($k=0;$k<$anztippfiles;$k++){
        @unlink($dirtipp.$dummy[$k]); // Tipps löschen
        }
  
      for($i=$del+1;$i<count($users);$i++){
        $users[$i-1]=$users[$i];
        }
      array_pop($users); // die letzte Zeile abgeschnitten
      require("lmo-tippsaveauth.php");
      }
    }
  $adda=$PHP_SELF."?action=admin&amp;todo=tipp";
  $addo=$PHP_SELF."?action=admin&amp;todo=tippoptions";
  $adde=$PHP_SELF."?action=admin&amp;todo=tippemail";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[2114] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

<?PHP
 if(count($users)>1){
   if(!isset($sort)){$sort="id";}

   $adds=$PHP_SELF."?action=admin&amp;todo=tippuser&amp;sort=";
   $added=$PHP_SELF."?action=admin&amp;todo=tippuseredit&amp;nick=";
   $addd=$PHP_SELF."?action=admin&amp;todo=tippuser&amp;sort=".$sort."&amp;del=";
?>
  <tr>
    <td class="lmost4" align="right"><nobr>
<?PHP
 if($sort!="id"){echo "<a href=\"javascript:chklmolink('".$adds."id');\">";}
   echo "ID"; // ID
 if($sort!="id"){echo "</a>";}
?></nobr></td>
    <td class="lmost4"><nobr>
<?PHP
 if($sort!="nick"){echo "<a href=\"javascript:chklmolink('".$adds."nick');\">";}
   echo $text[2023]; // Nickname
 if($sort!="nick"){echo "</a>";}
?></nobr></td>
    <td class="lmost4"><nobr>
<?PHP
 if($sort!="pass"){echo "<a href=\"javascript:chklmolink('".$adds."pass');\">";}
   echo $text[323]; // passwort
 if($sort!="pass"){echo "</a>";}
?></nobr></td>
    <td class="lmost4"><nobr>
<?PHP
 if($sort!="name"){echo "<a href=\"javascript:chklmolink('".$adds."name');\">";}
   echo $text[2134]; // Name
 if($sort!="name"){echo "</a>";}
?></nobr></td>
    <td class="lmost4"><nobr>
<?PHP
 if($sort!="team"){echo "<a href=\"javascript:chklmolink('".$adds."team');\">";}
   echo $text[2027]; // Team
 if($sort!="team"){echo "</a>";}
?></nobr></td>
    <td class="lmost4"><nobr>
<?PHP
 if($sort!="ltipp"){echo "<a href=\"javascript:chklmolink('".$adds."ltipp');\">";}
   echo $text[2270]; // letzter Tipp
 if($sort!="ltipp"){echo "</a>";}
?></nobr></td>
    <td class="lmost4">&nbsp;</td>
    <td class="lmost4">&nbsp;</td>
  </tr>

<?PHP
  $anztipper=count($users);
  $id=array_pad($array,$anztipper,"");
  $nick=array_pad($array,$anztipper,"");
  $pass=array_pad($array,$anztipper,"");
  $name=array_pad($array,$anztipper,"");
  $email=array_pad($array,$anztipper,"");
  $team=array_pad($array,$anztipper,"");
  $ltipp=array_pad($array,$anztipper,"");
  for($i=1;$i<$anztipper;$i++){
    $userd = split("[|]",$users[$i]);
    $id[$i]=$i;
    $nick[$i]=$userd[0];
    $pass[$i]=$userd[1];
    $name[$i]=substr($userd[3],strpos($userd[3]," ")+1).", ".substr($userd[3],0,strpos($userd[3]," "));
    $email[$i]=$userd[4];
    $team[$i]=$userd[5];
    $ltipp[$i]=0;
    $verz=opendir(substr($dirtipp,0,-1));
    while($files=readdir($verz)){
      if(substr($files,-5-strlen($userd[0]))=="_".$userd[0].".tip"){
      	if(filectime($dirtipp.$files)>$ltipp[$i]){
      	  $ltipp[$i]=filemtime($dirtipp.$files);
      	  }
      	}
      }
    closedir($verz);
    }

  $tab0 = array("");
  for($a=1;$a<$anztipper;$a++){
    if($sort=="id"){array_push($tab0,(50000000+$id[$a]).(50000000+$a));}
    elseif($sort=="nick"){array_push($tab0,strtolower($nick[$a]).(50000000+$a));}
    elseif($sort=="pass"){array_push($tab0,strtolower($pass[$a]).(50000000+$a));}
    elseif($sort=="name"){array_push($tab0,strtolower($name[$a]).(50000000+$a));}
    elseif($sort=="email"){array_push($tab0,strtolower($email[$a]).(50000000+$a));}
    elseif($sort=="team"){array_push($tab0,strtolower($team[$a]).(50000000+$a));}
    elseif($sort=="ltipp"){array_push($tab0,$ltipp[$a].(50000000+$a));}
    }
  array_shift($tab0);
  sort($tab0,SORT_STRING);


  for($x=1;$x<$anztipper;$x++){
    $i=intval(substr($tab0[$x-1],-7));
?>
  <tr>
    <td class="lmost5" align="right"><?PHP echo $id[$i]; ?></td>
    <td class="lmost5"><a href="mailto:<?PHP echo $email[$i]; ?>"><?PHP echo $nick[$i]; ?></a></td>
    <td class="lmost5"><?PHP echo $pass[$i]; ?></td>
    <td class="lmost5"><?PHP echo $name[$i]; ?></td>
    <td class="lmost5"><?PHP echo $team[$i]; ?></td>
    <td class="lmost5"><?PHP if($ltipp[$i]>0){echo date("d.m.Y H:i",$ltipp[$i]);} ?></td>
<?PHP    
    echo "<td class=\"lmost5\"><a href=\"javascript:chklmolink('".$added.$nick[$i]."');\">".$text[2098]."</a></td>";
    echo "<td class=\"lmost5\"><a href=\"javascript:chklmolink('".$addd.$nick[$i]."');\">".$text[82]."</a></td>";
    }
  } ?>

  <tr>
    <td class="lmost4" colspan="8"><nobr><?PHP echo $text[2136]; ?></nobr></td>
  </tr>
  <form name="lmoeditx" action="<?PHP echo $PHP_SELF; ?>" method="post">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippuser">
  <input type="hidden" name="save" value="-1">
  <tr>
    <td class="lmost5" align="right"><?PHP if(!isset($anztipper)){$anztipper=1;}echo $anztipper; ?></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xnickx" size="10" maxlength="32" value="NeuerNick"></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xpassx" size="10" maxlength="32" value="<?PHP require("lmo-adminuserpass.php") ?>"></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[327] ?>"><input class="lmoadminbut" type="submit" name="bestx" value="<?PHP echo $text[329]; ?>"></acronym></td>
  </tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$adda."');\" title=\"".$text[2063]."\">".$text[2063]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$adde."');\" title=\"".$text[2165]."\">".$text[2165]."</a></td>";
  echo "<td class=\"lmost1\" align=\"center\">".$text[2114]."</td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addo."');\" title=\"".$text[2055]."\">".$text[86]."</a></td>";
?>
    </tr></table></td>
  </tr>
</table>
<?PHP } ?>