<table class="lmoSubmenu" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?
if ($todo!='tipp') {?>
      <a href='<?=$tipp_addr_auswertung?>' onclick="return chklmolink();" title="<?=$text['tipp'][63]?>"><?=$text['tipp'][63]?></a><?
} else {
  echo $text['tipp'][63];
}?> </td>
    <td align="center"><?
if($_SESSION['lmouserok']==2){
  if ($todo!='tippemail') {?>
      <a href='<?=$tipp_addr_email?>' onClick="return chklmolink();" title="<?=$text['tipp'][165]?>"><?=$text['tipp'][165]?></a><?
  } else {
    echo $text['tipp'][165];
  }?> 
    </td>
    <td align="center"><?
  if ($todo!='tippuser' && $todo!='tippuseredit') {?>
      <a href='<?=$tipp_addr_user?>' onClick="return chklmolink();" title="<?=$text['tipp'][114]?>"><?=$text['tipp'][114]?></a><?
  } else {
    echo $text['tipp'][114];
  }?> 
    </td>
    <td align="center"><?
  if ($todo!='tippoptions') {?>
      <a href='<?=$tipp_addr_optionen?>' onClick="return chklmolink();" title="<?=$text['tipp'][55]?>"><?=$text[86]?></a><?
  } else {
    echo $text[86];
  }?> 
    </td><?
}?>
  </tr>
</table>