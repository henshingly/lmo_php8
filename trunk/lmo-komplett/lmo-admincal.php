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
  */
  
  

isset($_GET['abs'])?$abs=$_GET['abs']:$abs="";
isset($_GET['feld'])?$feld=$_GET['feld']:$feld="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>LMO Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<style type="text/css">
body{font-size:81%;font-family:sans-serif;}
table.caltab { font-size:91%;width:160px; border:1px solid grey; background-color:#ddd; padding:2px; margin:0;}
table.caltab1 { border:0; padding:0; margin:0; background-color:#fff;}
a:link, a:visited { color:#000; background-color:#fff;text-decoration:none;}
a:hover, a:active { color:#fff; background-color:#48f;}
td.caltz, td.calwt { color:#000; background-color:#ddd;font-weight: bolder; }

td.calat { color:#000; }
td.calat a:link, td.calat a:visited { color:#000; background-color:#fff;  text-decoration:none; }
td.calat a:hover, td.calat a:active { color:#ddd; background-color:#000;}

td.calht { color:#000; background-color:#aaf;font-weight: bolder;   }
td.calht a:link, td.calht a:visited { color:#000; background-color:#aaf;  text-decoration:none; }
td.calht a:hover, td.calht a:active { color:#aaf; background-color:#000;}

td.calhe { color:#f00; background-color:#aaf;  font-weight: bolder; }
td.calhe a:link, td.calhe a:visited { color:#f00; background-color:#aaf;  text-decoration:none; }
td.calhe a:hover, td.calhe a:active { color:#aaf; background-color:#f00;}

td.calwe { color:#f00;  font-weight: bolder; }
td.calwe a:link, td.calwe a:visited { color:#f00; background-color:#fff;  text-decoration:none; }
td.calwe a:hover, td.calwe a:active { color:#ddd; background-color:#f00;}
</style>
<script type="text/javascript">
<!--
opener.document.forms.<?=$abs; ?>.<?=$feld; ?>.select();
function lmogeben(x){
  opener.document.forms.<?=$abs; ?>.<?=$feld; ?>.value=x;
  self.close();
  }
// -->
</script>
</head>
<body>
<?
$addi=$_SERVER['PHP_SELF']."?abs=".$abs."&amp;feld=".$feld;
$dat = time();
$dat0 = getdate($dat);
$datj=$dat0['month']." ".$dat0['year'];
if(!isset($_GET['calshow']) || $_GET['calshow']=="") {
   $calshow=$dat0['month']." ".$dat0['year'];
} else {
  $calshow = $_GET['calshow'];
}
$dath=$calshow;
$calshow="";
$dat5="1 ".$dath;
$dat1 = getdate(strtotime($dat5));
$dat2 = getdate(strtotime($dat5." -1 month"));
$datr=$dat2['month']." ".$dat2['year'];
$dat3 = getdate(strtotime($dat5." +1 month"));
$datv=$dat3['month']." ".$dat3['year'];
$mn=array("0","Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
$erster=$dat1['wday'];?>
<table class="caltab">
  <tr>
    <td align="center">
      <table class="caltab1" width=100%>
        <tr>
          <td align="left"><a href="<?=$addi?>&amp;calshow=<?=$datr?>" title="zum vorigen Monat">&nbsp;&lt;&nbsp;</a></td>
          <td align="center" class="caltz"><?=$mn[$dat1['mon']]." ".$dat1['year'];?></td>
          <td align="right"><a href="<?=$addi?>" title="zum aktuellen Monat">&nbsp;#&nbsp;</a><a href="<?=$addi?>&amp;calshow=<?=$datv?>" title="zum nächsten Monat">&nbsp;&gt;&nbsp;</a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center">
      <table class="caltab1" width=100%>
        <tr>
          <td align="center" class="calwt">Mo</td>
          <td align="center" class="calwt">Di</td>
          <td align="center" class="calwt">Mi</td>
          <td align="center" class="calwt">Do</td>
          <td align="center" class="calwt">Fr</td>
          <td align="center" class="calwt">Sa</td>
          <td align="center" class="calwt">So</td>
        </tr><?
if($erster==0){$erster=7;}?>
        <tr><?
for($i=0;$i<$erster-1;$i++){?>
          <td class="calat">&nbsp;</td><?
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
    if($heute==1){?>
          <tr><?
    }?>
            <td align="center" class="<?=$stil?>"><a href="#" onclick='lmogeben("<?=strftime("%d.%m.%Y",strtotime($i." ".$dath))?>")' title="Datum übernehmen"><?="$k$i"?></a></td><?
    if($heute==7){?>
          </tr><?
      $j=$heute;
    }
  }
}
if ($j!=7){
  for ($i=0;$i<7-$j;$i++){?>
            <td class="calat">&nbsp;</td><?
  }?>
          </tr><?
}?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="right"><a href="#" onclick="self.close()" title="Kalender schließen, ohne ein Datum zu übernehmen">[schließen]</a></td>
  </tr>
</table>