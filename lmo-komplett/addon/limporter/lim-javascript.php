<?
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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


?>
<script language="JavaScript" type="text/JavaScript">
<!--
var nextButtonClicked = 0;

function findElement(n, d) {
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function checkHinweis () {
 var r = true;
 var obj = findElement("hw");
 if (obj){
    if (!obj.checked) {
			r = false;
			alert ('Sie müssen zunächst die Nutzungsbedingungen akzeptieren bevor Sie fortfahren können!');
 		}
 }
return r;
}
	

function checkSettings () {
 var r = true;
 if (nextButtonClicked==1) {
     var obj1 = findElement("cols[HEIM][0]");
     var obj2 = findElement("cols[GAST][0]");
     var err='';
     if (obj1){
        if (obj1.value == -1) {
                r = false;
                err = err+'\nHeimmanschaft';
        }
     }
     if (obj2){
        if (obj2.value == -1) {
                r = false;
                err = err+'\nGastmannschaft';
        }
     }
     if (r==false) {
        alert('Sie haben nicht alle Pflichtfelder zugeordnet.\nBitte geben Sie eine Spaltenzuordnung für folgende Attribute an:\n'+err);
        }
 }
nextButtonClicked=0;
return r;
}


//-->
</script>
