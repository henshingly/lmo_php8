<card id="save" title="Speicherung">
  <p><?
require_once(PATH_TO_LMO."/ini.fct");
$result = FALSE;
for ($i=0; $i<$anzsp; $i++) {
  $spielid=$i+1;
  
  if (($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)) {
    // Einlesen der Tore der Heimmannschaften
    $Tmp = ReadIniValue(PATH_TO_LMO.'/'.$file, "Round".$st, "GA".$spielid);
    
    $heimtore = "heim".$i;
    $gasttore = "gast".$i;
    
    $heim_goal=${$heimtore};
    $gast_goal=${$gasttore};
    
    if (is_numeric($heim_goal) && is_numeric($gast_goal)) {
      // darf eingetragen werden
      $result1 = WriteIniValue(PATH_TO_LMO.'/'.$file, "Round".$st, "GA".$spielid, $heim_goal);
      $result2 = WriteIniValue(PATH_TO_LMO.'/'.$file, "Round".$st, "GB".$spielid, $gast_goal);
      $result3 = WriteIniValue(PATH_TO_LMO.'/'.$file, "Options", "Actual", $st);
      $result = $result1 && $result2 && $result3;
    }
  }   
}

if($result) {
  echo "Speicherung erfolgreich";
} else {
  echo "Speicherung fehlgeschlagen";
}?>
	</p>
	<p><a href="<?php echo $_SERVER['PHP_SELF']."?wap_file=$file"; ?>&amp;op=day">zurück</a></p>
</card>
