  <tr>
    <td class="lmost4" colspan="3"><nobr>&nbsp;Limporter Class Library Demo&nbsp;</nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2">Limporter Ligabaum: Ein erzeugtes Liga- Objekt läßt sich relativ einfach um weitere Funktionalitäten erweitern.<BR>Für diese Demo wurde eine Funktion implementiert, die die Liga als Tree abbildet.<BR>Wählen Sie einen Spieltag aus, öffnet sich ein neues Fenster mit der Benutzeransicht des Spieltages.<BR>Das verwendete JAVASCRIPT Modul gibt es
    <a href="http://www.softcomplex.com/products/tigra_tree_menu/" target="_blank">hier</a>.</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2" align=left>
    <Table border=1>
    <TR>
		<td valign="top">
		<script language="JavaScript" src="addon/limporter/js/tree.js"></script>
		<script language="JavaScript" src="addon/limporter/js/tree_tpl.js"></script>
		<script language="JavaScript">
		new tree (<? echo jsLigaTree($liga);?>, tree_tpl);
		</script>
		</td>
		<td valign="top">

		</td>
		<td valign="top">

		</td>
		</tr>
		</table>
		<BR>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr>&nbsp;Inhalt der erzeugten Ligadatei</nobr></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="3"><nobr>&nbsp;
    <textarea name="fileContent" class="lmoadminein" cols="60" rows="10" wrap="OFF"><? echo $liga->fileContent(); ?></textarea>
    <br>&nbsp;</nobr>
    </td>
  </tr>