<script type="text/javascript">

name="lmo3";
img0 = new Image();
img0.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif";
img1 = new Image();
img1.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin1.gif";
img2 = new Image();
img2.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif";
img3 = new Image();
img3.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin3.gif";
img4 = new Image();
img4.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin4.gif";
img5 = new Image();
img5.src = "<?php echo URL_TO_IMGDIR?>/lmo-admin5.gif";
var lmotest=TRUE;
function chklmopass(){
  if (lmotest == TRUE){
    return confirm("<?php echo $text[117] ?>");
  } else {
    return TRUE;
  }
}
function chklmopas2(a){
  var r=TRUE;
  if (lmotest == TRUE){
    alert("<?php echo $text[117] ?>");
    r=FALSE;
    }
  if (lmotest == FALSE){
    var s3=FALSE;
    for (var i=1;i<a;i++){
      for (var j=i+1;j<=a;j++){
        var s1=document.getElementsByName("xplatz"+i)[0].value;
        var s2=document.getElementsByName("xplatz"+j)[0].value;
        if (s1==s2){s3=TRUE;}
        }
      }
    if (s3 == TRUE){
      alert("<?php echo $text[416]; ?>");
      r=FALSE;
      }
    }
  if (r == FALSE){
    return FALSE;
    }
  }
function chklmolink(){
  if (lmotest == FALSE){
    return confirm("<?php echo $text[119] ?>");
  } else {
    return TRUE;
  }
}
function siklmolink(adresse){
  return confirm("<?php echo $text[249] ?>");
}
function dellmolink(adresse,titel){
  return confirm("<?php echo $text[296] ?>:\n"+titel);
}
function emllmolink(adresse,emailaddi){
  if (ema=prompt("<?php echo $text[346] ?>",emailaddi)){
    if (ema!=""){
      window.open(adresse+"&madr="+ema,"lmoelm","width=250,height=150,resizable=yes,dependent=yes");
    }
  }
}
function dteamlmolink(adresse,team){
  return confirm("<?php echo $text[332] ?>:\n"+team);
}
function ateamlmolink(adresse){
  return confirm("<?php echo $text[335] ?>");
}
function opencal(feld,startdat){
  lmocal="<?php echo URL_TO_LMO?>/lmo-admincal.php?abs=lmoedit&feld="+feld;
  if (startdat!=""){lmocal=lmocal+"&calshow="+startdat;}
  lmowin = window.open(lmocal,"lmocalpop","width=220,height=200,resizable=yes,dependent=yes");
  lmotest=FALSE;
  return FALSE;
}

</script>