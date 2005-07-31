<style type="text/css">
.viewer * {
  font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
  font-size: 11px;
}
.viewer {
  border: none;
  margin: 0 0 0 0;
  background-color: Blue;
  color: white;
}

.viewer a {
  text-decoration: none;
  color: #fff;
}
.viewer a:visited {
  text-decoration: none;
  color: #999;
}

.viewer td, .viewer th {
   font-size: 12px;
  margin: 0 0 0 0;
   border: none;
}

.viewer h2 {
  font-size: 12px;
  font-weight: bold;
  padding:0.3em;margin:0;
  color: black;
  background-color: #c0c0c0;
  white-space:nowrap;
  text-align: left;
}
.viewer .vRow, .vRowHighlight {
  font-size: 10px;
  background-color:white;
  color: black;
}

.viewer .vRow a, .viewer .vRowHighlight a{
  color: black;
}

.viewer .vRowHighlight {
  font-weight: bold;
}

</style>
<table class="viewer">
  <tr>
    <th>Aktueller Spieltag +<!--Anfangsdatum--><!--Spieltageplus--> / -<!--Enddatum--><!--Spieltageminus--></th>
  </tr>
  <tr>
    <td>
      <table>
          <!-- BEGIN Liga -->
            <tr>
              <td colspan="6"><h2><!--Liganame--></h2></td>
            </tr>
            <tr>
              <td>
                <table width=100%  cellspacing="0"  cellpadding="2">
                  <!-- BEGIN Inhalt -->
                    <tr class="<!--Zeilenklasse-->">
                      <td><!--Spieltag--></td>
                      <td><!--Datum--></td>
                      <td><!--Uhrzeit--></td>
                      <td align="right"><acronym title="<!--HeimLang-->"><!--Heim--></acronym></td><td><!--Iconheim--></td>
                      <td>&nbsp;-&nbsp;</td>
                      <td><!--Icongast--></td><td align="left"><acronym title="<!--GastLang-->"><!--Gast--></acronym></td>
                      <td><!--Tore--></td>
                      <td><!--Tabellenlink--></td>
                      <td><!--Notiz--></td>
                      <td><!--Spielbericht--></td>
                    </tr>
                  <!-- END Inhalt -->
                </table>
              </td>
            </tr>
          <!-- END Liga -->
      </table>
    </td>
  </tr>
  <tr>
    <td align="right"><small><!--VERSION--></small></td>
  </tr>
</table>
