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
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

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
    for ($i = 1; $i <= $ligaDaten->anzteams; $i++) {
      if ($_POST["xteams".$i] != "") {
        $ligaDaten->teams[$i] = isset($_POST["xteams".$i])?trim($_POST["xteams".$i]):'';
      }
      $ligaDaten->teamm[$i] = isset($_POST["xteamm".$i])?($_POST["xteamm".$i]):'';
      if ($ligaDaten->teamm[$i] == "") { //search longest name part an take this as middle name
        $parts = preg_split("%[ |/]%",$ligaDaten->teams[$i]);
        foreach ($parts as $part) {
          if (strlen($part) >= strlen($ligaDaten->teamm[$i])) {
            $ligaDaten->teamm[$i] = trim(substr($part, 0, 12));
          }
        }
      }
      $ligaDaten->teamk[$i] = isset($_POST["xteamk".$i])?trim($_POST["xteamk".$i]):'';
      if ($ligaDaten->teamk[$i] == "") {
        $ligaDaten->teamk[$i] = trim(substr($ligaDaten->teamm[$i], 0, 5));
      }
      $ligaDaten->teamu[$i] = isset($_POST["xteamu".$i])?trim($_POST["xteamu".$i]):'';
      $ligaDaten->teamn[$i] = isset($_POST["xteamn".$i])?trim($_POST["xteamn".$i]):'';
      if ($ligaDaten->lmtype == 0) {
        $ligaDaten->strafp[$i] = (-1) * intval($_POST["xstrafp".$i]);
        if ($ligaDaten->minus == 2) {
          $ligaDaten->strafm[$i] = (-1) * intval($_POST["xstrafm".$i]);
        }
/** Hack-Straftore */
        $ligaDaten->torkorrektur1[$i] = (-1) * intval($_POST["xtorkorrektur1".$i]);
        $ligaDaten->torkorrektur2[$i] = (-1) * intval($_POST["xtorkorrektur2".$i]);
        $ligaDaten->strafdat[$i] = intval($_POST["xstrafdat".$i]);
      }
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
  } elseif ($team != "") {
    if ($team >= 1 && $team <= $ligaDaten->anzteams) {
      if ($ligaDaten->anzteams > 4) {
        for ($i = 0; $i < $ligaDaten->anzst; $i++) {
          for ($j = 0; $j < $ligaDaten->anzsp; $j++) {
            if (($ligaDaten->teama[$i][$j] == $team) || ($ligaDaten->teamb[$i][$j] == $team)) {
              $ligaDaten->teama[$i][$j] = 0;
              $ligaDaten->teamb[$i][$j] = 0;
              $ligaDaten->goala[$i][$j] = -1;
              $ligaDaten->goalb[$i][$j] = -1;
              $ligaDaten->msieg[$i][$j] = 0;
              $ligaDaten->mterm[$i][$j] = "";
              $ligaDaten->mnote[$i][$j] = "";
              $ligaDaten->mberi[$i][$j] = "";
              if ($ligaDaten->spez == 1) {
                $ligaDaten->mspez[$i][$j] = "_";
              }
            }
          }
          for ($j = $ligaDaten->anzsp-2; $j >= 0; $j--) {
            if (($ligaDaten->teama[$i][$j] == 0) && ($ligaDaten->teamb[$i][$j] == 0) && ($ligaDaten->goala[$i][$j] == -1) && ($ligaDaten->goalb[$i][$j] == -1)) {
              for ($k = $j+1; $k < $ligaDaten->anzsp; $k++) {
                $ligaDaten->teama[$i][$k-1] = $ligaDaten->teama[$i][$k];
                $ligaDaten->teamb[$i][$k-1] = $ligaDaten->teamb[$i][$k];
                $ligaDaten->goala[$i][$k-1] = $ligaDaten->goala[$i][$k];
                $ligaDaten->goalb[$i][$k-1] = $ligaDaten->goalb[$i][$k];
                $ligaDaten->msieg[$i][$k-1] = $ligaDaten->msieg[$i][$k];
                $ligaDaten->mterm[$i][$k-1] = $ligaDaten->mterm[$i][$k];
                $ligaDaten->mnote[$i][$k-1] = $ligaDaten->mnote[$i][$k];
                $ligaDaten->mberi[$i][$k-1] = $ligaDaten->mberi[$i][$k];
                if ($ligaDaten->spez == 1) {
                  $ligaDaten->mspez[$i][$k-1] = $ligaDaten->mspez[$i][$k];
                }
              }
              $ligaDaten->teama[$i][$ligaDaten->anzsp-1] = 0;
              $ligaDaten->teamb[$i][$ligaDaten->anzsp-1] = 0;
              $ligaDaten->goala[$i][$ligaDaten->anzsp-1] = -1;
              $ligaDaten->goalb[$i][$ligaDaten->anzsp-1] = -1;
              $ligaDaten->msieg[$i][$ligaDaten->anzsp-1] = 0;
              $ligaDaten->mterm[$i][$ligaDaten->anzsp-1] = "";
              $ligaDaten->mnote[$i][$ligaDaten->anzsp-1] = "";
              $ligaDaten->mberi[$i][$ligaDaten->anzsp-1] = "";
              if ($ligaDaten->spez == 1) {
                $ligaDaten->mspez[$i][$ligaDaten->anzsp-1] = "_";
              }
            }
          }
          for ($j = 0; $j < $ligaDaten->anzsp; $j++) {
            if ($ligaDaten->teama[$i][$j] > $team) {
              $ligaDaten->teama[$i][$j]--;
            }
            if ($ligaDaten->teamb[$i][$j] > $team) {
              $ligaDaten->teamb[$i][$j]--;
            }
          }
        }
        if ($ligaDaten->favteam == $team) {
          $ligaDaten->favteam = 0;
        } elseif ($ligaDaten->favteam > $team) {
          $ligaDaten->favteam--;
        }
        if ($ligaDaten->selteam == $team) {
          $ligaDaten->selteam = 0;
        } elseif ($ligaDaten->selteam > $team) {
          $ligaDaten->selteam--;
        }
        if ($ligaDaten->stat1 == $team) {
          $ligaDaten->stat1 = $ligaDaten->stat2;
          $ligaDaten->stat2 = $team;
        } elseif ($ligaDaten->stat1 > $team) {
          $ligaDaten->stat1--;
        }
        if ($ligaDaten->stat2 == $team) {
          $ligaDaten->stat2 = 0;
        } elseif ($ligaDaten->stat2 > $team) {
          $ligaDaten->stat2--;
        }
        for ($i = $team+1; $i <= $ligaDaten->anzteams; $i++) {
          $ligaDaten->teams[$i-1] = $ligaDaten->teams[$i];
          $ligaDaten->teamm[$i-1] = $ligaDaten->teamm[$i];
          $ligaDaten->teamk[$i-1] = $ligaDaten->teamk[$i];
          $ligaDaten->teamu[$i-1] = $ligaDaten->teamu[$i];
          $ligaDaten->teamn[$i-1] = $ligaDaten->teamn[$i];
          $ligaDaten->strafp[$i-1] = $ligaDaten->strafp[$i];
          if ($ligaDaten->minus == 2) {
            $ligaDaten->strafm[$i-1] = $ligaDaten->strafm[$i];
          }
        }
        $ligaDaten->teams[$ligaDaten->anzteams] = "";
        $ligaDaten->teamm[$ligaDaten->anzteams] = "";
        $ligaDaten->teamk[$ligaDaten->anzteams] = "";
        $ligaDaten->teamu[$ligaDaten->anzteams] = "";
        $ligaDaten->teamn[$ligaDaten->anzteams] = "";
        $ligaDaten->strafp[$ligaDaten->anzteams] = 0;
        if ($ligaDaten->minus == 2) {
          $ligaDaten->strafm[$ligaDaten->anzteams] = 0;
        }
        $ligaDaten->anzteams--;
        require(PATH_TO_LMO."/lmo-savefile.php");
      }
    } elseif ($team == -1) {
      if ($ligaDaten->anzteams < 40) {
        $ligaDaten->anzteams++;
        $ligaDaten->teams[$ligaDaten->anzteams] = "Neue Mannschaft";
        $ligaDaten->teamm[$ligaDaten->anzteams] = "";
        $ligaDaten->teamk[$ligaDaten->anzteams] = "";
        $ligaDaten->teamu[$ligaDaten->anzteams] = "";
        $ligaDaten->teamn[$ligaDaten->anzteams] = "";
        $ligaDaten->strafp[$ligaDaten->anzteams] = 0;
        if ($ligaDaten->minus == 2) {
          $ligaDaten->strafm[$ligaDaten->anzteams] = 0;
        }
        require(PATH_TO_LMO."/lmo-savefile.php");
      }
    }
  }
  if ($ligaDaten->lmtype == 0) {
    $breite = 4;
  } else {
    $breite = 2;
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?php echo $ligaDaten->titel?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th class="nobr" align="left"><acronym title="<?php echo $text[125].", ".$text[572].", ".$text[126]?>"><?php echo $text[127]; ?></acronym>&nbsp;</th>
<?php
  if ($ligaDaten->lmtype==0) {
?>
            <th class="nobr" colspan="2" align="center"><acronym title="<?php echo $text[131] ?>"><?php echo $text[542]."/".$text[543]; ?></acronym>&nbsp;</th>
            <th class="nobr" align="center"><acronym title="<?php echo $text[523] ?>"><?php echo $text[524]; ?></acronym>&nbsp;</th>
<?php
  }
?>
<!-- Hack-Straftore Ende -->
<?php
  if ($ligaDaten->lmtype==0) {
/** Titel Notiz */
?>
            <th class="nobr" align="center"><acronym title="<?php echo $text[405] ?>"><img src="<?php echo URL_TO_IMGDIR;?>/notiz.svg" height="20" alt="<?php echo $text[404]; ?>"></acronym></th>
<?php
  }
/** Titel Homepage */  ?>
            <th class="nobr" align="center"><acronym title="<?php echo $text[130] ?>"><img src="<?php echo URL_TO_IMGDIR;?>/spielbericht.svg" height="20" alt="<?php echo $text[129]; ?>"></acronym></th>
            <th class="nobr" colspan="<?php echo $breite; ?>" align="center">&nbsp;</th>
          </tr>
<?php
/** Mannschftsnamen */
  for ($i=1;$i<=$ligaDaten->anzteams;$i++) {
?>
          <tr>
            <td class="nobr">
              <input class="lmo-formular-input" type="text" name="xteams<?php echo $i; ?>" size="32" maxlength="64" value="<?php echo htmlspecialchars($ligaDaten->teams[$i]); ?>" onChange="dolmoedit()">
              <input class="lmo-formular-input" type="text" name="xteamm<?php echo $i; ?>" size="12" maxlength="12" value="<?php echo htmlspecialchars($ligaDaten->teamm[$i]); ?>" onChange="dolmoedit()">
              <input class="lmo-formular-input" type="text" name="xteamk<?php echo $i; ?>" size="5" maxlength="5" value="<?php echo htmlspecialchars($ligaDaten->teamk[$i]); ?>" onChange="dolmoedit()">
              &nbsp;
            </td>
<?php
  if ($ligaDaten->lmtype==0) {
?>
            <td class="lmoBackMarkierung nobr" align="center">
              <input class="lmo-formular-input" type="text" name="xstrafp<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*$ligaDaten->strafp[$i]; ?>" onChange="dolmoedit()">
<?php
    if ($ligaDaten->minus==2) {
?>
              : <input class="lmo-formular-input" type="text" name="xstrafm<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*$ligaDaten->strafm[$i]; ?>" onChange="dolmoedit()">
<?php
    }
    echo $ligaDaten->namepkt;
?>
            </td>

            <td class="nobr" align="center">
                <input class="lmo-formular-input" type="text" name="xtorkorrektur1<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*$ligaDaten->torkorrektur1[$i]; ?>" onChange="dolmoedit()">
              : <input class="lmo-formular-input" type="text" name="xtorkorrektur2<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*$ligaDaten->torkorrektur2[$i]; ?>" onChange="dolmoedit()">
              <?php echo $ligaDaten->nametor;?>
            </td>
            <td class="nobr" align="center">

                <input class="lmo-formular-input" type="text" name="xstrafdat<?php echo $i; ?>" size="2" maxlength="2" value="<?php echo $ligaDaten->strafdat[$i]; ?>" onChange="dolmoedit()">
              &nbsp;
            </td>

<?php
  }
  if ($ligaDaten->lmtype==0) {
?>
            <td class="nobr" align="center">
              <input id="n<?php echo $i?>" class="lmo-formular-input" type="text" name="xteamn<?php echo $i; ?>" tabindex="<?php echo $i;?>13" size="20" maxlength="255" value="<?php echo htmlentities($ligaDaten->teamn[$i]); ?>" onChange="dolmoedit()">
<?php
      if (trim($ligaDaten->teamn[$i]) == '') {
?>
              <script type="text/javascript">document.getElementById('n<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
      }
?>
            </td>
<?php
    }
/** Mannschafts URL/Homepage */
?>
            <td class="nobr" align="center">
              <input id="h<?php echo $i?>" class="lmo-formular-input" type="text" name="xteamu<?php echo $i; ?>" tabindex="<?php echo $i;?>14" size="30" maxlength="255" value="<?php echo htmlentities($ligaDaten->teamu[$i]); ?>" onChange="dolmoedit()">
<?php
      if (trim($ligaDaten->teamu[$i]) == '') {
?>
              <script type="text/javascript">document.getElementById('h<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'h<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
      }
?>
            </td>
<?php
    if ($ligaDaten->lmtype==0) {
/** Mannschaft löschen */
?>
            <td class="nobr">
              <a href='<?php echo $addz.$i; ?>' onclick="return dteamlmolink(this.href,'<?php echo $ligaDaten->teams[$i]; ?>');" title="<?php echo $text[334]; ?>">
                <img src="<?php echo URL_TO_IMGDIR."/delete.svg"?>" height="18" alt="<?php $text[333];?>" border="0">
              </a>
            </td>
<?php
        }
/** Mannschaftswappen */
?>
            <td class="nobr"><?php echo HTML_smallTeamIcon($file,$ligaDaten->teams[$i]," alt=''");?></td>
            <td class="nobr"><?php echo HTML_bigTeamIcon($file,$ligaDaten->teams[$i]," alt=''");?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="nobr" colspan="<?php echo $breite; ?>" align="right">
              <input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[132]; ?>">
            </td>
<?php
    if ($ligaDaten->lmtype==0) {
?>
            <td class="nobr" colspan="<?php echo $breite; ?>">
              <a href='<?php echo $addz; ?>-1' onclick="return ateamlmolink(this.href);" title="<?php echo $text[337]; ?>"><?php echo $text[336]; ?></a>
            </td>
<?php
    }
?>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<?php
    if ($ligaDaten->lmtype==0) {
        if ($team!="") {
?>
  <tr>
    <td class="nobr">
      <a href="<?php echo $addr?>-3" onclick="return chklmolink();" title="<?php echo $text[339]?>"><?php echo $text[338]?></a>
    </td>
  </tr>
<?php
        }
    }
?>
</table>
<?php
}
?>