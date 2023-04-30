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

require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "" && ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert']==1)) {
    //require_once(PATH_TO_LMO."/lmo-adminopenfile.php");
    require_once(PATH_TO_LMO."/lmo-openfile.php");
  if (!isset($team)) {
    $team = "";
  }
  if (!isset($save)) {
    $save = 0;
  }
  if ($save == 1) {
    for($i = 1; $i <= $anzteams; $i++) {
      if ($_POST["xteams".$i] != "") {
        $teams[$i] = isset($_POST["xteams".$i])?trim($_POST["xteams".$i]):'';
      }
      $teamm[$i] = isset($_POST["xteamm".$i])?($_POST["xteamm".$i]):'';
      if ($teamm[$i] == "") { //search longest name part an take this as middle name
        $parts = preg_split("%[ |/]%",$teams[$i]);
        foreach ($parts as $part) {
          if (strlen($part) >= strlen($teamm[$i])) {
            $teamm[$i] = trim(substr($part, 0, 12));
          }
        }
      }
      $teamk[$i] = isset($_POST["xteamk".$i])?trim($_POST["xteamk".$i]):'';
      if ($teamk[$i] == "") {
        $teamk[$i] = trim(substr($teamm[$i], 0, 5));
      }
      $teamu[$i] = isset($_POST["xteamu".$i])?trim($_POST["xteamu".$i]):'';
      $teamn[$i] = isset($_POST["xteamn".$i])?trim($_POST["xteamn".$i]):'';
      if ($lmtype == 0) {
        $strafp[$i] = (-1) * intval($_POST["xstrafp".$i]);
        if ($minus == 2) {
          $strafm[$i] = (-1) * intval($_POST["xstrafm".$i]);
        }
/** Hack-Straftore */
        $torkorrektur1[$i] = (-1) * intval($_POST["xtorkorrektur1".$i]);
        $torkorrektur2[$i] = (-1) * intval($_POST["xtorkorrektur2".$i]);
        $strafdat[$i] = intval($_POST["xstrafdat".$i]);
      }
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
  } elseif ($team != "") {
    if ($team >= 1 && $team <= $anzteams) {
      if ($anzteams > 4) {
        for ($i = 0; $i < $anzst; $i++) {
          for ($j = 0; $j < $anzsp; $j++) {
            if (($teama[$i][$j] == $team) || ($teamb[$i][$j] == $team)) {
              $teama[$i][$j] = 0;
              $teamb[$i][$j] = 0;
              $goala[$i][$j] = -1;
              $goalb[$i][$j] = -1;
              $msieg[$i][$j] = 0;
              $mterm[$i][$j] = "";
              $mnote[$i][$j] = "";
              $mberi[$i][$j] = "";
              if ($spez == 1) {
                $mspez[$i][$j] = "_";
              }
            }
          }
          for ($j = $anzsp-2; $j >= 0; $j--) {
            if (($teama[$i][$j] == 0) && ($teamb[$i][$j] == 0) && ($goala[$i][$j] == -1) && ($goalb[$i][$j] == -1)) {
              for ($k = $j+1; $k < $anzsp; $k++) {
                $teama[$i][$k-1] = $teama[$i][$k];
                $teamb[$i][$k-1] = $teamb[$i][$k];
                $goala[$i][$k-1] = $goala[$i][$k];
                $goalb[$i][$k-1] = $goalb[$i][$k];
                $msieg[$i][$k-1] = $msieg[$i][$k];
                $mterm[$i][$k-1] = $mterm[$i][$k];
                $mnote[$i][$k-1] = $mnote[$i][$k];
                $mberi[$i][$k-1] = $mberi[$i][$k];
                if ($spez == 1) {
                  $mspez[$i][$k-1] = $mspez[$i][$k];
                }
              }
              $teama[$i][$anzsp-1] = 0;
              $teamb[$i][$anzsp-1] = 0;
              $goala[$i][$anzsp-1] = -1;
              $goalb[$i][$anzsp-1] = -1;
              $msieg[$i][$anzsp-1] = 0;
              $mterm[$i][$anzsp-1] = "";
              $mnote[$i][$anzsp-1] = "";
              $mberi[$i][$anzsp-1] = "";
              if ($spez == 1) {
                $mspez[$i][$anzsp-1] = "_";
              }
            }
          }
          for ($j = 0; $j < $anzsp; $j++) {
            if ($teama[$i][$j] > $team) {
              $teama[$i][$j]--;
            }
            if ($teamb[$i][$j] > $team) {
              $teamb[$i][$j]--;
            }
          }
        }
        if ($favteam == $team) {
          $favteam = 0;
        } elseif ($favteam > $team) {
          $favteam--;
        }
        if ($selteam == $team) {
          $selteam = 0;
        } elseif ($selteam > $team) {
          $selteam--;
        }
        if ($stat1 == $team) {
          $stat1 = $stat2;
          $stat2 = $team;
        } elseif ($stat1 > $team) {
          $stat1--;
        }
        if ($stat2 == $team) {
          $stat2 = 0;
        } elseif($stat2 > $team) {
          $stat2--;
        }
        for ($i = $team+1; $i <= $anzteams; $i++) {
          $teams[$i-1] = $teams[$i];
          $teamm[$i-1] = $teamm[$i];
          $teamk[$i-1] = $teamk[$i];
          $teamu[$i-1] = $teamu[$i];
          $teamn[$i-1] = $teamn[$i];
          $strafp[$i-1] = $strafp[$i];
          if ($minus == 2) {
            $strafm[$i-1] = $strafm[$i];
          }
        }
        $teams[$anzteams] = "";
        $teamm[$anzteams] = "";
        $teamk[$anzteams] = "";
        $teamu[$anzteams] = "";
        $teamn[$anzteams] = "";
        $strafp[$anzteams] = 0;
        if ($minus == 2) {
          $strafm[$anzteams] = 0;
        }
        $anzteams--;
        require(PATH_TO_LMO."/lmo-savefile.php");
      }
    } elseif ($team == -1) {
      if ($anzteams < 40) {
        $anzteams++;
        $teams[$anzteams] = "Neue Mannschaft";
        $teamm[$anzteams] = "";
        $teamk[$anzteams] = "";
        $teamu[$anzteams] = "";
        $teamn[$anzteams] = "";
        $strafp[$anzteams] = 0;
        if ($minus == 2) {
          $strafm[$anzteams] = 0;
        }
        require(PATH_TO_LMO."/lmo-savefile.php");
      }
    }
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
  
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");
?>

<div class="container">
  <div class="row pt-3">
    <div class="col d-flex justify-content-center"><h1><?php echo $titel;?></h1></div>
  </div>
  <div class="row">
    <div class="col">
      <form name="lmoedit" class="row" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">

          <div class="row">
            <div class="col-4"><acronym title="<?php echo $text[125].", ".$text[572].", ".$text[126]?>"><?php echo $text[127]; ?></acronym></div>
<?php
  if ($lmtype==0) {
?>
            <div class="col-1 small"><acronym title="<?php echo $text[131] ?>"><?php echo $text[542]."/".$text[543]; ?></acronym></div>
            <div class="col-2 small"><acronym title="<?php echo $text[580] ?>"><?php echo $text[542]."/".$text[543]; ?></acronym></div>
            <div class="col-1 small"><acronym title="<?php echo $text[523] ?>"><?php echo $text[524]; ?></acronym></div>
<?php
  }
?>
<?php
  if ($lmtype==0) {
/** Titel Notiz */
?>
            <div class="col-auto"><acronym title="<?php echo $text[405] ?>"><i class="bi bi-info-circle-fill text-info" style="font-size: 1.3rem;"></i></acronym></div>
<?php
  }
/** Titel Homepage */  ?>
            <div class="col-auto"><acronym title="<?php echo $text[130] ?>"><i class="bi bi-box-arrow-up-right text-warning" style="font-size: 1.3rem;"></i></acronym></div>
          </div>
<?php
/** Mannschaftsnamen */
	for ($i=1;$i<=$anzteams;$i++) { 
?>
          <div class="row p-1">
            <div class="col-4">     
                <input class="custom-control" type="text" name="xteams<?php echo $i; ?>" size="18" maxlength="64" value="<?php echo htmlspecialchars($teams[$i]); ?>" placeholder="<?php echo $text[577] ?>" onChange="dolmoedit()">
                <input class="custom-control" type="text" name="xteamm<?php echo $i; ?>" size="10" maxlength="12" value="<?php echo htmlspecialchars($teamm[$i]); ?>" placeholder="<?php echo $text[578] ?>" onChange="dolmoedit()">
                <input class="custom-control" type="text" name="xteamk<?php echo $i; ?>" size="1" maxlength="5" value="<?php echo htmlspecialchars($teamk[$i]); ?>" placeholder="<?php echo $text[579] ?>" onChange="dolmoedit()">
            </div>
<?php
	if ($lmtype==0) { 
?>
            <div class="col-1">
            	<input class="custom-control" name="xstrafp<?php echo $i; ?>" style="width: 3rem;" maxlength="4" value="<?php echo (-1)*$strafp[$i]; ?>" onChange="dolmoedit()">
<?php  
		if ($minus==2) { 
?>
              : <input class="custom-control" name="xstrafm<?php echo $i; ?>" style="width: 3rem;"  maxlength="4" value="<?php echo (-1)*$strafm[$i]; ?>" onChange="dolmoedit()">
<?php  
		} 
  	//echo $namepkt;
?>
            </div>

  	    <div class="col-2">
                <input class="custom-control" name="xtorkorrektur1<?php echo $i; ?>" style="width: 3rem;" maxlength="4" value="<?php echo (-1)*$torkorrektur1[$i]; ?>" onChange="dolmoedit()">
              : <input class="custom-control" name="xtorkorrektur2<?php echo $i; ?>" style="width: 3rem;" maxlength="4" value="<?php echo (-1)*$torkorrektur2[$i]; ?>" onChange="dolmoedit()">
              <?php //echo $nametor;?>
            </div>
  	     <div class="col-1">
                <input class="custom-control" name="xstrafdat<?php echo $i; ?>" style="width: 3rem;" maxlength="2" value="<?php echo $strafdat[$i]; ?>" onChange="dolmoedit()">
              &nbsp;
            </div>

<?php
		} 
		if ($lmtype==0) { 
?>
            <div class="col-auto">
              <input id="n<?php echo $i?>" class="custom-control" type="text" name="xteamn<?php echo $i; ?>" tabindex="<?php echo $i;?>13" size="13" maxlength="255" value="<?php echo htmlentities($teamn[$i]); ?>" onChange="dolmoedit()">         
<?php      
			if (trim($teamn[$i]) == '') {
?>
              <script type="text/javascript">document.getElementById('n<?php echo $i?>').style.display='none';document.write('<a href="#" class="none" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php   
			}
?>             
            </div>
<?php
		} 
/** Mannschafts URL/Homepage */
?>
            <div class="col-auto">
              <input id="h<?php echo $i?>" class="custom-control" type="text" name="xteamu<?php echo $i; ?>" tabindex="<?php echo $i;?>14" size="13" maxlength="255" value="<?php echo htmlentities($teamu[$i]); ?>" onChange="dolmoedit()">
<?php      
			if (trim($teamu[$i]) == '') {
?>
              <script type="text/javascript">document.getElementById('h<?php echo $i?>').style.display='none';document.write('<a href="#" class="none" onClick="this.style.display=\'none\';document.getElementById(\'h<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php   
			}
?>
            </div>
<?php
		if ($lmtype==0) { 
/** Mannschaft löschen */
?>
            <div class="col-auto">
              <a href='<?php echo $addz.$i; ?>' onclick="return dteamlmolink(this.href,'<?php echo $teams[$i]; ?>');" class="btn btn-danger btn-sm" title="<?php echo $text[334]; ?>"><i class="bi bi-trash"></i></a>
            </div>
<?php
		} 
/** Mannschaftswappen */
?>
            <div class="col-1"><?php echo HTML_smallTeamIcon($file,$teams[$i]," alt='' width='24'");?></div>
          </div>
<?php
	} 
?>
          <div class="row p-3">
            <div class="col-6 text-start">
              <input title="<?php echo $text[114] ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo $text[132]; ?>" />
            </div>
<?php
	if ($lmtype==0) { 
?>
            <div class="col-4 text-end">
              <a class='btn btn-sm btn-success' role='button' href='<?php echo $addz; ?>-1' onclick="return ateamlmolink(this.href);" title="<?php echo $text[337]; ?>"><?php echo $text[336]; ?></a>
            </div>
<?php
	} 
?>
          </div>

      </form>
    </div>
  </div>
<?php
	if ($lmtype==0) { 
		if ($team!="") {
?>
  <<div class="row p-3">
    <div class="col">
      <a href="<?php echo $addr?>-3" onclick="return chklmolink();" title="<?php echo $text[339]?>"><?php echo $text[338]?></a>
    </div>
  </div>
<?php
		}
	} 
?>
</div>
<?php
}
?>