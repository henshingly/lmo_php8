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
  $save=isset($_POST['save'])?1:0;
  if($save==1){
    $fieber_stat1=trim($_POST["xstat1"]);
    $fieber_stat2=trim($_POST["xstat2"]);
    $kurvenmodus=trim($_POST["xkurvenmodus"]);
  }
  if(!isset($eigpos)){$eigpos=0;}
  if(!isset($fieber_stat1)){$fieber_stat1=-1;}
  if(!isset($fieber_stat2)){$fieber_stat2=-1;}
  if($fieber_stat1==$fieber_stat2){$fieber_stat2=-1;}
  if(!isset($kurvenmodus)){$kurvenmodus=1;}
  $addg=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=fieber&amp;file=".$file."&amp;stat1=";
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcgraph.php");
  //echo $anztipper;
?>
<form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="fieber">
  <input type="hidden" name="file" value="<?=$file; ?>">
  <input type="hidden" name="save" value="1">
  <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <th align="left"><? echo $text['tipp'][164]." 1";?></td>
      <th align="left"><? echo $text['tipp'][164]." 2";?></td>
      <th align="left"><? echo $text['tipp'][283];?></td>
      <th&nbsp;></th>
    </tr>
    <tr>
      <td>
        <select name="xstat1"><?
  $tab=array();
  for($i=0;$i<$anztipper;$i++){
    array_push($tab,strtolower($tippernick[$i]).(50000000+$i));
    }
  sort($tab,SORT_STRING);?>
          <option value="-1"<?if($fieber_stat1==-1){echo " selected";}?>>___</option><?
  for($i=0;$i<$anztipper;$i++){
    $j=intval(substr($tab[$i],-7));?>
          <option value="<?=$j?>"<?if($fieber_stat1==$j){echo " selected";}?>><?=$tippernick[$j]?></option><?
    }?>
        </select>
      </td>
      <td>
        <select name="xstat2">
          <option value="-1"<?if($fieber_stat2==-1){echo " selected";}?>>___</option><?
  for($i=0;$i<$anztipper;$i++){
    $j=intval(substr($tab[$i],-7));?>
          <option value="<?=$j?>"<?if($fieber_stat2==$j){echo " selected";}?>><?=$tippernick[$j]?></option><?
    }?>
        </select>
      </td>
      <td>
        <select name="xkurvenmodus">
          <option value="1"<?if($kurvenmodus==1){echo " selected";}?>><?=$text['tipp'][235]?></option>
          <option value="2"<?if($kurvenmodus==2){echo " selected";}?>><?=$text['tipp'][232]?></option>
          <option value="3"<?if($kurvenmodus==3){echo " selected";}?>><?=$text['tipp'][234]?></option>
          <option value="4"<?if($kurvenmodus==4){echo " selected";}?>><?=$text['tipp'][233]?></option>
        </select>
      </td>
      <td>
         <input type="submit" name="best" value="<? echo $text['tipp'][236]; ?>">
      </td>
    </tr><?
  if (isset($tippernick) && count($tippernick)>1) {?>
    <tr>
      <td colspan="4" align="center">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
    if ($fieber_stat1<0 && $fieber_stat2>=0) {
      $fieber_stat1=$fieber_stat2;
      $fieber_stat2=-1;
    }
    if ($fieber_stat1<0) {
      echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text['tipp'][284]."<br>&nbsp;</td></tr>";
    } else {
      $dummy=URL_TO_ADDONDIR."/tipp/lmo-tipppaintgraph.php?pganz=";
      if ($fieber_stat2>=0) {
        $dummy=$dummy."2";
      } else {
        $dummy=$dummy."1";
      }
      $dummy=$dummy."&pgteam1=".htmlentities($tippernick[$fieber_stat1]);
      if ($fieber_stat2>=0) {
        $dummy=$dummy."&pgteam2=".htmlentities($tippernick[$fieber_stat2]);
      }
      if ($kurvenmodus==1) {
        if ($fieber_stat2>=0) {
          $max=max(max($tipppunkte[$fieber_stat1]),max($tipppunkte[$fieber_stat2]));
        } else {
          $max=max($tipppunkte[$fieber_stat1]);
        }
      } else if ($kurvenmodus==2) {
        if ($fieber_stat2>=0) {
          $max=max(max($platz[$fieber_stat1]),max($platz[$fieber_stat2]));
        } else {
          $max=max($platz[$fieber_stat1]);
        }
      } else if ($kurvenmodus==3) {
        if ($fieber_stat2>=0) {
          $max=max(max($platz[$fieber_stat1]),max($platz[$fieber_stat2]),max($platz1[$fieber_stat1]),max($platz1[$fieber_stat2]));
        } else {
          $max=max(max($platz[$fieber_stat1]),max($platz1[$fieber_stat1]));
        }
      } else if ($kurvenmodus==4) {
        if ($fieber_stat2>=0) {
          $max=max(max($platz1[$fieber_stat1]),max($platz1[$fieber_stat2]));
        } else {
          $max=max($platz1[$fieber_stat1]);
        }
      }
      $dummy=$dummy."&max=".$max;
      $dummy=$dummy."&pgst=".$anzst;
      if ($kurvenmodus<4) {
        $dummy=$dummy."&pgplatz1=";
        if ($kurvenmodus==1) {
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$tipppunkte[$fieber_stat1][$j].",";
          }
        } else {
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$platz[$fieber_stat1][$j].",";
          }
        }
        $dummy.="0";
      }
      if ($kurvenmodus>2) {
        $dummy=$dummy."&pgplatz1a=";
        for ($j=0; $j<$anzst; $j++) {
          $dummy.=$platz1[$fieber_stat1][$j].",";
        }
        $dummy.="0";
      }
      if ($fieber_stat2>=0) {
        if ($kurvenmodus<4) {
          $dummy=$dummy."&pgplatz2=";
          if ($kurvenmodus==1) {
            for ($j=0; $j<$anzst; $j++) {
              $dummy.=$tipppunkte[$fieber_stat2][$j].",";
            }
          } else {
            for ($j=0; $j<$anzst; $j++) {
              $dummy.=$platz[$fieber_stat2][$j].",";
            }
          }
          $dummy.="0";
        }
        if ($kurvenmodus>2) {
          $dummy=$dummy."&pgplatz2a=";
          for ($j=0; $j<$anzst; $j++) {
            $dummy.=$platz1[$fieber_stat2][$j].",";
          }
          $dummy.="0";
        }
      }
      $dummy=$dummy."&kmodus=".$kurvenmodus;
      $dummy=$dummy."&pgtext1=".$text[135];
      //SPIELTAGE
      if ($kurvenmodus==1) {
        $dummy=$dummy."&pgtext2=".strtoupper($text['tipp'][38]);
      }
      // PUNKTE
      else{
        $dummy=$dummy."&pgtext2=".$text[136];
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