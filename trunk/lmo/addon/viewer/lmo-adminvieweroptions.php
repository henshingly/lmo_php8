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
  
require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
?>
<script src="<?=URL_TO_JSDIR?>/viewer.js" type="text/javascript"></script>
<?PHP
if($_SESSION['lmouserok']==2){
$verz=substr($dirliga,-1)=='/'?opendir(substr(PATH_TO_LMO."/".$dirliga,0,-1)):opendir(PATH_TO_LMO."/".$dirliga);
$tmpl_verz=substr($dirliga,-1)=='/'?opendir(substr(PATH_TO_TEMPLATEDIR."/viewer/",0,-1)):opendir(PATH_TO_TEMPLATEDIR."/viewer/");
$tmpl_counter=0;
while($t_files=readdir($tmpl_verz)) {
  if(strtolower(substr($t_files,-8))==".tpl.php"){
    $tpl_files[$tmpl_counter++]=substr($t_files,0,-8);
  }
}
$liga_counter=0;
$unbenannte_liga_counter=0;
$ligadatei=array();
while($files=readdir($verz)){
  if(strtolower(substr($files,-4))==".l98"){
    $sekt="";
    $datei = fopen(PATH_TO_LMO."/".$dirliga.$files,"rb");
    if ($datei) {
      $ligadatei[$liga_counter]['file_date']=filemtime(PATH_TO_LMO."/".$dirliga.$files); //Datum
      $ligadatei[$liga_counter]['file_name']=$files;

      $ligadatei[$liga_counter]['liga_name']="";  //Liganame
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
          if($option_name=="Teams"){$ligadatei[$liga_counter]['anz_teams']=$option_wert;}
          if($option_name=="Type"){
            if($option_wert=="1"){$ligadatei[$liga_counter]['rundenbezeichnung']=$text[370];}
          }          //Alle benötigten Werte gefunden -> Abbruch
          if($ligadatei[$liga_counter]['liga_name']!="" &&
             $ligadatei[$liga_counter]['anz_teams']!='')break;
       }
      }
      fclose($datei);
      if($ligadatei[$liga_counter]['liga_name']==""){
        $unbenannte_liga_counter++;
        $ligadatei[$liga_counter]['liga_name']=$text[507]." ".$unbenannte_liga_counter;
      }
      $liga_counter++;
    }
  }
}
closedir($verz);

//usort($ligadatei,'cmp');

isset($_POST['formular1']) ? $form1=true : $form1=false;                  // formular 1 ausgefüllt?
isset($_POST['formular2']) ? $form2=true : $form2=false;                  // formular 2 ausgefüllt?
isset($_POST['formular3']) ? $form3=true : $form3=false;                  // formular 3 ausgefüllt?

