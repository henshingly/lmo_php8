<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
 
/*Zusatzoptionen ab beta3*/
if (!isset($lmo_fieber_color1)) {
  $cfgarray['lmo_fieber_color1']='#00f';
  $lmo_fieber_color1='#00f';
}
if (!isset($lmo_fieber_color2)) {
  $cfgarray['lmo_fieber_color2']='#f00';
  $lmo_fieber_color2='#f00';
}
if (isset($cfgarray['einhinrueck'])) {
  unset($cfgarray['einhinrueck']);
}
/*Zusatzoptionen ab beta3*/
?>