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
  if($endtab==0){
    if(isset($anzst)){$endtab=$anzst;}
    $tabdat="";
    }
  else{
    $tabdat=$endtab.". ".$text[2];
    }

//  if($stwertmodus=="bis" ){$endtab=$anzst;}
  if($all==1){
    $endtab=0;
    $tabdat="";
    $anzst=0;
    }
  else{
    $st=$endtab;
    }
  if(!isset($wertung)){$wertung="einzel";}
  if(!isset($gewicht)){$gewicht="absolut";}
  if(!isset($stwertmodus)){$stwertmodus="nur";}
  if(($tabdat!="" && $stwertmodus=="nur") || $all==1){$showstsiege=0;}
  if(!isset($anzseite1)){$anzseite1=30;}
  if(!isset($von)){$von=1;}
  if(!isset($start)){$start=1;}
  if(!isset($eigpos)){$eigpos=1;}
  if($anzseite1<1){$anzseite1=30;}

  if($endtab>1 && $tabdat!="" && $stwertmodus!="nur"){
    $endtab--;
    if($wertung=="einzel" || $wertung=="intern"){require("lmo-tippcalcwert.php");}
    else{require("lmo-tippcalcwertteam.php");}
    
    if($wertung=="team"){$anztipper=$teamsanzahl;}
    $platz1 = array("");
    $platz1 = array_pad($array,$anztipper+1,"");
    for($x=0;$x<$anztipper;$x++){$x3=intval(substr($tab0[$x],-7));$platz1[$x3]=$x+1;}
    $endtab++;
    }
  if($wertung=="einzel" || $wertung=="intern"){require("lmo-tippcalcwert.php");}
  else{require("lmo-tippcalcwertteam.php");}

  if($wertung=="team"){$anztipper=$teamsanzahl;}
  $platz0 = array("");
  if(!isset($anztipper)){$anztipper=0;}
  $platz0 = array_pad($array,$anztipper+1,"");
  for($x=0;$x<$anztipper;$x++){
    $x3=intval(substr($tab0[$x],-7));
    $platz0[$x3]=$x+1;
    }
  if($tabdat==""){$addt1=$PHP_SELF."?action=tipp&amp;todo=wert&amp;all=".$all."&amp;file=".$file."&amp;PHPSESSID=".$PHPSESSID."&amp;gewicht=".$gewicht."&amp;wertung=";}else{$addt1=$PHP_SELF."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;PHPSESSID=".$PHPSESSID."&amp;file=".$file."&amp;gewicht=".$gewicht."&amp;endtab=".$endtab."&amp;wertung=";}
  $addt2=$PHP_SELF."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;PHPSESSID=".$PHPSESSID."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;endtab=";
  if($tabdat==""){$addt3=$PHP_SELF."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;PHPSESSID=".$PHPSESSID."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;start=";}else{$addt3=$PHP_SELF."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;PHPSESSID=".$PHPSESSID."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;endtab=".$endtab."&amp;start=";}
  $addt4=$PHP_SELF."?action=tipp&amp;todo=wert&amp;gewicht=".$gewicht."&amp;file=".$file."&amp;endtab=".$endtab."&amp;PHPSESSID=".$PHPSESSID."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;stwertmodus=";
  if($tabdat==""){$addt5=$PHP_SELF."?action=tipp&amp;todo=wert&amp;all=".$all."&amp;file=".$file."&amp;PHPSESSID=".$PHPSESSID."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;gewicht=";}else{$addt5=$PHP_SELF."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;PHPSESSID=".$PHPSESSID."&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ","%20",$teamintern)."&amp;gewicht=";}

?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <font color=black><?PHP if($HTTP_SESSION_VARS["lmotipperok"]==5){echo $lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;}}else{echo $text[2158];} ?></font>
  </td></tr>
