<nav>
  <ul class="nav nav-pills justify-content-center">
    <li class="nav-item"><?php 
if ($todo!='tipp') {?>
      <a href='<?php echo $tipp_addr_auswertung?>' class='nav-link' onclick="return chklmolink();" title="<?php echo $text['tipp'][63]?>"><?php echo $text['tipp'][63]?></a><?php 
} else {?>
      <a href='#' class='nav-link active' onclick="return chklmolink();" title="<?php echo $text['tipp'][63]?>"><?php echo $text['tipp'][63]?></a><?php
}?> </li>
    <li class="nav-item"><?php 
if($_SESSION['lmouserok']==2){
  if ($todo!='tippemail') {?>
      <a href='<?php echo $tipp_addr_email?>' class='nav-link' onClick="return chklmolink();" title="<?php echo $text['tipp'][165]?>"><?php echo $text['tipp'][165]?></a><?php 
  } else {?>
      <a href='#' class='nav-link active' onClick="return chklmolink();" title="<?php echo $text['tipp'][165]?>"><?php echo $text['tipp'][165]?></a><?php
  }?> 
    </li>
    <li class="nav-item"><?php 
  if ($todo!='tippuser' && $todo!='tippuseredit') {?>
      <a href='<?php echo $tipp_addr_user?>' class='nav-link' onClick="return chklmolink();" title="<?php echo $text['tipp'][114]?>"><?php echo $text['tipp'][114]?></a><?php 
  } else {?>
      <a href='+' class='nav-link active' onClick="return chklmolink();" title="<?php echo $text['tipp'][114]?>"><?php echo $text['tipp'][114]?></a><?php
  }?> 
    </li>
    <li class="nav-item"><?php 
  if ($todo!='tippoptions') {?>
      <a href='<?php echo $tipp_addr_optionen?>' class='nav-link' onClick="return chklmolink();" title="<?php echo $text['tipp'][55]?>"><?php echo $text[86]?></a><?php 
  } else {?>
      <a href='#' class='nav-link active' onClick="return chklmolink();" title="<?php echo $text['tipp'][55]?>"><?php echo $text[86]?></a><?php
  }?> 
    </li><?php 
}?>
  </ul>
</nav>