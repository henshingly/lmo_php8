  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[175] ?>"><?PHP echo "Quelle"; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[175] ?>"><select class="lmo-formular-input" name="xlocation" onChange="dolmoedit()"><?PHP echo "<option value=\"0\""; if($ximporttype==0){echo " selected";} echo ">"."Lokale Datei"."</option>"; echo "<option value=\"1\""; if($ximporttype==1){echo " selected";} echo ">"."Internetadresse (URL)"."</option>"; ?></select></acronym></td>
  </tr>
