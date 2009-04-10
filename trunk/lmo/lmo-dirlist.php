<?php
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
  
  
$todo=isset($_GET['todo']) && $_GET['todo']!="" ?$_GET['todo']:isset($_GET['file']) && $_GET['file']!=""?'edit':'';
$addi=$_SERVER["PHP_SELF"]."?todo=".$todo."&amp;file=";

$_SESSION['liga_sort']=isset($_REQUEST['liga_sort'])?$_REQUEST['liga_sort']:$liga_sort;
$_SESSION['liga_sort_direction']=isset($_REQUEST['liga_sort_direction'])?$_REQUEST['liga_sort_direction']:$liga_sort_direction;
$subdir=str_replace(array('../','./'),array('',''),$subdir);
$verz=substr($dirliga.$subdir,-1)=='/'?opendir(substr(PATH_TO_LMO."/".$dirliga.$subdir,0,-1)):opendir(PATH_TO_LMO."/".$dirliga.$subdir);
$liga_counter=0;
$unbenannte_liga_counter=0;
$ligadatei=array();
while($files=readdir($verz)){
  if(strtolower(substr($files,-4))==".l98"){
    $sekt="";
    $datei = fopen(PATH_TO_LMO."/".$dirliga.$subdir.$files,"rb");
    if ($datei && check_hilfsadmin($files)) {
      
      $ligadatei[$liga_counter]['file_date']=filemtime(PATH_TO_LMO."/".$dirliga.$subdir.$files); //Datum
      $ligadatei[$liga_counter]['file_name']=$files;
  
      $ligadatei[$liga_counter]['liga_name']="";  //Liganame
      $ligadatei[$liga_counter]['aktueller_spieltag']="";  //Aktueller Spieltag
      $ligadatei[$liga_counter]['anz_teams']="";  //Anzahl der Mannschaften
      $ligadatei[$liga_counter]['rundenbezeichnung']=$text[2];  //Spieltag oder Pokalrunde
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

<script type="text/javascript" src="<?php echo URL_TO_LMO?>/js/sortable/sortabletable.js"></script>
<script type="text/javascript" src="<?php echo URL_TO_LMO?>/js/sortable/limSortFunctions.js"></script>
<table id="ligaliste" class="lmoInner" cellspacing="0" width="99%">
  <thead>
		<tr>
			<th class="nobr" align="left" > &nbsp;</th>
			<th class="nobr" align="left" title="<?php echo $text[525].' '.$text[529].' '.$text[526]?>">
        <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[529]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
        <script type="text/javascript">document.write('<?php echo $text[529]?>');</script>
      </th><?php
  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {?>
			<th class="nobr" align="left" title="<?php echo $text[525]." ".$text[531]." ".$text[526] ?>">
        <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_name&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[531]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_name&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
        <script type="text/javascript">document.write('<?php echo $text[531]?>');</script>
      </th><?php
  }?>
			<th class="nobr" align="left" title="<?php echo $text[525]." ".$text[2]."/".$text[370]." ".$text[526]?>">
        <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=aktueller_spieltag&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[2]."/".$text[370].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[2]."/".$text[370]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=aktueller_spieltag&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[2]."/".$text[370].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
        <script type="text/javascript">document.write('<?php echo $text[2]."/".$text[370]?>');</script>
      </th>
			<th class="nobr" align="left" title="<?php echo $text[525]." ".$text[530]." ".$text[526]?>">
        <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_date&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[530]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_date&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
        <script type="text/javascript">document.write('<?php echo $text[530]?>');</script>
      </th>
		</tr>
  </thead>
  <tbody>
<?php foreach($ligadatei as $liga){?>
		<tr onMouseOver="this.className='lmoBackMarkierung';" onMouseOut="this.className=''">
			<td class="nobr" align="left"><?php echo	HTML_smallLigaIcon($liga['file_name'],"alt=''","");?></td>
			<td class="nobr" align="left"><a href="<?php echo $addi.$subdir.$liga['file_name']?>"><?php echo $liga['liga_name']?></a></td>
			<?php
  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {?>
      <td class="nobr" align="left"><?php echo $liga['file_name']?> &nbsp;</td><?php
  }?>
			<td class="nobr" align="left"><?php echo $liga['rundenbezeichnung']." ".$liga['aktueller_spieltag'];?> &nbsp;</td>
			<td class="nobr" align="left"><!--<?=filemtime(PATH_TO_LMO."/".$dirliga.$subdir.$liga['file_name'])?>--><?php echo strftime($defdateformat,filemtime(PATH_TO_LMO."/".$dirliga.$subdir.$liga['file_name']))?></td>
		</tr><?php
}
if($liga_counter==0){echo "<td colspan='4'>[".$text[223]."]</td>";}?>

</tbody>
</table>
<script type="text/javascript">
  var ligaTable = new SortableTable(document.getElementById("ligaliste"),<?php
if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {
  $sortprojection=array('liga_name'=>0,'file_name'=>1,'file_date'=>3,'asc'=>0,'desc'=>1);?>
                  ["CaseInsensitiveString","CaseInsensitiveString","RoundSort", "timeStamp"]);<?php
} else {
  $sortprojection=array('liga_name'=>0,'file_name'=>-1,'file_date'=>2,'asc'=>0,'desc'=>1);?>
                  ["CaseInsensitiveString","RoundSort", "timeStamp"]);<?php
}

if (isset($_SESSION['liga_sort']) && isset($_SESSION['liga_sort_direction'])) {
  if ($sortprojection[$_SESSION['liga_sort']]>=0)echo "ligaTable.sort(".$sortprojection[$_SESSION['liga_sort']].",".$sortprojection[$_SESSION['liga_sort_direction']].");";
} else {
  if ($sortprojection[$lmo_liga_sort]>=0) echo "ligaTable.sort(".$sortprojection[$lmo_liga_sort].",".$sortprojection[$lmo_liga_sort_direction].");";
}?>
</script>

<?php

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