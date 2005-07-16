<?php
if($_SESSION['lmouserok']==2) {
  if (file_exists(PATH_TO_ADDONDIR."/limporter/lim-adminupdate.php")) {
    if($st!=-9){?>
        <td align="center">
          <a href='<?=$addr?>-9' onclick="return chklmolink(this.href);" title="<?=$text['limporter'][13]?>"><?=$text['limporter'][12]?></a>
        </td><?
    }else{?>
        <td align="center"><?=$text['limporter'][12]?></td><?
    }
  }

  if (file_exists(PATH_TO_ADDONDIR."/limporter/lim-adminrounds.php")) {
    if($st!=-10){?>
        <td align="center">
          <a href='<?=$addr?>-10' onclick="return chklmolink(this.href);" title="<?=$text['limporter'][15]?>"><?=$text['limporter'][14]?></a>
        </td><?
    }else{?>
        <td align="center"><?=$text['limporter'][14]?></td><?
    }
  }
}
?>