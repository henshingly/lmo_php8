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

makeCompat(); //_POST, _GET, etc. für alte PHP Versionen verfügbar machen

if (isset($_REQUEST["ligalink"])) {	$ligalink=$_REQUEST["ligalink"];  } else $ligalink=$text[811];
if (isset($_REQUEST["sort"]))     { $sort=$_REQUEST["sort"];          } else $sort="";
if (isset($_REQUEST["statstart"])){ $statstart=$_REQUEST["statstart"];} else $statstart=0;
if (isset($_REQUEST["option"]))   {	$option = $_REQUEST["option"];    } else $option="";
if (isset($_REQUEST["wert"]))     {	$wert = $_REQUEST["wert"];        } else $wert="";

//Datei auslesen
if (isset($file) && $file!="") {

	//Konfiguration auslesen

	require("lmo-statloadconfig.php");

	//Adminkontrolle
	if ($lmouserok==2 || ($lmouserok==1 && $allowauxadmin==1)) {
		//zu speichernde Konfiguration
		if (isset($_REQUEST['picswidth']))          { $picswidth=$_REQUEST['picswidth']; }
		if (isset($_REQUEST['defaultsort']))        { $defaultsort=$_REQUEST['defaultsort']; }
		if (isset($_REQUEST['adminsort']))          { $adminsort=$_REQUEST['adminsort']; }
		if (isset($_REQUEST['ligalink']))           { $ligalink=$_REQUEST['ligalink']; }
		if (isset($_REQUEST['displayperpage']))     { $displayperpage=$_REQUEST['displayperpage']; }
		if (isset($_REQUEST['displayperpageadmin'])){ $displayperpageadmin=$_REQUEST['displayperpageadmin']; }

		if (isset($_REQUEST['displayzeros']))  $displayzeros=1;  else {if ($option=="saveconfig") $displayzeros=0;}
		if (isset($_REQUEST['nonamesort']))    $nonamesort=1;    else {if ($option=="saveconfig") $nonamesort=0;}
		if (isset($_REQUEST['allowauxadmin'])) $allowauxadmin=1; else {if ($option=="saveconfig") $allowauxadmin=0;}
		if (isset($_REQUEST['allowauxadmins'])) $allowauxadmins=1; else {if ($option=="saveconfig") $allowauxadmins=0;}
		if ($sort=="") $sort=intval($adminsort);

		if (file_exists($filename)) $filepointer = @fopen($filename,"r+b"); else $filepointer = @fopen($filename,"w+b");
		$spalten=array();
		$data=array();
		$spalten = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
		$typ=array(); //Spaltentyp (TRUE=String)
		$zeile=0;
		if (is_null($spalten[0])) {	//Datei war leer
			$spalten[0]=$text[802];		//Name der ersten Spalte
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
		if ($option!="statupdate") {if (!isset($typ[intval($sort)])) usort($data, 'cmpInt'); else {usort($data, 'cmpStr');}}
		$spaltenzahl=count($spalten);
		fclose($filepointer);

			switch ($option) {
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
							if ($spalten[$i]==$text[825] || $spalten[$i]==$text[832]) {$data[0][$i]=$text[843];$newplayer.="§".$text[843];}else{$data[0][$i]="0";$newplayer.="§0";}
						}else{
							if (is_numeric($data[$zeile-1][$i])) {
								$data[$zeile][$i]="0";
								$newplayer.="§0";
							}else{
								$data[$zeile][$i]=$text[843];
								$newplayer.="§".$text[843];
							}
						}
					}
					fputs($filepointer,$newplayer."\n");
					$zeile++;
					fclose($filepointer);
					$statstart=$zeile-$displayperpageadmin;
					if ($statstart<0) $statstart=0;
				}else{
					echo "$text[804]";
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
				}
				break;
			case "addcolumn": //Spalte hinzufügen
				if ($wert!="") {
					if (isset($_REQUEST['type'])) $val=$_REQUEST['type'];
					else $val="0";
					if ($wert==$text[825]) $val=$text["843"];
					if ($wert==$text[832]) $val=$text["843"];
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
             $formel_str[$spaltenzahl]="0";
           }
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
				}else{
					echo "$text[803]";
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
      	//if (!isset($typ[intval($sort)])) usort($data, 'cmpInt'); else {usort($data, 'cmpStr');}
      	break;
			case "saveconfig": //Konfiguration sichern
				if ($nonamesort==1 && $defaultsort==0) $defaultsort=1;
				$filepointer = @fopen($configfile,"w+b");
				set_file_buffer ($filepointer,0);
				fputs($filepointer,$text[820]."=".$picswidth."\n");
				fputs($filepointer,$text[821]."=".$defaultsort."\n");
				fputs($filepointer,$text[840]."=".$adminsort."\n");
				fputs($filepointer,$text[822]."=".$displayperpage."\n");
				fputs($filepointer,$text[842]."=".$displayperpageadmin."\n");
				fputs($filepointer,$text[823]."=".$displayzeros."\n");
				fputs($filepointer,$text[824]."=".$nonamesort."\n");
				if ($lmouserok==2) fputs($filepointer,$text[831]."=".$allowauxadmin."\n");
				if ($lmouserok==2) fputs($filepointer,$text[846]."=".$allowauxadmins."\n");
				fputs($filepointer,$text[841]."=".$ligalink."\n");
				fclose($filepointer);
				break;
		}
	?>

