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
if(!isset($emailart)){$emailart=-1;}
if(!isset($save)){$save=0;}
if(!isset($message)){$message="";}
if(!isset($betreff) || $betreff==""){$betreff=$text[2000];}
if(!isset($betreff1)){$betreff1="";}
if(!isset($textreminder1)){$textreminder1="";}
if(!isset($liganr)){$liganr=-1;}

if($save==1){
  if($emailart==1){
    if($liganr==0){
      $st=0;
      $liga="viewer";
      }
    else{
      $st=$st1[$liganr-1];
      $liga=$liga1[$liganr-1];
      }
    }
  require("lmo-tippemail.php");
  }

  $adda=$PHP_SELF."?action=admin&amp;todo=tipp";
  $addu=$PHP_SELF."?action=admin&amp;todo=tippuser";
  $addo=$PHP_SELF."?action=admin&amp;todo=tippoptions";
?>
<script language="JavaScript">
<!---
function changetextarea(x){
  if(x==0){
    document.getElementById("message").value="Hallo Tipper,";
    document.getElementById("betreff").value="Tippspiel-Newsletter";
    }
  if(x==1){
    document.getElementById("message").value=document.getElementsByName("textreminder1")[0].value;
    document.getElementById("betreff").value="Tip-Reminder";
    }
  if(x==2){
    document.getElementById("message").value="Hallo";
    document.getElementById("betreff").value="Tippspiel";
    }
  }
// --->
</script>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[2165] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippemail">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="textreminder1" value="<?PHP if($textreminder1==""){$textreminder1=$text[2174];}echo $textreminder1; ?>">
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="3"><acronym><input type="radio" name="emailart" value="0" id="0" <?PHP if($emailart==0){echo "checked";} ?> onClick="changetextarea(0)"><label for="0"><?PHP echo $text[2166]; ?></label></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5"><acronym><input type="radio" name="emailart" value="2" id="2" <?PHP if($emailart==2){echo "checked";} ?> onClick="changetextarea(2)"><label for="2"><?PHP echo $text[2168]; ?></label></acronym></td>
    <td class="lmost5" colspan="2">
    <select name="adressat" onChange="emailart[1].checked=true;changetextarea(2);">
      <?PHP
        echo "<option value=\"\" "; echo ">".$text[2051]."</option>";
        require("lmo-tippselectemail.php");
      ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" valign="top"><acronym><input type="radio" name="emailart" value="1" id="1" <?PHP if($emailart==1){echo "checked";} ?> onClick="changetextarea(1)"><label for="1"><?PHP echo $text[2167]; ?></label></acronym></td>
    <td class="lmost5" colspan="2"><table cellspacing="0" cellpadding="0" border="0">
      <?PHP
        $ftype=".l98";$iptype="reminder";require("lmo-tippnewdir.php");
        if($i>0){
      ?>
              <tr><td class="lmost5" colspan="2">
                <input type="radio" name="liganr" value="0" id="-1" <?PHP if($liganr==0){echo "checked";} ?> onClick="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;">
                <label for="-1"><?PHP echo "<b>".$text[2263]."</b>"; ?></label></td>
                </tr>
      <?PHP } ?>
    </table>
    <br><?PHP echo $text[2170]; if(!isset($tage)){$tage=4;}?>
    <input class="lmoadminein" type="text" name="tage" size="2" maxlength="2" value="<?PHP echo $tage; ?>" onFocus="emailart[2].checked=true;changetextarea(1);"><?PHP echo " ".$text[2171];?>
    <br>
    <?PHP echo $text[2164]; //Tipper
    $start1=1;
    if($save==1){if(isset($start)){$start1=$start;}}
    ?> 
    <input class="lmoadminein" type="text" name="start" size="2" maxlength="4" value="<?PHP echo $start1; ?>">
    <?PHP echo $text[4]; //bis
    $ende1=count($dumma);
    if($save==1){if(isset($ende)){$ende1=$ende;}}
    ?> 
    <input class="lmoadminein" type="text" name="ende" size="2" maxlength="4" value="<?PHP echo $ende1; ?>">
    </td>
  </tr>
  <tr>
    <td class="lmost5" colspan="4"><hr>
  </td></tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="3">
    <?PHP
    echo $text[2264]."<br>".$text[2265];
    if($save==1){if(isset($betreff)){$betreff1=$betreff;}}
    ?>
    <input class="lmoadminein" type="text" name="betreff" id="betreff" size="20" maxlength="40" value="<?PHP echo $betreff1; ?>"> 
    <br>
    <textarea id="message" name="message" rows="10" cols="60"><?PHP if($emailart==1){echo $textreminder1;}elseif($message!=""){echo $message;}else{echo "Hallo Tipper,";} ?></textarea>
  </td></tr>
  <tr>
    <td class="lmost5" colspan="4" align="right"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[2169]; ?>">
    </td>
  </tr>
  </form>
  <tr>
    <td class="lmost4" width="20">&nbsp;</td>
    <td class="lmost4" colspan="1" valign="top" align="right"><?PHP echo $text[2178]; ?></td>
    <td class="lmost4" colspan="2"><?PHP echo $text[2179]; ?></td>
    </td>
  </tr>
  </table></td>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$adda."');\" title=\"".$text[2063]."\">".$text[2063]."</a></td>";
  echo "<td class=\"lmost1\" align=\"center\">".$text[2165]."</td>";
if($lmouserok==2){
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addu."');\" title=\"".$text[2114]."\">".$text[2114]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addo."');\" title=\"".$text[2055]."\">".$text[86]."</a></td>";
  }
?>
    </tr></table></td>
  </tr>
</table>
