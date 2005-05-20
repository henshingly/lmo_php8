<?PHP
//
// Limporter Version 1.0
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
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
//require_once(PATH_TO_ADDONDIR.'/limporter/ini.php');

?>
<table width="650" border="1" cellspacing="0" cellpadding="1" class="csvtablebody">
  <tr>
    <td width="48" class="csvtableheader" colspan=2>&nbsp;</td>

<?PHP
  $regExpArray = array_values($lim_format_exp);
  $regExpNameArray =  array_keys($lim_format_exp);
  for ($i=0;$i<$col;$i++) {
    echo "<td class=\"csvtableheader\" align=\"center\">";
        $spTitel = "";
        foreach ($colums as $colum) {
        	if($colum[0]==$i) {$spTitel = $spTitel."&nbsp;<B>".$colum[2]."</B>&nbsp;";}
        }
        if($spTitel == "") {
          if($all==1){$spTitel=".";}
          else {
            if ($hd==1 and $rows[0][$i]!="") {$spTitel=$rows[0][$i];}
            else {$spTitel=$text['limporter'][62]."&nbsp;".($i+1);} // Für die Anzeige fangen wir bei 1 an
          }
        }
        echo $spTitel;
  echo "</td>\n";
  } // for Schleife
  echo "</tr>\n";

  $y = 1; // Zeilencounter
  foreach ($rows as $row) {
    if($y != $hd) {
        echo "<tr><td class='csvtableheader' colspan=2 align='center'>z".($y+$offset)."</td>";
        $x = 0;// Spaltencounter;
        foreach ($row as $value) {
            if($y == $hd) echo "<td class='csvtableheaderrow'>";else echo "<td class='csvtable'>";
            if ($all==0 or in_array($x,$showColum) ) {
              echo substr($value,0,50)."<BR>";
              if (in_array($x,$showColum)) {
                $ergebnis="";
                foreach ($colums as $colum) {
                  // Spalte wurde gewählt
                	if ($colum[0] == $x) {
                		if ($colum[1]>0 ) { // formatierung muss vorgenommen werden
                  		$myRegEx = $regExpArray[$colum[1]-1];
                      if(preg_match($myRegEx,$value,$results)) {
                        $ergebnis.=" <acronym title='(".($y+$offset).",".$colum[2].") ".$text['limporter'][63]." ";
                        $ergebnis.=$regExpNameArray[$x]." Regexp=$myRegEx'>".$results[1]."</acronym>";
                  		}
                    }
                    else {
                      $ergebnis.=" <acronym title='(".($y+$offset).",".$colum[2];
                      $ergebnis.=") ".$text['limporter'][64]."'>".$value."</acronym>";
                      }
                    echo "<nobr><B>".$ergebnis."</B></nobr>";
                   }
                } // foreach
              } // if in_array
            } // if
            echo "&nbsp;</td>\n";
            $x++;
        } // foreach
        echo "</tr>\n";
    }
    $y++;
  }
  echo "</table>\n";
?>