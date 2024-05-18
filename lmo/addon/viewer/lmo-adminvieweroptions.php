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
  
require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
?>
<script src="<?php echo URL_TO_JSDIR?>/viewer.js" type="text/javascript"></script>
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
  isset($_POST['spielberichtesymbol'])            ? $config_array[20]='spielberichtesymbol='.$_POST['spielberichtesymbol']                    : $config_array[20]='spielberichtesymbol=bericht.gif';
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

<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h3><?php echo $text['viewer'][42]; ?></h3></div>
  </div>
  <div class="row p-1">
    <div class="col d-flex justify-content-center"><?php echo $text['viewer'][43]; ?></div>
  </div>
  <div class="row p-1">
    <div class="col-8 offset-2 d-flex justify-content-center">
      <textarea class="form-control" rows="6" cols="80"><?php echo trim("\n<?php \n\$multi='".$save_file_name."';\ninclude('".dirname(__FILE__)."/viewer.php');\n?>");?></textarea>
    </div>
  </div>
  <div class="row p-1">
    <div class="col d-flex justify-content-center">
      <?php echo $text['viewer'][36]; ?>
    </div>
  </div>
  <div class="row p-1">
    <div class="col d-flex justify-content-center"><strong><?php echo $text['viewer'][100]; ?></strong></div>
  </div>
</div>

<?php
  }
  if (!$form1 && !$form2 && !$form3) { //<!-- Hauptauswahl  --> 
?>

<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h3><?php echo $text['viewer'][21]; ?></h3></div>
  </div>
  <form class="row" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>">
    <div class="row pb-1">
      <div class="col"><strong><?php echo $text['viewer'][0]; ?></strong></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><?php echo $text['viewer'][1];  ?></div>
      <div class="col-3"><input class="form-control" type="text" name="dateiname" value="unbenannt"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][2]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-4  offset-2 text-start"><input class="form-check-input" type="radio" value="1" name="modus" checked onClick="byDate(this);">&nbsp;<?php echo $text['viewer'][3];  ?></div>
      <div class="col-4 text-start"><input class="form-check-input" type="radio" value="2" name="modus" onClick="byDay(this);">&nbsp;<?php echo $text['viewer'][6];  ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><input class="form-control" type="number" name="anzahl_tage_plus" value="7"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][4]; ?></div>
      <div class="col-1"><input class="form-control" type="number" name="anzahl_spieltage_vor" value="3" disabled></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][7]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><input class="form-control" type="number" name="anzahl_tage_minus" value="7"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][5]; ?></div>
      <div class="col-1"><input class="form-control" type="number" name="anzahl_spieltage_zurueck" value="3" disabled></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][8]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col">&nbsp;</div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><input class="form-control" type="text" name="datumsformat" value="d.m.y"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][10]; ?></div>
      <div class="col-2">
        <select class="form-select" name="template" size="1">
          <?php  for($tpl=0; $tpl<$tmpl_counter; $tpl++) {
                   echo "<option>".$tpl_files[$tpl]."</option>".chr(13);
                 } ?>
        </select>
      </div>
      <div class="col-3 text-start"><?php echo $text['viewer'][20]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><input class="form-control" type="text" name="uhrzeitformat" value="H:i"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][28]; ?></div>
      <div class="col-2"><input class="form-control" type="text" name="titelzeile" value=""></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][27]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2 text-end"><input class="form-check-input" type="checkbox" name="favteam_highlight" checked></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][54]; ?></div>
      <div class="col-2">
        <select class="form-select" name="mannschaftsnamen" onChange="dolmoedit();">
          <option value="0"><?php echo $text['viewer'][46]?></option>
          <option value="1"><?php echo $text['viewer'][47]?></option>
          <option value="2"><?php echo $text['viewer'][48]?></option>
        </select>
      </div>
      <div class="col-3 text-start"><?php echo $text['viewer'][16]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2 text-end"><input class="form-check-input" type="checkbox" name="heute_highlight" checked></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][40]; ?></div>
      <div class="col-2"><input class="form-control" type="text" name="spielberichtesymbol" value="bericht.gif" onChange="document.getElementById('spielberichtesymbol').src='<?php echo URL_TO_IMGDIR;?>/viewer/'+this.value;"><img id="spielberichtesymbol" src="<?php echo URL_TO_IMGDIR;?>/viewer/bericht.gif" alt=""></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][23]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2 text-end"><input class="form-check-input" type="checkbox" name="spielberichte_neues_fenster"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][14]; ?></div>
      <div class="col-2"><input class="form-control" type="text" name="tabellensymbol" value="tabelle.gif" onChange="document.getElementById('tabellensymbol').src='<?php echo URL_TO_IMGDIR;?>/viewer/'+this.value;"><img id="tabellensymbol" src="<?php echo URL_TO_IMGDIR;?>/viewer/tabelle.gif" alt=""></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][24]; ?></div>
    </div>
    <div class="row align-items-center input-group pb-1">
      <div class="col-1 offset-2 text-end"><input class="form-check-input" type="checkbox" name="tabelle_verlinken"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][13]; ?></div>
      <div class="col-2"><input class="form-control" type="text" name="notizsymbol" value="notiz.gif" onChange="document.getElementById('notizsymbol').src='<?php echo URL_TO_IMGDIR;?>/viewer/'+this.value;"><img id="notizsymbol" src="<?php echo URL_TO_IMGDIR;?>/viewer/notiz.gif" alt=""></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][25]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2 text-end"><input class="form-check-input" type="checkbox" name="mannschaftshomepages_verlinken"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][25]; ?></div>
      <div class="col-2"><input class="form-control" type="text" name="spieltagtext"value="<?php echo $text[145];?>"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][26]; ?></div>
    </div>
    <div class="row align-items-center pb-1">
      <div class="col-1 offset-2"><input class="form-control" type="number" name="cache_refresh" size="3" value="0"></div>
      <div class="col-3 text-start"><acronym title="<?php echo $text['viewer'][53]; ?>"><?php echo $text['viewer'][52]; ?></acronym></div>
      <div class="col-2"><input class="form-control" type="text" name="tordummy" value="_"></div>
      <div class="col-3 text-start"><?php echo $text['viewer'][12]; ?></div>
    </div>
    <div class="row p-2">
      <div class="col">
        <input type="submit" class="btn btn-primary btn-sm" value="<?php echo $text['viewer'][22];  ?> >>" name="B1">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="formular1" value="1">
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col"><strong><?php echo $text['viewer'][100]; ?></strong></div>
  </div>
