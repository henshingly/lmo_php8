<?php
/** This file is part of Pdf Addon for LMO 4.
  * Copyright (C) 2017 by Dietmar Kersting
  *
  * MINITABLE Addon for LigaManager Online (pdf-tabelle.php and pdf-spielplan.php)
  * Copyright (C) 2003 by Tim Schumacher
  * timme@uni.de /
  *
  * Pdf Addon for LMO 4 für Spielplan (pdf-spielplan.php)
  * Copyright (C)  by Torsten Hofmann V 2.0
  *
  * Pdf Addon für LMO 4 is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
  *
  * Pdf Addon für LMO 4 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License
  * along with Pdf Addon für LMO 4.  If not, see <http://www.gnu.org/licenses/>.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  * Diese Datei ist Teil des PDF Addon für LMO 4.
  *
  * Pdf Addon für LMO 4 ist Freie Software: Sie können es unter den Bedingungen
  * der GNU General Public License, wie von der Free Software Foundation,
  * Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
  * veröffentlichten Version, weiterverbreiten und/oder modifizieren.
  *
  * Pdf Addon für LMO 4 wird in der Hoffnung, dass es nützlich sein wird, aber
  * OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
  * Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
  * Siehe die GNU General Public License für weitere Details.
  *
  * Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
  * Pdf Addon für LMO 4 erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
  *
  * DAS ENTFERNEN ODER DIE ÄNDERUNG DER COPYRIGHT-HINWEISE IST NICHT ERLAUBT!
  */

if($lmtype==0 && $druck==1){
  ob_start();
  if($lmtype==0 && $druck==1){
?>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center" width='50%'>
<?php
    if (file_exists(PATH_TO_ADDONDIR."/pdf/pdf-tabelle.php")) {
?>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Matchday"><?php echo $text['pdf'][002]?></button>
              <!-- Modal -->
              <div id="myModal_Matchday" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO."/addon/pdf/pdf-tabelle.php?file=".$file."&amp;st=".$st?>" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
<?php
    }
?>
            </td>
            <td align="center" width='50%'>
<?php
    if (file_exists(PATH_TO_ADDONDIR."/pdf/pdf-spielplan.php")) {
?>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Schedule"><?php echo $text['pdf'][000]?></button>
              <!-- Modal -->
              <div id="myModal_Schedule" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO."/addon/pdf/pdf-spielplan.php?file=".$file?>" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
<?php
    }
?>
            </td>
          </tr>
        </table>
<?php
  }
$output_savehtml.=ob_get_contents();ob_end_clean();
}
?>