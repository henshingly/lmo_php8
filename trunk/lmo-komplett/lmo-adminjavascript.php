<script type="text/javascript">

name="lmo3";
img0 = new Image();
img0.src = "<?=URL_TO_IMGDIR?>/lmo-admin0.gif";
img1 = new Image();
img1.src = "<?=URL_TO_IMGDIR?>/lmo-admin1.gif";
img2 = new Image();
img2.src = "<?=URL_TO_IMGDIR?>/lmo-admin2.gif";
img3 = new Image();
img3.src = "<?=URL_TO_IMGDIR?>/lmo-admin3.gif";
img4 = new Image();
img4.src = "<?=URL_TO_IMGDIR?>/lmo-admin4.gif";
img5 = new Image();
img5.src = "<?=URL_TO_IMGDIR?>/lmo-admin5.gif";
var lmotest=true;
function chklmopass(){
  if(lmotest == true){
    return confirm("<? echo $text[117] ?>");
  }else{
    return true;
  }
}
function chklmopas2(a){
  var r=true;
  if(lmotest == true){
    alert("<? echo $text[117] ?>");
    r=false;
    }
  if(lmotest == false){
    var s3=false;
    for(var i=1;i<a;i++){
      for(var j=i+1;j<=a;j++){
        var s1=document.getElementsByName("xplatz"+i)[0].value;
        var s2=document.getElementsByName("xplatz"+j)[0].value;
        if(s1==s2){s3=true;}
        }
      }
    if(s3 == true){
      alert("<? echo $text[416]; ?>");
      r=false;
      }
    }
  if(r == false){
    return false;
    }
  }
function chklmolink(){
  if(lmotest == false){
    return confirm("<? echo $text[119] ?>");
  }else{
    return true;
  }
}
function siklmolink(adresse){
  return confirm("<? echo $text[249] ?>");
}
function dellmolink(adresse,titel){
  return confirm("<? echo $text[296] ?>:\n"+titel);
}
function emllmolink(adresse,emailaddi){
  if(ema=prompt("<? echo $text[346] ?>",emailaddi)){
    if(ema!=""){
      window.open(adresse+"&madr="+ema,"lmoelm","width=250,height=150,resizable=yes,dependent=yes");
    }
  }
}
function dteamlmolink(adresse,team){
  return confirm("<? echo $text[332] ?>:\n"+team);
}
function ateamlmolink(adresse){
  return confirm("<? echo $text[335] ?>");
}
function opencal(feld,startdat){
  lmocal="<?=URL_TO_LMO?>/lmo-admincal.php?abs=lmoedit&feld="+feld;
  if(startdat!=""){lmocal=lmocal+"&calshow="+startdat;}
  lmowin = window.open(lmocal,"lmocalpop","width=180,height=200,resizable=yes,dependent=yes");
  lmotest=false;
  return false;
}

</script>