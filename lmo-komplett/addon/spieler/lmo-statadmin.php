<?
//
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
//
// Spielerstatistik-Addon 1.1
// Copyright (C) 2002 by Rene Marth
// marth@tsvschlieben.de / http://www.tsvschlieben.de
// Formel-Addon 1.0&alpha;
// Copyright (C) 2002 by Thorsten Keller
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//

require_once(dirname(__FILE__).'/../../init.php');

if (isset($_REQUEST["ligalink"])) {	$spieler_ligalink=$_REQUEST["ligalink"];  } else $spieler_ligalink=$text['spieler'][11];
if (isset($_REQUEST["sort"]))     { $spieler_sort=$_REQUEST["sort"];          } else $spieler_sort="";
if (isset($_REQUEST["statstart"])){ $statstart=$_REQUEST["statstart"];} else $spieler_statstart=0;
if (isset($_REQUEST["option"]))   {	$spieler_option = $_REQUEST["option"];    } else $spieler_option="";
if (isset($_REQUEST["wert"]))     {	$wert = $_REQUEST["wert"];        } else $spieler_wert="";

//Datei auslesen
if (isset($file) && $file!="") {

	//Konfiguration auslesen

	require(PATH_TO_ADDONDIR."/spieler/lmo-statloadconfig.php");

	//Adminkontrolle
	if ($_SESSION['lmouserok']==2 || ($_SESSION['lmouserok']==1 && $spieler_adminbereich_hilfsadmin_zulassen==1)) {
		//zu speichernde Konfiguration
		if (isset($_REQUEST['standard_sortierung']))              { $spieler_standard_sortierung=$_REQUEST['standard_sortierung']; }
    if (isset($_REQUEST['standard_richtung']))                { $spieler_standard_richtung=$_REQUEST['standard_richtung']; }
		if (isset($_REQUEST['adminbereich_standard_sortierung'])) { $spieler_adminbereich_standard_sortierung=$_REQUEST['adminbereich_standard_sortierung']; }
		if (isset($_REQUEST['ligalink']))                         { $spieler_ligalink=$_REQUEST['ligalink']; }
		if (isset($_REQUEST['anzeige_pro_seite']))                { $spieler_anzeige_pro_seite=$_REQUEST['anzeige_pro_seite']; }
		if (isset($_REQUEST['adminbereich_anzeige_pro_seite']))   { $spieler_adminbereich_anzeige_pro_seite=$_REQUEST['adminbereich_anzeige_pro_seite']; }

		if (isset($_REQUEST['nullwerte_anzeigen']))                   $spieler_nullwerte_anzeigen=1;                   else {if ($spieler_option=="saveconfig") $spieler_nullwerte_anzeigen=0;}
    if (isset($_REQUEST['vereinsweise_anzeigen']))                $spieler_vereinsweise_anzeigen=1;                else {if ($spieler_option=="saveconfig") $spieler_vereinsweise_anzeigen=0;}
    if (isset($_REQUEST['pfeile_anzeigen']))                      $spieler_pfeile_anzeigen=1;                      else {if ($spieler_option=="saveconfig") $spieler_pfeile_anzeigen=0;}
		if (isset($_REQUEST['extra_sortierspalte']))                  $spieler_extra_sortierspalte=1;                  else {if ($spieler_option=="saveconfig") $spieler_extra_sortierspalte=0;}
		if (isset($_REQUEST['adminbereich_hilfsadmin_zulassen']))     $spieler_adminbereich_hilfsadmin_zulassen=1;     else {if ($spieler_option=="saveconfig") $spieler_adminbereich_hilfsadmin_zulassen=0;}
		if (isset($_REQUEST['adminbereich_hilfsadmin_fuer_spalten'])) $spieler_adminbereich_hilfsadmin_fuer_spalten=1; else {if ($spieler_option=="saveconfig") $spieler_adminbereich_hilfsadmin_fuer_spalten=0;}
		if ($spieler_sort=="") $spieler_sort=intval($spieler_adminbereich_standard_sortierung);

		if (file_exists($filename)) $filepointer = @fopen($filename,"r+b"); else $filepointer = @fopen($filename,"w+b");
		$spalten=array();
		$data=array();
		$spalten = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
		$typ=array(); //Spaltentyp (TRUE=String)
		$zeile=0;
		if (is_null($spalten[0])) {	//Datei war leer
			$spalten[0]=$text['spieler'][2];		//Name der ersten Spalte
	    set_file_buffer ($filepointer,0);
			fwrite($filepointer,$spalten[0]."\n");	//Erste Zeile/Spalte in Datei schreiben
		}
	
	// Wenn in einer Spalte ne Formel steht, wurde an den Namen *_*-* angehängt
    $formel_ges=0;
    $speicher_spalten=$spalten;
    $formel=array();
    for ($i=0;$i<count($spalten);$i++){
      $formel[$i]=FALSE;
      if (strstr($spalten[$i],"*_*-*")){
        $formel_ges++;
        $formel[$i]=TRUE;
        $spalten[$i]=substr($spalten[$i],0,strlen($spalten[$i])-5);
      }
    }
    if ($formel_ges>0){
      $formel_str = array();
      $formel_str = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
    }
		while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
			for($i=0;$i<count($data[$zeile]);$i++) {
				if (!is_numeric($data[$zeile][$i])) $typ[$i]=TRUE;
			}
			$zeile++;
		}
		array_pop($data);
    if ($spieler_option!="statupdate") {if (!isset($typ[intval($spieler_sort)])) usort($data, 'cmpInt'); else {usort($data, 'cmpStr');}}
		$spaltenzahl=count($spalten);
		fclose($filepointer);

			switch ($spieler_option) {
			case "addplayer": //Spieler hinzufügen
				if ($wert!="") {
					$filepointer = @fopen($filename,"w+b");
					set_file_buffer ($filepointer,0);
					fputs($filepointer,join("§",$speicher_spalten)."\n");
          if ($formel_ges>0){
            fputs($filepointer,join("§",$formel_str)."\n");
            formel_berechnen($formel,$formel_str,$spalten);
          }
          $data[$zeile][0]=$wert;
					for ($i1=0;$i1<$zeile;$i1++) {
						fputs($filepointer,join("§",$data[$i1])."\n");
					}
					$newplayer=$wert;
					$data[$zeile][0]=$wert;
					for($i=1;$i<$spaltenzahl;$i++) {
						if ($zeile==0) {
							if ($spalten[$i]==$text['spieler'][25] || $spalten[$i]==$text['spieler'][32]) {$data[0][$i]=$text['spieler'][43];$newplayer.="§".$text['spieler'][43];}else{$data[0][$i]="0";$newplayer.="§0";}
						}else{
							if (is_numeric($data[$zeile-1][$i])) {
								$data[$zeile][$i]="0";
								$newplayer.="§0";
							}else{
								$data[$zeile][$i]=$text['spieler'][43];
								$newplayer.="§".$text['spieler'][43];
							}
						}
					}
					fputs($filepointer,$newplayer."\n");
					$zeile++;
					fclose($filepointer);
					$statstart=$zeile-$spieler_adminbereich_anzeige_pro_seite;
					if ($statstart<0) $statstart=0;
          touch(PATH_TO_LMO."/".$file);
				}else{
					echo $text['spieler'][4];
				}
				break;
			case "delplayer":
				if ($wert!="") {
					$filepointer = @fopen($filename,"w+b");
					set_file_buffer ($filepointer,0);
          fputs($filepointer,join("§",$speicher_spalten)."\n");
					if ($formel_ges>0){
            fputs($filepointer,join("§",$formel_str)."\n");
          }
          for ($i1=0;$i1<$zeile;$i1++) {
						if ($i1!=$wert) {
							fputs($filepointer,join("§",$data[$i1])."\n");
						}
					}
					$zeile=0;
					fclose($filepointer);
					$filepointer = fopen($filename,"rb");
					$spalten = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
					if ($formel_ges>0){
             fgetcsv($filepointer, 1000, "§"); //Zeile mit Formeln übergehen
          }
          while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
						$zeile++;
					}
					$spaltenzahl=count($spalten);
					fclose($filepointer);
          touch(PATH_TO_LMO."/".$file);
				}
				break;
			case "addcolumn": //Spalte hinzufügen
				if ($wert!="") {
					if (isset($_REQUEST['type'])) $val=$_REQUEST['type'];
					else $val="0";
          if ($wert==$text['spieler'][25]) $val=$text['spieler'][43];
					if ($wert==$text['spieler'][32]) $val=$text['spieler'][43];
					$filepointer = @fopen($filename,"w+b");
					set_file_buffer ($filepointer,0);
					$spalten[$spaltenzahl]=$wert;
          $speicher_spalten[$spaltenzahl]=$wert;
          if ($val=="F"){
            if ($formel_ges==0){
              for ($i=0;$i<$spaltenzahl;$i++){
                $formel_str[$i]="0";
              }
            }
            
            $formel_ges++;
            $speicher_spalten[$spaltenzahl].="*_*-*";
            $val="0";
            $formel[$spaltenzahl]=TRUE;
          }else{
            $formel[$spaltenzahl]=FALSE;
          }
            $formel_str[$spaltenzahl]="0";
          
					fputs($filepointer,join("§",$speicher_spalten)."\n"); //Spaltenbezeichner schreiben
					for($i=0;$i<$zeile;$i++) {  //Spalte nullen
             $data[$i][$spaltenzahl]=$val;
          }
          if ($formel_ges>0){
            fputs($filepointer,join("§",$formel_str)."\n");
            formel_berechnen($formel,$formel_str,$spalten);
          }
          for($i=0;$i<$zeile;$i++) {
            fputs($filepointer,join("§",$data[$i])."\n");
          }
					$spaltenzahl++;
					fclose($filepointer);
          touch(PATH_TO_LMO."/".$file);
				}else{
					echo $text['spieler'][3];
				}
				break;
			case "delcolumn":
				if ($wert>0) {
					$filepointer = @fopen($filename,"w+b");
					set_file_buffer ($filepointer,0);
          if ($formel[$wert]) $formel_ges--;
          array_splice($spalten,$wert,1);
          array_splice($speicher_spalten,$wert,1);
          array_splice($formel,$wert,1);
          $spaltenzahl--;
          fputs($filepointer,join("§",$speicher_spalten)."\n"); //Spaltenbezeichner schreiben
          for($i=0;$i<$zeile;$i++) {
            array_splice($data[$i],$wert,1);
          }
          if ($formel_ges>0){
            array_splice($formel_str,$wert,1);
            fputs($filepointer,join("§",$formel_str)."\n");
            formel_berechnen($formel,$formel_str,$spalten);
          }
          for($i=0;$i<$zeile;$i++) {
						fputs($filepointer,join("§",$data[$i])."\n");
					}
				  fclose($filepointer);
          touch(PATH_TO_LMO."/".$file);
				}
				break;
			case "sortieren":
    		$filepointer = @fopen($filename,"w+b");
    		set_file_buffer ($filepointer,0);
    		 fputs($filepointer,join("§",$speicher_spalten)."\n");
         if ($formel_ges>0){
           fputs($filepointer,join("§",$formel_str)."\n");
         }
    		for ($i1=0;$i1<$zeile;$i1++) {
    			fputs($filepointer,join("§",$data[$i1])."\n");
    		}
    		fclose($filepointer);
    		break;
			case "statupdate": //Statistik updaten
      	$filepointer = @fopen($filename,"w+b");
      	set_file_buffer ($filepointer,0);
      	for ($i0=0;$i0<$spaltenzahl;$i0++) {
      		if (isset($_REQUEST["spalten".$i0])) {
      			$spalten[$i0]=$_REQUEST["spalten".$i0];
      		  if ($formel[$i0]){
             $speicher_spalten[$i0]=$_REQUEST["spalten".$i0]."*_*-*";
            }else{
              $speicher_spalten[$i0]=$_REQUEST["spalten".$i0];
            }
          }
          if (isset($_REQUEST["formel_str".$i0])) {
            $formel_str[$i0]=$_REQUEST["formel_str".$i0];
          }
        }
        fputs($filepointer,join("§",$speicher_spalten)."\n");
      	for ($i1=0;$i1<$zeile;$i1++) {
      		for ($i2=0;$i2<$spaltenzahl;$i2++) {
      			if (isset($_REQUEST["data".$i1."|".$i2])) {
      				$data[$i1][$i2]=$_REQUEST["data".$i1."|".$i2];
      			}
      		}
      	}
        if ($formel_ges>0){
          fputs($filepointer,join("§",$formel_str)."\n");
          formel_berechnen($formel,$formel_str,$spalten);
        }
        for ($i1=0;$i1<$zeile;$i1++) {
           fputs($filepointer,join("§",$data[$i1])."\n");
        }
      	fclose($filepointer);
        touch(PATH_TO_LMO."/".$file);
      	//if (!isset($typ[intval($spieler_sort)])) usort($data, 'cmpInt'); else {usort($data, 'cmpStr');}
      	break;
			case "saveconfig": //Konfiguration sichern
				$filepointer = @fopen($configfile,"w+b");
        flock($filepointer,LOCK_EX);
				set_file_buffer ($filepointer,0);
				fputs($filepointer,$text['spieler'][21]."=".$spieler_standard_sortierung."\n");
        fputs($filepointer,$text['spieler'][13]."=".$spieler_standard_richtung."\n");
				fputs($filepointer,$text['spieler'][40]."=".$spieler_adminbereich_standard_sortierung."\n");
				fputs($filepointer,$text['spieler'][22]."=".$spieler_anzeige_pro_seite."\n");
				fputs($filepointer,$text['spieler'][42]."=".$spieler_adminbereich_anzeige_pro_seite."\n");
				fputs($filepointer,$text['spieler'][23]."=".$spieler_nullwerte_anzeigen."\n");
				fputs($filepointer,$text['spieler'][24]."=".$spieler_extra_sortierspalte."\n");
        fputs($filepointer,$text['spieler'][49]."=".$spieler_pfeile_anzeigen."\n");
        fputs($filepointer,$text['spieler'][50]."=".$spieler_vereinsweise_anzeigen."\n");
				if ($_SESSION['lmouserok']==2) fputs($filepointer,$text['spieler'][31]."=".$spieler_adminbereich_hilfsadmin_zulassen."\n");
				if ($_SESSION['lmouserok']==2) fputs($filepointer,$text['spieler'][46]."=".$spieler_adminbereich_hilfsadmin_fuer_spalten."\n");
				fputs($filepointer,$text['spieler'][41]."=".$spieler_ligalink."\n");
				flock($filepointer,LOCK_UN);
        fclose($filepointer);
				break;
		}
	?>

