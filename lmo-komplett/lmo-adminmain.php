<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once("lmo-admintest.php");
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
  }
$startzeit = getmicrotime();
if($action=="admin"){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  $adda=$PHP_SELF."?action=admin&amp;todo=";
  $addx="lmo-start.php?file=";
  if(!isset($st)){$sty=0;}else{$sty=$st;}
  if(!isset($newpage)){$newpage=0;}
  if(!isset($file)){$file="";}
?>

<script language="JavaScript">
<!---
name="lmo3";
img0 = new Image();
img0.src = "lmo-admin0.gif";
img1 = new Image();
img1.src = "lmo-admin1.gif";
img2 = new Image();
img2.src = "lmo-admin2.gif";
img3 = new Image();
img3.src = "lmo-admin3.gif";
img4 = new Image();
img4.src = "lmo-admin4.gif";
img5 = new Image();
img5.src = "lmo-admin5.gif";
var lmotest=true;
function lmoimg(x,y){
  document.getElementsByName("ximg"+x)[0].src = y.src;
  }
function lmotorclk(x,y,z){
  if(document.all && !window.opera){
    if(z==38){lmotorauf(x,y,1);}
    if(z==40){lmotorauf(x,y,-1);}
    }
  }
function lmoteamauf(x,z){
  var a=document.getElementsByName(x)[0].value;
  if(isNaN(a)==true){a=0;}else{a=parseInt(a);}
  if(a>40){a=40;}
  if(a<4){a=4;}
  if((z==1) && (a<40)){a++;}
  if((z==-1) && (a>4)){a--;}
  document.getElementsByName(x)[0].value=a;
  lmotest=false;
  }
function lmoteamclk(x,z){
  if(document.all && !window.opera){
    if(z==38){lmoteamauf(x,1);}
    if(z==40){lmoteamauf(x,-1);}
    }
  }
function lmoanzstauf(x,z){
  var a=document.getElementsByName(x)[0].value;
  if(isNaN(a)==true){a=0;}else{a=parseInt(a);}
  if(a>116){a=116;}
  if(a<6){a=6;}
  if((z==1) && (a<116)){a++;}
  if((z==-1) && (a>6)){a--;}
  document.getElementsByName(x)[0].value=a;
  lmotest=false;
  }
function lmoanzstclk(x,z){
  if(document.all && !window.opera){
    if(z==38){lmoanzstauf(x,1);}
    if(z==40){lmoanzstauf(x,-1);}
    }
  }
function lmoanzspauf(x,z){
  var a=document.getElementsByName(x)[0].value;
  if(isNaN(a)==true){a=0;}else{a=parseInt(a);}
  if(a>40){a=40;}
  if(a<2){a=2;}
  if((z==1) && (a<40)){a++;}
  if((z==-1) && (a>2)){a--;}
  document.getElementsByName(x)[0].value=a;
  lmotest=false;
  }
function lmoanzspclk(x,z){
  if(document.all && !window.opera){
    if(z==38){lmoanzspauf(x,1);}
    if(z==40){lmoanzspauf(x,-1);}
    }
  }
function lmotorauf(x,y,z){
  if(x=="a"){xx="b";}
  if(x=="b"){xx="a";}
  var a=document.getElementsByName("xgoal"+x+y)[0].value;
  if(a==""){a="-1";}
  if(a=="_"){a="-1";}
  if(a=="X"){a="-2";}
  if(a=="x"){a="-2";}
  var aa=document.getElementsByName("xgoal"+xx+y)[0].value;
  if(aa==""){aa="-1";}
  if(aa=="_"){aa="-1";}
  var ab=aa;
  if(isNaN(a)==true){a=0;}else{a=parseInt(a);}
  if((z==1) && (a<9999)){a++;}
  if((z==-1) && (a>-1)){a--;}
  if((a>-1) && (aa<0)){aa=0;}
  if((a<0) && (aa>-1)){aa=-1;}
  if(a==-2){a="X";}
  if(a==-1){a="_";}
  document.getElementsByName("xgoal"+x+y)[0].value=a;
  if(ab!=aa){
    if(aa==-1){aa="_";}
    document.getElementsByName("xgoal"+xx+y)[0].value=aa;
    }  
  lmotest=false;
  if(a=="X"){lmotorgte(x,y);}
  }
function lmotorgte(x,y){
  var a=document.getElementsByName("xgoal"+x+y)[0].value;
  if((a=="X") || (a=="x")){
    a="-2";
    if(x=="a"){b=1;c="b";}
    if(x=="b"){b=2;c="a";}
    document.getElementsByName("xgoal"+x+y)[0].value=document.getElementsByName("xgoal"+c+y)[0].value;
    document.getElementsByName("xmsieg"+y)[0].selectedIndex=b;
    }
  lmotest=false;
  }
function lmofilename(){
  var s=document.getElementsByName("xfile")[0].value;
  if(s.length==0){s='noname';}
  s=s.replace(/\\/,"/")
  if(s.lastIndexOf("/")>-1){var t=s.substr(s.lastIndexOf("/")+1,s.length); s=t;}
  if(s.substr(s.length-4,s.length).toLowerCase()==".l98"){var t=s.substr(0,s.length-4); s=t;}
  document.getElementsByName("xfile")[0].value=s;
  lmotest=false;
  }
function lmotitelname(){
  var s=document.getElementsByName("xtitel")[0].value;
  if(s.length==0){s='No Name';}
  document.getElementsByName("xtitel")[0].value=s;
  lmotest=false;
  }
function dolmoedit(){
  lmotest=false;
  }
function chklmopass(){
  if(lmotest == true){
    alert("<?PHP echo $text[117] ?>");
    return false;
    }
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
          if(s!="xplatz"+j){s3=s3+eval(document.getElementsByName("xplatz"+j)[0].value);}
          }
        document.getElementsByName("xplatz"+i)[0].selectedIndex=parseInt(s4-s3-1);
        }
      }
    }
  lmotest=false;
  }
