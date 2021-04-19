# LMO unter PHP7
Nachem der LMO nicht mehr weiter entwickelt wird, PHP aber in neuen Versionen veröffentlich wird und einige Dinge nicht mehr funktionieren, hat <a target="_blank" href="https://github.com/henshingly/LMO_PHP7">Henshingley</a> sich die Mühe gemacht den LMO für PHP 7.x zum Laufen gebracht und die Sourcen auf GitHub veröffentlicht.

Meinen privaten LMO habe ich schon vor längerem so umgebaut, dass er auch auf mobilen Endgeräten genutzt werden kann. Dazu habe ich mich für das Framework <a target="_blank" href="https://github.com/twbs/bootstrap">Bootstrap</a> entschieden, prinzipiell gehen aber auch problemlos <a target="_blank" href="https://github.com/foundation/foundation-sites">Foundation</a>, <a target="_blank" href="https://materializecss.com/">Materialize</a>, <a target="_blank" href="https://github.com/pure-css/pure">Pure.CSS</a>, <a target="_blank" href="https://github.com/milligram/milligram">Milligram</a>, <a target="_blank" href="https://github.com/dhg/Skeleton">Skeleton</a>, ...

Das System ist nahezu bei allen identisch, das wichtigste ist das Grid-System, um auf mobilen Seiten an den richtigen Stellen die Umbrüche umzusetzen.

Dabei arbeiten nahezu alle Frontend-Frameworks nach demselben Muster (und dahingehend ist der LMO auch umgebaut worden):

`<table.....>` wird zu `<div class="container-fluid">`

`<tr.....>` wird zu `<div class="row">`

`<td.....>` wird zu `<div class="col">` bzw. zu `<div class="col-x">`


Der aktuelle Stand kann unter https://lmo.babig.it/ eingesehen werden (entspricht dem GitHub-Stand).
