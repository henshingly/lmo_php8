<?php include("../init.php");?>
lmotest=true;

function dolmoedit(){
  lmotest=false;
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

function fillAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].name.indexOf(elm.name.substr(0,5)) >=0 ) {
      elm.form.elements[i].value = elm.value;
    }
  }

}