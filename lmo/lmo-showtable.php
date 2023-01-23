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
?>
<div class="container-fluid">
<?php
/*Inklusive Heim & Auswärts*/
if($tabonres==2){?>
  <div class="row font-weight-bold">
    <div class="col-6"><?php echo $tabdat;?></div>
    <div class="col-1"></div>
    <div class="col-1"><?php echo $text[41]; ?></div>
    <div class="col-1"><?php echo $text[42]; ?></div>
  </div><?php 
}?>
  <div class="row font-weight-bold">
    <div class="col-2"></div>
    <div class="col-3"></div>
    <div class="col-1 text-end"><?php echo $text[33]; ?></div>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[34]; ?></div><?php  
if($hidr!=1){?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[35]; ?></div>
<?php } ?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[36]; ?></div>
<?php  if($tabpkt==0){?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[37]?></div>
<?php } ?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[38]; ?></div>
    <div class="col-2 text-end d-lg-none"><?php echo $text[38]; ?></div>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $text[39]; ?></div>
<?php if($tabpkt==1){?>
    <div class="col-1 text-end"><?php echo $text[37]?></div>
<?php } ?>
  </div>
<?php
$j = 1;
for($x = 1; $x <= $anzteams; $x++) {
  $i = intval(substr($tab0[$x-1], strlen($tab0[$x-1]) - 6));
  if ($i == $favteam) {
    $dummy = "<strong>";
    $dumm2 = "</strong>";
  } else {
    $dummy = "";
    $dumm2 = "";
  }
  $label = "badge bg-secondary";
  if ($tabtype == 0) {
    if (($x == 1) && ($champ != 0)) {
      $label = "badge bg-success";
      $j = 2;
    }
    if (($x >= $j) && ($x < $j+$anzcl) && ($anzcl > 0)) {
      $label = "badge bg-info";
    }
    if (($x >= $j+$anzcl) && ($x < $j+$anzcl+$anzck) && ($anzck > 0)) {
      $label = "badge bg-clq";
    }
    if (($x >= $j+$anzcl+$anzck) && ($x < $j+$anzcl+$anzck+$anzuc) && ($anzuc > 0)) {
      $label = "badge bg-primary";
    }
    if (($x <= $anzteams-$anzab) && ($x > $anzteams-$anzab-$anzar) && ($anzar > 0)) {
      $label = "badge bg-warning";
    }
    if (($x <= $anzteams) && ($x > $anzteams-$anzab) && ($anzab > 0)) {
      $label = "badge bg-danger";
    }
  }
  ?>
  <div class="row">
    <div class="col-2 text-end d-none d-lg-block"><span class="<?php echo $label; ?>"><?php echo $x; ?></span>
<?php
  $y = "right text-info";
  if ($endtab > 1 && isset($platz0[$i]) && isset($platz1[$i])) {
    if ($platz0[$i] < $platz1[$i]) {
      $y = "up text-success";
    } elseif($platz0[$i] > $platz1[$i]) {
      $y = "down text-danger";
    }
  }?>
    <i class="bi bi-arrow-<?php echo $y?>"></i>
    </div>
    <div class="col-2 text-end d-lg-none"><span class="<?php echo $label; ?>"><?php echo $x; ?></span></div>
    <?php
    if (($teamu[$i] != "") && ($urlt == 1)) {
        $url = " <a href='".$teamu[$i]."' target='_blank'><i class='bi bi-house'></i></a>";
    } else {
        $url = " ";
    }
    if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
    
      /** Notizen anzeigen
       *
       * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
       * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
       */
      
      $lmo_tabellennotiz="";
      //Straf-/Bonuspunkte
      if ($strafp[$i]!=0 || $strafm[$i]!=0) {
        $lmo_tabellennotiz.="<br><strong>".$text[128].":</strong> ";
        //Punkte
        $lmo_tabellennotiz.=$strafp[$i]<0?"+".((-1)*applyFactor($strafp[$i],$pointsfaktor)):((-1)*applyFactor($strafp[$i],$pointsfaktor));
        //Minuspunkte
        if ($minus==2) {
          $lmo_tabellennotiz.=":".($strafm[$i]<0?"+".((-1)*applyFactor($strafm[$i],$pointsfaktor)):((-1)*applyFactor($strafm[$i],$pointsfaktor)));
        }
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
      }
      //Straf-/Bonustore
      if ($torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
        $lmo_tabellennotiz.="<br><strong>".$text[522].":</strong> ";
        //Tore
        $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":":((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":";
        //Gegentore
        $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*applyFactor($torkorrektur2[$i],$goalfaktor)):((-1)*applyFactor($torkorrektur2[$i],$goalfaktor));
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
      }
      //Teamnotizen
      if ($teamn[$i]!="") {
        $lmo_tabellennotiz.=$teamn[$i];
      }
      $notiz = " <a data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='".$lmo_tabellennotiz."'><i class='bi bi-info-square'></i></a>";
      $lmo_tabellennotiz="";
    } else {
      $notiz = " ";
    }?>
    <div class="col-3 text-start d-none d-lg-block">
    <?php
    echo $dummy.$teams[$i].$dumm2.$url.$notiz; ?>
    </div>
    <div class="col-3 text-start d-lg-none">
    <?php
    echo $dummy.$teamm[$i].$dumm2.$url.$notiz;?>
    </div>
    <div class="col-1 text-end"><?php echo $dummy.$spiele[$i].$dumm2; ?></div>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $dummy.$siege[$i].$dumm2; ?></div>
  <?php if($hidr!=1){ ?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $dummy.$unent[$i].$dumm2; ?></div>
  <?php }?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $dummy.$nieder[$i].$dumm2; ?></div>
  <?php if ($tabpkt == 0) {?>
    <div class="col-1 text-end"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong>
  <?php if ($minus == 2) {?>
    <strong>:<?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong>
  <?php } ?>
    </div>
  <?php } ?>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?><?php echo $dummy; ?>:<?php echo $dumm2; ?><?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></div>
    <div class="col-2 text-end d-lg-none"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?><?php echo $dummy; ?>:<?php echo $dumm2; ?><?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></div>
    <div class="col-1 text-end d-none d-lg-block"><?php echo $dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></div>
  <?php if($tabpkt==1){?>
    <div class="col-1 text-end"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?>
  <?php if($minus==2){?>
    : <?php echo applyFactor($negativ[$i],$pointsfaktor)?>
  <?php }?>
      </strong>
    </div>
  <?php }  ?>
</div>
<?php } 
if ($einzutoretab == 1) {
?>
  <div class="row">  
    <div class="col text-center">&nbsp;<?php  
  $zustat_file = str_replace(".l98", ".l98.php",  basename($file));
  $zustat_dir = basename($diroutput);
  if (file_exists(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file)) {
    require(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file);
    echo $text[4000].$text[38].": ".applyFactor($gzutore,$goalfaktor)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[4001].": ".applyFactor($gdstore,$goalfaktor);
  }?>
    </div>
  </div>
<?php
}
?>
  <div class="row">
    <div class="col offset-1">
<?php
  if ($einhinrueck==1 || $einheimausw==1) {
  if($tabtype!=0){?><a href="<?php echo $addt1."0"?>" title="<?php echo $text[27]?>"><?php echo $text[40]?></a><?php }else{echo $text[40];}?> <?php
  if($tabonres!=2 && $einheimausw==1){
    if($tabtype!=1){?><a href="<?php echo $addt1."1"?>" title="<?php echo $text[28]?>"><?php echo $text[41]?></a><?php }else{echo $text[41];}?> <?php
    if($tabtype!=2){?><a href="<?php echo $addt1."2"?>" title="<?php echo $text[29]?>"><?php echo $text[42]?></a><?php }else{echo $text[42];}?> <?php
  }
  if ($einhinrueck==1) {
    if($tabtype!=4){?><a href="<?php echo $addt1."4"?>"><?php echo $text[4003]?></a><?php }else{echo $text[4003];}?> <?php
    if($tabtype!=3){?><a href="<?php echo $addt1."3"?>"><?php echo $text[4002]?></a><?php }else{echo $text[4002];}
  }
}?>
    </div>
  </div>
</div>