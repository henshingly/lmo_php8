<?
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
if($file!="" && $tipp_tippfieber==1){
  if(!isset($save)){$save=0;}
  if($save==1){
    $stat1=trim($_POST["xstat1"]);
    $stat2=trim($_POST["xstat2"]);
    $kurvenmodus=trim($_POST["xkurvenmodus"]);
    }
  
  if(!isset($eigpos)){$eigpos=0;}
  if(!isset($stat1)){$stat1=-1;}
  if(!isset($stat2)){$stat2=-1;}
  if($stat1==$stat2){$stat2=-1;}
  if(!isset($kurvenmodus)){$kurvenmodus=1;}
  $addg=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=fieber&amp;file=".$file."&amp;stat1=";
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcgraph.php");
  echo $anztipper;
?>
<form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="fieber">
  <input type="hidden" name="file" value="<? echo $file; ?>">
  <input type="hidden" name="save" value="1">
  <table class="lmosta" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td class="lmost1"><? echo $text['tipp'][164]." 1";?></td>
      <td class="lmost1"><? echo $text['tipp'][164]." 2";?></td>
      <td class="lmost1"><? echo $text['tipp'][283];?></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <select name="xstat1"><?
  $tab=array();
  for($i=0;$i<$anztipper;$i++){
    array_push($tab,strtolower($tippernick[$i]).(50000000+$i));
    }
  sort($tab,SORT_STRING);?>
          <option value="-1"<?if($stat1==-1){echo " selected";}?>>___</option><?
  for($i=0;$i<$anztipper;$i++){
    $j=intval(substr($tab[$i],-7));?>
          <option value="<?=$j?>"<?if($stat1==$j){echo " selected";}?>><?=$tippernick[$j]?></option><?
    }?>
        </select>
      </td>
      <td>
        <select name="xstat2">
          <option value="-1"<?if($stat2==-1){echo " selected";}?>>___</option><?
  for($i=0;$i<$anztipper;$i++){
    $j=intval(substr($tab[$i],-7));?>
          <option value="$j"<?if($stat2==$j){echo " selected";}?>><?=$tippernick[$j]?></option><?
    }?>
        </select>
      </td>
      <td>
        <select name="xkurvenmodus">
          <option value="1"<?if($kurvenmodus==1){echo " selected";}?>><?=$text['tipp'][235]?></option>
          <option value="2"<?if($kurvenmodus==2){echo " selected";}?>><?=$text['tipp'][232]?></option>
          <option value="3"<?if($kurvenmodus==3){echo " selected";}?>><?=$text['tipp'][234]?></option>
          <option value="4"<?if($kurvenmodus==4){echo " selected";}?>><?=$text['tipp'][232]?></option>
        </select>
      </td>
      <td>
         <input type="submit" name="best" value="<? echo $text['tipp'][236]; ?>">
      </td>
    </tr><?
  if (isset($tippernick) && count($tippernick)>1) {?>
    <tr>
      <td colspan="4" align="center" class="lmost3">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
    if ($stat1<0 && $stat2>=0) {
      $stat1=$stat2;
      $stat2=-1;
    }
    if ($stat1<0) {
      echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text['tipp'][284]."<br>&nbsp;</td></tr>";
    } else {
      $dummy="lmo-tipppaintgraph.php?pganz=";
      if ($stat2>=0) {
        $dummy=$dummy."2";
      } else {
        $dummy=$dummy."1";
      }
      $dummy=$dummy."&amp;pgteam1=".htmlentities($tippernick[$stat1]);
      if ($stat2>=0) {
        $dummy=$dummy."&amp;pgteam2=".htmlentities($tippernick[$stat2]);
      }
      if ($kurvenmodus==1) {
        if ($stat2>=0) {
          $max=max(max($tipppunkte[$stat1]),max($tipppunkte[$stat2]));
        } else {
          $max=max($tipppunkte[$stat1]);
        }
      } else if ($kurvenmodus==2) {
        if ($stat2>=0) {
          $max=max(max($platz[$stat1]),max($platz[$stat2]));
        } else {
          $max=max($platz[$stat1]);
        }
      } else if ($kurvenmodus==3) {
        if ($stat2>=0) {
          $max=max(max($platz[$stat1]),max($platz[$stat2]),max($platz1[$stat1]),max($platz1[$stat2]));
        } else {
          $max=max(max($platz[$stat1]),max($platz1[$stat1]));
        }
      } else if ($kurvenmodus==4) {
        if ($stat2>=0) {
          $max=max(max($platz1[$stat1]),max($platz1[$stat2]));
        } else {
          $max=max($platz1[$stat1]);
        }
      }
      $dummy=$dummy."&amp;max=".$max;
      $dummy=$dummy."&amp;pgst=".$anzst;
      if ($kurvenmodus<4) {
        $dummy=$dummy."&amp;pgplatz1=";
        if ($kurvenmodus==1) {
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$tipppunkte[$stat1][$j].",";
          }
        } else {
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$platz[$stat1][$j].",";
          }
        }
        $dummy.="0";
      }
      if ($kurvenmodus>2) {
        $dummy=$dummy."&amp;pgplatz1a=";
        for ($j=0; $j<$anzst; $j++) {
          $dummy.=$platz1[$stat1][$j].",";
        }
        $dummy.="0";
      }
      if ($stat2>=0) {
        if ($kurvenmodus<4) {
          $dummy=$dummy."&amp;pgplatz2=";
          if ($kurvenmodus==1) {
            for ($j=0; $j<$anzst; $j++) {
              $dummy.=$tipppunkte[$stat2][$j].",";
            }
          } else {
            for ($j=0; $j<$anzst; $j++) {
              $dummy.=$platz[$stat2][$j].",";
            }
          }
          $dummy.="0";
        }
        if ($kurvenmodus>2) {
          $dummy=$dummy."&amp;pgplatz2a=";
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$platz1[$stat2][$j].",";
          }
          $dummy.="0";
        }
      }
      $dummy=$dummy."&amp;kmodus=".$kurvenmodus;
      $dummy=$dummy."&amp;pgtext1=".$text[135];
      //SPIELTAGE
      if ($kurvenmodus==1) {
        $dummy=$dummy."&amp;pgtext2=".strtoupper($text['tipp'][38]);
      }
      // PUNKTE
      else{
        $dummy=$dummy."&amp;pgtext2=".$text[136];
      }
      //PLATZIERUNG
      ?>
          <tr><td class="lmost5" colspan="3"><img src="<? echo $dummy; ?>" border="0"></td></tr><? 
    }?>
        </table>
      </td>
    </tr><?
  }?>
  </table>
</form><? 
}?>