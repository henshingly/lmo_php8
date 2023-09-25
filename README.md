# LMO unter PHP 8 & Bootstrap
Nachdem der LMO nicht mehr weiter entwickelt wird, PHP aber in neuen Versionen veröffentlich wird und einige Dinge nicht mehr funktionieren, hat <a target="_blank" href="//github.com/henshingly/LMO_PHP7">Henshingley</a> sich die Mühe gemacht den LMO für PHP 7.x zum Laufen zu bringen und die Sourcen auf GitHub veröffentlicht.

Meinen privaten LMO habe ich schon vor längerem so umgebaut, dass er auch auf mobilen Endgeräten genutzt werden kann. Dazu habe ich mich für das Framework <a target="_blank" href="//getbootstrap">Bootstrap</a> entschieden, prinzipiell gehen aber auch problemlos <a target="_blank" href="//get.foundation/">Foundation</a>, <a target="_blank" href="//materializecss.com/">Materialize</a>, <a target="_blank" href="//purecss.io/">Pure.CSS</a>, <a target="_blank" href="//milligram.io/">Milligram</a>, <a target="_blank" href="http://getskeleton.com/">Skeleton</a>, ...

Das System ist nahezu bei allen identisch, das wichtigste ist das Grid-System, um auf mobilen Seiten an den richtigen Stellen die Umbrüche umzusetzen.

Dabei arbeiten nahezu alle Frontend-Frameworks nach demselben Muster (und dahingehend ist der LMO auch umgebaut worden):

`<table.....>` wird zu `<div class="container">`

`<tr.....>` wird zu `<div class="row">`

`<td.....>` wird zu `<div class="col">` bzw. zu `<div class="col-x">`

Die Umstellung des Front- und Backends auf responsive Design ist abgeschlossen.
Bei einzelen Addons gibt es Elemente, in denen nicht aus responsive umgestellt werden kann (bspw. Spielerstatistik, wenn mehr als 12 Datenfelder enthalten sind).

Das Release 4.1.1 basiert komplett auf PHP 8.x, Stand jetzt sind keine Fehlermeldungen mehr vorhanden. Sollten welche identifiziert werden, bitte unter "Issues" ein Ticket eröffnen. 

Bei der Fieberkurve wird <a target="_blank" href="//www.chartjs.org/">Chart.js</a> verwendet, Iconset ist von Bootstrap.

Der aktuelle Stand kann unter https://lmo.babig.it/ eingesehen werden (entspricht dem GitHub-Stand).
