// Color Picker Script from Flooble.com
// For more information, visit 
//	http://www.flooble.com/scripts/colorpicker.php
// Copyright 2003 Animus Pactum Consulting inc.
// 
// Extended and debugged by Rene Marth 2004
//
//---------------------------------------------------------
var perline = 9;
var divSet = false;
var curId;
var colorLevels = Array('0', '3', '6', '9', 'C', 'F');
var colorArray = Array();
var ie = false;
var nocolor = 'none';

if (document.all ) { 
  ie = true; nocolor = ''; 
}
function getObj(id) {
  if (ie) { return document.all[id]; } 
  else {	return document.getElementById(id);	}
}

function addColor(r, g, b) {
  var red = colorLevels[r];
  var green = colorLevels[g];
  var blue = colorLevels[b];
  addColorValue(red, green, blue);
}

function addColorValue(r, g, b) {
  colorArray[colorArray.length] = '#' + r + g + b;
}

function setColor(color) {
  var link = getObj(curId);
  var field = getObj(curId + 'input');
  
  var picker = getObj('colorizer');

  field.value = color;
  if (color == '') {
    link.className = 'colorpicker nocolor';
  } else {
    link.className = 'colorpicker';
    link.style.backgroundColor = color;
  }
  picker.style.display = 'none';

  getObj(curId).title = color;
}

function setDiv(id) {   
  if (document.createElement) { 
    var elemDiv = document.createElement('div');
    if (typeof(elemDiv.innerHTML) != 'string') { return; }
    genColors();
    elemDiv.id = 'colorizer';
    elemDiv.style.position = 'absolute';
    elemDiv.style.display = 'none';   
    elemDiv.style.border = '#000 1px solid';
    elemDiv.style.background = '#FFF';
    elemDiv.innerHTML = '<span style="font-family:Verdana; font-size:11px;background:#fff;color:#000;">Farbwahl: ' 
                          + '(<a href="#" onClick="setColor(\'\');return false;">Keine</a>)&nbsp;&nbsp;&nbsp;<a style="border:1px solid #000;text-decoration:none;font-weight:bold;font-family:Verdana;background:#fff;color:#000;" href="#" onClick="document.getElementById(\'colorizer\').style.display=\'none\';return false;"> X </a><br>' 
                          + getColorTable() 
                          + '</span>';
    
    if (navigator.userAgent.indexOf("Gecko")!=-1){ 
     
      elemDiv.style.textAlign = 'left';   
      elemDiv.style.marginLeft = getObj(id).offsetLeft+'px';
      getObj(id).parentNode.insertBefore(elemDiv,getObj(id));
      
    } else { 
      document.body.appendChild(elemDiv);
    }
    divSet = true;
  }
}

function pickColor(id) {
  if (!divSet) { setDiv(id); }
  var picker = getObj('colorizer');   	
  if (id == curId && picker.style.display == 'block') {
    picker.style.display = 'none';
    return;
  }
  curId = id;
  var thelink = getObj(id);
  if (navigator.userAgent.indexOf("Gecko")!=-1){ 
    picker.style.marginLeft = getObj(id).offsetLeft+'px';
    picker.style.marginTop = getObj(id).parentNode.offsetTop+'px';
  } else { 
    picker.style.top = getAbsoluteOffsetTop(thelink) + 20;
    picker.style.left = getAbsoluteOffsetLeft(thelink);   
  }
  picker.style.display = 'block';
  dolmoedit();
}

function genColors() {
  addColorValue('0','0','0');
  addColorValue('3','3','3');
  addColorValue('6','6','6');
  addColorValue('8','8','8');
  addColorValue('9','9','9');        
  addColorValue('a','a','a');
  addColorValue('c','c','c');
  addColorValue('e','e','e');
  addColorValue('f','f','f');                
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(0,0,a);
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(a,a,5);
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(0,a,0);
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(a,5,a);
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(a,0,0);
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(5,a,a);
  
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(a,a,0);
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(5,5,a);
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(0,a,a);
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(a,5,5);
  
  for (a = 1; a < colorLevels.length; a++)
  addColor(a,0,a);			
  for (a = 1; a < colorLevels.length - 1; a++)
  addColor(5,a,5);
  
  return colorArray;
}

function getColorTable() {
  var colors = colorArray;
  var tableCode = '';
  tableCode += '<table border="0" cellspacing="1" cellpadding="1" style="margin:0">';
  for (i = 0; i < colors.length; i++) {
    if (i % perline == 0) { tableCode += '<tr>'; }
    tableCode += '<td style="cursor:crosshair;color: '+ colors[i] + '; background: ' + colors[i] + ';font-size: 10px;"><a style="cursor:crosshair;background:transparent;diplay:block;text-decoration:none;" title="' 
              + colors[i] + '" href="#" onClick="setColor(\'' + colors[i] + '\');return false;">&nbsp;&nbsp;&nbsp;</a></td>';
    if (i % perline == perline - 1) { tableCode += '</tr>'; }
  }
  if (i % perline != 0) { tableCode += '</tr>'; }
  tableCode += '</table>';
  return tableCode;
}

function relateColor(id, color) {
  
  var link = getObj(id);
  if (color.substr(0,1)!='#') { color="#" + color;}

  if ((color.search(/^#[0-9|a-f|A-F]{3}$/) == -1) && (color.search(/^#[0-9|a-f|A-F]{6}$/) == -1)) {
    link.style.backgroundColor = 'transparent';
    if (color=="#") {
      link.className = 'colorpicker nocolor';
      link.title="No Color";
    } else{
      link.className = 'colorpicker invalid';
      link.title="No valid Color!";
      
      
      
    }
    color = nocolor;
    //for (i in link.currentStyle) {if (link.currentStyle[i]!='') alert(i+" "+link.currentStyle[i]);}
  }else{
    link.className = 'colorpicker';
    link.style.backgroundColor = color;
    link.title = color;
  }
  
  
}

function getAbsoluteOffsetTop(obj) {
  var top = obj.offsetTop;
  var parent = obj.offsetParent;
  while (parent != document.body) {
    top += parent.offsetTop;
    parent = parent.offsetParent;
  }
  return top;
}

function getAbsoluteOffsetLeft(obj) {
  var left = obj.offsetLeft;
  var parent = obj.offsetParent;
  while (parent != document.body) {
    left += parent.offsetLeft;
    parent = parent.offsetParent;
  }
  return left;
}
function makePicker(id){
  if (document.createElement) { 
    document.write('&nbsp;<span onClick="pickColor(\''+id+'\');return false;" id="'+id+'" class="colorpicker">&nbsp;&nbsp;&nbsp;</span>');
    relateColor(id, getObj(id+'input').value);
  }
}