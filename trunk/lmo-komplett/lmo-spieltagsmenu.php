<table cellspacing="0" cellpadding="0" border="0">
  <tr><?
  for ($i=1; $i<=$anzst; $i++) {
    echo "<td align=\"right\" ";
    if ($i<>$st) {
      echo "class=\"lmost0\"><a href=\"".$addr.$i."\" title=\"".$text[9]."\">".$i."</a>";
    } else {
      echo "class=\"lmost1\">".$i;
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