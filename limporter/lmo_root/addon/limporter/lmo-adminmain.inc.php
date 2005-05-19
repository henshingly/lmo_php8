<?php
  if (file_exists(PATH_TO_ADDONDIR."/limporter/ini.php")) {
    if($todo!="import"){echo "<a href='{$adda}import&amp;imppage="
      .$newpage."' onclick='return chklmolink(this.href);' title=\""
      .$text['limporter'][1]."\">".$text['limporter'][0]."</a>";}
    else{
      echo $text['limporter'][0];
    }
    echo "&nbsp;";
  }