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

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
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
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_pokal = $lmo_einstellungen->istPokal();
  $lmo_mannschaften = $lmo_einstellungen->mannschaften();
  if ($save == 1) {
    for ($i = 1; $i <= $lmo_mannschaften; $i++) {
      $lmo_mannschaft = $lmo_liga->mannschaft($i);
      // ein leer gelassener Name bleibt der bisherige
      if ($_POST["xteams".$i] != "") {
        $lmo_mannschaft->name = isset($_POST["xteams".$i])?trim($_POST["xteams".$i]):'';
      }
      $lmo_name = $lmo_mannschaft->anzeigename();
      $lmo_mittel = isset($_POST["xteamm".$i])?($_POST["xteamm".$i]):'';
      if ($lmo_mittel == "") { //search longest name part an take this as middle name
        $parts = preg_split("%[ |/]%",$lmo_name);
        foreach ($parts as $part) {
          if (strlen($part) >= strlen($lmo_mittel)) {
            $lmo_mittel = trim(substr($part, 0, 12));
          }
        }
      }
      $lmo_mannschaft->mittel = $lmo_mittel;
      $lmo_mannschaft->kurz = isset($_POST["xteamk".$i])?trim($_POST["xteamk".$i]):'';
      if ($lmo_mannschaft->kurz == "") {
        $lmo_mannschaft->kurz = trim(substr($lmo_mittel, 0, 5));
      }
      $lmo_mannschaft->setzeUrl(isset($_POST["xteamu".$i])?trim($_POST["xteamu".$i]):'');
      $lmo_mannschaft->setzeNotiz(isset($_POST["xteamn".$i])?trim($_POST["xteamn".$i]):'');
      if (!$lmo_pokal) {
        // im Formular zaehlt ein Bonus positiv, in der Datei steht er mit umgekehrtem Vorzeichen
        $lmo_mannschaft->setzeStrafpunkte((-1) * intval($_POST["xstrafp".$i]));
        if ($lmo_einstellungen->mitMinuspunkten()) {
          $lmo_mannschaft->setzeStrafminuspunkte((-1) * intval($_POST["xstrafm".$i]));
        }
        $lmo_mannschaft->setzeTorkorrektur((-1) * intval($_POST["xtorkorrektur1".$i]), (-1) * intval($_POST["xtorkorrektur2".$i]));
        $lmo_mannschaft->setzeStrafeAbSpieltag(intval($_POST["xstrafdat".$i]));
      }
    }
    require(PATH_TO_LMO."/lmo-saveliga.php");
  } elseif ($team != "") {
    if ($team >= 1 && $team <= $lmo_mannschaften) {
      // eine Liga behaelt mindestens vier Mannschaften
      if ($lmo_mannschaften > 4) {
        $lmo_liga->entferneMannschaft((int)$team);
        require(PATH_TO_LMO."/lmo-saveliga.php");
      }
    } elseif ($team == -1) {
      if ($lmo_mannschaften < 40) {
        $lmo_liga->neueMannschaft("Neue Mannschaft");
        require(PATH_TO_LMO."/lmo-saveliga.php");
      }
    }
  }
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_mannschaften = $lmo_einstellungen->mannschaften();
  if (!$lmo_pokal) {
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
    <td align="center"><h1><?php echo $lmo_einstellungen->name()?></h1></td>
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
  if (!$lmo_pokal) {
?>
            <th class="nobr" colspan="2" align="center"><acronym title="<?php echo $text[131] ?>"><?php echo $text[542]."/".$text[543]; ?></acronym>&nbsp;</th>
            <th class="nobr" align="center"><acronym title="<?php echo $text[523] ?>"><?php echo $text[524]; ?></acronym>&nbsp;</th>
<?php
  }
?>
<!-- Hack-Straftore Ende -->
<?php
  if (!$lmo_pokal) {
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
  for ($i=1;$i<=$lmo_mannschaften;$i++) {
    $lmo_mannschaft = $lmo_liga->mannschaften[$i] ?? new \Lmo\Liga\Rohdaten\Mannschaft();
    $lmo_notiz = $lmo_mannschaft->werte['NOT'] ?? '';
    $lmo_url = $lmo_mannschaft->werte['URL'] ?? '';
?>
          <tr>
            <td class="nobr">
              <input class="lmo-formular-input" type="text" name="xteams<?php echo $i; ?>" size="32" maxlength="64" value="<?php echo htmlspecialchars($lmo_mannschaft->anzeigename()); ?>" onChange="dolmoedit()">
              <input class="lmo-formular-input" type="text" name="xteamm<?php echo $i; ?>" size="12" maxlength="12" value="<?php echo htmlspecialchars($lmo_mannschaft->mittelname()); ?>" onChange="dolmoedit()">
              <input class="lmo-formular-input" type="text" name="xteamk<?php echo $i; ?>" size="5" maxlength="5" value="<?php echo htmlspecialchars($lmo_mannschaft->kurzname()); ?>" onChange="dolmoedit()">
              &nbsp;
            </td>
<?php
  if (!$lmo_pokal) {
?>
            <td class="lmoBackMarkierung nobr" align="center">
              <input class="lmo-formular-input" type="text" name="xstrafp<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*(int)($lmo_mannschaft->werte['SP'] ?? 0); ?>" onChange="dolmoedit()">
<?php
    if ($lmo_einstellungen->mitMinuspunkten()) {
?>
              : <input class="lmo-formular-input" type="text" name="xstrafm<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*(int)($lmo_mannschaft->werte['SM'] ?? 0); ?>" onChange="dolmoedit()">
<?php
    }
    echo $text[37];
?>
            </td>

            <td class="nobr" align="center">
                <input class="lmo-formular-input" type="text" name="xtorkorrektur1<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*(int)($lmo_mannschaft->werte['TOR1'] ?? 0); ?>" onChange="dolmoedit()">
              : <input class="lmo-formular-input" type="text" name="xtorkorrektur2<?php echo $i; ?>" size="1" maxlength="4" value="<?php echo (-1)*(int)($lmo_mannschaft->werte['TOR2'] ?? 0); ?>" onChange="dolmoedit()">
              <?php echo $text[38];?>
            </td>
            <td class="nobr" align="center">

                <input class="lmo-formular-input" type="text" name="xstrafdat<?php echo $i; ?>" size="2" maxlength="2" value="<?php echo $lmo_mannschaft->werte['STDA'] ?? '0'; ?>" onChange="dolmoedit()">
              &nbsp;
            </td>

<?php
  }
  if (!$lmo_pokal) {
?>
            <td class="nobr" align="center">
              <input id="n<?php echo $i?>" class="lmo-formular-input" type="text" name="xteamn<?php echo $i; ?>" tabindex="<?php echo $i;?>13" size="20" maxlength="255" value="<?php echo htmlentities($lmo_notiz); ?>" onChange="dolmoedit()">
<?php
      if (trim($lmo_notiz) == '') {
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
              <input id="h<?php echo $i?>" class="lmo-formular-input" type="text" name="xteamu<?php echo $i; ?>" tabindex="<?php echo $i;?>14" size="30" maxlength="255" value="<?php echo htmlentities($lmo_url); ?>" onChange="dolmoedit()">
<?php
      if (trim($lmo_url) == '') {
?>
              <script type="text/javascript">document.getElementById('h<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'h<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
      }
?>
            </td>
<?php
    if (!$lmo_pokal) {
/** Mannschaft löschen */
?>
            <td class="nobr">
              <a href='<?php echo $addz.$i; ?>' onclick="return dteamlmolink(this.href,'<?php echo $lmo_mannschaft->anzeigename(); ?>');" title="<?php echo $text[334]; ?>">
                <img src="<?php echo URL_TO_IMGDIR."/delete.svg"?>" height="18" alt="<?php $text[333];?>" border="0">
              </a>
            </td>
<?php
        }
/** Mannschaftswappen */
?>
            <td class="nobr"><?php echo HTML_smallTeamIcon($file,$lmo_mannschaft->anzeigename()," alt=''");?></td>
            <td class="nobr"><?php echo HTML_bigTeamIcon($file,$lmo_mannschaft->anzeigename()," alt=''");?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="nobr" colspan="<?php echo $breite; ?>" align="right">
              <input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[132]; ?>">
            </td>
<?php
    if (!$lmo_pokal) {
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
    if (!$lmo_pokal) {
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