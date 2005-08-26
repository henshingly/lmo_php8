<?PHP
$folder=dir(PATH_TO_LMO."/".$dirliga);
$files = array();
if ($ximporttype==1) $extensions =explode(",",$limporter_csvExtension);
else if (($ximporttype==0) || ($ximporttype==2)) $extensions = array("htm","html");
while($data=$folder->read()){
  if( in_array(strtolower(substr($data,-3)),$extensions) or in_array(strtolower(substr($data,-4)),$extensions) ){
    $files[] = $data;
    sort($files);
  }
}
$folder->close();
// Jetzt noch gespeicherte URL lesen waere schon gut

?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2>&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2><?php echo $text['limporter'][36]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2><?php echo $text['limporter'][37]; ?>
    <?PHP if ($ximporttype==2) echo "<BR>".$text['limporter'][38]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right">
    <acronym title="<?php echo $text['limporter'][39]; ?>"><?PHP echo $text['limporter'][40]; ?></acronym></td>
    <td class="lmost5" align="left">

        <select name="fname" class="lmo-formular-input" onChange="if(this.form.fname.value!='')this.form.ximporturl.value=this.form.fname.value;">
<?PHP
echo "<option value=''>".$text['limporter'][41]."</option>\n";
foreach ($files as $aFile) {
  echo "<option value='".$folder->path.$aFile."'";
  if($ximporturl==$aFile){echo " selected";}echo ">".$aFile."</option>\n";
}
?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text['limporter'][42]; ?>">
    <?PHP echo $text['limporter'][43]; ?></acronym></nobr></td>
    <td class="lmost5" align="left">
      <acronym title="<?PHP echo $text['limporter'][44]; ?>">
      <input class="lmo-formular-input" type="text" name="ximporturl" size="40" maxlength="160" value="<?PHP echo $ximporturl; ?>"></acronym>
      &nbsp;
      <?php
      if ($ximporttype=="0" || $ximporttype=="2") {?>
      <input class="lmo-formular-input" type="checkbox" name="xcheckurl"
      <?PHP if($xcheckurl==1) {echo " checked";}?>>
      <acronym title="<?PHP echo $text['limporter'][45]; ?>"><?PHP echo $text['limporter'][46]; ?></acronym>
      <?php } else $xcheckurl=0; ?>
      </td>
  </tr>
  <tr>
    <td class="lmost5" align="left" colspan=3>&nbsp;</td>
  </tr>
<?PHP
  $dirPath = PATH_TO_ADDONDIR."/limporter/".$limporter_importDir;
  //echo $ximporttype;
  $parserFiles = getParserFiles($dirPath,$ximporttype,$text['limporter'][47]);
  if (count($parserFiles)>1) {
  ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2><?PHP echo $text['limporter'][48]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr>
    <acronym title="<?PHP echo $text['limporter'][49]; ?>">
      <?PHP echo $text['limporter'][50]; ?>
    </acronym></nobr>
    </td>

    <td class="lmost5" align="left">
        <select name="xparserFile" class="lmo-formular-input">
    <?PHP
    foreach ($parserFiles as $names) {
      echo "<option value='".$names[1]."'";
        if($xparserFile==$names[1]){echo " selected";}
      echo ">".$names[0]."</option>\n";
    }
    ?>
    </select>
    </td>
  </tr>
<?PHP } // if count($parserFiles)>1 ?>