if ($form1) {
  isset($_POST['dateiname']) ? $save_file_name=$_POST['dateiname'] : $save_file_name='unbenannt';
  $_POST['modus']==1 ? $config_array[2]='modus=1' :  $config_array[2]='modus=2';
//$config_array[2]='modus=1';
  isset($_POST['anzahl_tage_plus'])               ? $config_array[3] ='anzahl_tage_plus='.intval($_POST['anzahl_tage_plus'])                  : $config_array[3] ='anzahl_tage_plus=';
  isset($_POST['anzahl_tage_minus'])              ? $config_array[4] ='anzahl_tage_minus='.intval($_POST['anzahl_tage_minus'])                : $config_array[4] ='anzahl_tage_minus=';
  isset($_POST['anzahl_spieltage_vor'])           ? $config_array[5] ='anzahl_spieltage_vor='.intval($_POST['anzahl_spieltage_vor'])          : $config_array[5] ='anzahl_spieltage_vor=';
  isset($_POST['anzahl_spieltage_zurueck'])       ? $config_array[6]='anzahl_spieltage_zurueck='.intval($_POST['anzahl_spieltage_zurueck'])   : $config_array[6] ='anzahl_spieltage_zurueck=';
  isset($_POST['datumsformat'])                   ? $config_array[7] ='datumsformat='.$_POST['datumsformat']                                  : $config_array[7] ='datumsformat=%d.%m.%y';
  isset($_POST['heute_highlight'])                ? $config_array[8] ='heute_highlight=1'                                                     : $config_array[8]='heute_highlight=';
  isset($_POST['tabelle_verlinken'])              ? $config_array[9] ='tabelle_verlinken=1'                                                   : $config_array[9] ='tabelle_verlinken=';
  isset($_POST['spielberichte_neues_fenster'])    ? $config_array[10]='spielberichte_neues_fenster=1'                                         : $config_array[10]='spielberichte_neues_fenster=';
  isset($_POST['mannschaftshomepages_verlinken']) ? $config_array[11]='mannschaftshomepages_verlinken=1'                                      : $config_array[11]='mannschaftshomepages_verlinken=';
  isset($_POST['mannschaftsnamen'])               ? $config_array[12]='mannschaftsnamen='.$_POST['mannschaftsnamen']                          : $config_array[12]='mannschaftsnamen=';
  isset($_POST['titelzeile'])                     ? $config_array[13]='titelzeile='.$_POST['titelzeile']                                      : $config_array[13]='titelzeile=';
  isset($_POST['anstosstermin'])                  ? $config_array[14]='anstosstermin='.$_POST['anstosstermin']                                : $config_array[14]='anstosstermin=';
  isset($_POST['template'])                       ? $config_array[15]='template='.$_POST['template']                                          : $config_array[15]='template=standard';
  isset($_POST['uhrzeitformat'])                  ? $config_array[16]='uhrzeitformat='.$_POST['uhrzeitformat']                                : $config_array[16]='uhrzeitformat=%H:%M';
  isset($_POST['tordummy'])                       ? $config_array[17]='tordummy='.$_POST['tordummy']                                          : $config_array[17]='tordummy=_';
  isset($_POST['tabellensymbol'])                 ? $config_array[18]='tabellensymbol='.$_POST['tabellensymbol']                              : $config_array[18]='tabellensymbol=tabelle.gif';
  isset($_POST['spielberichtesymbol'])            ? $config_array[19]='spielberichtesymbol='.$_POST['spielberichtesymbol']                    : $config_array[19]='spielberichtesymbol=bericht.gif';
  isset($_POST['notizsymbol'])                    ? $config_array[20]='notizsymbol='.$_POST['notizsymbol']                                    : $config_array[20]='notizsymbol=notiz.gif';
  isset($_POST['spieltagtext'])                   ? $config_array[21]='spieltagtext='.$_POST['spieltagtext']                                  : $config_array[21]='spieltagtext=';
  isset($_POST['cache_refresh'])                  ? $config_array[22] ='cache_refresh='.$_POST['cache_refresh']                               : $config_array[22] ='cache_refresh=';
  isset($_POST['favteam_highlight'])              ? $config_array[23] ='favteam_highlight=1'                                                  : $config_array[23] ='favteam_highlight=';
  
  $save_config_array=implode(';',$config_array);
}

$z=1;
foreach($ligadatei as $liga){
  $ligennamen[$z]=$liga['liga_name'];
  $ligenfile[$z]=$liga['file_name'];
  $ligenteams[$z]=$liga['anz_teams'];
  $z++;
}

if (isset($_POST['B2'])) {
    $save_file_name=$_POST['dateiname'];
    $config_array=explode(';',$_POST['config_array']);
    $save_config_array=implode(';',$config_array);
    $zz=1;
    $z=$_POST['zaehler'];
    for ($i=1; $i<$z; $i++) {
      $h='c'.$i;
      if (isset ($_POST[$h])){
         $ausgewaehlte_ligen[$zz++]=$i;
       }
    }
}

$z=1;
$error_dateiopen=false; $speicherflag=false;
if ($form3) {
  $save_file_name=$_POST['dateiname'];
  $config_array=explode(';',$_POST['config_array']);
  $zz=1;
  $anz_ligen=0;
  $teamnr=0;
  $flag=TRUE;
  $save_array[1]='[Viewer Ligen]';
  $doppelt_check="";
  $z=$_POST['zaehler'];
  for ($i=0; $i<=$z; $i++) {
    $h='t'.$i;
    if (isset ($_POST[$h])){
      $ldn=$_POST[$h];
      $ligen_datei=substr($ldn,0,strrpos($ldn,'['));
      $team=substr($ldn,strrpos($ldn,'[')+1);
      $team=substr($team,0,strrpos($team,']'));
      $liga1= new liga();
      if ($liga1->loadFile(PATH_TO_LMO.'/'.$dirliga.$ligen_datei) == TRUE) { // Ligenfile vorhanden?
        $file_ligen_datei=file(chop(PATH_TO_LMO.'/ligen/'.$ligen_datei));
        if ($ligen_datei!=$doppelt_check) {
          $doppelt_check=$ligen_datei;
          $zz++;  $anz_ligen++;
          $save_array[$zz]='liga'.$anz_ligen.'='.$ligen_datei;
          $teamnr=0;
        }
      } else {
        echo "3. Formular SAVE_FILE: ".PATH_TO_LMO.'/'.$dirliga.$ligen_datei." nicht gefunden<br>";
      }
      $zz++; $teamnr++;
      $save_array[$zz]=$ligen_datei.'_'.$teamnr.'='.$team;
    }
  }
  $savedateiname=PATH_TO_CONFIGDIR.'/viewer/'.$save_file_name.'.view';
  $error_dateiopen=false;
  if(!$fp=fopen($savedateiname,"w")) {
    $error_dateiopen=true; echo "SCHEISSE";
  } else  {
    $config_array=explode(';',$_POST['config_array']);
    fwrite($fp,"[config]\n");
    foreach ($config_array as $w) {
      if (!$ok=fwrite($fp,$w.chr(10))) {
        $error_dateiopen=true;
      }
    }
    foreach ($save_array as $w) {
      if (!$ok=fwrite($fp,$w.chr(10))) {
       $error_dateiopen=true;
      }
    }
    fclose ($fp);
  }
}

