<script type="text/javascript">
<!--
var msg1="";
<?
  for($i=0;$i<count($nlines);$i++){
?>
  msg1=msg1+"<? echo $nlines[$i]; ?> +++ ";
<? } ?>
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(52/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/10);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  document.write("<form name='marqueeform'><input class='lmotickerein' type='text' name='marquee' size='52' readonly></form>");
  document.close();
  marquee();
-->
</script>