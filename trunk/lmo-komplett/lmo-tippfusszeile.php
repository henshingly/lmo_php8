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
if(!isset($nw)){$nw=0;}
?>
  <tr><td class="lmomain2" colspan="3" align="right">
    <table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
      <td class="lmomain2" valign="top"><nobr>
        <?PHP if($todo=="wert"){?>
          <?PHP echo "<strong>".$text[589].":</strong><br>"; /// Zeichenerklaerung ?>
            <?PHP if($wertung=="team"){?>
              <?PHP echo $text[619].": ".$text[620]."&nbsp;&nbsp;&nbsp;<br>"; // AT ?>
              <?PHP echo $text[619]."&Oslash;: ".$text[708]."&nbsp;&nbsp;&nbsp;<br>"; // AT ?>
            <?PHP } ?>
          <?PHP echo $text[623].": ".$text[617]."&nbsp;&nbsp;&nbsp;<br>"; // SG ?>
          <?PHP if($showstsiege==1){echo $text[590].": ".$text[771]."&nbsp;&nbsp;&nbsp;<br>";} // GS  ?>
          <?PHP echo $text[623];if($tippmodus==1){echo "&Oslash;: ".$text[624];}else{echo "&#37;: ".$text[625];} echo "&nbsp;&nbsp;&nbsp;<br>"; ?>
          <?PHP if($tippmodus==1){echo $text[37].": ".$text[616];}else{echo $text[622].": ".$text[618];}echo "&nbsp;&nbsp;&nbsp;<br>"; // PP ?>
        <?PHP } ?>
        <?PHP if($todo=="wert" || $todo=="edit" || $todo=="einsicht"){?>
         <?PHP if($tippmodus==1){?>
          <?PHP echo "<strong>".$text[608].":</strong><br>"; // Punkteverteilung ?>
          <?PHP if($rergebnis>0){echo $text[721].": ".$text[534].": ".$rergebnis." ".$text[538]."&nbsp;&nbsp;&nbsp;<br>";} ?>
          <?PHP if($rtendenzdiff>$rtendenz){echo $text[722].": ".$text[535].": ".$rtendenzdiff." ".$text[538]."&nbsp;&nbsp;&nbsp;<br>";} ?>
          <?PHP if($rtendenz>0){echo $text[723].": ".$text[536].": ".$rtendenz." ".$text[538]."&nbsp;&nbsp;&nbsp;<br>";} ?>
          <?PHP if($rtor>0){echo $text[724].": ".$text[537].": ".$rtor." ".$text[538]."&nbsp;&nbsp;&nbsp;<br>";} ?>
         <?PHP } ?>
         <?PHP if($rremis>0){echo $text[725].": ".$text[692].": ".$rremis." ".$text[538]."&nbsp;&nbsp;&nbsp;<br>";} ?>
         <?PHP if($jokertipp==1 && $todo=="einsicht"){echo "<font color=red>".$text[787]."</font>: ".$text[902]."&nbsp;&nbsp;&nbsp;<br>";} ?>
         <?PHP if($jokertipp==1 && $todo=="wert"){echo $text[726].": ".$text[727]."&nbsp;&nbsp;&nbsp;<br>";} ?>
         <?PHP if($jokertipp==1 && $todo=="edit"){echo $text[904].": ".$jokertippmulti."&nbsp;&nbsp;&nbsp;<br>";} ?>
         <?PHP if($nw==1){echo $text[730]." ".$text[731]."&nbsp;&nbsp;&nbsp;<br>";} ?>
        <?PHP } ?>
     </nobr></td>
      <td class="lmomain2" align="right" valign="bottom" rowspan="2"><nobr>
        <?PHP if(!isset($auswertfile)){$auswertfile="";}
              if(!isset($tippfile)){$tippfile="";}
              if(!isset($einsichtfile)){$einsichtfile="";}
              if($auswertfile==""){$auswertfile=$einsichtfile;}
              if($auswertfile!="" && file_exists($auswertfile)){
        	$auswertstand=date("d.m.Y H:i",filectime($auswertfile)); // Stand der *.aus-Datei
                echo $text[583].": ".$auswertstand."<br>";
                } ?>
        <?PHP if($tippfile!="" && $all!=1 && ($todo!="tabelle" || $nick!="") && file_exists($tippfile)){
        	$tippstand=date("d.m.Y H:i",filectime($tippfile)); // Stand der *_user.tip-Datei
                echo $text[586].": ".$tippstand."<br>";
                } ?>
        <?PHP if($file!="" && $all!=1 && isset($stand) && $stand!=""){echo $text[406].": ".$stand."<br>";} // Stand der *.l98-Datei ?>
        <?PHP if($calctime==1){echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";} ?>
        <?PHP echo $text[54]; ?> - <?PHP echo $text[55]; ?><br>
        <?PHP echo $text[584]; ?> - <?PHP echo $text[585]; ?>
      </nobr></td>
</tr><tr>
      <td class="lmomain1" valign="bottom">
<?PHP
 if($file!="" && $lmtype==0 && $all!=1){echo "<a href=\"".$PHP_SELF."?file=".$file."&amp;action=table\">".$text[5]." ".$text[599]."</a>&nbsp;&nbsp;&nbsp;<br>";}
 if($todo!="" && $todo!="logout"){echo "<a href=\"".$PHP_SELF."?action=tipp&amp;PHPSESSID=".$PHPSESSID."\">".$text[5]." ".$text[501]."</a>&nbsp;&nbsp;&nbsp;";}
 if($todo=="" || $todo=="logout"){if($backlink==1){echo "<a href=\"".$PHP_SELF."\">".$text[391]."</a>&nbsp;&nbsp;&nbsp;";}}
?>
 </td>
    </tr></table>
  </td></tr>
