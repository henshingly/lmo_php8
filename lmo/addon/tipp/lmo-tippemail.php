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
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var int|string $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $aadr Einstellung aus cfg.txt
 * @var int|string $tipp_dirtipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_immeralle Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_imvorraus Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_ligenzutippen Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippauthtxt Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $adressat
 * @var mixed $betreff
 * @var mixed $emailart
 * @var array<int|string, mixed> $goaltippa
 * @var mixed $message
 * @var mixed $tage
 * @var mixed $trans_lang
 * @var mixed $viewermode
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $anzst1
 * @var mixed $ktipp
 * @var array<int|string, mixed> $liga
 * @var mixed $st0
 */

require_once(PATH_TO_LMO . '/lmo-admintest.php');
require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tippaenderbar.php');
$mail = lmo_mailer($aadr, $text['tipp'][92]);

// Basis-URL für den [pass]-Platzhalter: da Passwoerter seit der Umstellung
// auf password_hash() nicht mehr im Klartext vorliegen, wird statt des
// (nutzlosen) Hash-Werts ein personalisierter Link zum Passwort-Reset
// verschickt (nutzt denselben Mechanismus wie lmo-tippemailpass.php).
$tippResetBaseUrl = lmo_request_origin() . $_SERVER['PHP_SELF'] . '?action=tipp&todo=getpass&xtippername2=';