function chklmopas2(a){
  var r=true;
  if(lmotest == true){
    alert("<?PHP echo $text[117] ?>");
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
      alert("<?PHP echo $text[416]; ?>");
      r=false;
      }
    }
  if(r == false){
    return false;
    }
  }
function chklmolink(adresse){
  if(lmotest == false){
    if(confirm("<?PHP echo $text[119] ?>") == true){
      self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
      }
    else{
      document.lmoedit.best.focus();
      }
    }
  else{
    self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
    }
  }
function siklmolink(adresse){
  if(confirm("<?PHP echo $text[249] ?>") == true){
    self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
    }
  }
function dellmolink(adresse,titel){
  if(confirm("<?PHP echo $text[296] ?>:\n"+titel) == true){
    self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
    }
  }
function emllmolink(adresse,emailaddi){
  if(ema=prompt("<?PHP echo $text[346] ?>",emailaddi)){
    if(ema!=""){
      lmowelm = window.open(adresse+"&amp;madr="+ema,"lmoelm","width=250,height=150,resizable=no,dependent=yes");
      }
    }
  }
function dteamlmolink(adresse,team){
  if(confirm("<?PHP echo $text[332] ?>:\n"+team) == true){
    self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
    }
  }
function ateamlmolink(adresse){
  if(confirm("<?PHP echo $text[335] ?>") == true){
    self.location.href=<?PHP echo "adresse+\"&".SID."\""; ?>;
    }
  }
function opencal(feld,startdat){
  lmocal="lmo-admincal.php?abs=lmoedit&amp;feld="+feld;
  if(startdat!=""){lmocal=lmocal+"&amp;calshow="+startdat;}
  lmowin = window.open(lmocal,"lmocalpop","width=180,height=200,resizable=no,dependent=yes");
  lmotest=false;
  }
// --->
</script>

<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><nobr>
      <?PHP echo $text[77]." ".$text[54]; ?>
    </nobr></td>
  </tr><tr>
    <td class="lmomain1"><nobr>

<?PHP

if($lmouserok==2){
  if($todo!="new"){echo "<a href=\"javascript:chklmolink('".$adda."new&amp;newpage=".$newpage."');\" title=\"".$text[79]."\">".$text[78]."</a>";}else{echo $text[78];}
  echo "&nbsp;";
  if($todo!="open"){echo "<a href=\"javascript:chklmolink('".$adda."open');\" title=\"".$text[81]."\">".$text[80]."</a>";}else{echo $text[80];}
  echo "&nbsp;";
  if($todo!="delete"){echo "<a href=\"javascript:chklmolink('".$adda."delete');\" title=\"".$text[83]."\">".$text[82]."</a>";}else{echo $text[82];}
  echo "&nbsp;";
  if($file!=""){
    if(($todo!="edit") && ($todo!="tabs")){echo "<a href=\"javascript:chklmolink('".$adda."edit&amp;file=$file');\" title=\"".$text[91]."\">".$text[90]."</a>";}else{echo $text[90];}
    echo "&nbsp;";
    }
  if($todo!="upload"){echo "<a href=\"javascript:chklmolink('".$adda."upload');\" title=\"".$text[85]."\">".$text[84]."</a>";}else{echo $text[84];}
  echo "&nbsp;";
  if($todo!="download"){echo "<a href=\"javascript:chklmolink('".$adda."download');\" title=\"".$text[315]."\">".$text[314]."</a>";}else{echo $text[314];}
  if($file!="" && $einspieler==1){
    echo "&nbsp;";
    require("lmo-openfile.php");
    if($todo!="statistik"){echo "<a href=\"javascript:chklmolink('".$adda."statistik&amp;file=$file');\" title=\"".$text[801]."\">".$text[800]."</a>";}else{echo $text[800];}echo "&nbsp;";  
  } 
  echo "&nbsp;";
  if(($todo!="options") && ($todo!="user") && ($todo!="design")){echo "<a href=\"javascript:chklmolink('".$adda."options');\" title=\"".$text[87]."\">".$text[86]."</a>";}else{echo $text[86];}
  echo "&nbsp;";
  if(($todo!="tipp") && ($todo!="tippemail") && ($todo!="tippuser") && ($todo!="tippuseredit") && ($todo!="tippoptions")){echo "<a href=\"javascript:chklmolink('".$adda."tipp');\" title=\"".$text[557]."\">".$text[500]."</a>";}else{echo $text[500];}
  }
