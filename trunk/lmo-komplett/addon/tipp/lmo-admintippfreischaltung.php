<?
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
$tipp_mailtext = str_replace(array('\n','[nick]','[pass]','[url]'),array("\n",$xtippernick,$xtipperpass,URL_TO_LMO."/lmo.php?action=tipp&xtippername=".$xtippernick."&xtipperpass=".$xtipperpass),$text['tipp'][298]);
if (@ini_get('safe_mode')=="0") {
  $sent=mail($xtipperemail,$text['tipp'][77],$tipp_mailtext,"From:".$text['tipp'][0]." <".$aadr.">","-f ".$lmo_aadr."\r\n");
} else {
  $sent=mail($xtipperemail,$text['tipp'][77],$tipp_mailtext,"From:".$text['tipp'][0]." <".$aadr.">");
}
if ($sent) {
  echo '<p class="message"><img src="'.URL_TO_IMGDIR.'/right.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][78]."</p>";
} else {
  echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][80]."</p>";
}
?>