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
  */
  
  
//require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if ($file!="") {
  $tipp_showzus=0;
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  if (!isset($nlines)) {
    $nlines=array();
  }
  
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfile.php");
  
  if (!isset($_POST['save'])) {
    $save=0;
  } else {
    $save=1;
  }
  if ($save==1) {
    if ($tipp_jokertipp==1) {
      $jksp=isset($_POST["xjokerspiel"])?trim($_POST["xjokerspiel"]):"";
    }
    for ($i=0; $i<$anzsp; $i++) {
      if ($lmtype==0) {
        $plus=0;
        $btip=tippaenderbar($mterm[$st-1][$i],$datum1[$st-1],$datum2[$st-1]);
        if ($btip==true) {
          if ($tipp_tippmodus==1) {
            $goaltippa[$i]=trim($_POST["xtippa".$i]);
            $goaltippb[$i]=trim($_POST["xtippb".$i]);
            
            if ($goaltippa[$i]=="" || $goaltippa[$i]<0 || $goaltippa[$i]=="_") {
              $goaltippa[$i]=-1;
              $goaltippb[$i]=-1;
            } else {
              $goaltippa[$i]=intval(trim($goaltippa[$i]));
              if ($goaltippa[$i]=="") {
                $goaltippa[$i]="0";
              }
            }
            
            if ($goaltippb[$i]=="" || $goaltippb[$i]<0 || $goaltippb[$i]=="_") {
              $goaltippa[$i]=-1;
              $goaltippb[$i]=-1;
            } else {
              $goaltippb[$i]=intval(trim($goaltippb[$i]));
              if ($goaltippb[$i]=="") {
                $goaltippb[$i]="0";
              }
            }
          } else if ($tipp_tippmodus==0) {
            if (!isset($_POST["xtipp".$i])) {
              $_POST["xtipp".$i]=0;
            }
            if ($_POST["xtipp".$i]==1) {
              $goaltippa[$i]="1";
              $goaltippb[$i]="0";
            } else if ($_POST["xtipp".$i]==2) {
              $goaltippa[$i]="0";
              $goaltippb[$i]="1";
            } else if ($_POST["xtipp".$i]==3) {
              $goaltippa[$i]="0";
              $goaltippb[$i]="0";
            } else {
              $goaltippa[$i]="-1";
              $goaltippb[$i]="-1";
            }
          }
        }
      } else {
        for ($n=0; $n<$modus[$st-1]; $n++) {
          $plus=0;
          $btip=tippaenderbar($mterm[$st-1][$i][$n],$datum1[$st-1],$datum2[$st-1]);
          if ($btip==true) {
            if ($tipp_tippmodus==1) {
              $goaltippa[$i][$n]=trim($_POST["xtippa".$i.$n]);
              $goaltippb[$i][$n]=trim($_POST["xtippb".$i.$n]);
              
              if ($goaltippa[$i][$n]=="" || $goaltippa[$i][$n]<0 || $goaltippa[$i][$n]=="_") {
                $goaltippa[$i][$n]=-1;
                $goaltippb[$i][$n]=-1;
              } else {
                $goaltippa[$i][$n]=intval(trim($goaltippa[$i][$n]));
                if ($goaltippa[$i][$n]=="") {
                  $goaltippa[$i][$n]="0";
                }
              }
              if ($goaltippb[$i][$n]=="" || $goaltippb[$i][$n]<0 || $goaltippb[$i][$n]=="_") {
                $goaltippa[$i][$n]=-1;
                $goaltippb[$i][$n]=-1;
              } else {
                $goaltippb[$i][$n]=intval(trim($goaltippb[$i][$n]));
                if ($goaltippb[$i][$n]=="") {
                  $goaltippb[$i][$n]="0";
                }
              }
            } else if ($tipp_tippmodus==0) {
              if (!isset($_POST["xtipp".$i.$n])) {
                $_POST["xtipp".$i.$n]=0;
              }
              if ($_POST["xtipp".$i.$n]==1) {
                $goaltippa[$i][$n]="1";
                $goaltippb[$i][$n]="0";
              } else if ($_POST["xtipp".$i.$n]==2) {
                $goaltippa[$i][$n]="0";
                $goaltippb[$i][$n]="1";
              } else if ($_POST["xtipp".$i.$n]==3) {
                $goaltippa[$i][$n]="0";
                $goaltippb[$i][$n]="0";
              } else {
                $goaltippa[$i][$n]="-1";
                $goaltippb[$i][$n]="-1";
              }
            }
          }
        }
      }
    }
    if ($tipp_jokertipp==1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippjokeranticheat.php");
    }
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php");
    if ($tipp_akteinsicht==1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveeinsicht1.php");
    }
  }
  $addr=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite=17;
  if ($spez==1) {
    $breite+=2;
  }
  if ($tipp_showtendenzabs==1) {
    $breite+=2;
  }
  if ($tipp_showtendenzpro==1) {
    $breite+=2;
  }
  if ($tipp_showdurchschntipp==1) {
    $breite+=2;
  }
  if ($datm==1) {
    $breite++;
  }
  if (!isset($hidr)) {
    $hidr=0;
  }
  //  if($lmtype==1 && $modus[$st-1]!=2){$hidr=1;} // bei KO-Turnier außer bei Hin- und Rückspiel keinen Remistipp zulassen
  if ($hidr==1) {
    $breite--;
  }
  if ($tipp_tippmodus==0) {
    $breite-=2;
  }
  $savebutton=0;
  if ($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1 || ($tipp_showdurchschntipp==1 && $tipp_tippmodus==1)) {
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");
  }