<?PHP if($all!=1){ ?>
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  echo "<td align=\"right\" valign=\"top\" class=\"lmost1\" colspan=\"3\" rowspan=\"4\">";
  echo $text[2285].":"; // Spieltagswertung:
  echo "&nbsp;</td>";
  for($i=1;$i<=$anzst;$i++){
    echo "<td align=\"right\" ";
    if($lmtype==1){
      if($i==$anzst){$j=$text[364];}
      elseif($i==$anzst-1){$j=$text[362];}
      elseif($i==$anzst-2){$j=$text[360];}
      elseif($i==$anzst-3){$j=$text[358];}
      else{$j=$i;}
      }
    else{$j=$i;}
    if(($i!=$endtab) || (($i==$endtab) && ($tabdat==""))){
      echo "class=\"lmost0\"><a href=\"".$addt2.$i."\" title=\"".$text[45]."\">".$j."</a>";
      }
    else{
      echo "class=\"lmost1\">".$j;
      }
    echo "&nbsp;</td>";
    if(($anzst>49) && (($anzst%4)==0)){
      if(($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)){echo "</tr><tr>";}
      }
    elseif(($anzst>38) && (($anzst%3)==0)){
      if(($i==$anzst/3) || ($i==$anzst/3*2)){echo "</tr><tr>";}
      }
    elseif(($anzst>25) && (($anzst%2)==0)){
      if($i==$anzst/2){echo "</tr><tr>";}
      }
    }
?>
    </tr></table></td>
  </tr>
<?PHP } //if($all!=1)
  if($tipperimteam>=0){
?>
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td ";
    if($wertung=="einzel"){
      echo "class=\"lmost1\">".$text[2061];
      }  
    else{
      echo "class=\"lmost0\"><a href=\"".$addt1."einzel\" title=\"".$text[2059]."\">".$text[2061]."</a>";
      }
    echo "&nbsp;</td>";

    echo "<td ";
    if($wertung=="team"){
      echo "class=\"lmost1\">".$text[2062];
      }  
    else{
      echo "class=\"lmost0\"><a href=\"".$addt1."team\" title=\"".$text[2060]."\">".$text[2062]."</a>";
      }
    echo "&nbsp;</td>";

    if($lmotipperverein!="" || $wertung=="intern"){
      echo "<td ";
      if($wertung=="intern"){
        echo "class=\"lmost1\">".$text[2144];
        }  
      else{
        echo "class=\"lmost0\"><a href=\"".$addt1."intern&amp;teamintern=".str_replace(" ","%20",$lmotipperverein)."\" title=\"".$text[2144]."\">".$text[2144]."</a>";
        }
      echo "&nbsp;</td>";
      }
?>
    </tr></table></td>
  </tr>
<?PHP }
if($tabdat!=""){ ?>
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td ";
    if($stwertmodus=="nur"){
      echo "class=\"lmost1\">".$text[2202];
      }  
    else{
      echo "class=\"lmost0\"><a href=\"".$addt4."nur\" title=\"".$text[2202]."\">".$text[2202]."</a>";
      }
    echo "&nbsp;</td>";
    echo "<td ";
    if($stwertmodus=="bis"){
      echo "class=\"lmost1\">".$text[2203];
      }  
    else{
      echo "class=\"lmost0\"><a href=\"".$addt4."bis\" title=\"".$text[2203]."\">".$text[2203]."</a>";
      }
    echo "&nbsp;</td>";
?>
    </tr></table></td>
  </tr>
<?PHP }
    $dummy=" align=\"right\"";
    if($wertung=="intern"){$start=1;$anzseite1=$anztipper;}
    if($anzseite1>0){$anzseiten=$anztipper/$anzseite1;}
    if($anzseiten>1){ ?> 
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td class=\"lmost1\">".$text[2205]."&nbsp;</td>";
    for($i=0;$i<$anzseiten;$i++){
      $von=($i*$anzseite1)+1;
      $bis=($i+1)*$anzseite1;
      if($bis>$anztipper){$bis=$anztipper;}
      if($von!=$start){echo "<td class=\"lmost0\"><a href=\"".$addt3.$von."\">";}
      else{echo "<td class=\"lmost1\">";}
      echo $von."-".$bis;
      if($von!=$start){echo "</a>";}
      echo "&nbsp;</td>";
      }
?>
    </tr></table></td>
  </tr>
<?PHP } // ende if($anzseiten>1) ?>

  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost4" colspan="3">
