<table class="lmoSubmenu" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?php
if ($todo != 'tipp') {?>
      <a href='<?php echo $tipp_addr_auswertung?>' onclick="return chklmolink();" title="<?php echo $text['tipp'][63]?>"><?php echo $text['tipp'][63]?></a><?php
} else {
    echo $text['tipp'][63];
}?> </td>
    <td align="center"><?php
if ($_SESSION['lmouserok'] == 2) {
    if ($todo != 'tippemail') {?>
      <a href='<?php echo $tipp_addr_email?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][165]?>"><?php echo $text['tipp'][165]?></a><?php
    } else {
        echo $text['tipp'][165];
    }?> 
    </td>
    <td align="center"><?php
    if ($todo != 'tippuser' && $todo != 'tippuseredit') {?>
      <a href='<?php echo $tipp_addr_user?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][114]?>"><?php echo $text['tipp'][114]?></a><?php
    } else {
        echo $text['tipp'][114];
    }?> 
    </td>
    <td align="center"><?php
    if ($todo != 'tippnachtrag') {?>
      <a href='<?php echo $tipp_addr_nachtrag?>' onClick="return chklmolink();"><?php echo isset($text['tipp'][306]) ? $text['tipp'][306] : 'Enter tips retroactively'?></a><?php
    } else {
        echo isset($text['tipp'][306]) ? $text['tipp'][306] : 'Enter tips retroactively';
    }?> 
    </td>
    <td align="center"><?php
    if ($todo != 'tippbackup') {?>
      <a href='<?php echo $tipp_addr_backup?>' onClick="return chklmolink();"><?php echo isset($text['tipp'][318]) ? $text['tipp'][318] : 'Backup manager'?></a><?php
    } else {
        echo isset($text['tipp'][318]) ? $text['tipp'][318] : 'Backup manager';
    }?> 
    </td>
    <td align="center"><?php
    if ($todo != 'tippoptions') {?>
      <a href='<?php echo $tipp_addr_optionen?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][55]?>"><?php echo $text[86]?></a><?php
    } else {
        echo $text[86];
    }?> 
    </td><?php
}?>
  </tr>
</table>