// FORMULARE

if($form3) {
	echo getMessage($text[138]);
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
  <tr>
    <th align="center"><h1><? echo $text['viewer'][42]; ?></h1></th>
  </tr>
  <tr>
    <td class="nobr">
      <form action="#" onSubmit="return false;">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr>
            <th colspan="2" align="center"><? echo $text['viewer'][43]; ?></h1></th>
          </tr>
          <tr>
            <td class="nobr">
              <textarea  rows="6"  cols="80"><? echo trim("\n<?php \n\$multi='".$save_file_name."';\ninclude('".dirname(__FILE__)."/viewer.php');\n?>");?></textarea>
            </td>
          </tr>
					<tr>
    				<td class="nobr"><h1><? echo $text['viewer'][36]; ?></h1></td>
  				</tr>
        </table>
      </form>
    </td>
  </tr>
	<tr>
    <td class="lmoFooter"><? echo $text['viewer'][100]; ?></td>
  </tr>
</table>

<?PHP
	}
	if (!$form1 && !$form2 && !$form3) { //<!-- Hauptauswahl  --> 
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
    <tr>
      <th align="center"><h1><? echo $text['viewer'][21];  ?></h1></td>
    </tr>
    <tr>
      <td class="nobr">
        <form method="POST" action="<? echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>">
          <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
              <th colspan="2" align="center"><? echo $text['viewer'][0]; ?></th>
            </tr>
            <tr>
              <td class="nobr" align="right">
<!--snipp ---------------------------------->
               <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                 <tr>
                   <td class="nobr"  colspan="4"><? echo $text['viewer'][1];  ?> <input class="lmo-formular-input" type="text" name="dateiname" size="20" value="unbenannt"> &nbsp;<? echo $text['viewer'][2];  ?> </td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right" height="22"><input class="lmo-formular-input" type="radio" value="1" name="modus" checked  onClick="byDate(this);"></td>
                   <td class="nobr" align="left"> <? echo $text['viewer'][3];  ?></td>
                   <td class="nobr" align="right"><input type="radio" value="2" name="modus" onClick="byDay(this);"></td>
                   <td class="nobr" align="left"><? echo $text['viewer'][6];  ?></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right" height="22"><input class="lmo-formular-input"  type="text" name="anzahl_tage_plus" size="3" value="7"></td>
                   <td class="nobr" align="left"><? echo $text['viewer'][4];  ?></td>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="anzahl_spieltage_vor" size="3" value="3" disabled> </td>
                   <td class="nobr" align="left"><? echo $text['viewer'][7];  ?></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right" height="22"><input class="lmo-formular-input" type="text" name="anzahl_tage_minus" size="3" value="7"> </td>
                   <td class="nobr" align="left"> <? echo $text['viewer'][5];  ?></td>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="anzahl_spieltage_zurueck" size="3" value="3" disabled></td>
                   <td class="nobr" align="left"> <? echo $text['viewer'][8];  ?></td>
                 </tr>
               </table>
               <br>
               <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                 <tr>
                   <td class="nobr"  colspan="4"></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="datumsformat" size="6" value="d.m.y"></td>
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][10];  ?></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][19];  ?></td>
                   <td class="nobr" align="left">&nbsp;<select class="lmo-formular-input"  name="template" size="1">
                        <? for($tpl=0; $tpl<$tmpl_counter; $tpl++) {
                             echo "<option>".$tpl_files[$tpl]."</option>".chr(13);
                           } ?>
                     </select>
                   </td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="uhrzeitformat" size="6" value="H:i"></td>                    
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][28];  ?></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][27];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="titelzeile" size="20" value=""></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="favteam_highlight" checked></td>
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][54];  ?></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][16]; ?></td>
                   <td class="nobr" align="left">&nbsp;<select class="lmo-formular-input"  name="mannschaftsnamen"  onChange="dolmoedit();">
                			<option value="0"><?=$text['viewer'][46]?></option>
                			<option value="1"><?=$text['viewer'][47]?></option>
                   		<option value="2"><?=$text['viewer'][48]?></option>
                   	</select>
                  </td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="heute_highlight" checked></td>
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][40];  ?></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][23];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="spielberichtesymbol" size="20" value="bericht.gif" onChange="document.getElementById('spielberichtesymbol').src='<?=URL_TO_IMGDIR;?>/viewer/'+this.value;">&nbsp;<img id="spielberichtesymbol" src="<?=URL_TO_IMGDIR;?>/viewer/bericht.gif" alt=""></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="spielberichte_neues_fenster"></td>
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][14];  ?></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][24];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="tabellensymbol" size="20" value="tabelle.gif" onChange="document.getElementById('tabellensymbol').src='<?=URL_TO_IMGDIR;?>/viewer/'+this.value;">&nbsp;<img id="tabellensymbol" src="<?=URL_TO_IMGDIR;?>/viewer/tabelle.gif" alt=""></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="tabelle_verlinken"></td>
                   <td class="nobr" align="left">&nbsp;<? echo $text['viewer'][13];  ?></td> 
                   <td class="nobr" align="right"><? echo $text['viewer'][25];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="notizsymbol" size="20" value="notiz.gif" onChange="document.getElementById('notizsymbol').src='<?=URL_TO_IMGDIR;?>/viewer/'+this.value;">&nbsp;<img id="notizsymbol" src="<?=URL_TO_IMGDIR;?>/viewer/notiz.gif" alt=""></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"> <input class="lmo-formular-input" type="checkbox" name="mannschaftshomepages_verlinken"> </td>
                   <td class="nobr" align="left">&nbsp; <? echo $text['viewer'][15];  ?> </td>  
                   <td class="nobr" align="right"><? echo $text['viewer'][26];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="spieltagtext" size="10" value="<?=$text[145];?>"></td>
                 </tr>
                 <tr>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="cache_refresh" size="3" value="0"></td>
                   <td class="nobr" align="left">&nbsp;<acronym title="<? echo $text['viewer'][53]; ?>"><? echo $text['viewer'][52]; ?></acronym></td>
                   <td class="nobr" align="right"><? echo $text['viewer'][12];  ?></td>
                   <td class="nobr" align="left">&nbsp;<input class="lmo-formular-input" type="text" name="tordummy" size="1" value="_"></td>
                 </tr>
               </table>
