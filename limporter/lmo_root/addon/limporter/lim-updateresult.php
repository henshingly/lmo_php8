  <tr>
    <td class="lmost5" colspan=3>
    
<?php
	$notFound1 = false;
	$notFound2 = false;
  $teamNames = $liga->teamNames();
  $updateTeamNames = $upDateLiga->teamNames();
  foreach ($teamNames as $teamName) {
  	if (in_array($teamName,$updateTeamNames)==false) {
  		$notFound1 = true;
  		echo '<BR><b>Warnung:</b> Die Mannschaft "'.$teamName.'" wurde nicht im Ligafile gefunden.';
		}
  }
  foreach ($updateTeamNames as $teamName) {
  	if (in_array($teamName,$teamNames)==false) {
  		$notFound2 = true;
  		echo '<BR><b>Warnung:</b> Die Mannschaft "'.$teamName.'" wurde nicht in der Quelle gefunden.';
		}
  }

	if ($notFound1 and $notFound2) {
	 echo '<br><br>Es konnten Mannschaften aufgrund von unterschiedlichen Schreibweisen im Ligafile und der angegebenen Quelle nicht erkannt werden.<br>Eine Aktualisierung der Partienen für diese Mannschaften ist daher nicht möglich.<br><br>';
	}
?>
        <table border= '0' cellspacing='0' align='center' class="lmoInner">
		<tr>
			<th>&nbsp;Spieltag&nbsp;</th>
			<th>&nbsp;Heimmannschaft&nbsp;</th>
			<th>&nbsp;Gastmannschaft&nbsp;</th>
			<th>&nbsp;Aktualisierung&nbsp;</th>
		</tr>
	    <tr><td colspan=4>&nbsp;</td>

<?php
if (count($partieArray) > 0) {
    foreach ($partieArray as $upDateTxt) {
        echo $upDateTxt;
    }
}
else {
	echo "<tr><td colspan=4>&nbsp;</td>";
	echo "<tr><td colspan=4>&nbsp;keine neuen Updates gefunden !&nbsp;</td>";
	echo "<tr><td colspan=4>&nbsp;</td>";
}
?>
	    <tr><td colspan=4>&nbsp;</td>
		<tr>
			<th colspan=4>&nbsp;
				<?php echo "&nbsp;".count($partieArray)." Partien aktualisiert";?>
				&nbsp;</th>
		</tr>
		</table>
	</td>