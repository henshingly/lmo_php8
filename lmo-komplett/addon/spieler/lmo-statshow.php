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
$picDir= URL_TO_IMGDIR.'/spieler/'; 	//Verz. für Spielerfotos und Spaltengraphiken

//Konfiguration laden
require(PATH_TO_ADDONDIR.'/spieler/lmo-statloadconfig.php');

if (isset($_REQUEST['sort'])) {	$sort=$_REQUEST['sort'];  } else $sort=$spieler_standard_sortierung;
if (isset($_REQUEST['begin'])){	$begin=$_REQUEST['begin'];}	else $begin=0;
if (isset($_REQUEST['direction'])){	$direction=$_REQUEST['direction'];}	else $direction=$spieler_standard_richtung;

if ($filepointer = @fopen($filename,"r+b")) {
	$spalten=array(); //Spaltenbezeichnung
	$data=array(); //Daten
	$typ=array(); //Spaltentyp (TRUE=String)
	$spalten = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
	$formel=FALSE;
  for ($i=0;$i<count($spalten);$i++){
    if (strstr($spalten[$i],"*_*-*")){
      $formel = TRUE;
      $spalten[$i]=substr($spalten[$i],0,strlen($spalten[$i])-5);
    }
  }
  if ($formel) fgetcsv($filepointer, 1000, "§"); //Zeile mit Formeln

	$linkspalte=array_search($text['spieler'][32],$spalten); //Linkunterstützung aktiviert?
	
	$zeile=0;
	while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
		for($i=0;$i<count($data[$zeile]);$i++) {
			if (!is_numeric($data[$zeile][$i])) $typ[$i]=TRUE;
		}
		$zeile++;
	}
	array_pop($data);
	if ($direction==1) {
    if (!isset($typ[$sort])) usort($data, 'cmpInt'); else usort($data, 'cmpStr');
  }else{
    if (!isset($typ[$sort])) usort($data, 'cmpInt2'); else usort($data, 'cmpStr2');
  }
	if ($spieler_nullwerte_anzeigen==0 && !isset($typ[$sort])) $data=array_filter($data, 'filterNullwerte'); //Nullwerte ausfiltern
	$spaltenzahl=count($spalten);
	
	if ($begin+$spieler_anzeige_pro_seite>$zeile) $maxdisplay=$zeile-$begin; else $maxdisplay=$spieler_anzeige_pro_seite;
	if ($spieler_anzeige_pro_seite<=0) {$maxdisplay=$zeile;$begin=0;}
?>
<style type="text/css">
	td.uhrzeit {font-size:0.65em;text-align:right;}
	.lmost4 a:link,.lmost4 a:visited  {text-decoration:underline;}
