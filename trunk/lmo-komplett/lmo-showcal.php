<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0"><? 
  if(strlen($cal)>4){ ?>
  <tr>
    <td align="center">
      <table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="left"><a href="<?=$addk.$ma; ?>" title="<?=$text[142]; ?>"><?=$text[5]; ?></a></td>
          <td align="center"><a href="<?=$addk.$ml; ?>" title="<?=$text[173]; ?>"><?=$md; ?></a></td>
          <td align="right"><a href="<?=$addk.$mb; ?>" title="<?=$text[143]; ?>"><?=$text[154]; ?></a>&nbsp;&nbsp;<a href="<?=$addk.$mc; ?>" title="<?=$text[144]; ?>"><?=$text[7]; ?></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="lmoKalender" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th width="60" align="center"><?=$text[147]; ?></th>
          <th width="60" align="center"><?=$text[148]; ?></th>
          <th width="60" align="center"><?=$text[149]; ?></th>
          <th width="60" align="center"><?=$text[150]; ?></th>
          <th width="60" align="center"><?=$text[151]; ?></th>
          <th width="60" align="center"><?=$text[152]; ?></th>
          <th width="60" align="center"><?=$text[153]; ?></th>
        </tr>
<?
  $dat0 = getdate(time());
  if ($erster != 1) {
    if ($erster == 0) {
      $erster = 7;
    }
    echo "<tr>";
    for($i = 0; $i < $erster-1; $i++) {
      echo "<td class=\"lmoLeer\">&nbsp;</td>";
    }
  }
  for($i = 1; $i <= 31; $i++) {
    $dat4 = getdate(strtotime($i.$mj));
    $heute = $dat4['wday'];
    if ($heute == 0) {
      $heute = 7;
    }
    if ($dat1['mon'] == $dat4['mon']) {
      $stil = "";
      $dum6 = $dat0['mday'].".".$dat0['mon'].".".$dat0['year'];
      $dum7 = $dat4['mday'].".".$dat4['mon'].".".$dat4['year'];
      if ($dum6 == $dum7) {
        if (($heute == 6) || ($heute == 7)) {
          $stil = "lmoBackMarkierung lmoFrontMarkierung";
        } else {
          $stil = "lmoBackMarkierung";
        }
      } else {
        if (($heute == 6) || ($heute == 7)) {
          $stil = "lmoFrontMarkierung";
        } else {
          $stil = "";
        }
      }
      if ($i <= 9) {
        $k = "0";
      } else {
        $k = "";
      }
      if ($heute == 1) {
        echo "<tr>";
      }
      echo "<td align='left' height=\"50\" valign=\"top\" class=\"".$stil."\">".$i;
      if (!empty($lmo_stlink[$i])) {
        echo "<br>".$lmo_stlink[$i];
      }
      echo "</td>";
      if ($heute == 7) {
        echo "</tr>";
      }
      $j = $heute;
    }
  }
  //print_r($dum2);
  if ($j != 7) {
    for ($i = 0; $i < 7-$j; $i++) {
      echo "<td class=\"lmoLeer\">&nbsp;</td>";
    }
    echo "</tr>";
  }
  
} else {

?>
  <tr>
    <td align="center">
      <table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="left"><a href="<?=$addk.$ma; ?>" title="<?=$text[157]; ?>"><?=$text[5]; ?></a></td>
          <td align="center"><?=$text[156]." ".$md; ?></td>
          <td align="right"><a href="<?=$addk.$mb; ?>" title="<?=$text[158]; ?>"><?=$text[154]; ?></a>&nbsp;&nbsp;<a href="<?=$addk.$mc; ?>" title="<?=$text[159]; ?>"><?=$text[7]; ?></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="lmoKalender" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  $dat0 = getdate(time());
  $lmo_output_buffer=array();
  for($i = 1; $i <= 12; $i++) {
    if (($i == 1) || ($i == 7)) {
      echo "<tr>";
    }
    echo "<th width=\"70\" >";
    if ($i <= 9) {
      $k = "0";
    } else {
      $k = "";
    }
    echo "<a href=\"".$addk.$k.$i.$md."\" title=\"".$text[172]."\">".$text[159+$i]."</a></th>";
    

    $lmo_output_buffer[$i]=$lmo_stlink[$i]."<br>";
  
    echo "</td>";
    if (($i == 6) || ($i == 12)) {
      echo "</tr><tr><td valign='top' height=\"150\">";
      echo implode("</td><td valign='top' >",$lmo_output_buffer);
      echo "</tr>";
      $lmo_output_buffer=array();
    }
  }
}?>
      </table>
    </td>
  </tr>
</table>