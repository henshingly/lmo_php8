<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  * $Id$
  */
  

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
		

		if (isset($_REQUEST['nullwerte_anzeigen']))                   $spieler_nullwerte_anzeigen=1;                   else {if ($spieler_option=="saveconfig") $spieler_nullwerte_anzeigen=0;}
    if (isset($_REQUEST['vereinsweise_anzeigen']))                $spieler_vereinsweise_anzeigen=1;                else {if ($spieler_option=="saveconfig") $spieler_vereinsweise_anzeigen=0;}
    
		if (isset($_REQUEST['extra_sortierspalte']))                  $spieler_extra_sortierspalte=1;                  else {if ($spieler_option=="saveconfig") $spieler_extra_sortierspalte=0;}
		if ($_SESSION['lmouserok']==2) {
      if (isset($_REQUEST['adminbereich_hilfsadmin_zulassen']))     $spieler_adminbereich_hilfsadmin_zulassen=1;     else {if ($spieler_option=="saveconfig") $spieler_adminbereich_hilfsadmin_zulassen=0;}
  		if (isset($_REQUEST['adminbereich_hilfsadmin_fuer_spalten'])) $spieler_adminbereich_hilfsadmin_fuer_spalten=1; else {if ($spieler_option=="saveconfig") $spieler_adminbereich_hilfsadmin_fuer_spalten=0;}
    }
		if ($spieler_sort=="") $spieler_sort=intval($spieler_adminbereich_standard_sortierung);

		if (file_exists($filename)) $filepointer = fopen($filename,"r+b"); else $filepointer = fopen($filename,"w+b");
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
					$statstart=$zeile;
					if ($statstart<0) $statstart=0;
          @touch(PATH_TO_LMO."/".$dirliga.$file);
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
          @touch(PATH_TO_LMO."/".$dirliga.$file);
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
          @touch(PATH_TO_LMO."/".$dirliga.$file);
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
          @touch(PATH_TO_LMO."/".$dirliga.$file);
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
        @touch(PATH_TO_LMO."/".$dirliga.$file);
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
				
				fputs($filepointer,$text['spieler'][23]."=".$spieler_nullwerte_anzeigen."\n");
				fputs($filepointer,$text['spieler'][24]."=".$spieler_extra_sortierspalte."\n");
        
        fputs($filepointer,$text['spieler'][50]."=".$spieler_vereinsweise_anzeigen."\n");
				if ($_SESSION['lmouserok']==2) fputs($filepointer,$text['spieler'][31]."=".$spieler_adminbereich_hilfsadmin_zulassen."\n");
				if ($_SESSION['lmouserok']==2) fputs($filepointer,$text['spieler'][46]."=".$spieler_adminbereich_hilfsadmin_fuer_spalten."\n");
				fputs($filepointer,$text['spieler'][41]."=".$spieler_ligalink."\n");
				flock($filepointer,LOCK_UN);
        fclose($filepointer);
				break;
		}
    $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
    $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
    include(PATH_TO_LMO."/lmo-adminsubnavi.php");
	?>

<script type="text/javascript">
function change(op,x) {
	var el=document.getElementsByName(x)[0];
  var a=el.value;
	if(!isNaN(a)){
		a=parseInt(a);
		document.getElementsByName(x)[0].value=eval(a+op+"1");
	}
  lmotest=false;
  mark(el);
  return false;
}
function sel(x) {
	document.getElementsByName(x)[0].select();
}
function mark(el){
  el.className="lmoTabelleMeister";
}

