<div class="container-fluid"><?php if(strlen($cal)>4){ ?>
  <div class="row justify-content-center">
    <div class="col">
      <div class="container-fluid">
        <div class="row">
          <div class="col-3 text-end"><a href="<?php echo $addk.$ma; ?>" title="<?php echo $text[142]; ?>"><?php echo $text[5]; ?></a></div>
          <div class="col-6 text-center"><a href="<?php echo $addk.$ml; ?>" title="<?php echo $text[173]; ?>"><?php echo $md; ?></a></div>
          <div class="col-3 text-start"><a href="<?php echo $addk.$mb; ?>" title="<?php echo $text[143]; ?>"><?php echo $text[154]; ?></a>&nbsp;&nbsp;<a href="<?php echo $addk.$mc; ?>" title="<?php echo $text[144]; ?>"><?php echo $text[7]; ?></a></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-1"><strong><?php echo $text[147]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[148]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[149]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[150]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[151]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[152]; ?></strong></div>
          <div class="col-1"><strong><?php echo $text[153]; ?></strong></div>
        </tr>
<?php 
  $dat0 = getdate(time());
  if ($erster != 1) {
    if ($erster == 0) {
      $erster = 7;
    }
    echo "<div class='row justify-content-center'>";
    for($i = 0; $i < $erster-1; $i++) {
      echo "<div class='col-1'>&nbsp;</div>";
    }
  }
  for($i = 1; $i <= 31; $i++) {
    $dat4 = getdate(strtotime($i.$mj));
    $heute = $dat4['wday'];
    if ($heute == 0) {
      $heute = 7;
    }
    if ($dat1['mon'] == $dat4['mon']) {
      $stil = "";
      $dum6 = $dat0['mday'].".".$dat0['mon'].".".$dat0['year'];
      $dum7 = $dat4['mday'].".".$dat4['mon'].".".$dat4['year'];
      if ($dum6 == $dum7) {
        if (($heute == 6) || ($heute == 7)) {
          $stil = "bg-warning";
        } else {
          $stil = "bg-info";
        }
      } else {
        if (($heute == 6) || ($heute == 7)) {
          $stil = "bg-warning";
        } else {
          $stil = "";
        }
      }
      if ($i <= 9) {
        $k = "0";
      } else {
        $k = "";
      }
      if ($heute == 1) {
        echo "<div class='row justify-content-center'>";
      }
      echo "<div class='col-1 $stil'>".$i."<br />&nbsp;";
      if (!empty($lmo_stlink[$i])) {
        echo $lmo_stlink[$i];
      }
      echo "</div>";
      if ($heute == 7) {
        echo "</div>";
      }
      $j = $heute;
    }
  }
  //print_r($dum2);
  if ($j != 7) {
    for ($i = 0; $i < 7-$j; $i++) {
      echo "<div class='col-1'>&nbsp;</div>";
    }
    echo "</div>";
  }
  
} else {

?>
  <div class="row justify-content-center">
    <div class="col">
      <div class="container-fluid">
        <div class='row'>
          <div class="col-3 text-end"><a href="<?php echo $addk.$ma; ?>" title="<?php echo $text[157]; ?>"><?php echo $text[5]; ?></a></div>
          <div class="col-6 text-center"><?php echo $text[156]." ".$md; ?></div>
          <div class="col-3 text-start"><a href="<?php echo $addk.$mb; ?>" title="<?php echo $text[158]; ?>"><?php echo $text[154]; ?></a>&nbsp;&nbsp;<a href="<?php echo $addk.$mc; ?>" title="<?php echo $text[159]; ?>"><?php echo $text[7]; ?></a></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col justify-content-center">
      <tdiv class="container-fluid"><?php 
  $dat0 = getdate(time());
  $lmo_output_buffer=array();
  for($i = 1; $i <= 12; $i++) {
    if (($i == 1) || ($i == 7)) {
      echo "<div class='row justify-content-center'>";
    }
    echo "<div class='col-1'>";
    if ($i <= 9) {
      $k = "0";
    } else {
      $k = "";
    }
    echo "<a href=\"".$addk.$k.$i.$md."\" title=\"".$text[172]."\">".$text[159+$i]."</a></div>";
    

    $lmo_output_buffer[$i]=$lmo_stlink[$i]."<br>";
  
    echo "</div>";
    if (($i == 6) || ($i == 12)) {
      echo "</div><div class='row justify-content-center'><div class='col-1'>";
      echo implode("</div><div class='col-1'>",$lmo_output_buffer);
      echo "</div>";
      $lmo_output_buffer=array();
    }
  }
}?>
      </div>
    </div>
  </div>
</div>