?>
<div class="container">
  <div class="row">
    <div class="col"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></div>
  </div>
  <div class="row">
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <div class="container">
          <div class="row"><?php
  if ($datum1[$st-1]!="") {
    $datum = explode('.',$datum1[$st-1]);
    $dum1=$me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum1="";
  }
  if ($datum2[$st-1]!="") {
    $datum = explode('.',$datum2[$st-1]);
    $dum2=$me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum2="";
  }
  if ($lmtype==1) {
    if ($st==$anzst) {
      $j=$text[374];
    } else if ($st==$anzst-1) {
      $j=$text[373];
    } else if ($st==$anzst-2) {
      $j=$text[372];
    } else if ($st==$anzst-3) {
      $j=$text[371];
    } else {
      $j=$st.". ".$text[370];
    }
  }?>
            <div class="col-6"><b><?php
  if ($lmtype==0) {
    echo $st.". ".$text[2];
  } else {
    echo $j;
  }
  if ($dats==1) {
    if ($datum1[$st-1]!="") {
      echo " ".$text[3]." ".$datum1[$st-1];
    }
    if ($datum2[$st-1]!="") {
      echo " ".$text[4]." ".$datum2[$st-1];
    }
  }?>
            </b></div><?php
  if($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1){ ?>
            <div class="col-2">
            <?php echo $text['tipp'][188]; /* Tipptendenz absolut */?>
            </div>
<?php  
  }
  //ERGEBNISMODUS
  if($tipp_tippmodus==1){  
    if($tipp_showdurchschntipp==1){ ?>
            <div class="col-1">
            <?php echo "Ø-".$text['tipp'][30]; /* DurchschnittsTipp*/ ?>
            </div><?php
    } ?>
            <div class="col-3">
              <?php echo $text['tipp'][209]; /* Dein Tipp */?><br><?php
    if ($goalfaktor!=1) {
      echo "(".$text[553+log10($goalfaktor)].")";
    }?>
            </div><?php
  }
  
  //TENDENZMODUS
  if($tipp_tippmodus==0){ ?>
            <div class="col-1">
              <acronym title="<?php echo $text['tipp'][95] ?>">1</acronym>&nbsp;<?php
    if($hidr==0){ ?>
              <acronym title="<?php echo $text['tipp'][96] ?>">0</acronym>&nbsp;<?php
    }?>
              <acronym title="<?php echo $text['tipp'][97] ?>">2</acronym>
            </div><?php
  }
  //BEIDE
  if ($tipp_jokertipp==1){ ?>
            <div class="col-1"><acronym title="<?php echo $text['tipp'][290] ?>"><?php echo $text['tipp'][289]; ?></acronym></div><?php
  } ?>
            <div class="col-1"><?php echo $text['tipp'][31]; /* Ergebnis */?></div>
            <div class="col-1"><?php echo $text[37]; /* PP */?></div>
          </div><?php
  if ($lmtype!=0) {
    
    $anzsp=$anzteams;
    for ($i=0; $i<$st; $i++) {
      $anzsp=$anzsp/2;
    }
    if (($klfin==1) && ($st==$anzst)) {
      $anzsp=$anzsp+1;
    }
  }
  $punktespieltag=0;
  $nw=0;
  $tipp_jokertippaktiv=true;
  $plus=1;
  if ($lmtype==0) {
    $btip = array_pad($array,$anzsp+1,"false");
    for ($i=0; $i<$anzsp; $i++) {
      $btip[$i]=tippaenderbar($mterm[$st-1][$i],$datum1[$st-1],$datum2[$st-1]);
      if ($tipp_jokertipp==1 && $jksp==($i+1) && $btip[$i]==false) {
        $tipp_jokertippaktiv=false;
      }
    }
  } else {
    $btip = array_pad($array,$anzsp+1,"");
    for ($i=0; $i<$anzsp; $i++) {
      $btip[$i] = array_pad(array("false"),$modus[$st-1]+1,"false");
      for ($n=0; $n<$modus[$st-1]; $n++) {
        $btip[$i][$n]=tippaenderbar($mterm[$st-1][$i][$n],$datum1[$st-1],$datum2[$st-1]);
        if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1) && $btip[$i][$n]==false) {
          $tipp_jokertippaktiv=false;
        }
      }
    }
  }
  
  for ($i=0; $i<$anzsp; $i++) {
    if ($teama[$st-1][$i]>0 && $teamb[$st-1][$i]>0) {
      if ($lmtype==0) {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippeditliga.php");
      }else{ 
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippeditko.php");
      }
    }
  }?>
          <div class="row">
            <div class="col-5"><?php if($tipp_imvorraus>=0 && $st>($stx+$tipp_imvorraus)){
    echo $text['tipp'][177];
  } 
  if($savebutton==1){ ?>
              <input class="btn btn-sm btn-success" type="submit" title="<?php echo $text[114] ?>" name="best" value="<?php echo $text['tipp'][8]; ?>"<?php if($tipp_imvorraus>=0 && $st>($stx+$tipp_imvorraus)){echo " disabled";} ?>><?php  }else{
    echo "&nbsp;";
  }?>
            </div>
            <div class="col-5 text-end"><?php
  echo $text[37]." ";
  if($lmtype==0){
   echo $text[2];
  }else{
   echo $j;
  }
  echo ": ".$punktespieltag;?>
            </div>
          </div>
          <div class="row">
            <div class="col"><?php if($tipp_tippBis>0){echo $text['tipp'][87]." ".$tipp_tippBis." ".$text['tipp'][88];} ?></div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><?php
   $st0 = $st-1;
   if ($st > 1) {?>
    <td align='left'>&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</td><?php
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
    <td align="right">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</td><?php
   }?>
  </tr>
</table><?php } ?>