</script>
<table class="lmoMiddle">
  <tr>
		<th align="center"><h1><?=$text['spieler'][18]?></h1></th>
	</tr>
	<tr>
		<td>
			<table class="lmoInner">
				<tr>
					<th align="left" colspan="2"><?=$text['spieler'][6]?></th>
				</tr>
				<tr>
					<td class="nobr" align="right">
						<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
							<acronym title="<?=$text['spieler'][9]?>"><input type="text" name="wert"></acronym>&nbsp;<input class="lmo-formular-button" type="submit" value=" + ">
							<input type="hidden" name="option" value="addplayer">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="edit">
              <input type="hidden" name="st" value="<?=$st; ?>">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
					<td class="nobr" align="left">
						<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
							<acronym title="<?=$text['spieler'][10]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$zeile;$x++) {?>
								<option value="<?=$x?>"><?=htmlentities(stripslashes($data[$x][0]),ENT_COMPAT);?></option><?
								}?>
							</select></acronym>&nbsp;<input class="lmo-formular-button" type="submit" value=" &minus; ">
							<input type="hidden" name="option" value="delplayer">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="edit">
              <input type="hidden" name="st" value="<?=$st; ?>">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
				</tr><?
				if ($_SESSION['lmouserok']==2 || ($_SESSION['lmouserok']==1 && $spieler_adminbereich_hilfsadmin_zulassen==1 && $spieler_adminbereich_hilfsadmin_fuer_spalten==1)) {?>
				<tr>
					<th align="left" colspan="2"><?=$text['spieler'][5]?></th>
				</tr>
				<tr>
					<td class="nobr" align="right">
						<form action="<?= $_SERVER['PHP_SELF']?>" method="post" name="spalten">
							<acronym title="<?=$text['spieler'][7]?>"><input type="text" name="wert"></acronym> 
              <input class="lmo-formular-button" type="submit" value=" + "><br>
							<acronym title="<?=$text['spieler'][30]?>"><?=$text['spieler'][38]?>:</acronym>
              <input type="radio" name="type" value="0" checked>&nbsp;<?=$text['spieler'][52]?>
              <input type="radio" name="type" value="<?=$text['spieler'][43]?>">&nbsp;<?=$text['spieler'][53]?>
              <input type="radio" name="type" value="F">&nbsp;<?=$text['spieler'][54]?>
              <input type="hidden" name="option" value="addcolumn">
							<input type="hidden" name="sort" value="<?=$spieler_sort?>">
							<input type="hidden" name="todo" value="edit">
              <input type="hidden" name="st" value="<?=$st; ?>">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
					<td class="nobr" align="left" valign="top">
						<form action="<?= $_SERVER['PHP_SELF']?>" method="post" name="spieler">
							<acronym title="<?=$text['spieler'][8]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$spaltenzahl;$x++) {?>
								<option value="<?=$x?>"<?if ($x==0){?> disabled<?}if ($x==1){?> selected<?}?>><?=htmlentities(stripslashes($spalten[$x]),ENT_COMPAT);?></option><?
								}?>
							</select></acronym>&nbsp;<input class="lmo-formular-button" type="submit" value=" &minus; ">
							<input type="hidden" name="option" value="delcolumn">
							<input type="hidden" name="todo" value="edit">
              <input type="hidden" name="st" value="<?=$st; ?>">
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
		<th align="center"><h1><?=$text['spieler'][1]?></h1></th>
	</tr>
	<tr>
	  <td>
			<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
        <table id="stats" class="lmoInner" >
					<thead>
						<tr><?
							for ($i=0;$i<$spaltenzahl;$i++) {
                $stat_sort=$_SERVER['PHP_SELF']."?action=admin&amp;todo=statistik&amp;sort=".$i."&amp;file=".$file."&amp;direction=";?>
								<th colspan="2" class="nobr" align="center">
                  <a href="<?=$stat_sort?>asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
                  <input type="text" name="spalten<?=$i?>" onChange="mark(this)" value="<?=$spalten[$i]?>" size="<?=strlen($spalten[$i]);?>">
                  <a href="<?=$stat_sort?>desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
								</th><?
							}?>
						</tr>
					</thead>
					<tfoot><?
              if ($formel_ges>0){?>
              <tr><?
                for ($i=0;$i<$spaltenzahl;$i++) {?>
                  <th colspan="2" align="center"><?
                  if ($formel[$i]){?>
                    <input type="text" onClick="sel('formel_str<?=$i?>')" onChange="mark(this)" name="formel_str<?=$i?>" value="<?=$formel_str[$i]?>" size="<?=strlen($formel_str[$i]);?>"><?
                  } elseif ($i==0) {
                    echo "<strong>".$text['spieler'][54].":</strong>";
                  } else {
                    echo "&nbsp;";
                  }?>
                  </th><?
                }?>
              </tr>
            <?}?>						
						<tr>
							<td align="right" colspan="<?=$spaltenzahl*2?>">
								<input type="hidden" name="option" value="statupdate">
								<input type="hidden" name="todo" value="edit">
                <input type="hidden" name="st" value="<?=$st; ?>">
								<input type="hidden" name="sort" value="<?=$spieler_sort?>">
								<input type="hidden" name="file" value="<?=$file?>">
								<input class="lmo-formular-button" type="submit" value="Statistik updaten">
							</td>
						</tr>
					</tfoot>
					<tbody><?
				$display=$zeile;$statstart=0;
				if ($display>$zeile) $display=$zeile;
				for ($j1=$statstart;$j1<$display;$j1++) {?>
				     <tr><?
					for ($j2=0;$j2<$spaltenzahl;$j2++) {
            $data[$j1][$j2]=htmlentities(stripslashes($data[$j1][$j2]),ENT_COMPAT);
            if (isset($formel[$j2]) && $formel[$j2]==1){?>
    			    <td colspan="2" align="center">
                <input type="text" name="data<?=$j1."|".$j2?>" value="<?=$data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>" disabled>
              </td><?
            }elseif (is_numeric($data[$j1][$j2])){?>
							<td align="right">
                <input type="text" name="data<?=$j1."|".$j2?>" value="<?= $data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>">
              </td>
              <td align="left">
  							<table cellpadding="0" cellspacing="0">
                  <tr>
                    <td><script type="text/javascript">document.write('<a href="#" onclick="return change(\'+\',\'data<?=$j1?>|<?=$j2?>\');" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                  </tr>
                  <tr>
                    <td><script type="text/javascript">document.write('<a href="#" onclick="return change(\'-\',\'data<?=$j1?>|<?=$j2?>\');" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                  </tr>
                </table>
							</td><?
						}else{
							if ($spalten[$j2]==$text['spieler'][25]) {?>
							<td colspan="2" align="left">
  							<select name="data<?=$j1."|".$j2?>" size="1"><?
  								for($j=0;$j<=$anzteams;$j++){?>
  									<option <?if ($teams[$j]==$data[$j1][$j2]) echo "selected";?>><?=$teams[$j]?></option><?
  								}?>
  							</select>
							</td><?
							}else{?>
							<td colspan="2" align="left">
								<input type="text" name="data<?=$j1."|".$j2?>"value="<?= $data[$j1][$j2]?>" size="<?=strlen($data[$j1][$j2]);?>">
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
		<th align="center"><h1><?=$text['spieler'][39]?></h1></th>
	</tr>
	<tr>
		<td>
			<form action="<?= $_SERVER['PHP_SELF']?>" method="post" name="form1">
				<input type="hidden" name="option" value="saveconfig">
				<input type="hidden" name="todo" value="edit">
        <input type="hidden" name="st" value="<?=$st; ?>">
				<input type="hidden" name="file" value="<?=$file?>">
				<table class="lmoInner">
					<tr>
						<th colspan="3"><?=$text['spieler'][44]?></th>
            <th colspan="2"><?=$text['spieler'][45]?></th>
					</tr>
					<tr>
						<td class="nobr"><?=$text['spieler'][22]?>: </td>
						<td align="right">
							<input type="text" name="anzeige_pro_seite"value="<?= $spieler_anzeige_pro_seite?>" size="<?=strlen($spieler_anzeige_pro_seite);?>">
						</td>
            <td align="left">
							<table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="return change(\'+\',\'anzeige_pro_seite\');" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="return change(\'-\',\'anzeige_pro_seite\');" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
              </table>
					  </td>
						<td align="left" class="nobr"><?=$text['spieler'][40]?>: </td>
            <td align="left">
  						<select name="adminbereich_standard_sortierung" onChange="mark(this)" size="1"><?
  
  						for ($x=0;$x<$spaltenzahl;$x++) {?>
  							<option value="<?=$x?>" <?if ($x==$spieler_adminbereich_standard_sortierung ) echo "selected";?>><?=$spalten[$x]?></option><?
  						}?>
  						</select>
						</td>
					</tr>
					<tr>
						<td align="left" class="nobr"><?=$text['spieler'][21]?>: </td>
						<td align="left" colspan="2">
  						<select name="standard_sortierung" onChange="mark(this)" size="1"><?
  						for ($x=0;$x<$spaltenzahl;$x++) {?>
  							<option value="<?=$x?>" <?if ($x==$spieler_standard_sortierung ) echo "selected";?>><?=$spalten[$x]?></option><?
  						}?>
  						</select>
						</td>
						<?if($_SESSION['lmouserok']==2){?>
            <td align="left" class="nobr"><?=$text['spieler'][31]?>: </td>
						<td align="left"><input type="checkbox" name="adminbereich_hilfsadmin_zulassen" onChange="mark(this)" value="<?=$spieler_adminbereich_hilfsadmin_zulassen?>" <?if ($spieler_adminbereich_hilfsadmin_zulassen==1) echo "checked";?> onClick="if (this.checked==true) document.form1.adminbereich_hilfsadmin_fuer_spalten.disabled=false; else {document.form1.adminbereich_hilfsadmin_fuer_spalten.disabled=true;document.form1.adminbereich_hilfsadmin_fuer_spalten.checked=false;}"></td>
            <?}?>
					</tr>
          <tr>
            <td align="left" class="nobr" rowspan="2"><?=$text['spieler'][13]?>: </td>
            <td align="left" class="nobr" colspan="2"><input type="radio" name="standard_richtung" onClick="mark(this)" value="1"<?if ($spieler_standard_richtung==1) echo " checked";?>> <?=$text['spieler'][48]?></td>
            <?if($_SESSION['lmouserok']==2){?>
            <td align="left" class="nobr"><?=$text['spieler'][46]?>: </td>
						<td align="left"><input <?if ($spieler_adminbereich_hilfsadmin_fuer_spalten!=1) echo "disabled"?> type="checkbox" onChange="mark(this)" name="adminbereich_hilfsadmin_fuer_spalten" value="<?=$spieler_adminbereich_hilfsadmin_fuer_spalten?>" <?if ($spieler_adminbereich_hilfsadmin_fuer_spalten==1) echo "checked";?>></td>
            <?}?>
          </tr>
          <tr>
            <td align="left" colspan="2" class="nobr"><input type="radio" name="standard_richtung" onClick="mark(this)" value="0"<?if ($spieler_standard_richtung==0) echo " checked";?>> <?=$text['spieler'][47]?></td>
            <td colspan="2" rowspan="4">&nbsp;</td>
          </tr>
          <tr>
						<td align="left" class="nobr"><?=$text['spieler'][41]?>: </td>
						<td colspan="2" align="left"><input type="text" name="ligalink" onChange="mark(this)" value="<?= $spieler_ligalink?>" size="<?=strlen($spieler_ligalink);?>"></td>
					</tr>
					<tr>
						<td align="left" class="nobr"><?=$text['spieler'][24]?>: </td>
						<td colspan="2" align="left"><input type="checkbox" name="extra_sortierspalte" onClick="mark(this)" value="<?=$spieler_extra_sortierspalte?>" <?if ($spieler_extra_sortierspalte==1) echo "checked";?>></td>
					</tr>
          <tr>
						<td align="left" class="nobr"><?=$text['spieler'][50]?>: </td>
						<td colspan="2" align="left"><input type="checkbox" name="vereinsweise_anzeigen" onClick="mark(this)" value="<?=$spieler_vereinsweise_anzeigen?>"<?if ($spieler_vereinsweise_anzeigen==1) echo " checked"; if (array_search($text['spieler'][25],$spalten)==0) { echo " disabled";  }?>></td>
					</tr>
					<tr>
						<td class="nobr"><?=$text['spieler'][23]?>: </td>
						<td colspan="2" align="left"><input type="checkbox" name="nullwerte_anzeigen" onClick="mark(this)" value="<?=$spieler_nullwerte_anzeigen?>" <?if ($spieler_nullwerte_anzeigen==1) echo "checked";?>></td>
					</tr>
					<tr>
						<td colspan="5" align="right"><input class="lmo-formular-button" type="submit" value="Konfiguration speichern"></td>
					</tr>
				</table>
			</form>
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
      $help_str=strtr($help_str,'+-*/0123456789.(),','                  ');
      echo (chop($help_str));
      if (strlen(trim($help_str))==0 || trim($help_str)=='MAX' || trim($help_str)=='MIN'){
        $formel_str[$i] = "\$help2=round(".$formel_str[$i].",2);";
      }else{
        $formel_str[$i] = "\$help2=\"".$text['spieler'][55]."\";";
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