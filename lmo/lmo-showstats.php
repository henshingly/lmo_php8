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
 * @var string|null $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $einzustats Einstellung aus cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $agastsieg
 * @var mixed $agastsieg1
 * @var mixed $agastsiegtor
 * @var mixed $agastsiegtor1
 * @var mixed $aheimsieg
 * @var mixed $aheimsieg1
 * @var mixed $aheimsiegtor
 * @var mixed $aheimsiegtor1
 * @var mixed $akt_sieglos
 * @var mixed $akt_unentschieden
 * @var mixed $akt_ungeschlagen
 * @var mixed $akt_verloren
 * @var array<int|string, mixed> $atore
 * @var mixed $counteranz
 * @var mixed $counteranz1
 * @var mixed $counteranz5
 * @var mixed $dsgasttore
 * @var mixed $dsheimtore
 * @var array<int|string, mixed> $etore
 * @var mixed $gbeide
 * @var mixed $gdstore
 * @var mixed $ggasttore
 * @var mixed $gheimtore
 * @var mixed $gzusieg1
 * @var mixed $gzusieg2
 * @var mixed $gzutore
 * @var mixed $gzuunent
 * @var mixed $hgastsieg
 * @var mixed $hgastsieg1
 * @var mixed $hgastsiegtor
 * @var mixed $hgastsiegtor1
 * @var mixed $hheimsieg
 * @var mixed $hheimsieg1
 * @var mixed $hheimsiegtor
 * @var mixed $hheimsiegtor1
 * @var mixed $htorreichm1
 * @var mixed $htorreichm2
 * @var mixed $htorreichm3
 * @var mixed $htorreichm4
 * @var mixed $htorreicht1
 * @var mixed $htorreicht2
 * @var mixed $htorreicht3
 * @var mixed $htorreicht4
 * @var mixed $max_gewonnen
 * @var mixed $max_sieglos
 * @var mixed $max_unentschieden
 * @var mixed $max_ungeschlagen
 * @var mixed $max_verloren
 * @var array<int|string, mixed> $maxn0
 * @var array<int|string, mixed> $maxs0
 * @var array<int|string, mixed> $negativ
 * @var array<int|string, mixed> $nieder
 * @var array<int|string, mixed> $punkte
 * @var array<int|string, mixed> $ser1
 * @var array<int|string, mixed> $ser2
 * @var array<int|string, mixed> $ser3
 * @var array<int|string, mixed> $ser4
 * @var array<int|string, mixed> $siege
 * @var array<int|string, mixed>|null $spiele
 * @var mixed $spieltagflag
 * @var mixed $spieltagflag1
 * @var mixed $spieltagflag2
 * @var mixed $spieltagflag3
 * @var mixed $spieltagflag4
 * @var mixed $spieltagflag5
 * @var array<int|string, mixed> $tab0
 * @var mixed $team_akt_gewonnen
 * @var mixed $team_akt_sieglos
 * @var mixed $team_akt_unentschieden
 * @var mixed $team_akt_ungeschlagen
 * @var mixed $team_akt_verloren
 * @var mixed $team_max_gewonnen
 * @var mixed $team_max_sieglos
 * @var mixed $team_max_unentschieden
 * @var mixed $team_max_ungeschlagen
 * @var mixed $team_max_verloren
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $ax
 * @var mixed $bx
 * @var mixed $cx
 * @var mixed $dx
 * @var array<int|string, mixed> $position
 * @var mixed $rstPrg_b
 * @var mixed $serie2
 * @var mixed $text_a
 * @var mixed $text_b
 * @var mixed $v
 */


