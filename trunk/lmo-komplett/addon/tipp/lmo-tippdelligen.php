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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if(($action=="tipp") && ($todo=="delligen")){
  if($newpage==1){
    if($xtipperligen!=""){
      foreach($xtipperligen as $key => $value){
        $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$lmotippername.".tip";
        if(file_exists($tippfile)){
          @unlink($tippfile); // Tipps löschen
          }
        }
      }
    } // end ($newpage==1)
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <font color=black><?PHP echo $lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></font>
  </td></tr>
  <tr><td align="center" class="lmost1"><?PHP echo $text['tipp'][266]; ?></td></tr>
  <tr><td align="center" class="lmost3">
  <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr><td class="lmost5"><nobr>
<?PHP if($newpage!=1){ ?>
  <form name="lmotippedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
  
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="delligen">
  <input type="hidden" name="newpage" value="1">
    <?PHP $ftype=".l98"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?>
  </nobr></td></tr>
    <tr>
<?PHP if($i>0){ ?>
      <td class="lmost4" align="right">
      <acronym><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text['tipp'][268]; ?>"></acronym>
      </td>
    </tr>
    <tr><td class="lmost5"><?PHP echo "<b>".$text['tipp'][82]."</b><br> ".$text['tipp'][267]; ?></td></tr>
<?PHP } ?>
  </form>
<?PHP } ?>
<?PHP if($newpage==1){ // Abbestellen erfolgreich ?>
   <tr>
      <td class="lmost5" align="center">  <?PHP echo $text['tipp'][269]; ?></td>
   </tr>
<?PHP } ?>
<?PHP if($newpage==1 || $i==0){ // zurück zur Übersicht ?>
   <tr>
      <td class="lmost4" align="right"><a href="<?PHP echo $_SERVER['PHP_SELF']."?action=tipp&amp;todo=&amp;PHPSESSID=".$PHPSESSID ?>"><?PHP echo $text[5]." ".$text['tipp'][1]; ?></a></td>
   </tr>
<?PHP } ?>

  </table>
  </td></tr></table>

<?PHP } $file=""; ?>
