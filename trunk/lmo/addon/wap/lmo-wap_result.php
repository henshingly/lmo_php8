<?
echo("<card id=\"day\" title=\"$st. Spieltag\">\n<p>");

//Anzeige Spieltag
if($file!=""){?>
<table columns="2" align="LC"><?
  $st_next = $st+1;
  $st_before = $st-1;
   
  for($i = 0; $i < $anzsp; $i++) {
    if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {
      echo "<tr><td>";
      if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
        echo "<b>";
      }
      $teamname = $teamk[$teama[$st-1][$i]];
      $teamname = ($teamname);
      echo $teamname;
      if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
        echo "</b>";
      }
       
      echo "-";
       
      if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
        echo "<b>";
      }
      $teamname = $teamk[$teamb[$st-1][$i]];
      $teamname = ($teamname);
      echo $teamname;
      if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
        echo "</b>";
      }
      $heim_tore = applyFactor($goala[$st-1][$i], $goalfaktor);
      $gast_tore = applyFactor($goalb[$st-1][$i], $goalfaktor);
       
      echo "</td><td>".$heim_tore.":".$gast_tore;
      echo "</td></tr>";
    }
  }
  echo "</table></p><p>";
  if ($st > 1) {
    echo "<a href=\"".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=day&amp;st=".$st_before."\">«</a>&#160;\n";
  }
  if ($st < $anzst) {
    echo "<a href=\"".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=day&amp;st=".$st_next."\">»</a>\n";
  }
  echo "<br/>";	?>
<br/><a href="<?=$_SERVER['PHP_SELF'].'?wap_file='.$file;?>&amp;op=table&amp;st=<?=$st?>"><?=$text[16];?></a> | <a href="<?=$_SERVER['PHP_SELF'].'?wap_file='.$file;?>&amp;op=help&amp;st=<?=$st?>"><?=$text[20];?></a><?
} 
echo("<br/><small><a href='".$_SERVER['PHP_SELF']."'>Home</a></small>");
// Anzeige Spieltag Ende

echo("</p>\n");
echo("</card>\n");
?>