if ($file!="") {
  // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen) und alle Mannschaften nach Nummer
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_anzteams = $lmo_einstellungen->mannschaften();
  $lmo_mannschaften = iterator_to_array($lmo_liga->alleMannschaften());
  // Name einer gewaehlten Mannschaft; ohne Auswahl "___"
  $lmo_name = static fn ($lmo_nr): string => $lmo_nr == 0 ? '___' : $lmo_liga->mannschaftsname($lmo_nr);
  $show_stat1=isset($_GET['stat1'])?$_GET['stat1']:$lmo_einstellungen->fieberkurveErste();
  $show_stat2=isset($_GET['stat2'])?$_GET['stat2']:$lmo_einstellungen->fieberkurveZweite();
  if ($show_stat1==0 && $show_stat2!=0) {
    $show_stat1=$show_stat2;
    $show_stat2=0;
  }
  $adds=$_SERVER['PHP_SELF']."?action=stats&amp;file=".$file."&amp;stat1=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for ($i=1;$i<=$lmo_anzteams;$i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[57]." ".$lmo_mannschaften[$i]->anzeigename()?>"><?php
    if ($i!=$show_stat1) {?>
            <a href="<?php echo $adds.$i?>&amp;stat2=<?php echo $show_stat2?>"><?php echo $lmo_mannschaften[$i]->kurzname(); ?></a><?php
    } else {
      echo $lmo_mannschaften[$i]->kurzname();
    }     ?></acronym>
          </td>
          <td><?php echo HTML_smallTeamIcon($file,$lmo_mannschaften[$i]->anzeigename()," alt=''"); ?>&nbsp;</td>
        </tr><?php
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if ($show_stat1==0) {?>
        <tr>
          <td align="center">&nbsp;<br><?php echo $text[24]; ?><br>&nbsp;</td>
        </tr><?php
  } else {
    $endtab = $lmo_einstellungen->spieltage();
    if (!isset($tabtype)) {
      $tabtype = 0;
    }
    if (!isset($newtabtype)) {
      $newtabtype = 0;
    }
    // die Tabelle der ganzen Saison (Lmo\Liga\Tabelle) und die Zeilen der beiden gewaehlten Mannschaften
    $lmo_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, (int)$tabtype, $endtab, (int)$newtabtype);
    $endtab = $lmo_tabelle->bis;
    $lmo_zeile1 = $lmo_tabelle->zeilen[$show_stat1] ?? new \Lmo\Liga\Tabellenzeile(0);
    $lmo_zeile2 = $lmo_tabelle->zeilen[$show_stat2] ?? new \Lmo\Liga\Tabellenzeile(0);
    // Platz in der Tabelle; fuehrt die Liga ein Handicap, gilt in der Gesamttabelle dessen Reihenfolge
    $lmo_tab_plaetze = $lmo_tabelle->reihenfolge;
    if ($lmo_einstellungen->mitHandicap() && $tabtype == 0) {
      $lmo_runde = empty($tabdat) ? $lmo_einstellungen->aktuellerSpieltag() : $endtab;
      $lmo_tab_plaetze = $lmo_tabelle->reihenfolgeNachHandicap(isset($lmo_liga->spieltage[$lmo_runde]) ? ($lmo_liga->spieltage[$lmo_runde]->werte['HS'] ?? '0') : '0');
    }
    $lmo_platz1 = array_search($lmo_zeile1->mannschaft, $lmo_tab_plaetze, true);
    $lmo_platz1 = $lmo_platz1 === false ? '' : $lmo_platz1 + 1;
    $lmo_platz2 = array_search($lmo_zeile2->mannschaft, $lmo_tab_plaetze, true);
    $lmo_platz2 = $lmo_platz2 === false ? '' : $lmo_platz2 + 1;?>
        <tr>
          <th class="text-right"><?php echo $lmo_name($show_stat1);?></th>
          <th class="text-center"><?php
      echo HTML_smallTeamIcon($file,$lmo_name($show_stat1)," alt=''")."&nbsp;";
      if ($show_stat2>0 && $show_stat1!=$show_stat2) {
        echo "&nbsp;".HTML_smallTeamIcon($file,$lmo_name($show_stat2)," alt=''");
      }?>
          </th><?php
      if ($show_stat2>0 && $show_stat1!=$show_stat2) {?>
          <th class="text-left"><?php echo $lmo_name($show_stat2);?></th><?php
      }?>
        </tr>
<?php
  $serie1="&nbsp;";
  if ($lmo_zeile1->serieSiege>0) {
    $serie1=$lmo_zeile1->serieSiege." ".$text[474]."<br>".$lmo_zeile1->serieUngeschlagen." ".$text[75];
  } elseif ($lmo_zeile1->serieNiederlagen>0) {
    $serie1=$lmo_zeile1->serieNiederlagen." ".$text[475]."<br>".$lmo_zeile1->serieSieglos." ".$text[76];
  } elseif ($lmo_zeile1->serieUngeschlagen>=$lmo_zeile1->serieSieglos) {
    $serie1=$lmo_zeile1->serieUngeschlagen." ".$text[75];
  } else {
    $serie1=$lmo_zeile1->serieSieglos." ".$text[76];
  }
  if ($show_stat2>0 && $show_stat1!=$show_stat2) {
    $chg1="k.A.";
    $chg2="k.A.";
    if (!empty($lmo_zeile1->spiele)&&!empty($lmo_zeile2->spiele)) {
      $ax=(100*$lmo_zeile1->siege/$lmo_zeile1->spiele)+(100*$lmo_zeile2->niederlagen/$lmo_zeile2->spiele);
      $bx=(100*$lmo_zeile2->siege/$lmo_zeile2->spiele)+(100*$lmo_zeile1->niederlagen/$lmo_zeile1->spiele);
      $cx=($lmo_zeile1->tore/$lmo_zeile1->spiele)+($lmo_zeile2->gegentore/$lmo_zeile2->spiele);
      $dx=($lmo_zeile2->tore/$lmo_zeile2->spiele)+($lmo_zeile1->gegentore/$lmo_zeile1->spiele);
      $ex=$ax+$bx;
      $fx=$cx+$dx;
    }
    if (isset($ex) && ($ex>0) && isset($fx) &&($fx>0)) {
      $ax=round(10000*$ax/$ex);
      $bx=round(10000*$bx/$ex);
      $cx=round(10000*$cx/$fx);
      $dx=round(10000*$dx/$fx);
      $chg1=number_format((($ax+$cx)/200),2,",",".");
      $chg2=number_format((($bx+$dx)/200),2,",",".");
    }
    $serie2="&nbsp;";
    if ($lmo_zeile2->serieSiege>0) {
      $serie2=$lmo_zeile2->serieSiege." ".$text[474]."<br>".$lmo_zeile2->serieUngeschlagen." ".$text[75];
    } elseif ($lmo_zeile2->serieNiederlagen>0) {
      $serie2=$lmo_zeile2->serieNiederlagen." ".$text[475]."<br>".$lmo_zeile2->serieSieglos." ".$text[76];
    } elseif ($lmo_zeile2->serieUngeschlagen>=$lmo_zeile2->serieSieglos) {
      $serie2=$lmo_zeile2->serieUngeschlagen." ".$text[75];
    } else {
      $serie2=$lmo_zeile2->serieSieglos." ".$text[76];
    }


?>
        <tr>
          <td align="right"><?php echo $chg1; ?>%</td>
          <th class="text-center"><?php echo $text[60]; ?></th>
          <td align="left"><?php echo $chg2; ?>%</td>
        </tr>
<?php } ?>
        <tr>
          <td align="right"><?php echo $lmo_platz1;?></td>
          <th class="text-center"><?php echo $text[61];?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo $lmo_platz2;?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo applyFactor($lmo_zeile1->punkte,$lmo_einstellungen->punktfaktor()); if ($lmo_einstellungen->mitMinuspunkten()) {":".applyFactor($lmo_zeile1->minuspunkte,$lmo_einstellungen->punktfaktor());} ?></td>
          <th class="text-center"><?php echo $text[37]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo applyFactor($lmo_zeile2->punkte,$lmo_einstellungen->punktfaktor()); if ($lmo_einstellungen->mitMinuspunkten()) {":".applyFactor($lmo_zeile2->minuspunkte,$lmo_einstellungen->punktfaktor());} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $lmo_zeile1->spiele;?></td>
          <th class="text-center"><?php echo $text[63]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo $lmo_zeile2->spiele;?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if ($lmo_zeile1->spiele) {echo applyFactor(number_format($lmo_zeile1->punkte/$lmo_zeile1->spiele,2),$lmo_einstellungen->punktfaktor()); if ($lmo_einstellungen->mitMinuspunkten()) {":".applyFactor(number_format($lmo_zeile1->minuspunkte/$lmo_zeile1->spiele,2),$lmo_einstellungen->punktfaktor());}} ?></td>
          <th class="text-center"><?php echo $text[37].$text[64]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {if ($lmo_zeile2->spiele) {?><td align="left"><?php echo applyFactor(number_format($lmo_zeile2->punkte/$lmo_zeile2->spiele,2),$lmo_einstellungen->punktfaktor()); if ($lmo_einstellungen->mitMinuspunkten()) {":".applyFactor(number_format($lmo_zeile2->minuspunkte/$lmo_zeile2->spiele,2),$lmo_einstellungen->punktfaktor());}} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo applyFactor($lmo_zeile1->tore,$lmo_einstellungen->torfaktor()).":".applyFactor($lmo_zeile1->gegentore,$lmo_einstellungen->torfaktor()); ?></td>
          <th class="text-center"><?php echo $text[38]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo applyFactor($lmo_zeile2->tore,$lmo_einstellungen->torfaktor()).":".applyFactor($lmo_zeile2->gegentore,$lmo_einstellungen->torfaktor()); ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if ($lmo_zeile1->spiele) { echo number_format(applyFactor($lmo_zeile1->tore,$lmo_einstellungen->torfaktor())/$lmo_zeile1->spiele,2).":".number_format(applyFactor($lmo_zeile1->gegentore,$lmo_einstellungen->torfaktor())/$lmo_zeile1->spiele,2);} ?></td>
          <th class="text-center"><?php echo $text[38].$text[64]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php if ($lmo_zeile2->spiele) { echo number_format(applyFactor($lmo_zeile2->tore,$lmo_einstellungen->torfaktor())/$lmo_zeile2->spiele,2).":".number_format(applyFactor($lmo_zeile2->gegentore,$lmo_einstellungen->torfaktor())/$lmo_zeile2->spiele,2);} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if ($lmo_zeile1->spiele) {echo $lmo_zeile1->siege." (".number_format($lmo_zeile1->siege*100/$lmo_zeile1->spiele,2,",",".")."%)";} ?></td>
          <th class="text-center"><?php echo $text[67]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php if ($lmo_zeile2->spiele) {echo $lmo_zeile2->siege." (".number_format($lmo_zeile2->siege*100/$lmo_zeile2->spiele,2,",",".")."%)";} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $lmo_zeile1->hoechsterSieg->alsText($lmo_einstellungen->torfaktor(), $text[72], $text[73], $text[74]); ?></td>
          <th class="top" style="text-align:center"><?php echo $text[68]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo $lmo_zeile2->hoechsterSieg->alsText($lmo_einstellungen->torfaktor(), $text[72], $text[73], $text[74]) ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if ($lmo_zeile1->spiele) {echo $lmo_zeile1->niederlagen." (".number_format($lmo_zeile1->niederlagen*100/$lmo_zeile1->spiele,2,",",".")."%)";} ?></td>
          <th class="text-center"><?php echo $text[69]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php if ($lmo_zeile2->spiele) {echo $lmo_zeile2->niederlagen." (".number_format($lmo_zeile2->niederlagen*100/$lmo_zeile2->spiele,2,",",".")."%)";} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $lmo_zeile1->hoechsteNiederlage->alsText($lmo_einstellungen->torfaktor(), $text[72], $text[73], $text[74]); ?></td>
          <th class="top" style="text-align:center"><?php echo $text[70]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo $lmo_zeile2->hoechsteNiederlage->alsText($lmo_einstellungen->torfaktor(), $text[72], $text[73], $text[74]); ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $serie1; ?></td>
          <th class="top" style="text-align:center"><?php echo $text[71]; ?></th>
          <?php if ($show_stat2>0 && $show_stat1!=$show_stat2) {?><td align="left"><?php echo $serie2; ?></td><?php } ?>
        </tr>

<?php
/** ClassLib Statistik Erweiterung begin */
//require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
$file = isset($file)?$file:NULL;
$liga = new liga();

// Existiert bereits ein Objekt der Liga (z.B. durch ein anderes Addin), wird dieses verwendet
// Dadurch wird das erneute Laden des Files vermieden. Performance !!!!
$ligaLoaded = false;
if ($file && (!isset($liga) || !is_object($liga) || $liga->fileName != $file)) {
  $liga = new liga();
  $ligaLoaded = $liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file);
}

if ($ligaLoaded  and $show_stat1 > 0 and $show_stat1 <= $liga->teamCount()) {
  $table = $liga->calcTable($liga->spieltageCount());
  $team_a = new team();
  $team_a = $liga->teamForNumber($show_stat1);
  $rstPrgMinus_a = 0;
  $rstPrgMinus_b = 0;
  $rstPrgPlus_a = 0;
  $rstPrgPlus_b = 0;
  $faktor = $liga->teamCount();
  $sortedGames_a = array();
  $sortedGames_b = array();
  $sortedGames_a = $liga->gamesSortedForTeam ($team_a,false);
  echo "<!-- OUTPUT Restprogramm START-->";
  echo "<tr><td align=\"right\" valign=\"top\">";
  foreach ($sortedGames_a as $game_a) {
    $result = $game_a['partie']->valuateGame();
    $pos = 1;
    if ( $result == -1 ) {
      // aktuelle Tabellenposition ermitteln
      if ($game_a['partie']->heim == $team_a)
        $gegner_a = &$game_a['partie']->gast;
      else
        $gegner_a = &$game_a['partie']->heim;

      foreach ( $table as $position ) {
        if ($position['team'] == $gegner_a) break;
        $pos ++;
      }
      $rstPrgPlus_a += $position["pPkt"];
      $rstPrgMinus_a += $position["mPkt"];

      if ($game_a['partie']->heim == $team_a)
        echo $text[73]."&nbsp;".$gegner_a->name;
      else
        echo $text[74]."&nbsp;".$gegner_a->name;
      echo "&nbsp;(".$pos.".)";
      echo "<br>";
    }
  }
  $rstPrg_a = $rstPrgPlus_a - $rstPrgMinus_a;
  echo "</td><th class=\"top\" style=\"text-align:center\">$text[4020]</th>";
  echo "<td align=\"left\" valign=\"top\">";
  if ($show_stat1 <> $show_stat2 and $show_stat2 > 0 and $show_stat2 <= $liga->teamCount() ) {
    $team_b = new team();
    $team_b = $liga->teamForNumber($show_stat2);
    $sortedGames_b = $liga->gamesSortedForTeam ($team_b,false);

    foreach ($sortedGames_b as $game_b) {
      $result = $game_b['partie']->valuateGame();
      $pos = 1;
      if ( $result == -1) {
        // aktuelle Tabellenposition ermitteln
        if ($game_b['partie']->heim == $team_b)
          $gegner_b = &$game_b['partie']->gast;
        else
          $gegner_b = &$game_b['partie']->heim;

        foreach ( $table as $position ) {
          if ($position['team'] == $gegner_b) break;
          $pos ++;
        }
        $rstPrgPlus_b += $position["pPkt"];
        $rstPrgMinus_b += $position["mPkt"];

        echo "(".$pos.".)&nbsp;";
        if ($game_b['partie']->heim == $team_b)
          echo $gegner_b->name."&nbsp;".$text[73];
        else
          echo $gegner_b->name."&nbsp;".$text[74];
        echo "<br>";
      }
    }
//    echo "</td></tr>";
    $rstPrg_b = $rstPrgPlus_b - $rstPrgMinus_b;
    if (($rstPrgPlus_a - $rstPrgMinus_a) < ($rstPrgPlus_b - $rstPrgMinus_b) ) {
      $text_a = $text[4025];
      $text_b = $text[4026];
    }
    elseif (($rstPrgPlus_a - $rstPrgMinus_a) > ($rstPrgPlus_b - $rstPrgMinus_b) ) {
      $text_a = $text[4026];
      $text_b = $text[4025];
    }
    else {
      $text_a = $text_b = $text[4024];
    }

  }
  echo "</td></tr>";

  if (isset($team_b) and is_object($team_b) ) {
    echo "<tr><th style=\"text-align:center\" colspan=\"3\">$text[4021]</th></tr>";
    echo "<tr><td align=\"right\">";
    echo $rstPrgPlus_a.":".$rstPrgMinus_a." (".($rstPrg_a>0?"+".$rstPrg_a:$rstPrg_a).")";
    echo "</td><th class=\"top\" style=\"text-align:center\">$text[4022]</th>";
    echo "<td align=\"left\">";
    echo $rstPrgPlus_b.":".$rstPrgMinus_b." (".($rstPrg_b>0?"+".$rstPrg_b:$rstPrg_b).")";
    echo "</td></tr>";
    echo "<tr><td align=\"right\">".$text_a."</td><th class=\"top\" style=\"text-align:center\">$text[4023]</th><td align=\"left\">".$text_b."</td></tr>";
  }
  echo "<!-- OUTPUT Restprogramm ENDE-->";
 } // loadFile
/** ClassLib Statistik Erweiterung end */
    }
