<?
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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "delligen")) {
  if ($newpage == 1) {
    if ($xtipperligen != "") {
      foreach($xtipperligen as $key => $value) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$lmotippername.".tip";
        if (file_exists($tippfile)) {
          @unlink($tippfile); // Tipps löschen
        }
      }
    }
  } // end ($newpage==1)
?>
<table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="lmost1"><?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></td>
  </tr>
  <tr>
    <td align="center" class="lmost1"><?=$text['tipp'][266]; ?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3"><? 
  if($newpage!=1){?>
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="delligen">
        <input type="hidden" name="newpage" value="1">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost5"><?
    $ftype=".l98"; 
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
            </td>
          </tr>
          <tr><? 
    if($i>0){ ?>
            <td class="lmost4" align="right">
              <input class="lmoadminbut" type="submit" name="xtippersub" value="<?=$text['tipp'][268]; ?>">
            </td>
          </tr>
          <tr>
            <td class="lmost5">
              <strong><?=$text['tipp'][82]?></strong> <?=$text['tipp'][267];?>
            </td>
          </tr>
        </table>
      </form><? 
    }
  }
  if($newpage==1){ /* Abbestellen erfolgreich */?>
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" align="center">  <?=$text['tipp'][269]; ?></td>
        </tr>
      </table><? 
  }
  if($newpage==1 || $i==0){ /* zurück zur Übersicht */?>
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">  
        <tr>
          <td class="lmost4" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
        </tr>
      </table><? 
   } ?>
    </td>
  </tr>
</table><? 
} 
$file=""; 
?>