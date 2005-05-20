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
  		echo '<BR>'.$text['limporter'][92].' "'.$teamName.'" '.$text['limporter'][93];
		}
  }
  foreach ($updateTeamNames as $teamName) {
  	if (in_array($teamName,$teamNames)==false) {
  		$notFound2 = true;
  		echo '<BR>'.$text['limporter'][92].' "'.$teamName.'" '.$text['limporter'][94];
		}
  }

	if ($notFound1 and $notFound2) {
	 echo '<br><br>'.$text['limporter'][95].'<br><br>';
	}
?>
        <table border= '0' cellspacing='0' align='center' class="lmoInner">
		<tr>
			<th>&nbsp;<?PHP echo $text['limporter'][65]; ?>&nbsp;</th>
			<th>&nbsp;<?PHP echo $text['limporter'][69]; ?>&nbsp;</th>
			<th>&nbsp;<?PHP echo $text['limporter'][70]; ?>&nbsp;</th>
			<th>&nbsp;<?PHP echo $text['limporter'][96]; ?>&nbsp;</th>
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
	echo "<tr><td colspan=4>&nbsp;".$text['limporter'][97]."&nbsp;</td>";
	echo "<tr><td colspan=4>&nbsp;</td>";
}
?>
	    <tr><td colspan=4>&nbsp;</td>
		<tr>
			<th colspan=4>&nbsp;
				<?php echo "&nbsp;".count($partieArray)." ".$text['limporter'][98]; ?>
				&nbsp;</th>
		</tr>
		</table>
	</td>