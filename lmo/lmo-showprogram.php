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


if($file!=""){
  $addp=$_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $selteam=!empty($_GET['selteam'])?$_GET['selteam']:$selteam;
?>

<div class="container">
  <div class="row">
    <div class="col">&nbsp;</div>
  </div>
  <div class="row">
    <div class="col-1 text-end">
      <?php
  for ($i=1; $i<=$anzteams; $i++) {
    if($i!=$selteam){?>
            <p>
                <a href="<?php echo $addp.$i?>" data-bs-toggle='tooltip' data-bs-placement='top' title="<?php echo $teams[$i]?>">
                    <?php echo HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' title='$teams[$i]'", " alt='$teamk[$i]'"); ?>
                </a>
            </p><?php
    } else {
     echo "<p>".HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' title='$teams[$i]'", " alt='$teamk[$i]'")."</p>";
    }
  }?>
    </div>
    <div class="col-11">
      <div class="container-fluid"><?php
  if ($selteam == 0) {
    echo "<div class='row'><div class='col'>".$text[24]."<br/></div></div>";
  } else {
    for($j=0;$j<$anzst;$j++) {
      for($i=0;$i<$anzsp;$i++) {
        if(($selteam==$teama[$j][$i]) || ($selteam==$teamb[$j][$i])) {
        $heim1=$heim2=$gast1=$gast2="";?>
        <div class="row"><?php
     if($datm==1) {
            if($mterm[$j][$i]>0) {
              $dum1 = datefmt_format($fmt, $mterm[$j][$i]);
              $dum2 = date("d.m.y", $mterm[$j][$i]);
            } else {
              $dum1=$dum2="";
            }?>

          <div class="col-2 text-end d-none d-lg-block"><?php echo $dum1; ?></div>
          <div class="col-2 text-end d-lg-none"><?php echo $dum2; ?></div><?php
        } ?>
          <?php
          if ($selteam==$teama[$j][$i]) {
            $heim1 = "<strong>";
          }
          //echo $teams[$teama[$j][$i]];
          if ($selteam==$teama[$j][$i]) {
            $heim2 = "</strong>";
          }
          ?>
          <div class="col-3 text-end d-none d-lg-block">
          <?php 
            echo $heim1.$teams[$teama[$j][$i]].$heim2; 
            //echo HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," style='vertical-align: middle;'"," alt='' width='24'")."&nbsp;";
          ?>
          </div>
          <div class="col-3 text-end d-lg-none">
          <?php 
            echo $heim1.$teamk[$teama[$j][$i]].$heim2; 
            //echo HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," style='vertical-align: middle;'"," alt='' width='24'")."&nbsp;";
          ?>
          </div>
          <?php
          if ($selteam==$teamb[$j][$i]) {
            $gast1 = "<strong>";
          }
          //echo $teams[$teamb[$j][$i]];
          if ($selteam==$teamb[$j][$i]) {
            $gast2 = "</strong>";
          }
          ?>

          <div class="col-3 text-start d-none d-lg-block"> -&nbsp;&nbsp;
          <?php 
            echo $gast1.$teams[$teamb[$j][$i]].$gast2; 
            //echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," style='vertical-align: middle;'"," alt='' width='24'")."&nbsp;";
          ?>
          </div>
          <div class="col-3 text-start d-lg-none"> -&nbsp;&nbsp; 
          <?php 
            echo $gast1.$teamk[$teamb[$j][$i]].$gast2; 
            //echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," style='vertical-align: middle;'"," alt='' width='24'")."&nbsp;";
          ?>
          </div>
          <div class="col-1 col-sm-auto"><?php echo applyFactor($goala[$j][$i],$goalfaktor); ?> : <?php echo applyFactor($goalb[$j][$i],$goalfaktor); ?></div><?php
          if($spez==1){ ?>
          <div class="col-1 col-sm-auto"><?php echo $mspez[$j][$i]; ?></div><?php
        }?>
          <div class="col-1 col-sm-auto"><?php
	  /** Mannschaftsicons finden */
          $lmo_teamaicon="";
          $lmo_teambicon="";
          if($urlb==1 || $mnote[$j][$i]!="" || $msieg[$j][$i]>0) {
            $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," width='24' style='vertical-align: middle;' title='".$teams[$teama[$j][$i]]."'"," alt='".$teamk[$teama[$j][$i]]."'");
            $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," width='24' style='vertical-align: middle;' title='".$teams[$teamb[$j][$i]]."'"," alt='".$teamk[$teamb[$j][$i]]."'");
          }
		  /** Spielbericht verlinken */
          if($urlb==1) {
            if($mberi[$j][$i]!="") {
              $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong><br><br>";
              echo "<a href='".$mberi[$j][$i]."' target='_blank' title='".nl2br($text[270])."'><i class='far fa-book fa-lg text-success'></i></a>";
            }else{
              echo "<img src='".URL_TO_IMGDIR."/blank.png' width='19' height='1' border='0' alt=''>";
            }
          }
          echo "&nbsp;";
          if ($mnote[$j][$i]!="" || $msieg[$j][$i]>0) {
            $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong> ".applyFactor($goala[$j][$i],$goalfaktor).":".applyFactor($goalb[$j][$i],$goalfaktor);
            //Beidseitiges Ergebnis
            if ($msieg[$j][$i]==3) {
              $lmo_spielnotiz.=" / ".applyFactor($goalb[$j][$i],$goalfaktor).":".applyFactor($goala[$j][$i],$goalfaktor);
            }
            if ($spez==1) {
              $lmo_spielnotiz.=" ".$mspez[$j][$i];
            }
			//Grüner Tisch: Heimteam siegt
            if ($msieg[$j][$i]==1) {
              $lmo_spielnotiz.=$text[219].": ".$teams[$teama[$j][$i]]." ".$text[211];
            }
			//Grüner Tisch: Gastteam siegt
            if ($msieg[$j][$i]==2) {
              $lmo_spielnotiz.=$text[219].": ".addslashes($teams[$teamb[$j][$i]]." ".$text[211]);
            }
			//Beidseitiges Ergebnis
            if ($msieg[$j][$i]==3) {
              $lmo_spielnotiz.=$text[219].": ".addslashes($text[212]);
            }
			//Allgemeine Notiz
            if ($mnote[$j][$i]!="") {
              $lmo_spielnotiz.=$text[22].": ".$mnote[$j][$i];
            }
            echo "<a data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='".$lmo_spielnotiz."'> <i class='bi bi-info-square text-info' style='font-size: 1.3rem;'></i></a>";
            $lmo_spielnotiz="";
          } else {
            echo "<img src='".URL_TO_IMGDIR."/blank.png' width='1' height='1' border='0' alt=''>";
          }
          ?></div>
          </div>
<?php     }
      }
    }
  }?>
      </div>
    </div>
  </div>
</div><?php
}?>
