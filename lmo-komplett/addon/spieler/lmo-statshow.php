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

//Konfiguration laden
require(PATH_TO_ADDONDIR.'/spieler/lmo-statloadconfig.php');

$sort=      isset($_GET['sort'])?       $_GET['sort']:      $spieler_standard_sortierung;
$begin=     isset($_GET['begin'])?      $_GET['begin']:     0;
$direction= isset($_GET['direction'])?  $_GET['direction']: $spieler_standard_richtung;
$team=      isset($_GET['team'])?       urldecode($_GET['team']):      '';

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
    if ($spalten[$i]==$text['spieler'][25]) {
      $vereinsspalte=$i;
    }
  }
  if ($formel) fgetcsv($filepointer, 1000, "§"); //Zeile mit Formeln

	$linkspalte=array_search($text['spieler'][32],$spalten); //Linkunterstützung aktiviert?
	
	$zeile=0;
	while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
		if ((isset($vereinsspalte) && isset($data[$zeile][$vereinsspalte]) && $spieler_vereinsweise_anzeigen==1 && $team==$data[$zeile][$vereinsspalte]) || $team=='') {
      for($i=0;$i<count($data[$zeile]);$i++) {
  			  if (!is_numeric($data[$zeile][$i])) $typ[$i]=TRUE;
  		}
  		$zeile++;
    }else{
      array_pop($data);
    }
	}
  array_pop($data);
	if ($spieler_nullwerte_anzeigen==0 && !isset($typ[$sort])) $data=array_filter($data, 'filterNullwerte'); //Nullwerte ausfiltern
  if ($direction==1) {
    if (!isset($typ[$sort])) usort($data, 'cmpInt'); else usort($data, 'cmpStr2');
  }else{
    if (!isset($typ[$sort])) usort($data, 'cmpInt2'); else usort($data, 'cmpStr');
  }
	
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
  if ($spieler_vereinsweise_anzeigen==1) {?>
		<td valign="top" class="lmost0" align="center">
			<table>
				<tr>
					<td class="lmost4"><?=$text['spieler'][25]?></td>
				</tr>
        <tr>
					<td class="lmost<?if ($team=='') {echo "4";}else{echo "0";}?>"><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction";?>"><?
      if (file_exists(PATH_TO_IMGDIR."/spieler/".$text['spieler'][51].".gif")) {
          $imgdata=getimagesize(PATH_TO_IMGDIR."/spieler/".$text['spieler'][51].".gif");
          ?><img title="<?=$t?>" border="0" src="<?=URL_TO_IMGDIR."/spieler/".rawurlencode($text['spieler'][51]).".gif"?>" <?=$imgdata[3]?> alt=""><?}
      else{echo $text['spieler'][51];}
      ?></a></nobr>
					</td>
				</tr><?
    //VEreinsspalte
    for($i=0;$i<count($teams)-1;$i++) {?>
				<tr>
					<td class="lmost<?if ($teams[$i]==$team) {echo "4";}else{echo "0";}?>"><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction&amp;team=".$teams[$i];?>"><?
          
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
        $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
      ?><img title="<?=$teams[$i]?>" border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i]).".gif"?>" <?=$imgdata[3]?> alt=""><?}
      else{echo $teamk[$i];}
      ?></a></nobr>
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
              if ($spieler_extra_sortierspalte==0) {
                if ($spieler_pfeile_anzeigen==1) {
    							if ($spalten[$i]!=$text['spieler'][32]) {?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=1&amp;team=$team";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48]." ".$text['spieler'][37]?>"><?}
                  if (file_exists(PATH_TO_IMGDIR."/lmo-admin2.gif")) {?><img title="<?=$text['spieler'][48]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin2.gif"?>" width="7" height="7" alt=""><?}
                  elseif ($spalten[$i]!=$text['spieler'][32]){?>&or;<?}?></a><?
                  if ($spalten[$i]!=$text['spieler'][32]) {
                    if (file_exists(PATH_TO_IMGDIR."/spieler/".$spalten[$i].".gif"))echo "&nbsp;<acronym title='".$spalten[$i]."'><img border='0' src='".URL_TO_IMGDIR."/spieler/".rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>&nbsp;";
    							  else echo "&nbsp;".$spalten[$i]."&nbsp;";
                  }
                  if ($spalten[$i]!=$text['spieler'][32]) {?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=0&amp;team=$team";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][47]." ".$text['spieler'][37]?>"><?}
                  if (file_exists(PATH_TO_IMGDIR."/lmo-admin0.gif")) {?><img title="<?=$text['spieler'][47]?>" border="0" src="<?=URL_TO_IMGDIR."/lmo-admin0.gif"?>" alt=""><?}
                  elseif ($spalten[$i]!=$text['spieler'][32] ){?>&and;<?}
                  ?></a><?
                }else{
                  if ($sort==$i) {$direction=$direction ^ 1;}
                  if ($sort==$i-1) {$direction=$direction ^ 1;}?>
  								<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=$direction&amp;team=$team";?>" title="<?=$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48-$direction]." ".$text['spieler'][37]?>"><?
    							if (file_exists(PATH_TO_IMGDIR."/spieler/".$spalten[$i].".gif"))echo "<acronym title='".$text['spieler'][36]." ".$spalten[$i]." ".$text['spieler'][48-$direction]." ".$text['spieler'][37]."'><img border='0' src='".URL_TO_IMGDIR."/spieler/".rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>";
    							elseif ($spalten[$i]!=$text['spieler'][32]) echo $spalten[$i];?>
  								</a>
  							</th><?
                }
              }else{
                if ($spalten[$i]!=$text['spieler'][32]) {
                  if (file_exists(PATH_TO_IMGDIR."/spieler/".$spalten[$i].".gif"))echo "&nbsp;<acronym title='".$spalten[$i]."'><img border='0' src='".URL_TO_IMGDIR."/spieler/".rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>&nbsp;";
    					    else echo $spalten[$i];
                }
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
								for ($x=$begin-1; $x>=0; $x--){
									if ($data[$x][$sort]!=$data[$j1][$sort]) {
										echo ($x+2).". ";
										break;
									}
                  if ($x==0) echo "1. ";
								}
							}?>
						</td>
						<td class="lmost5"><?
							//Spielerbild
              if (file_exists(PATH_TO_IMGDIR."/spieler/small/".$data[$j1][$j2].".jpg")) {
              $imgdata=getimagesize(PATH_TO_IMGDIR."/spieler/small/".$data[$j1][$j2].".jpg");?>
							<img border="0" src="<?=URL_TO_IMGDIR."/spieler/small/".rawurlencode($data[$j1][$j2])?>.jpg" <?=$imgdata[3]?> alt="<?=$text['spieler'][26]?>" title="<?=$data[$j1][$j2]?>"><?
							}else{?>&nbsp;<?}?>
						</td>
						<td class="lmost<?if ($j2==$sort) echo "4"; else echo"5"; ?>"><?
						}
						//Vereinslinks
						if ($spalten[$j2]==$text['spieler'][25]) {
							$pos=array_search($data[$j1][$j2],$teams);
              if((!is_null($pos) || $pos) && ($teamu[$pos]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$pos]."\" target=\"_blank\" title=\"".$text['spieler'][46]."\">";}
							if (file_exists(PATH_TO_IMGDIR."/teams/small/".$data[$j1][$j2].".gif")) {
              $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$data[$j1][$j2].".gif");?>
							<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($data[$j1][$j2])?>.gif" <?=$imgdata[3]?> alt="<?=$text['spieler'][27]?>" title="<?=$data[$j1][$j2]?>">&nbsp;<?
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
		</td><?
  if ($spieler_extra_sortierspalte==1) {?>
		<td valign="top" class="lmost0" align="center">
			<table>
				<tr>
					<td class="lmost4"><?=$text['spieler'][13]?></td>
				</tr><?
	  for ($i=0;$i<$spaltenzahl;$i++) {?>
				<tr>
					<td class="lmost<?if ($sort==$i) {echo "4";}else{echo "0";}?>"><nobr><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$begin&amp;sort=$i&amp;direction=1";?>"><?
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
  return -1*$c;
}
function filterNullwerte ($a) {
	global $sort,$zeile;
	if ($a[$sort]==0) $zeile--;
	return ($a[$sort]!=0);
}
?>