<?PHP
  if(isset($lmtype) && $lmtype==1 && $tabdat!=""){
    if($st==$anzst){$j=$text[374];}
    elseif($st==$anzst-1){$j=$text[373];}
    elseif($st==$anzst-2){$j=$text[372];}
    elseif($st==$anzst-3){$j=$text[371];}
    else{$j=$st.". ".$text[370];}
    echo $j;
    }
  else{echo $tabdat;}
?>
    </td>
    <td class="lmost4" width="2">&nbsp;</td>

<?PHP
  if( $wertung=="einzel"  || $wertung=="intern"){
    if( $tipperimteam>=0){
?>
    <td class="lmost4"><?PHP echo $text[2027]; // Team ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP
     }
    }
  else{ // Teamwertung
?>
    <td class="lmost4" align="right"><?PHP echo $text[2026]; // Anzahl Tipper ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2026]."&Oslash;"; // Anzahl Tipper Durchschnitt ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP } ?>
    <td class="lmost4" <?PHP echo $dummy; ?>>
    <?PHP if($gewicht!="spiele"){
    	    echo "<a href=\"".$addt5."spiele\">";
            }
    echo $text[2123]; // Spiele getippt
    if($gewicht!="spiele"){echo "</a>";}
    ?></td>
<?PHP
 if($showzus==1){
 if($tippmodus==1){
 if($rergebnis>0){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2221]; // RE ?></td>
<?PHP } 
 if($rtendenzdiff>$rtendenz){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2222]; // RTD ?></td>
<?PHP }
 if($rtendenz>0){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2223]; // RT ?></td>
<?PHP } 
 if($rtor>0){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2224]; // RG ?></td>
<?PHP } 
  } // ende if($tippmodus==1) 
 if($rremis>0){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2225]; // UB ?></td>
<?PHP } 
 if($jokertipp==1){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2226]; // JP ?></td>
<?PHP }
   } // ende if($showzus==1) 
 if($showstsiege==1){ ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[2090]; // GS ?></td>
<?PHP }
 ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?PHP echo $dummy; ?>>
    <?PHP if($gewicht!="relativ"){
    	    echo "<a href=\"".$addt5."relativ\" title=\"".$text[2150]."\">";
            }
          if($tippmodus==1){echo $text[2123]."&Oslash;";}
          else{echo $text[2123]."&#37;";}
           if($gewicht!="relativ"){echo "</a>";}
    ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?PHP echo $dummy; ?>>
    <?PHP if($gewicht!="absolut"){
    	    echo "<a href=\"".$addt5."absolut\" title=\"".$text[2149]."\">";
            }
          if($tippmodus==1){echo $text[37];}
    	  else{echo $text[2122];}
    	  if($gewicht!="absolut"){echo "</a>";}
   ?></td>

   </tr>

