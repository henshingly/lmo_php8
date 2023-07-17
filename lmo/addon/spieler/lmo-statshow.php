<?php
/* Liga Manager Online 4
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

require_once(dirname(__FILE__) . '/../../init.php');

//Konfiguration laden
require(PATH_TO_ADDONDIR . '/spieler/lmo-statloadconfig.php');

$sort = isset($_GET['sort'])? $_GET['sort']: $spieler_standard_sortierung;
$begin = isset($_GET['begin'])? $_GET['begin']: 0;
$direction = isset($_GET['direction'])? $_GET['direction']: $spieler_standard_richtung;
$team = !empty($_GET['team'])? urldecode($_GET['team']): '';

if (is_readable($filename) && $filepointer = fopen($filename, "r+b")) {
    $spalten = array(); //Spaltenbezeichnung
    $data = array(); //Daten
    $typ = array(); //Spaltentyp (true=String)
    $spalten = fgetcsv($filepointer, 10000, "#"); //Zeile mit Spaltenbezeichnern
    $formel = false;
    for ($i = 0; $i < count($spalten); $i++) {
        if (strstr($spalten[$i], "*_*-*")) {
            $formel = true;
            $spalten[$i] = substr($spalten[$i], 0, strlen($spalten[$i]) - 5);
        }
        if ($spalten[$i] == $text['spieler'][25]) {
            $vereinsspalte = $i;
        }
    }
    if ($formel) fgetcsv($filepointer, 10000, "#"); //Zeile mit Formeln

    $linkspalte = array_search($text['spieler'][32], $spalten); //Linkunterstützung aktiviert?

    $zeile = 0;
    while ($data[$zeile] = fgetcsv ($filepointer, 10000, "#")) {
        if ((isset($vereinsspalte) && isset($data[$zeile][$vereinsspalte]) && $spieler_vereinsweise_anzeigen == 1 && $team == $data[$zeile][$vereinsspalte]) || $team == '') {
            for($i = 0; $i < count($data[$zeile]); $i++) {
                if (!is_numeric($data[$zeile][$i])) $typ[$i] = true;
            }
            $zeile++;
        } else {
            array_pop($data);
        }
    }
    array_pop($data);
    if ($spieler_nullwerte_anzeigen == 0 && !isset($typ[$sort])) $data = array_filter($data, 'filterNullwerte'); //Nullwerte ausfiltern
    if ($direction == 1) {
        if (!isset($typ[$sort])) usort($data, 'cmpInt');
        else usort($data, 'cmpStr2');
    } else {
        if (!isset($typ[$sort])) usort($data, 'cmpInt2');
        else usort($data, 'cmpStr');
    }

    $spaltenzahl = count($spalten);

    if ($begin+$spieler_anzeige_pro_seite > $zeile) $maxdisplay = $zeile-$begin;
      else $maxdisplay = $spieler_anzeige_pro_seite;
    if ($spieler_anzeige_pro_seite <= 0) {
        $maxdisplay = $zeile;
        $begin = 0;
    }
?>
<table class="lmoMiddle">
  <tr><?php
    if ($spieler_vereinsweise_anzeigen == 1) { ?>
    <td valign="top" align="center">
      <table class="lmoMenu">
        <tr>
          <td align="right" class="nobr"><?php
        if ($team != '') { ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction";?>"><?php
        }
        echo $text['spieler'][51];
        if ($team != '') { ?></a><?php
        }?>
          </td>
          <td align="right"><?php
        if (file_exists(PATH_TO_IMGDIR . "/spieler/" . $text['spieler'][51] . ".gif")) {
            $imgdata = getimagesize(PATH_TO_IMGDIR . "/spieler/" . $text['spieler'][51] . ".gif");?>
            <img title="<?php echo $t?>" border="0" src="<?php echo URL_TO_IMGDIR . "/spieler/" . rawurlencode($text['spieler'][51]) . ".gif"?>" <?php echo $imgdata[3]?> alt=""><?php
        }?>
          </td>
        </tr><?php
        //Vereinsspalte
        for($i = 0; $i < count($teams) - 1; $i++) {
            $teams[$i] = stripslashes($teams[$i]);?>
        <tr>
          <td align="right" class="nobr"><?php
            if ($teams[$i] != $team) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction&amp;team=" . $teams[$i];?>"><?php
            }
            echo $teamk[$i];
            if ($teams[$i] != $team) { ?></a><?php
            }?>
          </td>
          <td align="right"><?php echo HTML_smallTeamIcon($file, $teams[$i], " alt=''"); ?></td>
        </tr><?php
        }?>
      </table>
    </td><?php
    }?>
    <td  valign="top">
      <table id="stats" class="lmoInner" cellpadding="0" cellspacing="1" border="0">
        <thead>
          <tr>
            <th></th>
            <th></th><?php
    for ($i = 0; $i < $spaltenzahl; $i++) {
        if ($spalten[$i] != $text['spieler'][32]) { ?>
            <th class="nobr" align="center"><?php
            if ($spieler_extra_sortierspalte == 0) {
                ?><a href="<?php
                echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=1&amp;team=$team";?>" title="<?php echo $text['spieler'][36] . " " . $spalten[$i]." " . $text['spieler'][48] . " " . $text['spieler'][37]?>"><img title="<?php echo $text['spieler'][48]?>" border="0" src="<?php echo URL_TO_IMGDIR . "/downsimple.png"?>" width="8" height="7" alt="&or;"></a><?php
            }
            if (file_exists(PATH_TO_IMGDIR . "/spieler/" . $spalten[$i] . ".gif")) {
                echo "&nbsp;<acronym title='" . $spalten[$i] . "'><img border='0' src='" . URL_TO_IMGDIR . "/spieler/" . rawurlencode($spalten[$i]) . ".gif' alt='" . $spalten[$i] . "'></acronym>&nbsp;";
            } else {
                echo "&nbsp;" . $spalten[$i] . "&nbsp;";
            }
            if ($spieler_extra_sortierspalte == 0) {
                ?><a href="<?php
                echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=0&amp;sort=$i&amp;direction=0&amp;team=$team";?>" title="<?php echo $text['spieler'][36] . " " . $spalten[$i] . " " . $text['spieler'][47] . " " . $text['spieler'][37]?>"><img title="<?php echo $text['spieler'][47]?>" border="0" src="<?php echo URL_TO_IMGDIR . "/upsimple.png"?>"  width="8" height="7"  alt="&and;"></a><?php
            }?>
            </th><?php
        }
    }?>
          </tr>
        </thead><?php
    if ($spieler_anzeige_pro_seite > 0) { ?>
        <tfoot>
          <tr>
            <th colspan="<?php echo $spaltenzahl + 2?>" align="center"><?php
        if ($begin == 0) {

        } elseif (($newbegin = $begin - $spieler_anzeige_pro_seite) >= 0) {
            ?><a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>">«&nbsp;<?php echo $text['spieler'][16]?></a><?php
        } else {
            ?><a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=0&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>">«&nbsp;<?php echo $text['spieler'][16]?></a><?php
        }
        $newbegin = 0;
        ?>&nbsp;|&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>"><?php echo $text['spieler'][17]?>&nbsp;<?php echo $spieler_anzeige_pro_seite?></a>&nbsp;|&nbsp;<?php
        if (($newbegin = $begin + $maxdisplay) < $zeile) {
            ?><a href="<?php echo $_SERVER['PHP_SELF'] . "?file=$file&amp;action=$action&amp;begin=$newbegin&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>"><?php echo $text['spieler'][15]?>&nbsp;»</a><?php
        }?>
            </th>
          </tr>
        </tfoot><?php
    }?>
        <tbody><?php
    for ($j1 = $begin; $j1 < $begin + $maxdisplay; $j1++) { ?>
          <tr><?php
        for ($j2 = 0; $j2 < $spaltenzahl; $j2++) {
            $data[$j1][$j2] = stripslashes($data[$j1][$j2]);
            if ($j2 == $sort) {
                $stat_class=' class="lmoBackMarkierung nobr"';
            } else {
                $stat_class=' class="nobr"';
            }
            if ($j2 == 0) {
                ?><td align="right" class="lmoBackMarkierung"><strong><?php
                if (!isset($data[$j1 - 1][$sort]) || $data[$j1][$sort] !== $data[$j1 - 1][$sort] && $j1 != $begin) echo ($j1 + 1) . ". ";

                if ($j1 > 0 && $j1 == $begin) {
                    for ($x = $begin - 1; $x >= 0; $x--) {
                        if ($data[$x][$sort] != $data[$j1][$sort]) {
                            echo ($x + 2) . ". ";
                            break;
                        }
                        if ($x == 0) echo "1. ";
                    }
                }?>
            </strong></td>
            <td align="left" class="lmoBackMarkierung"><?php
                //Spielerbild
                echo  HTML_icon($data[$j1][$j2], 'spieler', ''); ?>
            </td><?php
            } ?>
            <td <?php
            echo $stat_class;

            //Vereinslinks
            if ($spalten[$j2] == $text['spieler'][25]) {
                echo " align='center'>";
                $pos = array_search($data[$j1][$j2], $teamu);
                echo getSmallImage($data[$j1][$j2], "&nbsp;" . str_replace(" ", "&nbsp;", $data[$j1][$j2]) . "&nbsp;");
                if(!empty($pos) && $teamu[$pos] != "" && $urlt == 1) {echo "<a href=\"" . $teamu[$pos] . "\" target=\"_blank\" title=\"" . $text[46] . "\"><img border='0' width='11' src='" . URL_TO_IMGDIR . "/url.png' alt='" . $text[564] . "' title=\"" . $text[46] . "\"></a>";}

            //Spielerlinks
            } elseif ($j2 == 0 && !is_null($linkspalte) && $linkspalte!==false && $data[$j1][$linkspalte] != $text['spieler'][43]) {
                echo " align='left'>&nbsp;".$data[$j1][$j2];
                echo " <a href='" . $data[$j1][$linkspalte] . "' title='" . $text['spieler'][34] . "'><img border='0' width='11' src='" . URL_TO_IMGDIR . "/url.png' alt='" . $text[564] . "'></a>";

            //sonst. Spalten
            } elseif ($spalten[$j2] != $text['spieler'][32]) {
                if (is_numeric($data[$j1][$j2])) {
                    echo " align='center'>";
                } else {
                    echo " align='left'>";
                }
                echo  "&nbsp;".str_replace(" ", "&nbsp;", $data[$j1][$j2]) . "&nbsp;";
            }?></td><?php
        }?>
          </tr><?php
    }?>
        </tbody>
      </table>
    </td><?php
    if ($spieler_extra_sortierspalte == 1) { ?>
    <td valign="top" align="center">
      <table class="lmoMenu">
        <tr>
          <td class="lmost4"><?php echo $text['spieler'][13]?></td>
        </tr><?php
        for ($i = 0;$i < $spaltenzahl;$i++) { ?>
        <tr>
          <td class="nobr">
            <a href="<?php echo $_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$begin&amp;sort=$i&amp;direction=1&amp;team=$team";?>">
              <img title="<?php echo $text['spieler'][48]?>" border="0" src="<?php echo URL_TO_IMGDIR . "/downsimple.png"?>" alt="&or;" height="7" width="8">
            </a> <?php echo $spalten[$i]?>
            <a href="<?php echo $_SERVER['PHP_SELF']."?file=$file&amp;action=$action&amp;begin=$begin&amp;sort=$i&amp;direction=0&amp;team=$team";?>">
              <img title="<?php echo $text['spieler'][47]?>" border="0" src="<?php echo URL_TO_IMGDIR . "/upsimple.png"?>" alt="&and;" height="7" width="8">
            </a>
          </td>
        </tr><?php
        }?>
      </table>
    </td><?php
    }?>
  </tr>
</table>
<table width="99%">
  <tr>
    <td align="center">
      <a href="<?php echo URL_TO_ADDONDIR . jhztgtz"/spieler/lmo-statprint.php?file=$file&amp;begin=$begin&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>"><?php echo $text['spieler'][56]?></a>
    </td><?php
    if ($spieler_anzeige_pro_seite != 0) { ?>
    <td align="center">
      <a href="<?php echo URL_TO_ADDONDIR . "/spieler/lmo-statprint.php?file=$file&amp;sort=$sort&amp;direction=$direction&amp;team=$team";?>"><?php echo $text['spieler'][57]?></a>
    </td><?php
    }?>
  </tr>
</table><?php
} else { ?>
    <?php echo getMessage($text['spieler'][14], true);?><?php
}

function cmpInt ($a1, $a2) {
    global $sort;
    if ($a2[$sort] == $a1[$sort]) return 0;
    return ($a1[$sort] > $a2[$sort]) ? -1 : 1;
}

function cmpStr ($a2, $a1) {
    global $sort;
    $a1[$sort] = strtr($a1[$sort], "¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    $a2[$sort] = strtr($a2[$sort], "¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    $c = strnatcasecmp($a2[$sort], $a1[$sort]);
    return $c;
}

function cmpInt2 ($a1, $a2) {
    global $sort;
    if ($a2[$sort] == $a1[$sort]) return 0;
    return ($a1[$sort]>$a2[$sort]) ? 1 : -1;
}

function cmpStr2 ($a2, $a1) {
    global $sort;
    $a1[$sort] = strtr($a1[$sort], "¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    $a2[$sort] = strtr($a2[$sort], "¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    $c = strnatcasecmp($a2[$sort], $a1[$sort]);
    return -1*$c;
}

function filterNullwerte ($a) {
    global $sort, $zeile;
    if ($a[$sort] == 0) $zeile--;
    return ($a[$sort] != 0);
}
?>