<?PHP

//if ($ximporttype==1) {
    $folder=dir(PATH_TO_LMO."/".$dirliga);
if ($ximporttype==1) $extensions =split(",",$limporter_csvExtension);
else if ($ximporttype==0) $extensions = array("htm","html");
    while($data=$folder->read()){
      if( in_array(strtolower(substr($data,-3)),$extensions) or in_array(strtolower(substr($data,-4)),$extensions) ){
	  	$files[] = $data;
	  }
    }
   $folder->close();
?>
  <tr>
    <td class="lmost5" align="left" colspan=3>Spielplan Datenquelle wählen:</td>
  </tr>
  <tr>
    <td class="lmost5" align="left" colspan=3>Wählen Sie eine lokale Datei aus, oder geben Sie die vollständige URL des Spielplans an.</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="Wählen hier die Datei aus, von der Sie den Spielplan importieren wollen."><?PHP echo "lokale Datei auswählen";/*$text[113];*/ ?></acronym></nobr></td>
    <td class="lmost5" align="left">

        <select name="fname" onChange="if(this.form.fname.value!='')this.form.ximporturl.value=this.form.fname.value;">
<?PHP
	echo "<option value=''>Bitte Datei w&auml;hlen</option>\n";

foreach ($files as $aFile) {
	echo "<option value='".$folder->path.$aFile."'";
	if($ximporturl==$aFile){echo " selected";}echo ">".$aFile."</option>\n";
}
?>
		</select>
    </td>
  </tr>
<?PHP 
//}


?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="oder hier die URL angeben, von der Sie den Spielplan importieren wollen.">
    <?PHP echo "Pfad zum Spielplan";/*$text[113];*/ ?></acronym></nobr></td>
    <td class="lmost5" align="left"><acronym title="Geben Sie hier die URL an, von der Sie den Spielplan importieren wollen. z.B. http://www.url.de/spielplaene/03/kkl/plan.htm"><input class="lmoadminein" type="text" name="ximporturl" size="40" maxlength="160" value="<?PHP echo $ximporturl; ?>"></acronym></td>
  </tr>