if ($message != '') {
    $dumma = array();
    $pswfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;
    $dumma = file($pswfile);
    // Die PHP-Schutzzeile am Dateianfang ist kein Tipper-Datensatz
    $dumma = array_values(array_filter($dumma, function ($line) {
        return !str_starts_with(trim($line), '<?php');
    }));

    $mail->Subject = $betreff . ' (' . $_SERVER['HTTP_HOST'] . ')';
    $anzemail = 0;
    $anztipper = count($dumma);
    if (!isset($start)) {
        $start = 1;
    }
    if (!isset($ende)) {
        $ende = $anztipper;
    }

    if ($emailart == 0) {
        for ($tippernr = $start - 1; $tippernr < $ende; $tippernr ++) {
            $dummb = explode('|', $dumma[$tippernr]);
            if (isset($dummb[9], $dummb[4]) && $dummb[9] != -1 && $dummb[4] != '') {
                $textmessage = $message;
                $textmessage = str_replace(array('[nick]', '[pass]', '[name]'),array($dummb[0], $tippResetBaseUrl . urlencode($dummb[0]), $dummb[3]), $textmessage);
                $mail->Body = $textmessage;
                $mail->addAddress($dummb[4]);
                if ($mail->send()) {
                    $anzemail ++;
                } else {
                    echo $mail->ErrorInfo;
                }
                $mail->ClearAllRecipients();
                $mail->ClearReplyTos();
            }
        }
            echo getMessage($anzemail . ' ' . $text['tipp'][175]);
    } elseif ($emailart == 1) {
        $tipp_textreminder1 = str_replace(array("\r\n", "\n", "\r"), array('&#10;', '&#10;', '&#10;') , $message);
        require(PATH_TO_LMO . '/lmo-savecfg.php');
        $now = strtotime('now');
        $then = strtotime('+' . $tage . ' day');
        if ($viewermode == 1) {
            $verz = opendir(substr($dirliga, 0, -1));
            $dateien = array();
            while ($files = readdir($verz)) {
                $ftest = 1;
                if ($tipp_immeralle != 1) {
                    $ftest = 0;
                    $ftest1 = '';
                    $ftest1 = explode(',', $tipp_ligenzutippen);
                    if (isset($ftest1)) {
                        for ($u = 0; $u < count($ftest1); $u ++) {
                            if ($ftest1[$u] == substr($files, 0, -4)) {
                                $ftest = 1;
                            }
                        }
                    }
                }
                if ($ftest == 1) {
                    array_push($dateien, $files);
                }
            }
            closedir($verz);
            sort($dateien);

            $anzligen = count($dateien);

            // anstehende Spiele aller Ligen (Lmo\Tipp\AnstehendesSpiel); gleicher Index wie $liga, $spieltag, $spiel, $zeit
            $lmo_spiele = array();
            $liga = array();
            $spieltag = array();
            $spiel = array();
            $zeit = array();

            $anzspiele = 0;

            for ($lnr = 0; $lnr < $anzligen; $lnr ++) {
                $file = $dirliga . $dateien[$lnr];
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippemailviewer.php');
            }

            $goaltipp = array_pad(array('_'), $anzspiele + 1, '_');

            for ($tippernr = $start - 1; $tippernr < $ende; $tippernr++) {
                $dummb = explode('|', $dumma[$tippernr]);
                if (isset($dummb[10], $dummb[4]) && $dummb[10] != -1 && $dummb[4] != '') {
                    for ($i = 0; $i < $anzspiele; $i ++) {
                        $goaltipp[$i] = '_';
                    }
                    $textmessage = $message;
                    $lliga = '';
                    $lspieltag = '';
                    $spiele = '';
                    for ($i = 0; $i < $anzspiele; $i ++) {
                        if ($i == 0 || $liga[$i] != $liga[$i - 1]) {
                            $tippfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . $liga[$i] . '_' . $dummb[0] . '.tip';
                            if (file_exists($tippfile)) {
                                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippemailviewer1.php');
                                $ktipp = 1;
                            } else {
                                $ktipp = 0;
                            }
                        }
                        if ($ktipp == 1) {
                            if ($goaltipp[$i] == '_') {
                                if ($lliga != $liga[$i]) {
                                    $spiele .= "\n" . $lmo_spiele[$i]->titel . ':';
                                }
                                if ($lspieltag != $spieltag[$i] || $lliga != $liga[$i]) {
                                    if ($lmo_spiele[$i]->typ == 0) {
                                        $spiele .= "\n" . $spieltag[$i] . '. ' . $text[2] . ':';
                                    } else {
                                        if ($spieltag[$i] == $lmo_spiele[$i]->runden) {
                                            $j = $text[374];
                                        } elseif ($spieltag[$i] == $lmo_spiele[$i]->runden-1) {
                                            $j = $text[373];
                                        } elseif ($spieltag[$i] == $lmo_spiele[$i]->runden-2) {
                                            $j = $text[372];
                                        } elseif ($spieltag[$i] == $lmo_spiele[$i]->runden-3) {
                                            $j = $text[371];
                                        } else {
                                            $j = $spieltag[$i] . '. ' . $text[370];
                                        }
                                        $spiele .= $j . ':';
                                    }
                                }
                                $spiele .= "\n" . $lmo_spiele[$i]->heim . ' - ' . $lmo_spiele[$i]->gast . ' (' . $text['tipp'][87] . ' ' . $zeit[$i] . ')';
                                $lliga = $liga[$i];
                                $lspieltag = $spieltag[$i];
                            }
                        }
                    }
                    if ($spiele != '') {
                        $textmessage = str_replace('[nick]', $dummb[0], $textmessage);
                        $textmessage = str_replace('[pass]', $tippResetBaseUrl . urlencode($dummb[0]), $textmessage);
                        $textmessage = str_replace('[name]', $dummb[3], $textmessage);
                        $textmessage = str_replace('[spiele]', $spiele, $textmessage);
                        $mail->Body = $textmessage;
                        $mail->addAddress($dummb[4]);
                        if ($mail->send()) {
                            $anzemail ++;
                        } else {
                            echo $mail->ErrorInfo;
                        }
                        $mail->ClearAllRecipients();
                        $mail->ClearReplyTos();
                    }
                }
            }
        } elseif ($liga != '' && $tage > 0 && $st >= 0) {
            $file = $liga;
            if ($st > 0) {
                require(PATH_TO_LMO . '/lmo-openfiledat.php');
            } elseif ($st == 0) {
                require(PATH_TO_LMO . '/lmo-openfile.php');
            }

            for ($tippernr = $start - 1; $tippernr < $ende; $tippernr ++) {
                $dummb = explode('|', $dumma[$tippernr]);
                if (isset($dummb[10], $dummb[4]) && $dummb[10] != -1 && $dummb[4] != '') {
                    $textmessage = $message;
                    $tippfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . substr($file, 0, -4) . '_' . $dummb[0] . '.tip';
                    $spiele = '';
                    if (file_exists($tippfile)) {
                        if ($st > 0) {
                            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippopenfile.php');
                            $st0 = $st - 1;
                            $anzst1 = $st;
                        } elseif ($st == 0) {
                            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippopenfileall.php');
                            $st0 = 0;
                            $anzst1 = $ligaDaten->anzst;
                        }
                        for (; $st0 <= $anzst1; $st0 ++) {
                            if ($tipp_imvorraus < 0 || $st0 <= ($ligaDaten->stx + $tipp_imvorraus)) {
                                if ($ligaDaten->lmtype == 0) {
                                    for ($dd = 0; $dd < $ligaDaten->anzsp; $dd ++) {
                                        $zeit = zeit($ligaDaten->mterm[$st0][$dd], $ligaDaten->datum1[$st0], $ligaDaten->datum2[$st0]);
                                        if ($now < $zeit && $then > $zeit) {
                                            if ((($st == 0 && $goaltippa[$st0][$dd] == '_') || ($st > 0 && $goaltippa[$dd] == '_')) && $ligaDaten->teama[$st0][$dd] > 0) {
                                                $spiele = $spiele . $ligaDaten->teams[$ligaDaten->teama[$st0][$dd]] . ' - ' . $ligaDaten->teams[$ligaDaten->teamb[$st0][$dd]] . ' (' . $text['tipp'][87] . ' ' . strtr(date('l, d.F.Y H:i', $zeit), $trans_lang) . ')';
                                            }
                                        }
                                    }
                                } elseif ($ligaDaten->lmtype != 0) {
                                    for ($dd = 0; $dd < $ligaDaten->anzsp; $dd ++) {
                                        for ($ddd = 0; $ddd < $ligaDaten->modus[$st0]; $ddd ++) {
                                            $zeit = zeit($ligaDaten->mterm[$st0][$dd][$ddd], $ligaDaten->datum1[$st0], $ligaDaten->datum2[$st0]);
                                            if ($now < $zeit && $then > $zeit) {
                                                if ((($st == 0 && $goaltippa[$st0][$dd][$ddd] == '_') || ($st > 0 && $goaltippa[$dd][$ddd] == '_')) && $ligaDaten->teama[$st0][$dd] > 0) {
                                                    $spiele = $spiele . $ligaDaten->teams[$ligaDaten->teama[$st0][$dd]] . ' - ' . $ligaDaten->teams[$ligaDaten->teamb[$st0][$dd]] . ' (' . $text['tipp'][87] . ' ' . strtr(date('l, d.F.Y H:i', $zeit), $trans_lang) . ')';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } // End for ($spieltag = 1; $spieltag <= $anzst; $spieltag ++)

                        if ($spiele != '') {
                            $textmessage = str_replace('[nick]', $dummb[0], $textmessage);
                            $textmessage = str_replace('[pass]', $tippResetBaseUrl . urlencode($dummb[0]), $textmessage);
                            $textmessage = str_replace('[name]', $dummb[3], $textmessage);
                            $textmessage = str_replace('[spiele]', $spiele, $textmessage);
                            $mail->Body = $textmessage;
                            $mail->addAddress($dummb[4]);
                            if ($mail->send()) {
                                $anzemail++;
                            } else {
                                echo $mail->ErrorInfo;
                            }
                            $mail->ClearAllRecipients();
                            $mail->ClearReplyTos();
                        }
                    }
                } // End if ($dummb[10] != -1 && $dummb[4] != '')
            } // End for ($tippernr = $start - 1; $tippernr < $ende; $tippernr ++)
        } // End elseif ($liga != '' && $tage > 0 && $st >= 0)
        echo getMessage($anzemail . ' ' . $text['tipp'][175]);
    } elseif ($emailart == 2 && $adressat != '') {
        $dummb = explode('|', $dumma[0]);
        for ($i = 0; $i < $anztipper && $adressat != $dummb[0]; $i ++) {
            $dummb = explode('|', $dumma[$i]);
        }
        $textmessage = $message;
        $textmessage = str_replace('[nick]', $dummb[0], $textmessage);
        $textmessage = str_replace('[pass]', $tippResetBaseUrl . urlencode($dummb[0]), $textmessage);
        $textmessage = str_replace('[name]', $dummb[3], $textmessage);
        $mail->Body = $textmessage;
        $mail->addAddress($dummb[4]);
        if ($mail->send()) {
            $anzemail++;
            $mail->ClearAllRecipients();
            $mail->ClearReplyTos();
        } else {
            echo $mail->ErrorInfo;
        }
    }
}

?>
