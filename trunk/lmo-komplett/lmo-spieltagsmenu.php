<table class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
  <tr><?
  for ($i=1; $i<=$anzst; $i++) {
    if ($lmtype==1) {
      if ($i==$anzst) {
        $j=$text[364];
        $k=$text[365];
      } else if ($i==$anzst-1) {
        $j=$text[362];
        $k=$text[363];
      } else if ($i==$anzst-2) {
        $j=$text[360];
        $k=$text[361];
      } else if ($i==$anzst-3) {
        $j=$text[358];
        $k=$text[359];
      } else {
        $j=$i;
        $k=$text[366];
      }
    } else {
      $j=sprintf("%02d",$i);
      $k=$text[9];
    }
    echo "<td align='center'>";
    if ($i<>$st) {
      echo "<a href='".$addr.$i."' title='".$k."'>".$j."</a>";
    } else {
      echo $j;
    }
    echo "&nbsp;</td>";
    if (($anzst>49) && (($anzst%4)==0)) {
      if (($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)) {
        echo "</tr><tr>";
      }
    } else if (($anzst>38) && (($anzst%3)==0)) {
      if (($i==$anzst/3) || ($i==$anzst/3*2)) {
        echo "</tr><tr>";
      }
    } else if (($anzst>29) && (($anzst%2)==0)) {
      if ($i==$anzst/2) {
        echo "</tr><tr>";
      }
    }
  }?>
  </tr>
</table>