elseif($lmouserok==1){
  if($todo!="open"){echo "<a href=\"javascript:chklmolink('".$adda."open');\" title=\"".$text[81]."\">".$text[80]."</a>";}else{echo $text[80];}
  echo "&nbsp;";
  if($file!=""){
    if(($todo!="edit") && ($todo!="tabs")){echo "<a href=\"javascript:chklmolink('".$adda."edit&amp;file=$file');\" title=\"".$text[91]."\">".$text[90]."</a>";}else{echo $text[90];}
    echo "&nbsp;";
    }
  if($todo!="download"){echo "<a href=\"javascript:chklmolink('".$adda."download');\" title=\"".$text[315]."\">".$text[314]."</a>";}else{echo $text[314];}
  if($file!="" && $einspieler==1){
    echo "&nbsp;";
    require("lmo-openfile.php");
    if($todo!="statistik"){echo "<a href=\"javascript:chklmolink('".$adda."statistik&amp;file=$file');\" title=\"".$text[801]."\">".$text[800]."</a>";}else{echo $text[800];}echo "&nbsp;";  
    } 
  }
?>

    </nobr></td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><nobr>

<?PHP
  echo "<a href=\"javascript:chklmolink('".$adda."logout');\" title=\"".$text[89]."\">".$text[88]."</a>";
  echo "&nbsp;";
  if($lmouserok==2){echo "<a href=\"lmohelp1.htm\" target=\"_blank\" title=\"".$text[313]."\">".$text[312]."</a>";}else{echo "<a href=\"lmohelp2.htm\" target=\"_blank\" title=\"".$text[313]."\">".$text[312]."</a>";}
?>
      
    </nobr></td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center">

<?PHP
if($lmouserok==2){
  if($todo=="new"){require("lmo-adminnew.php");}
  elseif($todo=="open"){require("lmo-adminopen.php");}
  elseif($todo=="delete"){require("lmo-admindelete.php");}
  elseif($todo=="edit"){
    if($sty==-1){require("lmo-adminbasic.php");}
    elseif($sty==-2){require("lmo-adminteams.php");}
    elseif($sty==-3){require("lmo-adminanz.php");}
    else{require("lmo-adminedit.php");}
    }
  elseif($todo=="tabs"){require("lmo-admintab.php");}
  elseif($todo=="upload"){require("lmo-adminupload.php");}
  elseif($todo=="download"){require("lmo-admindown.php");}
  elseif($todo=="options"){require("lmo-adminoptions.php");}
  elseif($todo=="user"){require("lmo-adminuser.php");}
  elseif($todo=="design"){require("lmo-admindesign.php");}
  elseif($todo=="statistik"){include("lmo-statadmin.php");}
  elseif($todo=="tipp"){require("lmo-admintipp.php");}
  elseif($todo=="tippemail"){require("lmo-admintippemail.php");}
  elseif($todo=="tippuser"){require("lmo-admintippuser.php");}
  elseif($todo=="tippuseredit"){require("lmo-admintippuseredit.php");}
  elseif($todo=="tippoptions"){require("lmo-admintippoptions.php");}
  elseif($todo==""){require("lmo-adminpad.php");}
  }
elseif($lmouserok==1){
  if($todo=="open"){require("lmo-adminopen.php");}
  elseif($todo=="edit"){
    if($sty==-1){require("lmo-adminbasic.php");}
    else{require("lmo-adminedit.php");}
    }
  elseif($todo=="tabs"){require("lmo-admintab.php");}
  elseif($todo=="download"){require("lmo-admindown.php");}
  elseif($todo==""){require("lmo-adminpad.php");}
  elseif($todo=="statistik"){include("lmo-statadmin.php");}
  }
?>

    </td>
  </tr>
  <tr><td class="lmomain1" colspan="3" align="right"><nobr>
  <?PHP if($file!=""){echo "<a href=\"".$addx.$file."\" target=\"_blank\" title=\"".$text[116]."\">".$text[115]."</a>";} ?>
  </nobr></td></tr>
  <tr><td class="lmomain2" colspan="3" align="right"><nobr><?PHP echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek."; ?></nobr></td></tr>
</table>

<?PHP } ?>