<style type="text/css">
p {
  font: bold 0.9em Helvetica, Arial, Sans-Serif;
  padding: 0.2em;
  margin: 0em;
}
#eins {
  color: white;
  text-shadow: 1px 1px grey, 1.5px 1.5px grey, 2px 2px grey;
  top: 0;
  left: 0;
  transition: all 0.3s ease-out;
}
#eins:hover { position: relative;
  top: -2px;
  left: -2px;
  text-shadow: 1px 1px grey, 1.5px 1.5px grey, 2px 2px grey, 2.5px 2.5px grey, 3px 3px grey, 3.5px 3.5px grey;
}
.wround tr:last-child td:first-child {
  padding: 5px 12px;
  border-bottom: 1px solid hsl(215,30%,80%);
  border-left: 1px solid hsl(215,30%,80%);
  border-bottom-left-radius:10px;
}
.wround tr:last-child td:last-child {
  padding: 5px 12px;
  border-bottom: 1px solid hsl(215,30%,80%);
  border-right: 1px solid hsl(215,30%,80%);
  border-bottom-right-radius:10px;
}
.wround {
  border-collapse: collapse
}
.wround td, .notround th {
  border-bottom:1px solid #00BFFF;
  padding:5px
}
.wround th {
  background-color: #00BFFF;
  color:white;
}
.wround th:first-child {
  border-top-left-radius: 10px
}
.wround th:last-child {
  border-top-right-radius: 10px
}
.wround .footer { 
  font-size: 80%;
  font-weight: normal;
}
</style>
<table class="wround">
  <tr>
    <th colspan="3"><a href="<!--Link-->"><p id="eins"><!--gotoTippspiel--></p></a></th>
  </tr>
  <tr bgcolor="#00BFFF">
    <td align="center"><acronym title="Platz">P</acronym></td>
    <td align="left"><acronym title="Name">Name</acronym></td>
    <td align="right"><acronym title="Punkte">Punkte</acronym></td>
  </tr><!-- BEGIN Inhalt -->
  <tr style="<!--Style-->">
    <td align="center"><!--Platz--></td>
    <td align="left"><!--Name--></td>
    <td align="right"><!--Punkte--></td>
	
  </tr><!-- END Inhalt -->
  <tr>
    <td class="footer" valign="bottom" colspan="3" align="right"><!--LetzteAuswertung--></td>
  </tr>
</table>