<?PHP
  $eigplatz=$anztipper+2;
  $j=1;
  $ende=$start+$anzseite1-1;
  if($ende>$anztipper){$ende=$anztipper;}
  if(!isset($lx)){$lx=1;}
  if(!isset($lax)){$lax=0;}
  if($anztipper>0){$laeng=strlen($tab0[0]);}
  for($x=1;$x<=$anztipper;$x++){
    $i=intval(substr($tab0[$x-1],-7));
    if(($x>=$start && $x<=$ende) || $i==$eigpos){
    
    $poswechs=1;
    if($x>1){
      for($k=0;$k<=$laeng-24;$k+=8){
        if(intval(substr($tab0[$x-1],$k+1,7))!=intval(substr($tab0[$x-2],$k+1,7))){break;}
        if($k==$laeng-24){$poswechs=0;}
        }
      }
    if($x==1 || $poswechs==1){
      $lx=$x;
      }

    if($wertung!="intern" || $teamintern==$tipperteam[$i]){
      if($lx==$x){$lax=$x;}
      if($i==$eigpos){$eigplatz=$x;}
      if(($x==$start && $eigplatz<$x-1) || ($x==$eigplatz && $x>$ende+1)){
?>
  <tr><td class="lmost5" align="right">...
  </td>
  </tr>
<?PHP      
      }

    if((($wertung=="einzel" || $wertung=="intern") && $lmotippername==$tippernick[$i]) || ($wertung=="team" && $lmotipperverein==$team[$i])){
      $dummy="<strong>";$dumm2="</strong>";
      }else{
      $dummy="";$dumm2="";
      }

    $dumm1="lmost5";
    if((($wertung!="intern" && $lax==1) || ($wertung=="intern" && $lx==1)) && $tipppunktegesamt[$i]>0){$dumm1="lmost9a";}
    if((($wertung!="intern" && $lax==2) || ($wertung=="intern" && $lx==2)) && $tipppunktegesamt[$i]>0){$dumm1="lmost9b";}
    if((($wertung!="intern" && $lax==3) || ($wertung=="intern" && $lx==3)) && $tipppunktegesamt[$i]>0){$dumm1="lmost9c";}

if($wertung=="team" || $tippernick[$i]!=""){
?>
  <tr>
    <td class="<?PHP echo $dumm1; ?>" align="right">
<?PHP
if($lax==$x){
  echo $dummy.$x.$dumm2;
  }
elseif($wertung=="intern" && $lax!=$lx){
  echo $dummy.$lx.$dumm2;
  $lax=$lx;
  }
else{
  echo "&nbsp;";
}
?>
    </td>
<?PHP
  $y=0;
  if(($endtab>1) && ($tabdat!="") && $tipppunktegesamt[intval(substr($tab0[0],-7))]>0 && $stwertmodus!="nur"){
    if($platz0[$i]<$platz1[$i]){$y=1;}
    elseif($platz0[$i]>$platz1[$i]){$y=2;}
    }
  if($tabdat!="" && $stwertmodus!="nur"){
    echo "<td class=\"".$dumm1."\"";
    echo "><img src=\"lmo-tab".$y.".gif\" width=\"9\" height=\"9\" border=\"0\">";
    echo "</td>";
    }
  else{
    echo "<td class=\"".$dumm1."\">&nbsp;</td>";
    }
?>
<?PHP
  if( $wertung=="einzel" || $wertung=="intern"){
?>
    <td class="<?PHP echo $dumm1; ?>"><nobr>
<?PHP
  echo $dummy;
  if($showname==1){
    if($showemail==1){echo "<a href=mailto:".$tipperemail[$i].">";}
    echo $tippername[$i];
    if($showemail==1){echo "</a>";}
    }
  if($shownick==1 || ($showemail==0 && $showname==0)){
    if($showname==1){echo " (";}
    if($showname==0 && $showemail==1){echo "<a href=mailto:".$tipperemail[$i].">";}
    echo $tippernick[$i];
    if($showname==0 && $showemail==1){echo "</a>";}
    if($showname==1){echo ")";}
    }
  elseif($showemail==1 && $showname==0){
    echo "<a href=mailto:".$tipperemail[$i].">".$tipperemail[$i]."</a>";
    }
  echo $dumm2;
?>
    </nobr></td>
<?PHP
   }else{
?>
    <td class="<?PHP echo $dumm1; ?>"><?PHP if($wertung!="intern" && $team[$i]!=" "){echo "<a href=\"".$addt1."intern&amp;teamintern=".str_replace(" ","%20",$team[$i])."\" title=\"".$text[2144]."\">";} echo $dummy.$team[$i].$dumm2; if($wertung!="intern" && $team[$i]!=" "){echo "</a>";} ?></td>
<?PHP
   }

 if( $tipperimteam>=0){
  if( $wertung=="einzel" || $wertung=="intern"){
    if($tipperteam[$i]==""){$tipperteam[$i]="&nbsp;";}
?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>"><nobr><?PHP if($wertung!="intern" && $tipperteam[$i]!="&nbsp;"){echo "<a href=\"".$addt1."intern&amp;teamintern=".str_replace(" ","%20",$tipperteam[$i])."\" title=\"".$text[2144]."\">";} echo $dummy.$tipperteam[$i].$dumm2; if($wertung!="intern" && $tipperteam[$i]!="&nbsp;"){echo "</a>";} ?></nobr></td>
<?PHP
   }else{
?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$tipperimteam[$i].$dumm2; ?></td>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.number_format($tipppunktegesamt[$i]/$tipperimteam[$i],2,".",",").$dumm2; ?></td>
<?PHP }
    }
    echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\">";
    if($gewicht=="spiele"){echo "<strong>";}else{echo $dummy;}
    echo $spielegetipptgesamt[$i];
    if($gewicht=="spiele"){echo "</strong>";}else{echo $dumm2;}
    echo "</td>";

 if($showzus==1){
 if($tippmodus==1){
 if($rergebnis>0){if($punkte1gesamt[$i]==""){$punkte1gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte1gesamt[$i].$dumm2; ?></td>
<?PHP }
 if($rtendenzdiff>$rtendenz){if($punkte2gesamt[$i]==""){$punkte2gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte2gesamt[$i].$dumm2; ?></td>
<?PHP }else{$punkte3gesamt[$i]+=$punkte2gesamt[$i];}
 if($rtendenz>0){if($punkte3gesamt[$i]==""){$punkte3gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte3gesamt[$i].$dumm2; ?></td>
<?PHP }
 if($rtor>0){if($punkte4gesamt[$i]==""){$punkte4gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte4gesamt[$i].$dumm2; ?></td>
<?PHP }
    } // ende if($tippmodus==1)
 if($rremis>0){if($punkte5gesamt[$i]==""){$punkte5gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte5gesamt[$i].$dumm2; ?></td>
<?PHP }
 if($jokertipp==1){if($punkte6gesamt[$i]==""){$punkte6gesamt[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$punkte6gesamt[$i].$dumm2; ?></td>
<?PHP }
    } // ende if($showzus==1)
 if($showstsiege==1){if($stsiege[$i]==""){$stsiege[$i]="&nbsp;";} ?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$stsiege[$i].$dumm2; ?></td>
<?PHP }
    $quotegesamt[$i]=number_format($quotegesamt[$i]/100,2,".",",");
    echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\">";
    if($gewicht=="relativ"){echo "<strong>";}else{echo $dummy;}
    echo $quotegesamt[$i];
    if($gewicht=="relativ"){echo "</strong>";}else{echo $dumm2;}
    echo "</td>";

    echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\">";
    if($gewicht=="absolut"){echo "<strong>";}else{echo $dummy;}
    echo $tipppunktegesamt[$i];
    if($gewicht=="absolut"){echo "</strong>";}else{echo $dumm2;}
    echo "</td>";
} // ende if($wertung!="intern" || $teamintern==$tipperteam[$i])

?>
  </tr>
<?PHP
     } // ende   if($wertung=="team" || $tippernick[$i]!="")
   } // ende   if(($x>=$start && $x<=$ende) || $i==$eigpos)
  } // ende for($x=1;$x<=$anztipper;$x++)
  ?>

  </table>
  </td>
  </tr>
<?PHP if($anzseiten>1){ ?> 
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td class=\"lmost1\">".$text[2205]."&nbsp;</td>";
    for($i=0;$i<$anzseiten;$i++){
      $von=($i*$anzseite1)+1;
      $bis=($i+1)*$anzseite1;
      if($bis>$anztipper){$bis=$anztipper;}
      if($von!=$start){echo "<td class=\"lmost0\"><a href=\"".$addt3.$von."\">";}
      else{echo "<td class=\"lmost1\">";}
      echo $von."-".$bis;
      if($von!=$start){echo "</a>";}
      echo "&nbsp;</td>";
      }
?>
    </tr></table></td>
  </tr>
<?PHP } // ende if($anzseiten>1)

if($tabdat!=""){ ?>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
<?PHP $st0=$endtab-1;if($endtab>1){echo "<td class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[43]."\">".$text[5]."</a></td>";} ?>
<?PHP $st0=$endtab+1;if($endtab<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[44]."\">".$text[7]."</a></td>";} ?>
      </tr>
      </table>
    </td>
  </tr>
<?PHP } ?>
</table>
