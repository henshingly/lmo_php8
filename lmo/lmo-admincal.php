<?php
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



require(__DIR__ . "/init.php");
isset($_GET['abs'])?$abs=$_GET['abs']:$abs="";
isset($_GET['feld'])?$feld=$_GET['feld']:$feld="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>Pop-Up <?php echo $text[255];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
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
opener.document.forms.<?php echo $abs; ?>.<?php echo $feld; ?>.select();
function lmogeben(x){
  opener.document.forms.<?php echo $abs; ?>.<?php echo $feld; ?>.value=x;
  self.close();
  }
// -->
</script>
</head>
<body>
<center>
<?php
$addi = $_SERVER['PHP_SELF'] . "?abs=" . $abs . "&amp;feld=" . $feld;
$dat = time();
$dat0 = getdate($dat);
if (!isset($_GET['calshow']) || $_GET['calshow'] == "") {
   $calshow=$dat0['month'] . " " . $dat0['year'];
} else {
  $calshow = $_GET['calshow'];
}
$dath = $calshow;
$calshow = "";
$dat5 = "1 " . $dath;
$dat1 = getdate(strtotime($dat5));
$dat2 = getdate(strtotime($dat5 . " -1 month"));
$datr = $dat2['month'] . " " . $dat2['year'];
$dat3 = getdate(strtotime($dat5 . " +1 month"));
$datv = $dat3['month'] . " " . $dat3['year'];
$mn = array( 'Monday' => $text['date'][0], 'Tuesday' => $text['date'][1], 'Wednesday' => $text['date'][2], 'Thursday' => $text['date'][3], 'Friday' => $text['date'][4], 'Saturday' => $text['date'][5], 'Sunday' => $text['date'][6], 'Mon' => $text['date'][7], 'Tue' => $text['date'][8], 'Wed' => $text['date'][9], 'Thu' => $text['date'][10], 'Fri' => $text['date'][11], 'Sat' => $text['date'][12], 'Sun' => $text['date'][13], 'January' => $text['date'][14], 'February' => $text['date'][15], 'March' => $text['date'][16], 'April' => $text['date'][17], 'May' => $text['date'][18], 'June' => $text['date'][19], 'July' => $text['date'][20], 'August' => $text['date'][21], 'September' => $text['date'][22], 'October' => $text['date'][23], 'November' => $text['date'][24], 'December' => $text['date'][25], 'Jan' => $text['date'][26], 'Feb' => $text['date'][27], 'Mar' => $text['date'][28], 'Apr' => $text['date'][29], 'May' => $text['date'][30], 'Jun' => $text['date'][31], 'Jul' => $text['date'][32], 'Aug' => $text['date'][33], 'Sep' => $text['date'][34], 'Oct' => $text['date'][35], 'Nov' => $text['date'][36], 'Dec' => $text['date'][37] );

$first = $dat1['wday'];?>
<table class="caltab">
  <tr>
    <td align="center">
      <table class="caltab1" width=100%>
        <tr>
          <td align="left"><a href="<?php echo $addi?>&amp;calshow=<?php echo $datr?>" title="<?php echo $text['date'][38];?>">&nbsp;&lt;&nbsp;</a></td>
          <td align="center" class="caltz"><?php echo $mn[$dat1['month']] . " " . $dat1['year'];?></td>
          <td align="right"><a href="<?php echo $addi?>" title="<?php echo $text['date'][39];?>">&nbsp;#&nbsp;</a><a href="<?php echo $addi?>&amp;calshow=<?php echo $datv?>" title="<?php echo $text['date'][40];?>">&nbsp;&gt;&nbsp;</a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center">
      <table class="caltab1" width=100%>
        <tr>
          <td align="center" class="calwt"><?php echo $text['date'][7];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][8];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][9];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][10];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][11];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][12];?></td>
          <td align="center" class="calwt"><?php echo $text['date'][13];?></td>
        </tr><?php
if ($first == 0) {$first = 7;}?>
        <tr><?php
for ($i = 0; $i < $first - 1; $i ++){?>
          <td class="calat">&nbsp;</td><?php
}
for ($i = 1; $i <= 31; $i ++){
  $dat4 = getdate(strtotime($i . " " . $dath));
  $today = $dat4['wday'];
  if ($today == 0) {$today = 7;}
  if ($dat1['mon'] == $dat4['mon']){
    $stil = "calat";
    $dum1 = $dat0['mday'] . "." . $dat0['mon'] . "." . $dat0['year'];
    $dum2 = $dat4['mday'] . "." . $dat4['mon'] . "." . $dat4['year'];
    if ($dum1 == $dum2){
      if (($today == 6) || ($today == 7)){$stil = "calhe";} else {$stil = "calht";}
      }
      else {
      if (($today == 6) || ($today == 7)){$stil = "calwe";} else {$stil = "calat";}
    }
    if ($i <= 9) {$k = "0";} else {$k = "";}
    if ($today == 1){?>
          <tr><?php
    }?>
            <td align="center" class="<?php echo $stil?>"><a href="#" onclick='lmogeben("<?php echo date("d.m.Y",strtotime($i." ".$dath))?>")' title="<?php echo $text['date'][41];?>"><?php echo "$k$i"?></a></td><?php
    if ($today == 7){?>
          </tr><?php
      $j = $today;
    }
  }
}
if ($j != 7){
  for ($i = 0; $i < 7 - $j; $i ++){?>
            <td class="calat">&nbsp;</td><?php
  }?>
          </tr><?php
}?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="right"><a href="#" onclick="self.close()" title="<?php echo $text['date'][42];?>">[<?php echo $text[347];?>]</a></td>
  </tr>
</table>
</center>
</body>
</html>