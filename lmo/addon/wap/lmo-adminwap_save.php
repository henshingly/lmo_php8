<card id="save" title="Speicherung">
  <p><?
require_once(PATH_TO_LMO."/ini.fct");
$result = FALSE;
for ($i=0; $i<$anzsp; $i++) {
  $spielid=$i+1;
  
  if (($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)) {
    // Einlesen der Tore der Heimmannschaften
    $Tmp = ReadIniValue(PATH_TO_LMO.'/'.$dirliga.$file, "Round".$st, "GA".$spielid);
    
    $heimtore = "heim".$i;
    $gasttore = "gast".$i;
    
    $heim_goal=!is_numeric(${$heimtore})?${$heimtore}:-1;
    $gast_goal=!is_numeric(${$gasttore})?${$gasttore}:-1;

    // darf eingetragen werden
    $result1 = WriteIniValue(PATH_TO_LMO.'/'.$dirliga.$file, "Round".$st, "GA".$spielid, $heim_goal);
    $result2 = WriteIniValue(PATH_TO_LMO.'/'.$dirliga.$file, "Round".$st, "GB".$spielid, $gast_goal);
    $result3 = WriteIniValue(PATH_TO_LMO.'/'.$dirliga.$file, "Options", "Actual", $st);
    $result = $result1 && $result2 && $result3;

  }   
}

if($result) {
  $file2=$file;

  //ob_start();
  /*Zusätzliche Auswertungen*/
  if ($einsavehtml==1) {
    if (file_exists("lmo-savehtml.php")) {
      include(PATH_TO_LMO."/lmo-savehtml.php");
    }
    if (file_exists("lmo-savehtml1.php")) {
      include(PATH_TO_LMO."/lmo-savehtml1.php");
    }
  }
  if ($einzutore==1 || $einzutoretab==1 || $einzustats==1) {
    if (file_exists("lmo-zustat.php")) {
      include(PATH_TO_LMO."/lmo-zustat.php");
    }
  }
  $ftest0 = 1;
  $todo="edit";
  $liga = substr($file, 0, -4);
   
  if ($tipp_immeralle == 0) {
    $ftest0 = 0;
    $ftest1 = "";
    $ftest1 = explode(',', $tipp_ligenzutippen);
    if (isset($ftest1)) {
      for($u = 0; $u < count($ftest1); $u++) {
        if ($ftest1[$u] == $liga) {
          $ftest0 = 1;
        }
      }
    }
  }
  // Tippspiel-Addon
  if ($ftest0 == 1) {
    // Liga darf getippt werden
    if ($tipp_aktauswert == 1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewert.php");
    }
    if ($tipp_aktauswertges == 1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewertgesamt.php");
    }
  }
  // Tippspiel-Addon
  //ob_end_clean();
  echo "Speicherung erfolgreich";
} else {
  echo "Speicherung fehlgeschlagen";
}?>
	</p>
	<p><a href="<? echo $_SERVER['PHP_SELF']."?wap_file=$file2"; ?>&amp;st=<?=$st?>&amp;op=day">zurück</a></p>
</card>