</div>  

<?php
  }
  if (!$form2 && $form1 && !$form3) {  // <!-- Bei  ersten Aufruf Ligendateien anzeigen -->
?>

<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h3><?php echo $text['viewer'][21];  ?></h3></div>
  </div>
  <form class="row" name="B2" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>">
    <div class="row">
      <div class="col"><strong><?php echo $text['viewer'][30]; ?></strong></div>
    </div>
    <div class="row">
      <div class="col-3 offset-5 text-start">
      <?php foreach($ligadatei as $liga){?>
        <input class="form-check-input" type="checkbox" name="<?php echo 'c'.$z; ?>" value = "<?php echo 'c'.$z; ?>"> <?php echo $liga['liga_name'].'<br>'; ?>
         <?php echo chr(13); $z++; } ?>
      </div>
    </div>
    <div class="row pt-3">
      <div class="col">
        <script type="text/javascript">
          document.writeln ('<input type="button" class="btn btn-sm btn-secondary" value="<?php echo $text['viewer'][43]; ?>" onClick="checkAll(this)"\>');
      	  document.writeln ('<input type="button" class="btn btn-sm btn-secondary" value="<?php echo $text['viewer'][44]; ?>" onClick="uncheckAll(this)"\>');
      	  document.writeln ('<input type="button" class="btn btn-sm btn-secondary" value="<?php echo $text['viewer'][45]; ?>" onClick="switchAll(this)"\>');         
      	</script>
      </div>
    </div>
    <div class="row p-3">
      <div class="col"><?php echo getMessage($text['viewer'][51],TRUE);?></div>
    </div>
    <div class="row">
      <div class="col">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="formular2" value="1">
        <input type="hidden" name="dateinameok" value="1">
        <input type="hidden" name="dateiname" value="<?php echo $save_file_name; ?>">
        <input type="hidden" name="config_array" value="<?php echo $save_config_array; ?>">
        <input type="hidden" name="zaehler" value="<?php echo $z; ?>">
        <input type="submit" class="btn btn-primary btn-sm" value="<?php echo $text['viewer'][22]; ?> >>" name="B2">
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col"><strong><?php echo $text['viewer'][100]; ?></strong></div>
  </div>
</div>


<?php 
}
if (!$form3 && $form2) {   //<!-- Jetzt kommen die Mannschaftsauswahlen  --> ?>

<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h3><?php echo $text['viewer'][21]; ?> </h3></div>
  </div>
  <form class="row" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vieweroptions'; ?>" name="B3">
    <div class="row">
      <div class="col"><strong><?php echo $text['viewer'][31]; ?></strong></div>
    </div>
    <?php $ges_teams=0;
          for ($i=1; $i<=count($ausgewaehlte_ligen) ;$i++ ) {
            $liga1=new liga();
            if ($liga1->loadFile(PATH_TO_LMO.'/'.$dirliga.$ligenfile[$ausgewaehlte_ligen[$i]]) == TRUE) { // Ligenfile vorhanden? ?>
    <div class="row pt-4">
      <div class="col d-flex justify-content-center"><h3><?php echo $ligennamen[$ausgewaehlte_ligen[$i]]; ?></h3></div>
    </div>
             <?php $ii=1; $spalte=1; $max=count($liga1->teams);
              foreach ($liga1->teams as $mannschaft) {
                if ($ii>$max) break;
                if ($spalte==1) echo '<div class="row">'.chr(13).'<div class="col-2 offset-3 text-start">';
                if ($spalte>1) echo '<div class="col-2 text-start">';
                echo '<input type="checkbox" class="form-check-input" name="t'.$ges_teams.'" value="'.$ligenfile[$ausgewaehlte_ligen[$i]].'['.$ii.']'.'">&nbsp;'.$mannschaft->name;
                if ($spalte<4) echo '</div>'.chr(13);
                if ($spalte==4) echo '</div>'.chr(13)."</div>".chr(13);
                $ii++; $spalte++; if ($spalte > 4) $spalte=1; $ges_teams++;
              }
            } else {
              echo "[".PATH_TO_LMO.'/'.$dirliga.$ligenfile[$ausgewaehlte_ligen[$i]]."] ".$text['viewer'][50]."<br>";
            }
          } ?>
    <div class="row pt-3">
      <div class="col">
        <script type="text/javascript">
          document.writeln ('<input type=button class="btn btn-secondary btn-sm" value="<?php echo $text['viewer'][43]; ?>" onClick="checkAll(this)"\>');
	  document.writeln ('<input type=button class="btn btn-secondary btn-sm" value="<?php echo $text['viewer'][44]; ?>" onClick="uncheckAll(this)"\>');
	  document.writeln ('<input type=button class="btn btn-secondary btn-sm" value="<?php echo $text['viewer'][45]; ?>" onClick="switchAll(this)"\>');         
	</script>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <br />
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="formular3" value="1">
        <input type="hidden" name="ausgewaehlte_ligen[]" value="<?php echo $ausgewaehlte_ligen ?>">
        <input type="hidden" name="zaehler" value="<?php echo $ges_teams; ?>">
        <input type="hidden" name="dateiname" value="<?php echo $save_file_name; ?>">
        <input type="hidden" name="config_array" value="<?php echo $save_config_array; ?>">
        <input type="hidden" name="zaehler" value="<?php echo $ges_teams; ?>">
        <input type="submit" class="btn btn-primary btn-sm" value="<?php echo $text['viewer'][32]; ?> >>" name="B3">
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col"><strong><?php echo $text['viewer'][100]; ?></strong></div>
  </div>
</div>

<?php
  } 
}
?>