<style type="text/css">
input {border:1px solid;font-family:"Courier New" Courier monospace;}
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
		<td align="center" class="lmost1"><?=$text[800]?></td>
	</tr>
	<tr>
		<td>
			<table class="lmostb">
				<tr>
					<td class="lmost4" colspan="2"><?=$text[806]?></td>
				</tr>
				<tr>
					<td class="lmost5" width="50%" align="center"><nobr>
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text[809]?>"><input type="text" name="wert">&nbsp;<input class="lmoadminbut" type="submit" value=" + "></acronym>
							<input type="hidden" name="option" value="addplayer">
							<input type="hidden" name="sort" value="<?=$sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form></nobr>
					</td>
					<td class="lmost5" width="50%" align="center"><nobr>
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text[810]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$zeile;$x++) {?>
								<option value="<?=$x?>"><?=$data[$x][0]?></option><?
								}?>
							</select>&nbsp;<input class="lmoadminbut" type="submit" value=" - "></acronym>
							<input type="hidden" name="option" value="delplayer">
							<input type="hidden" name="sort" value="<?=$sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form></nobr>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr><?
				if ($lmouserok==2 || ($lmouserok==1 && $allowauxadmin==1 && $allowauxadmins==1)) {?>
				<tr>
					<td class="lmost4" colspan="2"><?=$text[805]?></td>
				</tr>
				<tr>
					<td class="lmost5" width="50%" align="center">
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text[807]?>"><input type="text" name="wert">&nbsp;<input class="lmoadminbut"type="submit" value=" + "></acronym><br>
							<acronym title="<?=$text[830]?>">Typ:&nbsp;<input type="radio" name="type" value="0" checked>&nbsp;Zahlen&nbsp;<input type="radio" name="type" value="<?=$text["843"]?>">&nbsp;Text<input type="radio" name="type" value="F">&nbsp;Formel
</acronym>
							<input type="hidden" name="option" value="addcolumn">
							<input type="hidden" name="sort" value="<?=$sort?>">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
					<td class="lmost5" width="50%" align="center">
						<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post">
							<acronym title="<?=$text[808]?>"><select name="wert" size="1"><?
								for ($x=0;$x<$spaltenzahl;$x++) {?>
								<option value="<?=$x?>"<?if ($x==0){?> disabled<?}if ($x==1){?> selected<?}?>><?=$spalten[$x]?></option><?
								}?>
							</select>&nbsp;<input class="lmoadminbut" type="submit" value=" - "></acronym>
							<input type="hidden" name="option" value="delcolumn">
							<input type="hidden" name="todo" value="statistik">
							<input type="hidden" name="sort" value="<?=$sort?>">
							<input type="hidden" name="file" value="<?=$file?>">
						</form>
					</td>
				</tr><?
				}?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" class="lmost1"><nobr><?=$text[801]?></nobr></td>
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
							<option value="<?=$i?>"<?if ($i==$sort) echo " selected";?>><?=$spalten[$i]?><?
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
							if ($displayperpageadmin>0) {?>
						<tr>
							<td align="center" colspan="<?=$spaltenzahl?>">
								<table width="100%">
									<tr>
										<td align="left"><?
								if ($statstart<=0) {?>&laquo;<?
								}else {?><a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=statistik&amp;sort=$sort&amp;file=$file&amp;statstart=".($statstart-$displayperpageadmin)."&amp;".SID?>">&laquo;</a><?}?>
										</td>
										<td align="right"><?
								if ($statstart+$displayperpageadmin>=$zeile) {?>&raquo;<?
								}else {?><a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=statistik&amp;sort=$sort&amp;file=$file&amp;statstart=".($statstart+$displayperpageadmin)."&amp;".SID?>">&raquo;</a><?}?>
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
								<input type="hidden" name="sort" value="<?=$sort?>">
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
				if ($displayperpageadmin>0) $display=$displayperpageadmin+$statstart; else {$display=$zeile;$statstart=0;}
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
							if ($spalten[$j2]==$text[825]) {?>
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
		<td align="center" class="lmost1"><nobr><?=$text[839]?></nobr></td>
	</tr>
	<tr>
		<td>
			<form action="<?= $_SERVER['PHP_SELF']."?".SID;?>" method="post" name="form1">
				<input type="hidden" name="option" value="saveconfig">
				<input type="hidden" name="todo" value="statistik">
				<input type="hidden" name="file" value="<?=$file?>">
				<table  class="lmostb">
					<tr>
						<th colspan="2"><?=$text["844"]?></th><th colspan="2" rowspan="2"><?=$text["845"]?></th>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[822]?>: </nobr></td>
						<td><nobr>
							<input type="button" value="-" onClick="change('-','displayperpage')">
							<input type="text" name="displayperpage"value="<?= $displayperpage?>" size="<?=strlen($displayperpage);?>">
							<input type="button" value="+" onClick="change('+','displayperpage')"></nobr>
						</td>
						<td class="lmost4">
							<input type="hidden" name="displayperpageadmin" value="0">
						</td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[821]?>: </nobr></td>
						<td>
							<acronym title="<?=$text[821]?>">
								<select name="defaultsort" size="1"><?

								for ($x=$nonamesort;$x<$spaltenzahl;$x++) {?>
									<option value="<?=$x?>" <?if ($x==$defaultsort ) echo "selected";?>><?=$spalten[$x]?></option><?
								}?>
								</select>
							</acronym>
						</td>
						<td class="lmost4"><nobr><?=$text[840]?>: </nobr></td>
						<td>
							<acronym title="<?=$text[840]?>">
								<select name="adminsort" size="1"><?

								for ($x=0;$x<$spaltenzahl;$x++) {?>
									<option value="<?=$x?>" <?if ($x==$adminsort ) echo "selected";?>><?=$spalten[$x]?></option><?
								}?>
								</select>
							</acronym>
						</td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[841]?>: </nobr></td>
						<td><input type="text" name="ligalink" value="<?= $ligalink?>" size="<?=strlen($ligalink);?>"></td>
						<td class="lmost4"><nobr><?=$text[831]?>: </nobr></td>
						<td><?if($lmouserok==2){?><input type="checkbox" name="allowauxadmin" value="<?=$allowauxadmin?>" <?if ($allowauxadmin==1) echo "checked";?> onClick="if (this.checked==true) document.form1.allowauxadmins.disabled=false; else {document.form1.allowauxadmins.disabled=true;document.form1.allowauxadmins.checked=false;}"><?}?></td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[820]?>: </nobr></td>
						<td><input type="text" name="picswidth"value="<?= $picswidth?>" size="<?=strlen($picswidth);?>"></td>
						<td class="lmost4"><nobr><?=$text[846]?>: </nobr></td>
						<td><?if($lmouserok==2){?><input <?if ($allowauxadmin!=1) echo "disabled"?> type="checkbox" name="allowauxadmins" value="<?=$allowauxadmins?>" <?if ($allowauxadmins==1) echo "checked";?>><?}?></td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[824]?>: </nobr></td>
						<td><input type="checkbox" name="nonamesort" value="<?=$nonamesort?>" <?if ($nonamesort==1) echo "checked";?>></td>
					</tr>
					<tr>
						<td class="lmost4"><nobr><?=$text[823]?>: </nobr></td>
						<td><input type="checkbox" name="displayzeros" value="<?=$displayzeros?>" <?if ($displayzeros==1) echo "checked";?>></td>
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
			<a href="javascript:chklmolink('<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=$file&amp;st=-1"?>');" title="<?=$text[100]?>"><?=$text[99]?></a>&nbsp; &nbsp;
			<a href="javascript:chklmolink('<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=$file&amp;st=-2"?>');" title="<?=$text[102]?>"><?=$text[101]?></a>
		</td>
	</tr>
</table>
<?
	}else{
		echo $text[833];
	}//Hilfsadmin
}//Datei existiert

function cmpInt ($a1, $a2) {
	global $sort;
	if ($a2[$sort]==$a1[$sort]) return 0;
  return ($a1[$sort]>$a2[$sort]) ? -1 : 1;
}
function cmpStr ($a2, $a1) {
	global $sort;
	$a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$c = strnatcasecmp($a2[$sort],$a1[$sort]);
  if (!$c)
    $c = strnatcasecmp($a1[$sort],$a2[$sort]);
  return $c;
}
function makeCompat() {
  global $HTTP_GET_VARS,$HTTP_POST_VARS,$HTTP_SESSION_VARS,$HTTP_COOKIE_VARS,$HTTP_SERVER_VARS;
	if (!isset($_GET)) {
		$_GLOBALS['_GET'] = $HTTP_GET_VARS;
  	$_GLOBALS['_POST'] = $HTTP_POST_VARS;
		$_GLOBALS['_REQUEST'] = $HTTP_POST_VARS+$HTTP_GET_VARS;
  	$_GLOBALS['_SESSION'] = $HTTP_SESSION_VARS;
  	$_GLOBALS['_COOKIE'] = $HTTP_COOKIE_VARS;
  	$_GLOBALS['_SERVER'] = $HTTP_SERVER_VARS;
	}
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