?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for ($i=1;$i<=$lmo_anzteams;$i++) {?>
        <tr>
          <td><?php echo HTML_smallTeamIcon($file,$lmo_mannschaften[$i]->anzeigename()," alt=''"); ?>&nbsp;</td>
          <td align="left">
            <acronym title="<?php echo $text[57]." ".$lmo_mannschaften[$i]->anzeigename()?>"><?php
    if ($i!=$show_stat2) {
               ?><a href="<?php echo $adds.$show_stat1?>&amp;stat2=<?php echo $i?>"><?php echo $lmo_mannschaften[$i]->kurzname()?></a><?php
    } else {
      echo $lmo_mannschaften[$i]->kurzname();
    }
          ?></acronym>
          </td>
        </tr><?php
  }?>
      </table>
    </td>
  </tr>
</table><?php
  if ($einzustats == 1) {
    $zustat_file = PATH_TO_LMO."/".basename($diroutput)."/".str_replace(".l98", ".l98.php", basename($file));
    if (!file_exists($zustat_file) || filemtime($zustat_file) < filemtime(PATH_TO_LMO.'/'.$dirliga.$file)) {
      $generate_zustat = true;
      include_once(PATH_TO_LMO."/lmo-zustat.php");
    }
    include_once($zustat_file);?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="5"><h1><?php echo $text[4009]?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="4" align="center"><?php echo $text[63]?> </th>
        </tr>
        <tr>
          <td align="right"><?php echo $text[516]; ?></td>
          <td align="right"><?php echo $text[4006]; ?></td>
          <td align="center"><?php echo $text[200]; ?></td>
          <td align="left"><?php echo $text[4007]; ?></td>
        </tr>
        <tr>
          <td align="right"> <strong><?php echo $ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></strong></td>
          <td align="right"> <strong><?php echo $gzusieg1?></strong><?php if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="center"> <strong><?php echo $gzuunent?></strong><?php if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="left"> <strong><?php echo $gzusieg2?></strong><?php if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?> </td>
        </tr><?php
    if ($gbeide>0) {?>
        <tr>
          <td align="right" colspan="2"><?php echo $text[4012];?></td>
          <td colspan="2" align="center"><strong><?php echo $gbeide?></strong><?php if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></td>
        </tr><?php
    }?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[38]?> </th>
        </tr>
        <tr>
          <td align="right"><?php echo $text[516]?> </td>
          <td align="right"><?php echo $text[41]."-".$text[38]?> </td>
          <td>&nbsp;</td>
          <td align="left"><?php echo $text[42]."-".$text[38]?> </td>
        </tr>
        <tr>
          <td align="right"> <strong><?php echo applyFactor($gzutore,$lmo_einstellungen->torfaktor());?></strong> (<?php echo $text[517]?><?php echo applyFactor($gdstore,$lmo_einstellungen->torfaktor())?>) </td>
          <td align="right"> <strong><?php echo applyFactor($gheimtore,$lmo_einstellungen->torfaktor());?></strong><?php if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v% ".$text[517].applyFactor($dsheimtore,$lmo_einstellungen->torfaktor()).")";}?> </td>
          <td>&nbsp;</td>
          <td align="left"> <strong><?php echo applyFactor($ggasttore,$lmo_einstellungen->torfaktor());?></strong><?php if ($gdstore>0) {echo " (".(100-$v)."% ".$text[517].applyFactor($dsgasttore,$lmo_einstellungen->torfaktor()).")";}?> </td>
        </tr><?php
    if ($hheimsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4013]?></th>
        </tr><tr>
          <td align="right"><?php echo $hheimsieg?> - </td>
          <td align="left"><?php echo $hgastsieg?></td>
          <td colspan="2" align="left"><?php echo applyFactor($hheimsiegtor,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($hgastsiegtor,$lmo_einstellungen->torfaktor())?> (<?php echo $spieltagflag?>.<?php echo $text[4014]?>)</td>
        </tr><?php
      if ($hheimsiegtor1>0) {?>
        <tr>
          <td align="right"><?php echo $hheimsieg1?> - </td>
          <td align="left"><?php echo $hgastsieg1?></td>
          <td colspan="2" align="left"><?php echo applyFactor($hheimsiegtor1,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($hgastsiegtor1,$lmo_einstellungen->torfaktor())?> (<?php echo $spieltagflag1?>.<?php echo $text[4014]?>)</td>
        </tr><?php
        if ($counteranz>2) {
          $counteranz0=$counteranz-2;?>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?php echo $text[4015]?> <?php echo $counteranz0?> <?php echo $text[4016]?></small></td>
        </tr><?php
        }
      }
    }
    if ($agastsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4017]?></th>
        </tr>
        <tr>
          <td align="right"><?php echo $aheimsieg?> - </td>
          <td align="left"><?php echo $agastsieg?></td>
          <td colspan="2" align="left"><?php echo applyFactor($aheimsiegtor,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($agastsiegtor,$lmo_einstellungen->torfaktor())?> (<?php echo $spieltagflag2?>.<?php echo $text[4014]?>)</td>
        </tr>  <?php
      if ($agastsiegtor1>0) {?>
        <tr>
          <td align="right"><?php echo $aheimsieg1?> - </td>
          <td align="left"><?php echo $agastsieg1?></td>
          <td colspan="2" align="left"><?php echo applyFactor($aheimsiegtor1,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($agastsiegtor1,$lmo_einstellungen->torfaktor())?>  (<?php echo $spieltagflag3?>.<?php echo $text[4014]?>)</td>
        </tr><?php
        if ($counteranz1>2) {
          $counteranz4=$counteranz1-2;?>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?php echo $text[4015]?> <?php echo $counteranz4?> <?php echo $text[4016]?></small></td>
        </tr><?php
        }
      }
    }
    if ($spieltagflag4>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4018]?> <?php echo $text[38]?></th>
        </tr>
        <tr>
          <td align="right"><?php echo $htorreichm1?> - </td>
          <td align="left"><?php echo $htorreichm2?></td>
          <td colspan="2" align="left"><?php echo applyFactor($htorreicht1,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($htorreicht2,$lmo_einstellungen->torfaktor())?>  (<?php echo $spieltagflag4?>.<?php echo $text[4014]?>)</td>
        </tr><?php
      if ($spieltagflag5>0) {?>
        <tr>
          <td align="right"><?php echo $htorreichm3?> - </td>
          <td align="left"><?php echo $htorreichm4?></td>
          <td colspan="2" align="left"><?php echo applyFactor($htorreicht3,$lmo_einstellungen->torfaktor())?>:<?php echo applyFactor($htorreicht4,$lmo_einstellungen->torfaktor())?>  (<?php echo $spieltagflag5?>.<?php echo $text[4014]?>)</td>
        </tr><?php
        if ($counteranz5>2) {
          $counteranz6=$counteranz5-2;?>
        <tr>
           <td>&nbsp;</td>
           <td colspan="3" align="right"><small><?php echo $text[4015]?> <?php echo $counteranz6?> <?php echo $text[4019]?></small></td>
         </tr><?php
        }
      }
    }
    if (isset($akt_gewonnen)) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4027]?></th>
        </tr>
        <tr>
          <td colspan="4">
            <table width="100%" cellpadding="3" cellspacing="0">
              <tr>
                <th>&nbsp;</th>
                <th style="text-align:center" colspan="2"><?php echo $text[4033]?></th>
                <th style="text-align:center" colspan="2"><?php echo $text[4034]?></th>
              </tr>
              <tr>
                <th style="text-align:right"><?php echo $text[4028]?>&nbsp;&nbsp;</th>
                <td align="right" class="lmoTabelleMeister"><strong><?php echo $akt_gewonnen?></strong>&nbsp;</td>
                <td class="lmoTabelleMeister"><?php echo nl2br($team_akt_gewonnen, false)?>&nbsp;</td>
                <td align="right" class="lmoTabelleMeister"><strong><?php echo $max_gewonnen?></strong>&nbsp;</td>
                <td class="lmoTabelleMeister">&nbsp;<?php echo nl2br($team_max_gewonnen, false)?></td>
              </tr>
              <tr>
                <th style="text-align:right"><?php echo $text[4029]?>&nbsp;&nbsp;</th>
                <td align="right" class="lmoTabelleUefa"><strong><?php echo $akt_ungeschlagen?></strong>&nbsp;</td>
                <td class="lmoTabelleUefa"><?php echo nl2br($team_akt_ungeschlagen, false)?>&nbsp;</td>
                <td align="right" class="lmoTabelleUefa"><strong><?php echo $max_ungeschlagen?></strong>&nbsp;</td>
                <td class="lmoTabelleUefa">&nbsp;<?php echo nl2br($team_max_ungeschlagen, false)?></td>
              </tr>
              <tr>
                <th style="text-align:right"><?php echo $text[200]?>&nbsp;&nbsp;</th>
                <td align="right"><strong><?php echo $akt_unentschieden?>&nbsp;</strong>&nbsp;</td>
                <td><?php echo nl2br($team_akt_unentschieden, false)?></td>
                <td align="right"><strong><?php echo $max_unentschieden?></strong>&nbsp;</td>
                <td><?php echo nl2br($team_max_unentschieden, false)?></td>
              </tr>
              <tr>
                <th style="text-align:right"><?php echo $text[4031]?>&nbsp;&nbsp;</th>
                <td align="right" class="lmoTabelleRelegation"><strong><?php echo $akt_sieglos?></strong>&nbsp;</td>
                <td class="lmoTabelleRelegation"><?php echo nl2br($team_akt_sieglos, false)?>&nbsp;</td>
                <td align="right" class="lmoTabelleRelegation"><strong><?php echo $max_sieglos?></strong>&nbsp;</td>
                <td class="lmoTabelleRelegation"><?php echo nl2br($team_max_sieglos, false)?></td>
              </tr>
              <tr>
                <th style="text-align:right"><?php echo $text[4032]?>&nbsp;&nbsp;</th>
                <td align="right" class="lmoTabelleAbsteiger"><strong><?php echo $akt_verloren?></strong>&nbsp;</td>
                <td class="lmoTabelleAbsteiger"><?php echo nl2br($team_akt_verloren)?>&nbsp;</td>
                <td align="right" class="lmoTabelleAbsteiger"><strong><?php echo $max_verloren?></strong>&nbsp;</td>
                <td class="lmoTabelleAbsteiger"><?php echo nl2br($team_max_verloren)?></td>
              </tr>
            </table>
          </td>
        </tr><?php
    }?>
      </table>
    </td>
  </tr>
</table><?php
  } //if (zustats)
} ?>