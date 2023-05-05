<nav class="p-3">
  <ul class="nav nav-pills">
    <li class="nav-item"><?php 
  if ($todo != "") {
    echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp\" class=\"nav-link\">".$text['tipp'][52]."</a>";
  } else {
    echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][52]."</a>";
  }
  echo "</li>";
  echo "<li class='nav-item'>";
  if ($viewermode == 1) {
    echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][9]."</a>";
  } elseif($file != "") {
    if ($tipp_sttipp != -1) {
      if ($todo != "edit") {
        echo "<a href=\"".$adda."edit&amp;file=".$file."&amp;st=".$st."\" class=\"nav-link\">".$text['tipp'][9]."</a>";
      } else {
        echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][9]."</a>";
      }
      echo "</li>";
      echo "<li class='nav-item'>";
    }
    if ($tipp_tippeinsicht == 1) {
      if ($todo != "einsicht") {
        echo "<a href=\"".$adda."einsicht&amp;file=".$file."&amp;st=".$st."\" class=\"nav-link\">".$text['tipp'][157]."</a>";
      } else {
        echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][157]."</a>";
      }
      echo "</li>";
      echo "<li class='nav-item'>";
    }
    if ($lmtype == 0 && $tipp_tipptabelle1 == 1) {
      if ($todo != "tabelle") {
        echo "<a href=\"".$adda."tabelle&amp;file=".$file."\" class=\"nav-link\">".$text['tipp'][172]."</a>";
      } else {
        echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][172]."</a>";
      }
      echo "</li>";
      echo "<li class='nav-item'>";
    }
    if ($tipp_tippfieber == 1) {
      if ($todo != "fieber") {
        echo "<a href=\"".$adda."fieber&amp;file=".$file."\" class=\"nav-link\">".$text[133]."</a>";
      } else {
        echo "<a href=\"#\" class=\"nav-link active\">".$text[133]."</a>";
      }
      echo "</li>";
      echo "<li class='nav-item'>";
    }
    if ($todo != "wert" || $all == 1) {
      echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=einzel\" class=\"nav-link\">".$text['tipp'][54]."</a>";
    } else {
      echo "<a href=\"#\" class=\"nav-link active\">".$text['tipp'][54]."</a>";
    }
    echo "</li>";
    echo "<li class='nav-item'>";
  }
  /*
  if($tipp_gesamt==1){
    if($todo!="wert" || $all!=1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;wertung=einzel&amp;all=1\">".$text['tipp'][56]."</a>";}
    else{echo $text['tipp'][56];}
  }
  echo "&nbsp;&nbsp;";
*/?>
    </li><?php
  if($tipp_regeln==1){?>
    <li class="nav-item">
      <a href='<?php echo URL_TO_ADDONDIR."/tipp/".$tipp_regelnlink?>' class='nav-link' target='regeln' onclick='window.open(this.href,this.target,"scrollbars=yes,resizable=yes");return false;'><?php echo $text['tipp'][185]?></a>
    </li><?php 
  }?>
    <li class="nav-item"><?php 
  echo "<a href=\"".$adda."logout\" class=\"nav-link\" >".$text[88]."</a>";
  ?>
    </li>
  </ul>
</nav>