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
$picDir= "stats/pic/"; 	//Verz. für Spielerfotos und Spaltengraphiken
if (session_name()=="PHPSESSID") define("SID",""); //falls keine Session gestartet war setze SID

//Konfiguration laden
require(PATH_TO_LMO.'lmo-statloadconfig.php');

if (isset($_REQUEST['sort'])) {	$sort=$_REQUEST['sort'];  } else $sort=$defaultsort;
if (isset($_REQUEST['begin'])){	$begin=$_REQUEST['begin'];}	else $begin=0;

if ($filepointer = @fopen($filename,"r+b")) {
	$spalten=array(); //Spaltenbezeichnung
	$data=array(); //Daten
	$typ=array(); //Spaltentyp (TRUE=String)
	$spalten = fgetcsv($filepointer, 1000, "§"); //Zeile mit Spaltenbezeichnern
	for ($i=0;$i<count($spalten);$i++){
    if (strstr($spalten[$i],"*_*-*")){
      $formel = TRUE;
      $spalten[$i]=substr($spalten[$i],0,strlen($spalten[$i])-5);
    }
  }
  if ($formel) fgetcsv($filepointer, 1000, "§"); //Zeile mit Formeln

	$linkspalte=array_search($text["832"],$spalten); //Linkunterstützung aktiviert?
	
	$zeile=0;
	while ($data[$zeile] = fgetcsv ($filepointer, 10000, "§")) {
		for($i=0;$i<count($data[$zeile]);$i++) {
			if (!is_numeric($data[$zeile][$i])) $typ[$i]=TRUE;
		}
		$zeile++;
	}
	array_pop($data);
	if (!isset($typ[$sort])) usort($data, 'cmpInt'); else usort($data, 'cmpStr');
	if ($displayzeros==0 && !isset($typ[$sort])) $data=array_filter($data, 'filterNullwerte'); //Nullwerte ausfiltern
	$spaltenzahl=count($spalten);
	
	if ($begin+$displayperpage>$zeile) $maxdisplay=$zeile-$begin; else $maxdisplay=$displayperpage;
	if ($displayperpage<=0) {$maxdisplay=$zeile;$begin=0;}
?>
<style type="text/css">
	td.uhrzeit {font-size:0.65em;text-align:right;}
	.lmost4 a:link,.lmost4 a:visited  {text-decoration:underline;}
</style>
<table class="lmosta">
	<tr>
		<?/** Falls eine extra-Spalte "Sortierung" gewünscht wird, bitte diese Zeile entfernen
		<td valign="top" class="lmost0" align="center">
			<table>
				<tr>
					<td class="lmost5"><?=$text[3013]?></td>
				</tr><?
				for ($i=$nonamesort;$i<$spaltenzahl;$i++) {?>
				<tr>
					<td class="lmost1"><?
					if ($i==$sort){
						echo $spalten[$i];
					}else{?>
						<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;".SID;?>"><?=$spalten[$i]?></a><?
					}?>
					</td>
				</tr><?
				}?>
			</table>
		</td>
		Falls eine extra-Spalte "Sortierung" gewünscht wird, bitte diese Zeile entfernen*/?>
		<td  valign="top">
			<table class="lmosta" width="80%" cellpadding="2">
				<thead>
					<tr>
						<th></th><th></th><?
						for ($i=0;$i<$spaltenzahl;$i++) {?>
							<th class="lmost0"><?
							if (($i!=0) || ($nonamesort==0)) {?>
								<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;".SID;?>" title="<?="$text[3036] $spalten[$i] $text[3037]"?>"><?
							}
							if (file_exists($picDir.$spalten[$i].".gif"))echo "<acronym title='$text[3036] $spalten[$i] $text[3037]'><img border='0' src='".$picDir.rawurlencode($spalten[$i]).".gif' alt='".$spalten[$i]."'></acronym>";
							elseif ($spalten[$i]!=$text["832"]) echo $spalten[$i];
							if (($i!=0) || ($nonamesort==0)) {?>
								</a><?
							}?>
							</th><?
						}?>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="lmost0" colspan="<?=$spaltenzahl+2?>"><?
						if ($displayperpage>0) {
							if ($begin==0){
								?>«&nbsp;<?=$text[3016]?><?
							}elseif (($newbegin=$begin-$displayperpage)>=0) {
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;".SID;?>">&laquo;&nbsp;<?=$text[3016]?></a><?
							}else{
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;".SID;?>">«&nbsp;<?=$text[3016]?></a><?
							}
							$newbegin=0;
							?>&nbsp;|&nbsp;<a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;".SID;?>"><?=$text[3017]?>&nbsp;<?=$displayperpage?></a>&nbsp;|&nbsp;<?
							if (($newbegin=$begin+$maxdisplay)<$zeile) {
								?><a href="<?=$_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;".SID;?>"><?=$text[3015]?>&nbsp;&raquo;</a><?
							}else{
								?><?=$text[3015]?>&nbsp;»<?
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
									}
								}
							}?>
						</td>
						<td class="lmost5"><?
							if (file_exists($picDir.$data[$j1][$j2].".jpg")) {?>
							<img border="0" src="<?=$picDir.rawurlencode($data[$j1][$j2])?>.jpg" width="<?=$picswidth?>" alt="<?=$text[3026]?>" title="<?=$data[$j1][$j2]?>"><?
							}else{?>&nbsp;<?}?>
						</td>
						<td class="lmost<?if ($j2==$sort) echo "4"; else echo"5"; ?>"><?
						}
						//Vereinslinks
						if ($spalten[$j2]==$text[3025]) {
							$pos=array_search($data[$j1][$j2],$teams);
							if((!is_null($pos) || $pos) && ($teamu[$pos]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$pos]."\" target=\"_blank\" title=\"".$text[46]."\">";}
							if (file_exists($picDir.$data[$j1][$j2].".jpg")) {?>
							<img border="0" src="<?=$picDir.rawurlencode($data[$j1][$j2])?>.jpg" width="<?=$picswidth?>" alt="<?=$text[3027]?>" title="<?=$data[$j1][$j2]?>">&nbsp;<?
							}else	echo  "&nbsp;".str_replace(" ","&nbsp;",$data[$j1][$j2])."&nbsp;";
							if($pos=array_search($data[$j1][$j2],$teamu) && ($teamu[$pos]!="") && ($urlt==1)){echo "</a>";}	
						//Spielerlinks
						}elseif ($j2==0 && !is_null($linkspalte) && !$linkspalte===FALSE && $data[$j1][$linkspalte]!=$text["843"]){
							echo "&nbsp;<a href='".$data[$j1][$linkspalte]."' title='$text[3034]'>".str_replace(" ","&nbsp;",$data[$j1][$j2])."</a>&nbsp;";
						//sonst. Spalten
						}elseif ($spalten[$j2]!=$text["832"]){
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
		<td class="uhrzeit" colspan="<?=$spaltenzahl+1?>"><?=$text[3028]?>: <?= date("d.m.Y H:i", filemtime($filename)); ?> <?=$text[3029]?><br><?=$text[3035]?></td>
	</tr>
</table>
<?
}else{?>
	<div class="Message"><?=$text[3014]?></div><?
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
function filterNullwerte ($a) {
	global $sort,$zeile;
	if ($a[$sort]==0) $zeile--;
	return ($a[$sort]!=0);
}

function makeCompat() {
  global $_GET,$_POST,$_SESSION,$HTTP_COOKIE_VARS,$HTTP_SERVER_VARS;
	if (!isset($_GET)) {
		$_GLOBALS['_GET'] = $_GET;
  	$_GLOBALS['_POST'] = $_POST;
		$_GLOBALS['_REQUEST'] = $_POST+$_GET;
  	$_GLOBALS['_SESSION'] = $_SESSION;
  	$_GLOBALS['_COOKIE'] = $HTTP_COOKIE_VARS;
  	$_GLOBALS['_SERVER'] = $HTTP_SERVER_VARS;
	}
}
?>