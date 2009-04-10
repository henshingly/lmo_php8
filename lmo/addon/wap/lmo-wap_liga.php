<card id="index" title="Ergebnisdienst">
    <p><?
$array = array("");
$verz = opendir(substr(PATH_TO_LMO."/".$dirliga, 0, -1));
$dummy = array();
$dummy2 = array();
$r = 0;
while ($verz && $files = readdir($verz)) {
  if (strtolower(substr($files, -4)) == ".l98") {
    $dummy2['"'.(filemtime(PATH_TO_LMO."/".$dirliga.$files)+$r).'"'] = $files;
    $r++;
  }
}
closedir($verz);
krsort($dummy2);
foreach ($dummy2 as $d) $dummy[] = $d;
$i = 0;
$j = 0;
if ($begin < 0) $begin = 0;
if ($begin > count($dummy)) $begin = count($dummy)-($begin-count($dummy)+1);
if ($wap_anzahl_ligen_pro_seite+$begin > count($dummy)) $ende = count($dummy);
else $ende = $wap_anzahl_ligen_pro_seite+$begin;
for($k = $begin; $k < $ende; $k++) {
  $files = $dummy[$k];
  $sekt = "";
  $t0 = "";
  $t1 = "";
  $t4 = "";
  $t2 = $text[2];
  $datei = fopen(PATH_TO_LMO."/".$dirliga.$files, "r");
  if ($datei) {
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = substr($zeile, 1, -1);
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";") && ($sekt == "Options")) {
        $schl = substr($zeile, 0, strpos($zeile, "="));
        $wert = substr($zeile, strpos($zeile, "=")+1);
        if ($schl == "Name") {
          $t0 = $wert;
        }
        if ($schl == "Actual") {
          $t1 = $wert;
        }
        if ($schl == "Teams") {
          $t4 = $wert;
        }
        if ($schl == "Type") {
          if ($wert == "1") {
            $t2 = $text[370];
          }
        }
        if (($t0 != "") && ($t1 != "") && ($t4 != ""))break;
      }
    }
    fclose($datei);
  }
  $i++;
  if ($t0 == "") {
    $j++;
    $t0 = $text[507].$j;
  }
  if ($t1 != "") {
    if ($t2 == $text[2]) {
      $t3 = " / ".$t1.".".$text[145];
    } else {
      $t5 = strlen(decbin($t4-1));
      if ($t1 == $t5-1) {
        $t3 = " / ".$text[362];
      } elseif($t1 == $t5) {
        $t3 = " / ".$text[364];
      } elseif($t1 == $t5-2) {
        $t3 = " / ".$text[360];
      } elseif($t1 == $t5-3) {
        $t3 = " / ".$text[358];
      } elseif($t1 == $t5-4) {
        $t3 = " / ".$text[376].$t1;
      } else {
        $t3 = " / ".$text[376].$t1;
      }
    }
  } else {
    $t3 = "";
  }
  //Ligenliste laden Ende
   
  $t0 = ($t0);?>
      <small>
        <a href='<?=$_SERVER['PHP_SELF']?>?file=<?=$files?>&amp;op=nav&amp;st=<?=$t1?>'><?=$t0?></a>
        <br/><?=strftime($defdateformat,filemtime(PATH_TO_LMO."/".$dirliga.$files)).$t3?>
      </small>
      <br/><?  
}
if ($begin-1>0) {?>
    <a href='<?=$_SERVER['PHP_SELF']?>?begin=<?=$begin-$wap_anzahl_ligen_pro_seite?>'>zurück</a><?
}
if ($begin-1>0 && $ende+1<count($dummy)) echo "&#160;|&#160; ";
if ($ende<count($dummy)) {?>
    <a href='<?=$_SERVER['PHP_SELF']?>?begin=<?=$begin+$wap_anzahl_ligen_pro_seite?>'>weiter</a><?
}
if($i==0){ 
  echo $text[223];
}?>
    </p>
  </card>