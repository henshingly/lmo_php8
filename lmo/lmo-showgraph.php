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
  
  
if(($file!="") && ($kurve==1)){
  $tension = '0.4';
?>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="container">
      <?php
    $tabtype=0;
    require(PATH_TO_LMO."/lmo-calcgraph.php");
    for($k=1;$k<$anzteams+1;$k++) {
        ${'platz_'.$k} = "";
        for ($l=0;$l<$anzst;$l++) {
            ${'platz_'.$k} = ${'platz_'.$k}.$platz[$k][$l].",";
        }
    }
    ?>
        <div class="row">
          <div class="col"><br/><canvas id="myChart" width="1000" height="600"></canvas>
		     <?php
                $data = "";
				$pgtext1=$text[135];
                $pgtext2=$text[136];
                // Anzahl Spieltage in x-Achse
                $spieltag = array();
                for($i=1; $i<=$anzst;$i++) {
                    $spieltag[] = $i;
                }
                $xAxis = implode(",", $spieltag);

                for($j=1;$j<$anzteams+1;$j++) {
                    ${'platz'.$j} = explode(",", ${'platz_'.$j});
                    foreach(array_keys(${'platz'.$j}, '0') as $key) {
                        unset(${'platz'.$j}[$key]);
                    }
                    ${'pgplatz'.$j} = implode(",", ${'platz'.$j});
                    $color = mt_rand(0, 160).",".mt_rand(0, 160).",".mt_rand(0, 160).",1";
                    $axisColor = "rgba(90, 90, 90, 1)";
                    $flag = 'true';
                    if($j < 3) $flag = 'false';
                    $data .= "{
                        label: '$teams[$j]',
                        fill: false,
                        lineTension: $tension,
                        backgroundColor: 'rgba($color)',
                        borderColor: 'rgba($color)',
                        data: [${'pgplatz'.$j}],
                        hidden: $flag,
                    },";
                }
			?>
<script>

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [<?php echo $xAxis; ?>],
			datasets: [<?php echo $data; ?>]
		},
		options: {
			scales: {
				x: {
					grid: {
					    color: '<?php echo $axisColor; ?>'
					},
					title: {
						display: true,
						text: '<?php echo $pgtext1; ?>',
						color: '<?php echo $axisColor; ?>',
						font: {
							size: 24,
						},
					},
					ticks: {
					    color: '<?php echo $axisColor; ?>'
					}
				},
				y: {
					grid: {
					    color: '<?php echo $axisColor; ?>'
					},
					title: {
						display: true,
						text: '<?php echo $pgtext2; ?>',
						color: '<?php echo $axisColor; ?>',
						font: {
							size: 24,
						},
					},
					min: 1,
					max: <?php echo $anzteams; ?>,
					reverse: true,
					ticks: {
					    maxTicksLimit: <?php echo $anzteams; ?>,
					    color: '<?php echo $axisColor; ?>'
					}
				},
			},
			plugins: {
			    tooltip: {
			        displayColors: true,
			        mode: 'index',
			        callbacks: {
				        label: function(context) {
				        	    var label = context.dataset.label;
				        		var pos = context.parsed.y;
				        		pos += ". Platz";
				        		return label + ": " + pos;
        	            },
        	            title: function(context) {
	        	               	var label = context[0].label;
	        	               	label += ". Spieltag";
	        	               	return label;
        	            }
                	}
			    }
			}
		}
	});
</script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>