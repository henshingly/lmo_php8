<?PHP
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
  
  
$qs=getenv("QUERY_STRING");
?>
<FRAMESET ROWS="*">	
<FRAME SRC="lmo.php?<?PHP echo $qs; ?>" Name="lmo" MARGINWIDTH=0 MARGINHEIGHT=0 NORESIZE FRAMEBORDER="No" BORDER=0>
</FRAMESET>