<style type="text/css">
input {border:1px solid;font-family:"Courier New" monospace;}
acronym {cursor:help;}
</style>
<script type="text/javascript">
function change(op,x) {
	var a=document.getElementsByName(x)[0].value;
	if(!isNaN(a)){
		a=parseInt(a);
		document.getElementsByName(x)[0].value=eval(a+op+"1");
	}
  lmotest=false;
}
function sel(x) {
	document.getElementsByName(x)[0].select();
}
</script>
<table class="lmomosta">
	<tr>
		<td align="center" class="lmost1"><?=$text['spieler'][0]?></td>
	</tr>
	<tr>
		<td>
			<table class="lmostb">
				<tr>
					<td class="lmost4" colspan="2"><?=$text['spieler'][6]?></td>
				</tr>
				<tr>
					<td class="lmost5" width="50%" align="center"><nobr>
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text['spieler'][9]?>"><input type="text" name="wert">&nbsp;<input class="lmoadminbut" type="submit" value=" + "></acronym>
							<input type="hidden" name="option" value="addplayer">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form></nobr>
					</td>
					<td class="lmost5" width="50%" align="center"><nobr>
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text['spieler'][10]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$zeile;$x++) {?>
								<option value="<?=$x?>"><?=$data[$x][0]?></option><?
								}?>
							</select>&nbsp;<input class="lmoadminbut" type="submit" value=" - "></acronym>
							<input type="hidden" name="option" value="delplayer">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form></nobr>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr><?
				if ($_SESSION['lmouserok']==2 || ($_SESSION['lmouserok']==1 && $spieler_adminbereich_hilfsadmin_zulassen==1 && $spieler_adminbereich_hilfsadmin_fuer_spalten==1)) {?>
				<tr>
					<td class="lmost4" colspan="2"><?=$text['spieler'][5]?></td>
				</tr>
				<tr>
					<td class="lmost5" width="50%" align="center">
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text['spieler'][7]?>"><input type="text" name="wert">&nbsp;<input class="lmoadminbut"type="submit" value=" + "></acronym><br>
							<acronym title="<?=$text['spieler'][30]?>">Typ:&nbsp;<input type="radio" name="type" value="0" checked>&nbsp;Zahlen&nbsp;<input type="radio" name="type" value="<?=$text['spieler'][43]?>">&nbsp;Text<input type="radio" name="type" value="F">&nbsp;Formel
</acronym>
							<input type="hidden" name="option" value="addcolumn">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
					<td class="lmost5" width="50%" align="center">
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text['spieler'][8]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$spaltenzahl;$x++) {?>
								<option value="<?=$x?>"<?if ($x==0){?> disabled<?}if ($x==1){?> selected<?}?>><?=$spalten[$x]?></option><?
								}?>
							</select>&nbsp;<input class="lmoadminbut" type="submit" value=" - "></acronym>
							<input type="hidden" name="option" value="delcolumn">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
				</tr><?
				}?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" class="lmost1"><nobr><?=$text['spieler'][1]?></nobr></td>
	</tr>
	<tr>
	<tr>
		<td>
			<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
			<table class="lmostb">
				<tr>
					<th class="lmost4">
						<select size="1" name="sort"><?
	for ($i=0;$i<$spaltenzahl;$i++) {?>
							<option value="<?=$i?>"<?if ($i==$spieler_sort) echo " selected";?>><?=$spalten[$i]?><?
	}?>
						</select>
					</th>
					<th class="lmost4">
						<input type="hidden" name="todo" value="statistik">
						<input type="hidden" name="option" value="sortieren">
						<input type="hidden" name="file" value="<?=$file?>">
						<input class="lmoadminbut" type="submit" value="Sortieren">
					</th>
				</tr>
			</table>
			</form>
		</td>
	</tr>
		<td>
			<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
				<table class="lmostb">
					<thead>
						<tr><?
							for ($i=0;$i<$spaltenzahl;$i++) {?>
								<th class="lmost4">
									<input type="text" onClick="this.select()" name="spalten<?=$i?>" value="<?=$spalten[$i]?>" size="<?=strlen($spalten[$i]);?>">
								</th><?
							}?>
						</tr>
					</thead>
					<tfoot><?
							if ($spieler_adminbereich_anzeige_pro_seite>0) {?>
						<tr>
							<td align="center" colspan="<?=$spaltenzahl?>">
								<table width="100%">
									<tr>
										<td align="left"><?
								if ($statstart<=0) {?>&laquo;<?
								}else {?><a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=statistik&amp;sort=$spieler_sort&amp;file=$file&amp;statstart=".($statstart-$spieler_adminbereich_anzeige_pro_seite)."&amp;".SID?>">&laquo;</a><?}?>
										</td>
										<td align="right"><?
								if ($statstart+$spieler_adminbereich_anzeige_pro_seite>=$zeile) {?>&raquo;<?
								}else {?><a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=statistik&amp;sort=$spieler_sort&amp;file=$file&amp;statstart=".($statstart+$spieler_adminbereich_anzeige_pro_seite)."&amp;".SID?>">&raquo;</a><?}?>
										</td>
									</tr>
								</table
							</td>
						</tr><?
						}?>
						<tr>
							<td align="right" colspan="<?=$spaltenzahl?>">
								<input type="hidden" name="option" value="statupdate">
								<input type="hidden" name="todo" value="statistik">
								<input type="hidden" name="sort" value="<?=$spieler_sort?>">
								<input type="hidden" name="statstart" value="<?=$statstart?>">
								<input type="hidden" name="file" value="<?=$file?>">
								<input class="lmoadminbut" type="submit" value="Statistik updaten">
							</td>
						</tr>
					</tfoot>
					<tbody><?
        if ($formel_ges>0){?>
        <tr><?
          for ($i=0;$i<$spaltenzahl;$i++) {?>
            <td class="lmostb" align="center"><?
            if ($formel[$i]){?>
              <input type="text" onClick="sel('formel_str<?=$i?>')" name="formel_str<?=$i?>" value="<?=$formel_str[$i]?>" size="<?=strlen($formel_str[$i]);?>"><?
             }else echo "&nbsp;"?>
            </td><?
          }?>
        </tr>
      <?}
				if ($spieler_adminbereich_anzeige_pro_seite>0) $display=$spieler_adminbereich_anzeige_pro_seite+$statstart; else {$display=$zeile;$statstart=0;}
				if ($display>$zeile) $display=$zeile;
				for ($j1=$statstart;$j1<$display;$j1++) {?>
				<tr><?
					for ($j2=0;$j2<$spaltenzahl;$j2++) {
            if (isset($formel[$j2]) && $formel[$j2]==1){?>
			    <td class="lmostb" align="center">
            <nobr><input type="text" name="data<?=$j1."|".$j2?>" value="<?= $data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>" disabled></nobr>
          </td><?
            }elseif (is_numeric($data[$j1][$j2])){?>
							<td class="lmostb" align="center">
								<nobr>
									<input type="button" value="-" onClick="change('-','data<?=$j1."|".$j2?>')">
									<input type="text" onClick="this.select()" name="data<?=$j1."|".$j2?>"value="<?= $data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>">
									<input type="button" value="+" onClick="change('+','data<?=$j1."|".$j2?>')">
								</nobr>
							</td><?
						}else{
							if ($spalten[$j2]==$text['spieler'][25]) {?>
							<td class="lmostb">
								<nobr>
									<select name="data<?=$j1."|".$j2?>" size="1"><?
										for($j=0;$j<=$anzteams;$j++){?>
											<option <?if ($teams[$j]==$data[$j1][$j2]) echo "selected";?>><?=$teams[$j]?></option><?
										}?>
									</option>
								</nobr>
							</td><?
							}else{?>
							<td class="lmostb">
								<nobr>
									<input type="text" onClick="this.select()" name="data<?=$j1."|".$j2?>"value="<?= $data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>">
								</nobr>
							</td><?
							}
						}
					}?>
						</tr><?
				}?>
					</tbody>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align="center" class="lmost1"><nobr><?=$text['spieler'][39]?></nobr></td>
	</tr>
	<tr>
		<td>
			<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post" name="form1">
				<input type="hidden" name="option" value="saveconfig">
				<input type="hidden" name="todo" value="statistik">
				<input type="hidden" name="file" value="<?=$file?>">
				<table  class="lmostb">
					<tr>
						<th colspan="2"><?=$text['spieler'][44]?></th><th colspan="2" rowspan="2"><?=$text['spieler'][45]?></th>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text['spieler'][22]?>: </nobr></td>
						<td><nobr>
							<input type="button" value="-" onClick="change('-','anzeige_pro_seite')">
							<input type="text" name="anzeige_pro_seite"value="<?= $spieler_anzeige_pro_seite?>" size="<?=strlen($spieler_anzeige_pro_seite);?>">
							<input type="button" value="+" onClick="change('+','anzeige_pro_seite')"></nobr>
						</td>
						<td class="lmost4">
							<input type="hidden" name="adminbereich_anzeige_pro_seite" value="0">
						</td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text['spieler'][21]?>: </nobr></td>
						<td>
							<acronym title="<?=$text['spieler'][21]?>">
								<select name="standard_sortierung" size="1"><?

								for ($x=0;$x<$spaltenzahl;$x++) {?>
									<option value="<?=$x?>" <?if ($x==$spieler_standard_sortierung ) echo "selected";?>><?=$spalten[$x]?></option><?
								}?>
								</select>
							</acronym>
						</td>
						<td class="lmost4"><nobr><?=$text['spieler'][40]?>: </nobr></td>
						<td>
							<acronym title="<?=$text['spieler'][40]?>">
								<select name="adminbereich_standard_sortierung" size="1"><?

								for ($x=0;$x<$spaltenzahl;$x++) {?>
									<option value="<?=$x?>" <?if ($x==$spieler_adminbereich_standard_sortierung ) echo "selected";?>><?=$spalten[$x]?></option><?
								}?>
								</select>
							</acronym>
						</td>
					</tr>
          <tr>
            <td class="lmost4" rowspan="2"><nobr><?=$text['spieler'][13]?>: </nobr></td>
            <td><input type="radio" name="standard_richtung" value="1"<?if ($spieler_standard_richtung==1) echo " checked";?>> <?=$text['spieler'][48]?></td>
            <td class="lmost4"><nobr><?=$text['spieler'][31]?>: </nobr></td>
						<td><?if($_SESSION['lmouserok']==2){?><input type="checkbox" name="adminbereich_hilfsadmin_zulassen" value="<?=$spieler_adminbereich_hilfsadmin_zulassen?>" <?if ($spieler_adminbereich_hilfsadmin_zulassen==1) echo "checked";?> onClick="if (this.checked==true) document.form1.adminbereich_hilfsadmin_fuer_spalten.disabled=false; else {document.form1.adminbereich_hilfsadmin_fuer_spalten.disabled=true;document.form1.adminbereich_hilfsadmin_fuer_spalten.checked=false;}"><?}?></td>
					</tr>
          <tr>
            <td><input type="radio" name="standard_richtung" value="0"<?if ($spieler_standard_richtung==0) echo " checked";?>> <?=$text['spieler'][47]?></td>
            <td class="lmost4"><nobr><?=$text['spieler'][46]?>: </nobr></td>
						<td><?if($_SESSION['lmouserok']==2){?><input <?if ($spieler_adminbereich_hilfsadmin_fuer_spalten!=1) echo "disabled"?> type="checkbox" name="adminbereich_hilfsadmin_fuer_spalten" value="<?=$spieler_adminbereich_hilfsadmin_fuer_spalten?>" <?if ($spieler_adminbereich_hilfsadmin_fuer_spalten==1) echo "checked";?>><?}?></td>
          </tr>
          <tr>
						<td class="lmost4"><nobr><?=$text['spieler'][41]?>: </nobr></td>
						<td><input type="text" name="ligalink" value="<?= $spieler_ligalink?>" size="<?=strlen($spieler_ligalink);?>"></td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text['spieler'][24]?>: </nobr></td>
						<td><input type="checkbox" name="extra_sortierspalte" value="<?=$spieler_extra_sortierspalte?>" <?if ($spieler_extra_sortierspalte==1) echo "checked";?>></td>
					</tr><?
   if (array_search($text['spieler'][25],$spalten)>0) {?>
          <tr>
						<td class="lmost4"><nobr><?=$text['spieler'][50]?>: </nobr></td>
						<td><input type="checkbox" name="vereinsweise_anzeigen" value="<?=$spieler_vereinsweise_anzeigen?>" <?if ($spieler_vereinsweise_anzeigen==1) echo "checked";?>></td>
					</tr><?
   }?>
          <tr>
						<td class="lmost4"><nobr><?=$text['spieler'][49]?>: </nobr></td>
						<td><input type="checkbox" name="pfeile_anzeigen" value="<?=$spieler_pfeile_anzeigen?>" <?if ($spieler_pfeile_anzeigen==1) echo "checked";?>></td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text['spieler'][23]?>: </nobr></td>
						<td><input type="checkbox" name="nullwerte_anzeigen" value="<?=$spieler_nullwerte_anzeigen?>" <?if ($spieler_nullwerte_anzeigen==1) echo "checked";?>></td>
					</tr>
					<tr>
						<td colspan="4" align="right"><input class="lmoadminbut" type="submit" value="Konfiguration speichern"></td>
					</tr>
				</table>
			</form>
		</td>
		</tr>
		<tr>
		<td class="lmost2" align="center">
			<a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=$file&amp;st=-1"?>' onclick='return chklmolink(this.href);' title="<?=$text[100]?>"><?=$text[99]?></a>&nbsp; &nbsp;
			<a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=$file&amp;st=-2"?>' onclick='return chklmolink(this.href);' title="<?=$text[102]?>"><?=$text[101]?></a>
		</td>
	</tr>
