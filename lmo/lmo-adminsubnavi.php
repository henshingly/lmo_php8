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
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der Liga: der geladene oder gerade gespeicherte Stand
 * @var array<int|string, mixed> $text Sprachtexte
 * @var int|string $st gewaehlter Spieltag
 * @var string $todo gewaehlte Aktion (Aufrufparameter)
 *
 * Einstellungen:
 * @var int|string $einspieler Einstellung aus cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $addb
 * @var mixed $addr
 */

?>
      <table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
<?php
if ($st < 0 || $todo != 'edit') {?>
          <td align="center"><a href='<?php echo $addr; ?>1' onClick="return chklmolink();" title="<?php echo $text[411]; ?>"><?php echo $text[10]; ?></a></td>
<?php
}
else {?>
          <td align="center"><?php echo $text[10]; ?></td>
<?php
}
if ($einspieler == 1) {
    if ($st != -4) {?>
          <td align="center"><a href='<?php echo $addr; ?>-4' onClick="return chklmolink();" title="<?php echo $text['spieler'][1]; ?>"><?php echo $text['spieler'][18]; ?></a></td>
<?php
    }
    else {?>
          <td align="center"><?php echo $text['spieler'][18]; ?></td>
<?php
    }
}

if ($st != -1) {?>
          <td align="center"><a href='<?php echo $addr; ?>-1' onClick="return chklmolink();" title="<?php echo $text[100]; ?>"><?php echo $text[99]; ?></a></td>
<?php
}
else {?>
          <td align="center"><?php echo $text[99]; ?></td>
<?php
}

if ($lmo_liga->einstellungen()->mitHandicap()) {
    if ($todo != 'tabs') {?>
          <td align="center"><a href='<?php echo $addb . $lmo_liga->einstellungen()->aktuellerSpieltag(); ?>' onClick="return chklmolink();" title="<?php echo $text[409]; ?>"><?php echo $text[16]; ?></a></td>
<?php
    }
    else {?>
          <td align="center"><?php echo $text[16]; ?></td>
<?php
    }
}

if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
    if ($st != -2) {?>
          <td align="center"><a href='<?php echo $addr; ?>-2' onClick="return chklmolink();" title="<?php echo $text[102]; ?>"><?php echo $text[101]; ?></a></td>
<?php
    }
    else {?>
          <td align="center"><?php echo $text[101]; ?></td>
<?php
    }
}

if ($st!=-10) {?>
          <td align="center"><a href='<?php echo $addr; ?>-10' onclick="return chklmolink(this.href);" title="<?php echo $text[5002]; ?>"><?php echo $text[5001]; ?></a></td>
<?php
}
else {?>
          <td align="center"><?php echo $text[5001]; ?></td>
<?php
}?>
        </tr>
      </table>
