  <tr>
    <td class="lmost4" colspan="3"><nobr>&nbsp;Limporter Ligabaum&nbsp;</nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2" align=left>
		<script language="JavaScript" src="addon/limporter/js/tree.js"></script>
		<script language="JavaScript" src="addon/limporter/js/tree_tpl.js"></script>
		<script language="JavaScript">
		var LIGATREE =<?PHP echo $lFile->jsLigaTree();?>
		new tree (LIGATREE, tree_tpl);
		</script>
		<BR>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr>&nbsp;Inhalt des erzeugten Ligafile&nbsp;</nobr></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="3"><nobr>&nbsp;
    <textarea name="fileContent" class="lmoadminein" cols="60" rows="10" wrap="OFF"><?PHP echo $lFile->fileContent(); ?></textarea>
    <br>&nbsp;</nobr>
    </td>
  </tr>