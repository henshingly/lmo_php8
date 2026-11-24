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

if ($file != '' && $tipp_tippfieber == 1) {
    $save = isset($_POST['save']) ? 1 : 0;
    if ($save == 1) {
        $fieber_stat1 = trim($_POST['xstat1']);
        $fieber_stat2 = trim($_POST['xstat2']);
        $kurvenmodus = trim($_POST['xkurvenmodus']);
    }
    if (!isset($eigpos)) {
        $eigpos = 0;
    }
    if (!isset($fieber_stat1)) {
        $fieber_stat1 = -1;
    }
    if (!isset($fieber_stat2)) {
        $fieber_stat2 = -1;
    }
    if ($fieber_stat1 == $fieber_stat2) {
        $fieber_stat2 = -1;
    }
    if (!isset($kurvenmodus)) {
        $kurvenmodus = 1;
    }
    $addg = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=fieber&amp;file=' . $file . '&amp;stat1=';
    require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalcgraph.php');
    //echo $anztipper;
    ?>
<form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="fieber">
  <input type="hidden" name="file" value="<?php echo $file; ?>">
  <input type="hidden" name="save" value="1">
  <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <th align="left"><?php echo $text['tipp'][164] . ' 1';?></th>
      <th align="left"><?php echo $text['tipp'][164] . ' 2';?></th>
      <th align="left"><?php echo $text['tipp'][283];?></th>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <td>
        <select name="xstat1"><?php
      $tab = [];
    for ($i = 0;$i < $anztipper;$i++) {
        array_push($tab, strtolower($tippernick[$i]) . (50000000 + $i));
    }
    sort($tab, SORT_STRING);?>
          <option value="-1"<?php if ($fieber_stat1 == -1) {
              echo ' selected';
          }?>>___</option><?php
  for ($i = 0;$i < $anztipper;$i++) {
      $j = intval(substr($tab[$i], -7));?>
          <option value="<?php echo $j?>"<?php if ($fieber_stat1 == $j) {
              echo ' selected';
          }?>><?php echo $tippernick[$j]?></option><?php
  }?>
        </select>
      </td>
      <td>
        <select name="xstat2">
          <option value="-1"<?php if ($fieber_stat2 == -1) {
              echo ' selected';
          }?>>___</option><?php
  for ($i = 0;$i < $anztipper;$i++) {
      $j = intval(substr($tab[$i], -7));?>
          <option value="<?php echo $j?>"<?php if ($fieber_stat2 == $j) {
              echo ' selected';
          }?>><?php echo $tippernick[$j]?></option><?php
  }?>
        </select>
      </td>
      <td>
        <select name="xkurvenmodus">
          <option value="1"<?php if ($kurvenmodus == 1) {
              echo ' selected';
          }?>><?php echo $text['tipp'][235]?></option>
          <option value="2"<?php if ($kurvenmodus == 2) {
              echo ' selected';
          }?>><?php echo $text['tipp'][232]?></option>	
        </select>
      </td>
      <td>
         <input type="submit" name="best" value="<?php echo $text['tipp'][236]; ?>">
      </td>
    </tr><?php
  if (isset($tippernick) && count($tippernick) > 1) {?>
    <tr>
      <td colspan="4" align="center">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
    if ($fieber_stat1 < 0 && $fieber_stat2 >= 0) {
        $fieber_stat1 = $fieber_stat2;
        $fieber_stat2 = -1;
    }
      if ($fieber_stat1 < 0) {
          echo '<tr><th><h2>' . $text['tipp'][284] . '</h2></th></tr>';
      } else {
          // max = größter Wert der dargestellten Kurven (für die Skalierung der Y-Achse)
          if ($kurvenmodus == 1) {
              $max = $fieber_stat2 >= 0 ? max(max($tipppunkte[$fieber_stat1]), max($tipppunkte[$fieber_stat2])) : max($tipppunkte[$fieber_stat1]);
          } elseif ($kurvenmodus == 2) {
              $max = $fieber_stat2 >= 0 ? max(max($platz[$fieber_stat1]), max($platz[$fieber_stat2])) : max($platz[$fieber_stat1]);
          } elseif ($kurvenmodus == 3) {
              $max = $fieber_stat2 >= 0 ? max(max($platz[$fieber_stat1]), max($platz[$fieber_stat2]), max($platz1[$fieber_stat1]), max($platz1[$fieber_stat2])) : max(max($platz[$fieber_stat1]), max($platz1[$fieber_stat1]));
          } else {
              $max = $fieber_stat2 >= 0 ? max(max($platz1[$fieber_stat1]), max($platz1[$fieber_stat2])) : max($platz1[$fieber_stat1]);
          }
          $max = (int)$max < 1 ? 10 : (int)$max;

          // Werte eines Tippers als Liste für Chart.js ('' = noch kein Wert -> Lücke)
          $kurveWerte = static function (array $werte) use ($anzst): array {
              $out = [];
              for ($j = 0; $j < $anzst; $j++) {
                  $out[] = (isset($werte[$j]) && $werte[$j] !== '') ? (int)$werte[$j] : null;
              }
              return $out;
          };
          $kurven = [];
          $tipperListe = [[$fieber_stat1, '0,0,255', '0,0,128']];
          if ($fieber_stat2 >= 0) {
              $tipperListe[] = [$fieber_stat2, '255,0,0', '128,0,0'];
          }
          foreach ($tipperListe as [$idx, $farbe, $farbeDunkel]) {
              $nick = $tippernick[$idx];
              if ($kurvenmodus == 1) {
                  $kurven[] = ['label' => $nick, 'color' => $farbe, 'data' => $kurveWerte($tipppunkte[$idx])];
              } else {
                  if ($kurvenmodus < 4) {
                      $kurven[] = ['label' => $nick, 'color' => $farbe, 'data' => $kurveWerte($platz[$idx])];
                  }
                  if ($kurvenmodus > 2) {
                      $kurven[] = ['label' => $nick . ' (Σ)', 'color' => $farbeDunkel, 'data' => $kurveWerte($platz1[$idx])];
                  }
              }
          }
          $kurvenAchseY = $kurvenmodus == 1 ? strtoupper($text['tipp'][38]) : $text[136];
          $kurvenLabels = range(1, max(1, (int)$anzst));
          ?>
          <tr>
            <td align="center" colspan="3">
              <div style="position:relative;width:100%;max-width:800px;"><canvas id="tippChart" width="700" height="500"></canvas></div>
              <script src="<?php echo URL_TO_LMO; ?>/js/chart.js"></script>
              <script>
                (function () {
                  var punkte = <?php echo $kurvenmodus == 1 ? 'true' : 'false'; ?>;
                  var kurven = <?php echo json_encode($kurven, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
                  var axisColor = 'rgba(90, 90, 90, 1)';
                  new Chart(document.getElementById('tippChart'), {
                    type: 'line',
                    data: {
                      labels: <?php echo json_encode($kurvenLabels); ?>,
                      datasets: kurven.map(function (k) {
                        return {
                          label: k.label,
                          data: k.data,
                          fill: false,
                          spanGaps: false,
                          tension: 0.4,
                          cubicInterpolationMode: 'monotone',
                          borderWidth: 3,
                          pointRadius: 3,
                          backgroundColor: 'rgba(' + k.color + ',1)',
                          borderColor: 'rgba(' + k.color + ',1)'
                        };
                      })
                    },
                    options: {
                      scales: {
                        x: {
                          grid: { color: axisColor },
                          title: { display: true, text: <?php echo json_encode($text[135]); ?>, color: axisColor, font: { size: 18 } },
                          ticks: { color: axisColor }
                        },
                        y: {
                          grid: { color: axisColor },
                          title: { display: true, text: <?php echo json_encode($kurvenAchseY); ?>, color: axisColor, font: { size: 18 } },
                          reverse: !punkte,
                          min: punkte ? 0 : 1,
                          max: <?php echo $kurvenmodus == 1 ? 'undefined' : $max; ?>,
                          ticks: { color: axisColor, precision: 0 }
                        }
                      },
                      plugins: {
                        tooltip: {
                          mode: 'index',
                          intersect: false,
                          callbacks: {
                            title: function (items) { return items[0].label + '. <?php echo addslashes($text[2]); ?>'; }
                          }
                        }
                      }
                    }
                  });
                })();
              </script>
            </td>
          </tr><?php    }?>
        </table>
      </td>
    </tr><?php
  }?>
  </table>
</form><?php }?>