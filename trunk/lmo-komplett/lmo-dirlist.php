<?PHP
//
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
$addi=$_SERVER["PHP_SELF"]."?file=";

$_SESSION['liga_sort']=isset($_REQUEST['liga_sort'])?$_REQUEST['liga_sort']:$liga_sort;
$_SESSION['liga_sort_direction']=isset($_REQUEST['liga_sort_direction'])?$_REQUEST['liga_sort_direction']:$liga_sort_direction;

$verz=opendir(substr(PATH_TO_LMO."/".$dirliga,0,-1));
$liga_counter=0;
$unbenannte_liga_counter=0;
while($files=readdir($verz)){
  if(strtolower(substr($files,-4))==".l98"){

    $ligadatei[$liga_counter]['file_date']=filemtime(PATH_TO_LMO."/".$dirliga.$files); //Datum
    $ligadatei[$liga_counter]['file_name']=$files;

    $ligadatei[$liga_counter]['liga_name']="";  //Liganame
    $ligadatei[$liga_counter]['aktueller_spieltag']="";  //Aktueller Spieltag
    $ligadatei[$liga_counter]['anz_teams']="";  //Anzahl der Mannschaften
    $ligadatei[$liga_counter]['rundenbezeichnung']=$text[2];  //Spieltag oder Pokalrunde

    $sekt="";
    $datei = fopen(PATH_TO_LMO."/".$dirliga.$files,"rb");
    if ($datei) {
      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile=trim($zeile);
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){  //Sektion
          $sekt=substr($zeile,1,-1);
        }elseif((strpos($zeile,"=")!==false) && (substr($zeile,0,1)!=";") && ($sekt=="Options")){  //Wert
          $option=explode("=",$zeile,2);
          $option_name=$option[0];
          $option_wert=isset($option[1])?$option[1]:'';
          if($option_name=="Name"){$ligadatei[$liga_counter]['liga_name']=$option_wert;}
          if($option_name=="Actual"){$ligadatei[$liga_counter]['aktueller_spieltag']=$option_wert;}
          if($option_name=="Teams"){$ligadatei[$liga_counter]['anz_teams']=$option_wert;}
          if($option_name=="Type"){
            if($option_wert=="1"){$ligadatei[$liga_counter]['rundenbezeichnung']=$text[370];}
          }
          //Alle benötigten Werte gefunden -> Abbruch
          if($ligadatei[$liga_counter]['liga_name']!="" &&
             $ligadatei[$liga_counter]['aktueller_spieltag']!="" &&
             $ligadatei[$liga_counter]['anz_teams']!='')break;
        }
      }
      fclose($datei);
      if($ligadatei[$liga_counter]['liga_name']==""){
        $unbenannte_liga_counter++;
        $ligadatei[$liga_counter]['liga_name']=$text[507]." ".$unbenannte_liga_counter;
      }
      if($ligadatei[$liga_counter]['aktueller_spieltag']!=""){
        if($ligadatei[$liga_counter]['rundenbezeichnung']!=$text[2]){  //Pokal
          $t5=strlen(decbin($ligadatei[$liga_counter]['anz_teams']));
          switch ($ligadatei[$liga_counter]['aktueller_spieltag']) {
            case ($t5-1):
              $ligadatei[$liga_counter]['rundenbezeichnung']=$text[374];
              $ligadatei[$liga_counter]['aktueller_spieltag']='';
              break;
            case ($t5-2):
              $ligadatei[$liga_counter]['rundenbezeichnung']=$text[373];
              $ligadatei[$liga_counter]['aktueller_spieltag']='';
              break;
            case ($t5-3):
              $ligadatei[$liga_counter]['rundenbezeichnung']=$text[372];
              $ligadatei[$liga_counter]['aktueller_spieltag']='';
              break;
            case ($t5-4):
              $ligadatei[$liga_counter]['rundenbezeichnung']=$text[371];
              $ligadatei[$liga_counter]['aktueller_spieltag']='';
              break;
          }
        }
      }else{
        $ligadatei[$liga_counter]['rundenbezeichnung']="";
      }
      $liga_counter++;
    }
  }
}
closedir($verz);

usort($ligadatei,'cmp');
if (isset($_SESSION['liga_sort_direction']) && $_SESSION['liga_sort_direction']=='desc') $ligadatei=array_reverse($ligadatei);?>

<script type="text/javascript" src="js/sortable/sortabletable.js"></script>
<script type="text/javascript" src="js/sortable/limSortFunctions.js"></script>
<table id="ligaliste" class="lmost0" cellspacing="0">
  <col />
	<?/*<col />*/?>
	<col style="text-align: right" />
	<col style="text-align: right" />
  <thead>
		<tr>
			<td class="lmost4" title="<?=$text[525].' '.$text[529].' '.$text[526]?>">
        <noscript><a href="<?=$_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" width="7" height="7" border="0" alt="&and;"></a> <?=$text[529]?> <a href="<?=$_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" width="7" height="7" border="0" alt="&or;"></a></noscript>
        <script type="text/javascript">document.write('<?=$text[529]?>');</script>
      </td>
			<?/*<td title="Nach Dateinamen sortieren">Dateiname</td>*/?>
			<td class="lmost4" title="Nach Spieltag / Runde sortieren">Spieltag / Runde</td>
			<td class="lmost4" title="Nach Datum sortieren">letzte Änderung</td>
		</tr>
  </thead>
  <tbody>
<? foreach($ligadatei as $liga){?>
		<tr onMouseOver="this.className='lmost4';" onMouseOut="this.className='lmost5'">
			<td><a href="<?=$addi.$dirliga.$liga['file_name']?>"><?=$liga['liga_name']?></a></td>
			<?/*<td class="lmost5"><?=$liga['file_name']?></td>*/?>
			<td><?=$liga['rundenbezeichnung']." ".$liga['aktueller_spieltag'];?></td>
			<td><?=date("d.m.Y H:i",filemtime(PATH_TO_LMO."/".$dirliga.$liga['file_name']))?></td>
		</tr>

<?
}
if($liga_counter==0){echo "<td colspan=4>[".$text[223]."]</td>";}?>

</tbody>
</table>

<script type="text/javascript">

var ligaTable = new SortableTable(document.getElementById("ligaliste"),
	["CaseInsensitiveString","RoundSort", "GermanDateTime"]);/*"CaseInsensitiveString",*/
// LigaName=0
//
// FileDate=2
ligaTable.sort(0);
</script>

<?

function cmp ($a1, $a2) {
  $sort=(isset($_SESSION['liga_sort']) && isset($a1[$_SESSION['liga_sort']]) && isset($a1[$_SESSION['liga_sort']]))?$_SESSION['liga_sort']:'liga_name';
  if (is_numeric($a1[$sort]) && is_numeric($a2[$sort])) {  //Numerischer Vergleich
    if ($a2[$sort]==$a1[$sort]) return 0;
    return ($a1[$sort]>$a2[$sort]) ? 1 : -1;
  }else{ //Stringvergleich
    $a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  	$a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  	return  strnatcasecmp($a1[$sort],$a2[$sort]);
  }
}

?>