</table>
<?
	}else{
		echo $text['spieler'][33];
	}//Hilfsadmin
}//Datei existiert

function cmpInt ($a1, $a2) {
	global $spieler_sort;
	if ($a2[$spieler_sort]==$a1[$spieler_sort]) return 0;
  return ($a1[$spieler_sort]>$a2[$spieler_sort]) ? -1 : 1;
}
function cmpStr ($a2, $a1) {
	global $spieler_sort;
	$a1[$spieler_sort]=strtr($a1[$spieler_sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$a2[$spieler_sort]=strtr($a2[$spieler_sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$c = strnatcasecmp($a2[$spieler_sort],$a1[$spieler_sort]);
  if (!$c)
    $c = strnatcasecmp($a1[$spieler_sort],$a2[$spieler_sort]);
  return $c;
}

function cmpstrlength ($a, $b) {
    if (strlen($a) == strlen($b)) return 0;
    return (strlen($a) > strlen($b)) ? -1 : 1;
}

function formel_berechnen ($formel,$formel_str,$spalten){
  global $data;
  uasort($spalten, 'cmpstrlength');
  for ($i=0;$i<count($spalten);$i++){
    if ($formel[$i]){
      $formel_str[$i]=strtoupper($formel_str[$i]);
      $help_str=$formel_str[$i];
      foreach ($spalten as $key => $value ){
        if ($i!=$key){
          $help_str=str_replace(strtoupper($value),"",$help_str);
          $formel_str[$i]=str_replace(strtoupper($value),"\$data[\$j][$key]",$formel_str[$i]);
        }
      }
      $help_str=strtr($help_str,"+-*/0123456789.","               ");
      if (strlen(chop($help_str))==0){
        $formel_str[$i] = "\$help2=round(".$formel_str[$i].",2);";
      }else{
        $formel_str[$i] = "\$help2=\"Formel so nicht erlaubt\";";
      }
    }
  }
  for ($i=0;$i<count($spalten);$i++){
    if ($formel[$i]){
      for ($j=0;$j<count($data);$j++){
        $help2=0.00;
        @eval($formel_str[$i]);
        $data[$j][$i]=$help2;
      }
    }
  }
}
?>