</style>
<table class="lmosta">
	<tr><?
  if ($spieler_extra_sortierspalte==1) {?>
		<td valign="top" class="lmost0" align="center">
			<table>
				<tr>
					<td class="lmost4"><?=$text['spieler'][13]?></td>
				</tr><?
	  for ($i=0;$i<$spaltenzahl;$i++) {?>
				<tr>
					<td class="lmost<?if ($sort==$i) {echo "4";}else{echo "0";}?>"><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$begin&amp;sort=$i&amp;direction=1";?>"><nobr><?
      if (file_exists(PATH_TO_IMGDIR."/lmo-admin2.gif")) {?><img title="<?=$text['spieler'][48]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin2.gif"?>" alt=""><?}
      else{?>&or;<?}
      ?></a>&nbsp;<?=$spalten[$i]?>&nbsp;<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$begin&amp;sort=$i&amp;direction=0";?>"><?
      if (file_exists(PATH_TO_IMGDIR."/lmo-admin0.gif")) {?><img title="<?=$text['spieler'][47]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin0.gif"?>" alt=""><?}
      else{?>&and;<?}?></a></nobr>
					</td>
				</tr><?
    }?>
			</table>
		</td><?
  }?>
		<td  valign="top">
			<table class="lmosta" width="80%" cellpadding="2">
				<thead>
					<tr>
						<th></th><th></th><?
						for ($i=0;$i<$spaltenzahl;$i++) {?>
							<th class="lmost4"><nobr><?
              if ($spieler_pfeile_anzeigen==1) {
  							if ($spalten[$i]!=$text['spieler'][32]) {?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=1";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48]." ".$text['spieler'][37]?>"><?}
                if (file_exists(PATH_TO_IMGDIR."/lmo-admin2.gif")) {?><img title="<?=$text['spieler'][48]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin2.gif"?>" alt=""><?}
                elseif ($spalten[$i]!=$text['spieler'][32]){?>&or;<?}?></a><?
                if ($spalten[$i]!=$text['spieler'][32]) {
                  if (file_exists(PATH_TO_IMGDIR."/spieler/".$spalten[$i].".gif"))echo "&nbsp;<acronym title='".$spalten[$i]."'><img border='0' src='".URL_TO_IMGDIR."/spieler/".rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>&nbsp;";
  							  else echo "&nbsp;".$spalten[$i]."&nbsp;";
                }
                if ($spalten[$i]!=$text['spieler'][32]) {?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=0";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][47]." ".$text['spieler'][37]?>"><?}
                if (file_exists(PATH_TO_IMGDIR."/lmo-admin0.gif")) {?><img title="<?=$text['spieler'][47]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin0.gif"?>" alt=""><?}
                elseif ($spalten[$i]!=$text['spieler'][32] ){?>&and;<?}
                ?></a><?
              }else{
                if ($sort==$i) {$direction=$direction ^ 1;}
                if ($sort==$i-1) {$direction=$direction ^ 1;}?>
								<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=$direction";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48-$direction]." ".$text['spieler'][37]?>"><?
  							if (file_exists(PATH_TO_IMGDIR."/spieler/".$spalten[$i].".gif"))echo "<acronym title='".$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48-$direction]." ".$text['spieler'][37]."'><img border='0' src='".URL_TO_IMGDIR."/spieler/".rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>";
  							elseif ($spalten[$i]!=$text['spieler'][32]) echo $spalten[$i];?>
								</a>
							</th><?
              }?>
              </nobr></th><?
						}?>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="lmost0" colspan="<?=$spaltenzahl+2?>"><?
						if ($spieler_anzeige_pro_seite>0) {
							if ($begin==0){
								?>«&nbsp;<?=$text['spieler'][16]?><?
							}elseif (($newbegin=$begin-$spieler_anzeige_pro_seite)>=0) {
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction";?>">&laquo;&nbsp;<?=$text['spieler'][16]?></a><?
							}else{
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction";?>">«&nbsp;<?=$text['spieler'][16]?></a><?
							}
							$newbegin=0;
							?>&nbsp;|&nbsp;<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction";?>"><?=$text['spieler'][17]?>&nbsp;<?=$spieler_anzeige_pro_seite?></a>&nbsp;|&nbsp;<?
							if (($newbegin=$begin+$maxdisplay)<$zeile) {
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction";?>"><?=$text['spieler'][15]?>&nbsp;&raquo;</a><?
							}else{
								?><?=$text['spieler'][15]?>&nbsp;»<?
							}
						}?>
						</th>
					</tr>
				</tfoot>
				<tbody><?
				for ($j1=$begin;$j1<$begin+$maxdisplay;$j1++) {?>
					<tr><?
					for ($j2=0;$j2<$spaltenzahl;$j2++) {?>
						<td class="lmost<?if ($j2==$sort || $j2==0) echo "4"; else echo"5"; ?>"<?
						if ($j2>0){?> align="center"><?
						}else{?> ><?
							if (!isset($data[$j1-1][$sort]) || $data[$j1][$sort] !== $data[$j1-1][$sort] && $j1!=$begin) echo ($j1+1).". ";
							if ($j1>0 && $j1==$begin) {
								for ($x=$begin-1; $x>0; $x--){
									if ($data[$x][$sort]!=$data[$j1][$sort]) {
										echo ($x+2).". ";
										break;
									}else{
                    echo ($x).". ";
										break;
                  }
								}
							}?>
						</td>
						<td class="lmost5"><?
							if (file_exists($picDir.$data[$j1][$j2].".jpg")) {?>
							<img border="0" src="<?=$picDir.rawurlencode($data[$j1][$j2])?>.jpg" width="<?=$spielerbildbreite?>" alt="<?=$text['spieler'][26]?>" title="<?=$data[$j1][$j2]?>"><?
							}else{?>&nbsp;<?}?>
						</td>
						<td class="lmost<?if ($j2==$sort) echo "4"; else echo"5"; ?>"><?
						}
						//Vereinslinks
						if ($spalten[$j2]==$text['spieler'][25]) {
							$pos=array_search($data[$j1][$j2],$teams);
							if((!is_null($pos) || $pos) && ($teamu[$pos]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$pos]."\" target=\"_blank\" title=\"".$text['spieler'][46]."\">";}
							if (file_exists($picDir.$data[$j1][$j2].".jpg")) {?>
							<img border="0" src="<?=$picDir.rawurlencode($data[$j1][$j2])?>.jpg" width="<?=$spielerbildbreite?>" alt="<?=$text['spieler'][27]?>" title="<?=$data[$j1][$j2]?>">&nbsp;<?
							}else	echo  "&nbsp;".str_replace(" ","&nbsp;",$data[$j1][$j2])."&nbsp;";
							if($pos=array_search($data[$j1][$j2],$teamu) && ($teamu[$pos]!="") && ($urlt==1)){echo "</a>";}	
						//Spielerlinks
						}elseif ($j2==0 && !is_null($linkspalte) && !$linkspalte===FALSE && $data[$j1][$linkspalte]!=$text['spieler']["843"]){
							echo "&nbsp;<a href='".$data[$j1][$linkspalte]."' title='".$text['spieler'][34]."'>".str_replace(" ","&nbsp;",$data[$j1][$j2])."</a>&nbsp;";
						//sonst. Spalten
						}elseif ($spalten[$j2]!=$text['spieler'][32]){
							echo  "&nbsp;".str_replace(" ","&nbsp;",$data[$j1][$j2])."&nbsp;";
						}?>
						</td><?
					}?>
					</tr><?
				}?>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td class="uhrzeit" colspan="<?=$spaltenzahl+1?>"><?=$text['spieler'][28]?>: <?= date("d.m.Y H:i", filemtime($filename)); ?> <?=$text['spieler'][29]?></td>
	</tr>
</table>
<?
}else{?>
	<div class="Message"><?=$text['spieler'][14]?></div><?
}
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
function cmpInt2 ($a1, $a2) {
	global $sort;
	if ($a2[$sort]==$a1[$sort]) return 0;
  return ($a1[$sort]>$a2[$sort]) ? 1 : -1;
}
function cmpStr2 ($a2, $a1) {
	global $sort;
	$a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$c = strnatcasecmp($a2[$sort],$a1[$sort]);
  if (!$c)
    $c = strnatcasecmp($a1[$sort],$a2[$sort]);
  return !$c;
}
function filterNullwerte ($a) {
	global $sort,$zeile;
	if ($a[$sort]==0) $zeile--;
	return ($a[$sort]!=0);
}
?>