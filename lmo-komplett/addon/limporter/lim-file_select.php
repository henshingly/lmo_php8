<?

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
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2>&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2>Spielplan Datenquelle wählen</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2>Wählen Sie eine lokale Datei aus dem LMO Ligen Verzeichnis aus,<BR>oder geben Sie den vollständige URL-Pfad des Spielplans an.</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td align="right">

    <acronym title="Wählen hier die Datei aus, von der Sie den Spielplan importieren wollen."><? echo "lokale Datei auswählen";/*$text[113];*/ ?></acronym></td>
    <td class="lmost5" align="left">

        <select name="fname" class="lmo-formular-input" onChange="if(this.form.fname.value!='')this.form.ximporturl.value=this.form.fname.value;">
<?
echo "<option value=''>Bitte Datei w&auml;hlen</option>\n";
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
    <td align="right">
<nobr><acronym title="oder hier die URL angeben, von der Sie den Spielplan importieren wollen.">
    <? echo "Pfad zum Spielplan";/*$text[113];*/ ?></acronym></nobr></td>
    <td class="lmost5" align="left">
    	<acronym title="Geben Sie hier die URL an, von der Sie den Spielplan importieren wollen. z.B. http://www.url.de/spielplaene/03/kkl/plan.htm">
    	<input class="lmo-formular-input" type="text" name="ximporturl" size="40" maxlength="160" value="<? echo $ximporturl; ?>">
    	</acronym></td>
  </tr>
  <tr>
    <td class="lmost5" align="left" colspan=3>&nbsp;</td>
  </tr>
<?
	$dirPath = PATH_TO_ADDONDIR."/limporter/".$limporter_importDir;
	$parserFiles = getParserFiles($dirPath,$ximporttype,'-- keine verwenden --');
	if (count($parserFiles)>1) {
	?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="left" colspan=2>Geben Sie hier an, ob Sie Importeinstellungen einer gespeicherten Parameterdatei verwenden möchten.</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td align="right">
<nobr>
    <acronym title="Sie können hier gespeicherte Importeinstellungen wählen.">
    	<? echo "folgende Parameterdatei (*.lim) verwenden";/*$text[113];*/ ?>
    </acronym></nobr>
    </td>

    <td class="lmost5" align="left">
        <select name="xparserFile" class="lmo-formular-input">
    <?
    foreach ($parserFiles as $names) {
    	echo "<option value='".$names[1]."'";
    		if($xparserFile==$names[1]){echo " selected";}
    	echo ">".$names[0]."</option>\n";
    }
    ?>
		</select>
    </td>
  </tr>
<? } // if count($parserFiles)>1 ?>