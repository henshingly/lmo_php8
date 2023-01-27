<?php include("../init.php");?>
name="lmo3";
img0 = new Image();
img0.src = "<i class='bi bi-arrow-up-short text-info'></i>";
img1 = new Image();
img1.src = "<i class='bi bi-arrow-up-short text-danger'></i>";
img2 = new Image();
img2.src = "<i class='bi bi-arrow-down-short text-info'></i>";
img3 = new Image();
img3.src = "<i class='bi bi-arrow-down-short text-danger'></i>";
img4 = new Image();
img4.src = "<i class='bi bi-calendar-date'></i>";
img5 = new Image();
img5.src = "<i class='bi bi-calendar-date-fill'></i>";
lmotest=true;

function lmoimg (x,y){
  document.getElementsByName("ximg"+x)[0].src = y.src;
  }
function dolmoedit(){
  lmotest=false;
  }
function dolmoedi2(a,s){
  var s1=document.getElementsByName(s)[0].value;
  for(var i=1;i<=a;i++){
    if(s!="xplatz"+i){
      var s2=document.getElementsByName("xplatz"+i)[0].value;
      if(s1==s2){
        s3=0;
        s4=0;
        for(var j=1;j<=a;j++){
          s4=s4+j;
          if(s!="xplatz"+j){
            s3=s3+eval(document.getElementsByName("xplatz"+j)[0].value);
          }
        }
        document.getElementsByName("xplatz"+i)[0].selectedIndex=parseInt(s4-s3-1);
      }
    }
  }
  lmotest=false;
}
function chklmopass(){
  if(lmotest == true){
    return confirm("<?php echo $text[117] ?>");
  }else{
    return true;
  }
}
function chklmopas2(a){
  var r=true;
  if(lmotest == true){
    r=confirm("<?php echo $text[117] ?>");
    }
  if(lmotest == false){
    var s3=false;
    for(var i=1;i < a;i++){
      for(var j=i+1;j <= a;j++){
        var s1=document.getElementsByName("xplatz"+i)[0].value;
        var s2=document.getElementsByName("xplatz"+j)[0].value;
        if(s1==s2){s3=true;}
        }
      }
    if(s3 == true){
      alert("<?php echo $text[416]; ?>");
      r=false;
      }
    }
  if(r == false){
    return false;
    }
  }
function siklmolink(adresse){
  return confirm("<?php echo $text[249] ?>");
}
function dellmolink(adresse,titel){
  return confirm("<?php echo $text[296] ?>:\n"+titel);
}
function emllmolink(adresse,emailaddi){
  if(ema=prompt("<?php echo $text[346] ?>",emailaddi)){
    if(ema!=""){
      window.open(adresse+"&madr="+ema,"lmoelm","width=250,height=150,resizable=yes,dependent=yes");
    }
  }
}
function dteamlmolink(adresse,team){
  return confirm("<?php echo $text[332] ?>:\n"+team);
}

function opencal(feld,startdat){
  lmocal="<?php echo URL_TO_LMO?>/lmo-admincal.php?abs=lmoedit&feld="+feld;
  if(startdat!=""){lmocal=lmocal+"&calshow="+startdat;}
  lmowin = window.open(lmocal,"lmocalpop","width=180,height=200,resizable=yes,dependent=yes");
  lmotest=false;
  return false;
}

function fillAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].name.indexOf(elm.name.substr(0,5)) >=0 ) {
      elm.form.elements[i].value = elm.value;
    }
  }

}