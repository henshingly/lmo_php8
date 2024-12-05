<script type="text/javascript">
<!---
function immerallechange(){
  lmotest=FALSE;
  for (i=0;i<document.getElementsByName("xtipperligen[]").length;i++){
    if (document.getElementsByName("ximmeralle")[0].checked==0){
      document.getElementsByName("xtipperligen[]")[i].disabled=FALSE;
      }
    else {
      document.getElementsByName("xtipperligen[]")[i].disabled=TRUE;
      }
    }
  }
function moduschange(){
  lmotest=FALSE;
  if (document.getElementsByName("xtippmodus")[0].value==1){
    document.getElementsByName("xrergebnis")[0].disabled=FALSE;
    document.getElementsByName("xrtendenzdiff")[0].disabled=FALSE;
    document.getElementsByName("xrtendenz")[0].disabled=FALSE;
    document.getElementsByName("xrtor")[0].disabled=FALSE;
    document.getElementsByName("xrtendenztor")[0].disabled=FALSE;
    document.getElementsByName("xrtendenzremis")[0].disabled=FALSE;
    document.getElementsByName("xshowdurchschntipp")[0].disabled=FALSE;
    document.getElementsByName("xpfeiltipp")[0].disabled=FALSE;
    }
  else {
    document.getElementsByName("xrergebnis")[0].disabled=TRUE;
    document.getElementsByName("xrtendenzdiff")[0].disabled=TRUE;
    document.getElementsByName("xrtendenz")[0].disabled=TRUE;
    document.getElementsByName("xrtor")[0].disabled=TRUE;
    document.getElementsByName("xrtendenztor")[0].disabled=TRUE;
    document.getElementsByName("xrtendenzremis")[0].disabled=TRUE;
    document.getElementsByName("xshowdurchschntipp")[0].disabled=TRUE;
    document.getElementsByName("xpfeiltipp")[0].disabled=TRUE;
    }
  }

function regelnchange(){
  lmotest=FALSE;
  if (document.getElementsByName("xregeln")[0].checked==1){
    document.getElementsByName("xregelnlink")[0].disabled=FALSE;
    }
  else {
    document.getElementsByName("xregelnlink")[0].disabled=TRUE;
    }
  }

function jokerchange(){
lmotest=FALSE;
  if (document.getElementsByName("xjokertipp")[0].checked==1){
    document.getElementsByName("xjokertippmulti")[0].disabled=FALSE;   
    }
  else {
    document.getElementsByName("xjokertippmulti")[0].disabled=TRUE;    
    }
  }

function viewerchange(){
lmotest=FALSE;
  if (document.getElementsByName("xviewertipp")[0].checked==1){
    document.getElementsByName("xviewertage")[0].disabled=FALSE;   
  } else {
    document.getElementsByName("xviewertage")[0].disabled=TRUE;    
  }
  if (document.getElementsByName("xsttipp")[0].checked==0 && document.getElementsByName("xviewertipp")[0].checked==0){
      alert('<?php echo $text['tipp'][301]?>');
  }
}	  
// --->
</script>