<!--snipp ---------------------------------->
              </td>
            </tr>
            <td class="nobr" align="right">
              <input type="submit" class="lmo-formular-button" value="<? echo $text['viewer'][22];  ?> >>" name="B1">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="formular1" value="1">
            </td>
          </table>
        </form>
      </td>
      <tr>
        <td class="lmoFooter"><? echo $text['viewer'][100]; ?></td>
  	</tr>
	</tr>
</table>  

<?PHP
	}
if (!$form2 && $form1 && !$form3) {  // <!-- Bei  ersten Aufruf Ligendateien anzeigen -->
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
	<tr>
  	<th align="center"><h1><? echo $text['viewer'][21];  ?></h1></th>
	</tr>
	<tr>
		<td class="nobr">
			<form name="B2" method="POST" action="<? echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>">
				<table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
        	<tr>
        		<th colspan="2" align="center"><? echo $text['viewer'][30]; ?></th>
         	</tr>
         	<tr>
        		<td class="nobr">
							<table class="lmoInner" width="99%">
              	<tr>
               		<td class="nobr"  align="left">
                  			<? foreach($ligadatei as $liga){?><input  type="checkbox" name="<? echo 'c'.$z; ?>" value = "<? echo 'c'.$z; ?>"> <? echo $liga['liga_name'].'<br>'; ?>
                                             <?echo chr(13); $z++; } 
                        ?>
               		</td>
               	</tr>
                <tr>
              		<td align="left">
                    <script type="text/javascript">
                      document.writeln ('<input type=button value="<? echo $text['viewer'][43]; ?>" onClick="checkAll(this)"\>');
      						    document.writeln ('<input type=button value="<? echo $text['viewer'][44]; ?>" onClick="uncheckAll(this)"\>');
      							  document.writeln ('<input type=button value="<? echo $text['viewer'][45]; ?>" onClick="switchAll(this)"\>');         
      							</script>
      					   </td>
								</tr>

    						<tr>
        				<td><?=getMessage($text['viewer'][51],TRUE);?></td>
      				</tr>
							</table>
           	</td>
         	</tr>
         	<tr>
         		<td class="nobr" align="right">
           				<input type="hidden" name="action" value="admin">
                  <input type="hidden" name="formular2" value="1">
                  <input type="hidden" name="dateinameok" value="1">
                	<input type="hidden" name="dateiname" value="<? echo $save_file_name; ?>">
                  <input type="hidden" name="config_array" value="<? echo $save_config_array; ?>">
                	<input type="hidden" name="zaehler" value="<?echo $z; ?>">
                	<input type="submit" class="lmo-formular-button" value="<? echo $text['viewer'][22]; ?> >>" name="B2">
        		</td>
        	</tr>
        </table>
     	</form>
   	</td>
	</tr>
  <tr>
 		<td class="lmoFooter"><? echo $text['viewer'][100]; ?></td>
	</tr>
</table>

<?
}
if (!$form3 && $form2){   //<!-- Jetzt kommen die Mannschaftsauswahlen  --> ?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
	<tr>
    <th align="center"><h1><? echo $text['viewer'][21]; ?> </h1></th>
	</tr>
  <tr>
  	<td class="nobr">
    	<form method="POST" action="<? echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>" name="B3">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr>
            <th colspan="2" align="center"><? echo $text['viewer'][31]; ?></h1></th>
          </tr>
          <tr>
						<td class="nobr">
              <? $ges_teams=0;
              for ($i=1; $i<=count($ausgewaehlte_ligen) ;$i++ ) {
                $liga1=new liga();
                if ($liga1->loadFile(PATH_TO_LMO.'/'.$dirliga.$ligenfile[$ausgewaehlte_ligen[$i]]) == TRUE) { // Ligenfile vorhanden? ?>
                  <table class=lmoInner cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td class="nobr"  colspan="3" align="center"><h1><? echo $ligennamen[$ausgewaehlte_ligen[$i]]; ?></h1></td>
                    </tr>

                    <?
                    $ii=1; $spalte=1; $max=count($liga1->teams);
                    foreach ($liga1->teams as $mannschaft) {
                      if ($ii>$max) break;
                      if ($spalte==1) echo '<tr>'.chr(13).'<td class="nobr"  align="left">';
                      if ($spalte==2) echo '<td class="nobr"  align="left">';
                      if ($spalte==3) echo '<td class="nobr"  align="left">';
                      echo '<input type="checkbox" name="t'.$ges_teams.'" value="'.$ligenfile[$ausgewaehlte_ligen[$i]].'['.$ii.']'.'">'.$mannschaft->name;
                      if ($spalte==1) echo '</td>'.chr(13);
                      if ($spalte==2) echo '</td>'.chr(13);
                      if ($spalte==3) echo '</td>'.chr(13)."</tr>".chr(13);
                      $ii++; $spalte++; if ($spalte > 3) $spalte=1; $ges_teams++;
                    }
                    if ($spalte <3) echo"</tr>";
                    ?>
                  </table> 
                  <?
                } else {
                  echo "[".PATH_TO_LMO.'/'.$dirliga.$ligenfile[$ausgewaehlte_ligen[$i]]."] ".$text['viewer'][50]."<br>";
                }
              } ?>
            	</td>
           </tr>
           <tr>
             <td align="left">
              <script type="text/javascript">
                document.writeln ('<input type=button value="<? echo $text['viewer'][43]; ?>" onClick="checkAll(this)"\>');
						    document.writeln ('<input type=button value="<? echo $text['viewer'][44]; ?>" onClick="uncheckAll(this)"\>');
							  document.writeln ('<input type=button value="<? echo $text['viewer'][45]; ?>" onClick="switchAll(this)"\>');         
							</script>
					   </td>
					 </tr>
					 <tr>
					   <td align="right">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="formular3" value="1">
              <input type="hidden" name="ausgewaehlte_ligen[]" value="<? echo $ausgewaehlte_ligen ?>">
              <input type="hidden" name="zaehler" value="<? echo $ges_teams; ?>">
              <input type="hidden" name="dateiname" value="<? echo $save_file_name; ?>">
              <input type="hidden" name="config_array" value="<? echo $save_config_array; ?>">
              <input type="hidden" name="zaehler" value="<? echo $ges_teams; ?>">
              <input type="submit" class="lmo-formular-button" value="<? echo $text['viewer'][32]; ?> >>" name="B3"></p>
						</td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmoFooter"><? echo $text['viewer'][100]; ?></td>
  </tr>
</table>

<?PHP 
	} 
	}
?>