<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
?>
<style type="text/css">
<!--
a.callink:link { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callink:visited { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callink:active { color:#ffffff; background-color:#4488ff; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callink:hover { color:#ffffff; background-color:#4488ff; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callin2:link { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callin2:visited { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callin2:active { color:#ffff00; background-color:#4488ff; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
a.callin2:hover { color:#ffff00; background-color:#4488ff; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; text-decoration:none; }
td.caltz { color:#000000; font-family: arial,helvetica,sans-serif; font-size: 11px; font-weight: bold; }
td.calwt { color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: bold; }
td.calat { color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; }
td.calat a:link { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calat a:visited { color:#000000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calat a:active { color:#E0E0E0; background-color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calat a:hover { color:#E0E0E0; background-color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calht { color:#000000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: bold; }
td.calht a:link { color:#000000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calht a:visited { color:#000000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calht a:active { color:#AAAAFF; background-color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calht a:hover { color:#AAAAFF; background-color:#000000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calhe { color:#FF0000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: bold; }
td.calhe a:link { color:#FF0000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calhe a:visited { color:#FF0000; background-color:#AAAAFF; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calhe a:active { color:#AAAAFF; background-color:#FF0000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calhe a:hover { color:#AAAAFF; background-color:#FF0000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calwe { color:#FF0000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: bold; }
td.calwe a:link { color:#FF0000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calwe a:visited { color:#FF0000; background-color:#E0E0E0; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calwe a:active { color:#E0E0E0; background-color:#FF0000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
td.calwe a:hover { color:#E0E0E0; background-color:#FF0000; font-family: arial,helvetica,sans-serif; font-size: 10px; font-weight: normal; text-decoration:none; }
table.caltab { width:160px; border:1px solid grey; background-color:#E0E0E0; padding:2px; margin:0px; }
table.caltab1 { border:0px; padding:0px; margin:0px; }
table.caltab2 { border:0px; padding:0px; margin:0px; }
//-->
</style>


<script language="JavaScript">
<!---
opener.<?PHP echo $abs; ?>.<?PHP echo $feld; ?>.select();
function lmogeben(x){
  opener.<?PHP echo $abs; ?>.<?PHP echo $feld; ?>.value=x;
  self.close();
  }
// --->
</script>

<?PHP
$addi=$PHP_SELF."?abs=".$abs."&amp;feld=".$feld;
$dat = time();
$dat0 = getdate($dat);
$datj=$dat0['month']." ".$dat0['year'];
if($calshow==""){$calshow=$dat0['month']." ".$dat0['year'];}
$dath=$calshow;
$calshow="";
$dat5="1 ".$dath;
$dat1 = getdate(strtotime($dat5));
$dat2 = getdate(strtotime($dat5." -1 month"));
$datr=$dat2['month']." ".$dat2['year'];
$dat3 = getdate(strtotime($dat5." +1 month"));
$datv=$dat3['month']." ".$dat3['year'];
$mn=array("0","Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
$erster=$dat1['wday'];
echo "<table class=\"caltab\"><tr><td align=center><table class=\"caltab1\" width=100%><tr>";
echo "<td align=left><a href=\"".$addi."&amp;calshow=".$datr."\" class=\"callink\" title=\"zum vorigen Monat\">&nbsp;&lt;&nbsp;</a></td>";
echo "<td align=center class=\"caltz\">".$mn[$dat1['mon']]." ".$dat1['year']."</td>";
echo "<td align=right><a href=\"".$addi."\" class=\"callink\" title=\"zum aktuellen Monat\">&nbsp;#&nbsp;</a><a href=\"".$addi."&amp;calshow=".$datv."\" class=\"callink\" title=\"zum n&auml;chsten Monat\">&nbsp;&gt;&nbsp;</a></td>";
echo "</tr></table></td></tr><tr><td align=center><table class=\"caltab2\" width=100%><tr><td align=center class=\"calwt\">Mo</td><td align=center class=\"calwt\">Di</td><td align=center class=\"calwt\">Mi</td><td align=center class=\"calwt\">Do</td><td align=center class=\"calwt\">Fr</td><td align=center class=\"calwt\">Sa</td><td align=center class=\"calwt\">So</td></tr>";
if($erster!=1){
  if($erster==0){$erster=7;}
  echo "<tr>";
  for($i=0;$i<$erster-1;$i++){echo "<td class=\"calat\">&nbsp;</td>";}
  }
for($i=1;$i<=31;$i++){
  $dat4 = getdate(strtotime($i." ".$dath));
  $heute=$dat4['wday'];
  if($heute==0){$heute=7;}
  if($dat1['mon']==$dat4['mon']){
    $stil="calat";
    $dum1=$dat0['mday'].".".$dat0['mon'].".".$dat0['year'];
    $dum2=$dat4['mday'].".".$dat4['mon'].".".$dat4['year'];
    if($dum1==$dum2){
      if(($heute==6) || ($heute==7)){$stil="calhe";}else{$stil="calht";}
      }
      else{
      if(($heute==6) || ($heute==7)){$stil="calwe";}else{$stil="calat";}
      }
    if ($i<=9){$k="0";}else{$k="";}
    if($heute==1){echo "<tr>";}
    echo "<td align=center class=\"".$stil."\"><a href=\"javascript:lmogeben('".strftime("%d.%m.%Y",strtotime($i." ".$dath))."')\" title=\"Datum &uuml;bernehmen\">".$k.$i."</a></td>";
    if($heute==7){echo "</tr>";}
    $j=$heute;
    }
  }
if ($j!=7){
  for ($i=0;$i<7-$j;$i++){echo "<td class=\"calat\">&nbsp;</td>";}
  echo "</tr>";
  }
echo "</td></tr></table></td></tr>";
echo "<tr><td align=right><a href=\"javascript:self.close()\" class=\"callin2\" title=\"Kalender schlie&szlig;en, ohne ein Datum zu &uuml;bernehmen\">[schlie&szlig;en]</a></td></tr></table>";
?>
