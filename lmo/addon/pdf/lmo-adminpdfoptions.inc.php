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

require_once(PATH_TO_LMO."/lmo-admintest.php");
isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=0;
if(isset($_POST['save']) && $_POST['save']==1){
  if ($show==0) {
    $pdf_lmo_pdf_font=                 isset($_POST["xpdf_lmo_pdf_font"])?                 $_POST["xpdf_lmo_pdf_font"]:                 $pdf_lmo_pdf_font;
    $pdf_lmo_pdf_homepage=             isset($_POST["xpdf_lmo_pdf_homepage"])?             $_POST["xpdf_lmo_pdf_homepage"]:             $pdf_lmo_pdf_homepage;
    $pdf_lmo_pdf_bild=                 isset($_POST["xpdf_lmo_pdf_bild"])?                 $_POST["xpdf_lmo_pdf_bild"]:                 $pdf_lmo_pdf_bild;
    $pdf_lmo_show_pdfimg=              isset($_POST["xpdf_lmo_show_pdfimg"])?              $_POST["xpdf_lmo_show_pdfimg"]:              $pdf_lmo_show_pdfimg;
    $pdf_lmo_show_rectangle=           isset($_POST["xpdf_lmo_show_rectangle"])?           $_POST["xpdf_lmo_show_rectangle"]:           $pdf_lmo_show_rectangle;
    $pdf_lmo_pdf_Rectangle_Width=      isset($_POST["xpdf_lmo_pdf_Rectangle_Width"])?      $_POST["xpdf_lmo_pdf_Rectangle_Width"]:      $pdf_lmo_pdf_Rectangle_Width;
    $pdf_lmo_pdf_Distance_Side_Edge=   isset($_POST["xpdf_lmo_pdf_Distance_Side_Edge"])?   $_POST["xpdf_lmo_pdf_Distance_Side_Edge"]:   $pdf_lmo_pdf_Distance_Side_Edge;
    $pdf_lmo_pdf_Distance_Lower_Edge=  isset($_POST["xpdf_lmo_pdf_Distance_Lower_Edge"])?  $_POST["xpdf_lmo_pdf_Distance_Lower_Edge"]:  $pdf_lmo_pdf_Distance_Lower_Edge;
    $pdf_TextColorRed=                 isset($_POST["xpdf_TextColorRed"])?                 $_POST["xpdf_TextColorRed"]:                 $pdf_TextColorRed;
    $pdf_TextColorGreen=               isset($_POST["xpdf_TextColorGreen"])?               $_POST["xpdf_TextColorGreen"]:               $pdf_TextColorGreen;
    $pdf_TextColorBlue=                isset($_POST["xpdf_TextColorBlue"])?                $_POST["xpdf_TextColorBlue"]:                $pdf_TextColorBlue;
    $pdf_RectangleColorRed=            isset($_POST["xpdf_RectangleColorRed"])?            $_POST["xpdf_RectangleColorRed"]:            $pdf_RectangleColorRed;
    $pdf_RectangleColorGreen=          isset($_POST["xpdf_RectangleColorGreen"])?          $_POST["xpdf_RectangleColorGreen"]:          $pdf_RectangleColorGreen;
    $pdf_RectangleColorBlue=           isset($_POST["xpdf_RectangleColorBlue"])?           $_POST["xpdf_RectangleColorBlue"]:           $pdf_RectangleColorBlue;
  } elseif ($show==1) {
    $pdf_lmo_pdf_matchday_icon=        isset($_POST["xpdf_lmo_pdf_matchday_icon"])?        $_POST["xpdf_lmo_pdf_matchday_icon"]:        '0';
    $pdf_lmo_pdf_table_icon=           isset($_POST["xpdf_lmo_pdf_table_icon"])?           $_POST["xpdf_lmo_pdf_table_icon"]:           '0';
    $pdf_lmo_pdf_nmatchday_icon=       isset($_POST["xpdf_lmo_pdf_nmatchday_icon"])?       $_POST["xpdf_lmo_pdf_nmatchday_icon"]:       '0';
    $pdf_table_md_gridlines=           isset($_POST["xpdf_table_md_gridlines"])?           $_POST["xpdf_table_md_gridlines"]:           '0';
    $pdf_table_tb_gridlines=           isset($_POST["xpdf_table_tb_gridlines"])?           $_POST["xpdf_table_tb_gridlines"]:           '0';
    $pdf_table_tb_width=               isset($_POST["xpdf_table_tb_width"])?               $_POST["xpdf_table_tb_width"]:               $pdf_table_tb_width;
    $pdf_table_md_width=               isset($_POST["xpdf_table_md_width"])?               $_POST["xpdf_table_md_width"]:               $pdf_table_md_width;
    $pdf_lmo_show_gameday=             isset($_POST["xpdf_lmo_show_gameday"])?             $_POST["xpdf_lmo_show_gameday"]:             $pdf_lmo_show_gameday;
    $pdf_lmo_show_table=               isset($_POST["xpdf_lmo_show_table"])?               $_POST["xpdf_lmo_show_table"]:               $pdf_lmo_show_table;
    $pdf_lmo_show_nextgameday=         isset($_POST["xpdf_lmo_show_nextgameday"])?         $_POST["xpdf_lmo_show_nextgameday"]:         $pdf_lmo_show_nextgameday;
    $pdf_table_md_fontsize=            isset($_POST["xpdf_table_md_fontsize"])?            $_POST["xpdf_table_md_fontsize"]:            $pdf_table_md_fontsize;
    $pdf_table_md_tfontsize=           isset($_POST["xpdf_table_md_tfontsize"])?           $_POST["xpdf_table_md_tfontsize"]:           $pdf_table_md_tfontsize;
    $pdf_table_tb_fontsize=            isset($_POST["xpdf_table_tb_fontsize"])?            $_POST["xpdf_table_tb_fontsize"]:            $pdf_table_tb_fontsize;
    $pdf_table_tb_tfontsize=           isset($_POST["xpdf_table_tb_tfontsize"])?           $_POST["xpdf_table_tb_tfontsize"]:           $pdf_table_tb_tfontsize;
    $pdf_iconsize_md=                  isset($_POST["xpdf_iconsize_md"])?                  $_POST["xpdf_iconsize_md"]:                  $pdf_iconsize_md;
    $pdf_iconsize_tb=                  isset($_POST["xpdf_iconsize_tb"])?                  $_POST["xpdf_iconsize_tb"]:                  $pdf_iconsize_tb;
  } elseif ($show==2) {
    $pdf_lmo_pdf_schedule_icon=        isset($_POST["xpdf_lmo_pdf_schedule_icon"])?        $_POST["xpdf_lmo_pdf_schedule_icon"]:        '0';
    $pdf_table_gd_gridlines=           isset($_POST["xpdf_table_gd_gridlines"])?           $_POST["xpdf_table_gd_gridlines"]:           '0';
    $pdf_table_gd_width=               isset($_POST["xpdf_table_gd_width"])?               $_POST["xpdf_table_gd_width"]:               $pdf_table_gd_width;
    $pdf_table_gd_fontsize=            isset($_POST["xpdf_table_gd_fontsize"])?            $_POST["xpdf_table_gd_fontsize"]:            $pdf_table_gd_fontsize;
    $pdf_table_gd_tfontsize=           isset($_POST["xpdf_table_gd_tfontsize"])?           $_POST["xpdf_table_gd_tfontsize"]:           $pdf_table_gd_tfontsize;
    $pdf_iconsize_gd=                  isset($_POST["xpdf_iconsize_gd"])?                  $_POST["xpdf_iconsize_gd"]:                  $pdf_iconsize_gd;
  } elseif ($show==3) {
    $pdf_lmo_pdf_format=               isset($_POST["xpdf_lmo_pdf_format"])?               $_POST["xpdf_lmo_pdf_format"]:               '0';
    $pdf_lmo_pdf_teamfett=             isset($_POST["xpdf_lmo_pdf_teamfett"])?             $_POST["xpdf_lmo_pdf_teamfett"]:             '0';
    $pdf_lmo_pdf_teamnamen=            isset($_POST["xpdf_lmo_pdf_teamnamen"])?            $_POST["xpdf_lmo_pdf_teamnamen"]:            '0';
    $pdf_lmo_pdf_anzeige=              isset($_POST["xpdf_lmo_pdf_anzeige"])?              $_POST["xpdf_lmo_pdf_anzeige"]:              '0';
    $pdf_lmo_pdf_serie=                isset($_POST["xpdf_lmo_pdf_serie"])?                $_POST["xpdf_lmo_pdf_serie"]:                '0';
    $pdf_lmo_pdf_teamplanicon=         isset($_POST["xpdf_lmo_pdf_teamplanicon"])?         $_POST["xpdf_lmo_pdf_teamplanicon"]:         '0';
    $pdf_iconsize_tp_port=             isset($_POST["xpdf_iconsize_tp_port"])?             $_POST["xpdf_iconsize_tp_port"]:             $pdf_iconsize_tp_port;
    $pdf_iconsize_tp_land=             isset($_POST["xpdf_iconsize_tp_land"])?             $_POST["xpdf_iconsize_tp_land"]:             $pdf_iconsize_tp_land;
    $pdf_tp_port_fontsize=             isset($_POST["xpdf_tp_port_fontsize"])?             $_POST["xpdf_tp_port_fontsize"]:             $pdf_tp_port_fontsize;
    $pdf_tp_port_tfontsize=            isset($_POST["xpdf_tp_port_tfontsize"])?            $_POST["xpdf_tp_port_tfontsize"]:            $pdf_tp_port_tfontsize;
    $pdf_tp_port_Datum=                isset($_POST["xpdf_tp_port_Datum"])?                $_POST["xpdf_tp_port_Datum"]:                $pdf_tp_port_Datum;
    $pdf_tp_port_Zeit=                 isset($_POST["xpdf_tp_port_Zeit"])?                 $_POST["xpdf_tp_port_Zeit"]:                 $pdf_tp_port_Zeit;
    $pdf_tp_port_Team=                 isset($_POST["xpdf_tp_port_Team"])?                 $_POST["xpdf_tp_port_Team"]:                 $pdf_tp_port_Team;
    $pdf_tp_port_Result=               isset($_POST["xpdf_tp_port_Result"])?               $_POST["xpdf_tp_port_Result"]:               $pdf_tp_port_Result;
    $pdf_tp_land_fontsize=             isset($_POST["xpdf_tp_land_fontsize"])?             $_POST["xpdf_tp_land_fontsize"]:             $pdf_tp_land_fontsize;
    $pdf_tp_land_tfontsize=            isset($_POST["xpdf_tp_land_tfontsize"])?            $_POST["xpdf_tp_land_tfontsize"]:            $pdf_tp_land_tfontsize;
    $pdf_tp_land_Datum=                isset($_POST["xpdf_tp_land_Datum"])?                $_POST["xpdf_tp_land_Datum"]:                $pdf_tp_land_Datum;
    $pdf_tp_land_Zeit=                 isset($_POST["xpdf_tp_land_Zeit"])?                 $_POST["xpdf_tp_land_Zeit"]:                 $pdf_tp_land_Zeit;
    $pdf_tp_land_Team=                 isset($_POST["xpdf_tp_land_Team"])?                 $_POST["xpdf_tp_land_Team"]:                 $pdf_tp_land_Team;
    $pdf_tp_land_Result=               isset($_POST["xpdf_tp_land_Result"])?               $_POST["xpdf_tp_land_Result"]:               $pdf_tp_land_Result;
  }
  require(PATH_TO_LMO."/lmo-savecfg.php");
}

?>
<script src="<?php echo URL_TO_JSDIR?>/colorpicker.js" type="text/javascript"></script>
<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?php echo $text['pdf'][201]?></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><h1><?php echo $text[432] ?></h1></td>
  </tr>
  <tr>
    <td valign="top" align="left">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?php if ($show==0) {echo $text['pdf'][203]?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=pdfoptions&amp;show=0";?>"><?php echo $text['pdf'][203];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==1) {echo $text['pdf'][15]." ".$text['pdf'][204]?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=pdfoptions&amp;show=1";?>"><?php echo $text['pdf'][15]." ".$text['pdf'][204];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==2) {echo $text['pdf'][15]." ".$text['pdf'][205]?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=pdfoptions&amp;show=2";?>"><?php echo $text['pdf'][15]." ".$text['pdf'][205];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==3) {echo $text['pdf'][206]?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=pdfoptions&amp;show=3";?>"><?php echo $text['pdf'][206];?></a><?php }?></td></tr>
        <tr><td align="right"><a target="_blank" href='<?php echo URL_TO_LMO."/help/Deutsch/addons/readme.php' title='".$text['pdf'][199]."'>".$text[312] ?></td></tr>
      </table>
    </td>
    <td align="left" valign="top">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="pdfoptions">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="show" value="<?php echo $show?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php if ($show==0) {?>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][203] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][212]?>"><?php echo $text['pdf'][211];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_lmo_pdf_homepage" size="20" maxlength="80" value="<?php echo $pdf_lmo_pdf_homepage;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][198].": ".$text['pdf'][227]?>"><?php echo $text[442];?></acronym></td>
            <td class="nobr" colspan="2">
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][228];?>: <?php echo $text['pdf'][231];?>" name="xpdf_TextColorRed" size="1" maxlength="3" value="<?php echo $pdf_TextColorRed;?>" onChange="dolmoedit()"><?php for($number_text1=0.0; $number_text1 <= 1.0; $number_text1=$number_text1+0.1) { ?><option value="<?php echo number_format($number_text1, 1); ?>"<?php if ($pdf_TextColorRed==(number_format($number_text1, 1))) echo " selected";?>><?php echo number_format($number_text1, 1); ?></option><?php } ?></select>
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][229];?>: <?php echo $text['pdf'][231];?>" name="xpdf_TextColorGreen" size="1" maxlength="3" value="<?php echo $pdf_TextColorGreen;?>" onChange="dolmoedit()"><?php for($number_text2=0.0; $number_text2 <= 1.0; $number_text2=$number_text2+0.1) { ?><option value="<?php echo number_format($number_text2, 1); ?>"<?php if ($pdf_TextColorGreen==(number_format($number_text2, 1))) echo " selected";?>><?php echo number_format($number_text2, 1); ?></option><?php } ?></select>
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][230];?>: <?php echo $text['pdf'][231];?>" name="xpdf_TextColorBlue" size="1" maxlength="3" value="<?php echo $pdf_TextColorBlue;?>" onChange="dolmoedit()"><?php for($number_text3=0.0; $number_text3 <= 1.0; $number_text3=$number_text3+0.1) { ?><option value="<?php echo number_format($number_text3, 1); ?>"<?php if ($pdf_TextColorBlue==(number_format($number_text3, 1))) echo " selected";?>><?php echo number_format($number_text3, 1); ?></option><?php } ?></select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><?php echo $text['pdf'][232];?></td>
            <td>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Example_Matchday"><?php echo $text['pdf'][234]?></button>
              <!-- Modal -->
              <div id="myModal_Example_Matchday" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO?>/addon/pdf/lmo-color_help.php" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][210]?>"><?php echo $text['pdf'][209];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_lmo_pdf_bild" size="20" maxlength="80" value="<?php echo $pdf_lmo_pdf_bild;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][111]?>"><?php echo $text['pdf'][209]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_show_pdfimg" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_show_pdfimg=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_show_pdfimg" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_show_pdfimg=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][237]?>"><?php echo $text['pdf'][236];?></acronym></td>
            <td class="nobr" colspan="2"><?php $font_folder = PATH_TO_ADDONDIR."/classlib/classes/pdf/fonts/"; $all_font = scandir($font_folder); ?>
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][237];?>" name="xpdf_lmo_pdf_font" value="<?php echo $pdf_lmo_pdf_font;?>" onChange="dolmoedit()"><?php
              foreach ($all_font as $font) {
                $fontinfo = pathinfo($font_folder."/".$font);
                if ($font != "." && $font != ".." && $fontinfo['extension'] != "fonts") { ?>
                <option value="<?php echo $fontinfo['basename']; ?>"<?php if ($pdf_lmo_pdf_font==($fontinfo['basename'])) echo " selected";?>><?php echo $fontinfo['filename']; ?></option><?php
                };
              };?></select>
            </td>
          </tr>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][219] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][113]?>"><?php echo $text['pdf'][112]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_show_rectangle" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_show_rectangle=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_show_rectangle" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_show_rectangle=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][227]?>"><?php echo $text['pdf'][226];?></acronym></td>
            <td class="nobr" colspan="2">
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][228];?>: <?php echo $text['pdf'][231];?>" name="xpdf_RectangleColorRed" size="1" maxlength="3" value="<?php echo $pdf_RectangleColorRed;?>" onChange="dolmoedit()"><?php for($number1=0.0; $number1 <= 1.0; $number1=$number1+0.1) { ?><option value="<?php echo number_format($number1, 1); ?>"<?php if ($pdf_RectangleColorRed==(number_format($number1, 1))) echo " selected";?>><?php echo number_format($number1, 1); ?></option><?php } ?></select>
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][229];?>: <?php echo $text['pdf'][231];?>" name="xpdf_RectangleColorGreen" size="1" maxlength="3" value="<?php echo $pdf_RectangleColorGreen;?>" onChange="dolmoedit()"><?php for($number2=0.0; $number2 <= 1.0; $number2=$number2+0.1) { ?><option value="<?php echo number_format($number2, 1); ?>"<?php if ($pdf_RectangleColorGreen==(number_format($number2, 1))) echo " selected";?>><?php echo number_format($number2, 1); ?></option><?php } ?></select>
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][230];?>: <?php echo $text['pdf'][231];?>" name="xpdf_RectangleColorBlue" size="1" maxlength="3" value="<?php echo $pdf_RectangleColorBlue;?>" onChange="dolmoedit()"><?php for($number3=0.0; $number3 <= 1.0; $number3=$number3+0.1) { ?><option value="<?php echo number_format($number3, 1); ?>"<?php if ($pdf_RectangleColorBlue==(number_format($number3, 1))) echo " selected";?>><?php echo number_format($number3, 1); ?></option><?php } ?></select>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][221]?>"><?php echo $text['pdf'][220];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_lmo_pdf_Rectangle_Width" size="5" maxlength="10" value="<?php echo $pdf_lmo_pdf_Rectangle_Width;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][223]?>"><?php echo $text['pdf'][222];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_lmo_pdf_Distance_Side_Edge" size="5" maxlength="10" value="<?php echo $pdf_lmo_pdf_Distance_Side_Edge;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][225]?>"><?php echo $text['pdf'][224];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_lmo_pdf_Distance_Lower_Edge" size="5" maxlength="10" value="<?php echo $pdf_lmo_pdf_Distance_Lower_Edge;?>" onChange="dolmoedit()"></td>
          </tr>
<?php } elseif ($show==1) {?>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][15]." ".$text['pdf'][204] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][262]?>"><?php echo $text['pdf'][265]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_matchday_icon" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_matchday_icon=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_matchday_icon" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_matchday_icon=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][262]?>"><?php echo $text['pdf'][266]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_table_icon" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_table_icon=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_table_icon" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_table_icon=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][262]?>"><?php echo $text['pdf'][267]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_nmatchday_icon" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_nmatchday_icon=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_nmatchday_icon" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_nmatchday_icon=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][272]?>"><?php echo $text[16].": ".$text['pdf'][108]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_show_gameday" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_show_gameday=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_show_gameday" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_show_gameday=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][272]?>"><?php echo $text[16].": ".$text['pdf'][109]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_show_table" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_show_table=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_show_table" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_show_table=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][272]?>"><?php echo $text[16].": ".$text['pdf'][110]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_show_nextgameday" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_show_nextgameday=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_show_nextgameday" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_show_nextgameday=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][200].": ".$text['pdf'][273] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text[537]." ".$text[16];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_md_tfontsize" size="1" maxlength="2" value="<?php echo $pdf_table_md_tfontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text['pdf'][275];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_md_fontsize" size="1" maxlength="2" value="<?php echo $pdf_table_md_fontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][277]?>"><?php echo $text['pdf'][276];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_iconsize_md" size="1" maxlength="2" value="<?php echo $pdf_iconsize_md;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][269]?>"><?php echo $text['pdf'][268].": ".$text['pdf'][108]."/".$text['pdf'][110];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_md_width" size="1" maxlength="3" value="<?php echo $pdf_table_md_width;?>" onChange="dolmoedit()"> %</td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][284]." ".$text['pdf'][273]?>"><?php echo $text['pdf'][283].": ".$text['pdf'][279];?></acronym></td>
            <td class="nobr" colspan="2">
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][230];?>: <?php echo $text['pdf'][231];?>" name="xpdf_table_md_gridlines" size="1" maxlength="2" value="<?php echo $pdf_table_md_gridlines;?>" onChange="dolmoedit()"><?php for($number_gridline=0; $number_gridline <= 31; $number_gridline=$number_gridline+1) { ?><option value="<?php echo $number_gridline; ?>"<?php if ($pdf_table_md_gridlines==$number_gridline) echo " selected";?>><?php echo $number_gridline; ?></option><?php } ?></select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><?php echo $text['pdf'][281]." ".$text['pdf'][283];?></td>
            <td>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Example_Matchday"><?php echo $text['pdf'][282]?></button>
              <!-- Modal -->
              <div id="myModal_Example_Matchday" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO?>/addon/pdf/pdf-select_matchdayformat.php" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][200].": ".$text['pdf'][271] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text[537]." ".$text[16];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_tb_tfontsize" size="1" maxlength="2" value="<?php echo $pdf_table_tb_tfontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text['pdf'][275];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_tb_fontsize" size="1" maxlength="2" value="<?php echo $pdf_table_tb_fontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][277]?>"><?php echo $text['pdf'][276];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_iconsize_tb" size="1" maxlength="2" value="<?php echo $pdf_iconsize_tb;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][270]?>"><?php echo $text['pdf'][268].": ".$text['pdf'][271];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_tb_width" size="1" maxlength="3" value="<?php echo $pdf_table_tb_width;?>" onChange="dolmoedit()"> %</td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][284]." ".$text['pdf'][271]?>"><?php echo $text['pdf'][283].": ".$text['pdf'][279];?></acronym></td>
            <td class="nobr" colspan="2">
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][230];?>: <?php echo $text['pdf'][231];?>" name="xpdf_table_tb_gridlines" size="1" maxlength="2" value="<?php echo $pdf_table_tb_gridlines;?>" onChange="dolmoedit()"><?php for($number_gridline=0; $number_gridline <= 31; $number_gridline=$number_gridline+1) { ?><option value="<?php echo $number_gridline; ?>"<?php if ($pdf_table_tb_gridlines==$number_gridline) echo " selected";?>><?php echo $number_gridline; ?></option><?php } ?></select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><?php echo $text['pdf'][281]." ".$text['pdf'][283];?></td>
            <td>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Example_Table"><?php echo $text['pdf'][282]?></button>
              <!-- Modal -->
              <div id="myModal_Example_Table" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO?>/addon/pdf/pdf-select_tableformat.php" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
          </tr>
<?php } elseif ($show==2) {?>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][15]." ".$text['pdf'][205] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text[537]." ".$text[16];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_gd_tfontsize" size="1" maxlength="2" value="<?php echo $pdf_table_gd_tfontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text['pdf'][275];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_gd_fontsize" size="1" maxlength="2" value="<?php echo $pdf_table_gd_fontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][262]?>"><?php echo $text['pdf'][265]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_schedule_icon" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_schedule_icon=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_schedule_icon" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_schedule_icon=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][277]?>"><?php echo $text['pdf'][276];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_iconsize_gd" size="1" maxlength="2" value="<?php echo $pdf_iconsize_gd;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][285]?>"><?php echo $text['pdf'][268].": ".$text['pdf'][104];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_table_gd_width" size="1" maxlength="3" value="<?php echo $pdf_table_gd_width;?>" onChange="dolmoedit()"> %</td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][284]." ".$text['pdf'][104]?>"><?php echo $text['pdf'][283].": ".$text['pdf'][279];?></acronym></td>
            <td class="nobr" colspan="2">
              <select class="lmo-formular-input" type="text" title="<?php echo $text['pdf'][230];?>: <?php echo $text['pdf'][231];?>" name="xpdf_table_gd_gridlines" size="1" maxlength="2" value="<?php echo $pdf_table_gd_gridlines;?>" onChange="dolmoedit()"><?php for($number_gridline=0; $number_gridline <= 31; $number_gridline=$number_gridline+1) { ?><option value="<?php echo $number_gridline; ?>"<?php if ($pdf_table_gd_gridlines==$number_gridline) echo " selected";?>><?php echo $number_gridline; ?></option><?php } ?></select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><?php echo $text['pdf'][281]." ".$text['pdf'][283];?></td>
            <td>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_Example_Matchday"><?php echo $text['pdf'][282]?></button>
              <!-- Modal -->
              <div id="myModal_Example_Matchday" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <embed src="<?php echo URL_TO_LMO?>/addon/pdf/pdf-select_matchdayformat.php" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><?php echo $text['pdf'][290]?></button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
          </tr>
<?php } elseif ($show==3) {?>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][206] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right" rowspan="2"><acronym title="<?php echo $text['pdf'][241]?>"><?php echo $text['pdf'][238]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_format" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_format=='1') echo " checked";?>> <?php echo $text['pdf'][239]?></td>
          </tr>
          <tr>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_format" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_format=='0') echo " checked";?>> <?php echo $text['pdf'][240]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][243]?>"><?php echo $text['pdf'][242]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_teamfett" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_teamfett=='1') echo " checked";?>> <?php echo $text['pdf'][244]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_teamfett" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_teamfett=='0') echo " checked";?>> <?php echo $text['pdf'][245]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][247]?>"><?php echo $text['pdf'][246]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_teamnamen" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_teamnamen=='0') echo " checked";?>> <?php echo $text['pdf'][248]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_teamnamen" onClick="dolmoedit()" value="2"<?php if ($pdf_lmo_pdf_teamnamen=='2') echo " checked";?>> <?php echo $text['pdf'][249]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_teamnamen" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_teamnamen=='1') echo " checked";?>> <?php echo $text['pdf'][250]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][252]?>"><?php echo $text['pdf'][251]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_anzeige" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_anzeige=='1') echo " checked";?>> <?php echo $text['pdf'][253]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_anzeige" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_anzeige=='0') echo " checked";?>> <?php echo $text['pdf'][254]?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][256]?>"><?php echo $text['pdf'][255]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_serie" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_serie=='0') echo " checked";?>> <acronym title="<?php echo $text['pdf'][259]?>"><?php echo $text['pdf'][257]?></acronym>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_serie" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_serie=='1') echo " checked";?>> <acronym title="<?php echo $text['pdf'][260]?>"><?php echo $text['pdf'][258]?></acronym></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][262]?>"><?php echo $text['pdf'][261]?></acronym></td>
            <td class="nobr" colspan="2"><input type="radio" name="xpdf_lmo_pdf_teamplanicon" onClick="dolmoedit()" value="1"<?php if ($pdf_lmo_pdf_teamplanicon=='1') echo " checked";?>> <?php echo $text['pdf'][263]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type="radio" name="xpdf_lmo_pdf_teamplanicon" onClick="dolmoedit()" value="0"<?php if ($pdf_lmo_pdf_teamplanicon=='0') echo " checked";?>> <?php echo $text['pdf'][264]?></td>
          </tr>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][200].": ".$text['pdf'][239] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text[537]." ".$text[16];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_tfontsize" size="1" maxlength="2" value="<?php echo $pdf_tp_port_tfontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text['pdf'][275];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_fontsize" size="1" maxlength="2" value="<?php echo $pdf_tp_port_fontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][277]?>"><?php echo $text['pdf'][276];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_iconsize_tp_port" size="1" maxlength="2" value="<?php echo $pdf_iconsize_tp_port;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][286]?>"><?php echo $text['pdf'][274].": ".$text['pdf'][8];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_Datum" size="1" maxlength="2" value="<?php echo $pdf_tp_port_Datum;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][287]?>"><?php echo $text['pdf'][274].": ".$text[549];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_Zeit" size="1" maxlength="2" value="<?php echo $pdf_tp_port_Zeit;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][288]?>"><?php echo $text['pdf'][274].": ".$text[41]."/".$text['pdf'][6];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_Team" size="1" maxlength="3" value="<?php echo $pdf_tp_port_Team;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][289]?>"><?php echo $text['pdf'][274].": ".$text['pdf'][9];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_port_Result" size="1" maxlength="2" value="<?php echo $pdf_tp_port_Result;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <th colspan="3"><?php echo $text['pdf'][200].": ".$text['pdf'][240] ?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text[537]." ".$text[16];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_tfontsize" size="1" maxlength="2" value="<?php echo $pdf_tp_land_tfontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[438]?>"><?php echo $text[437].": ".$text['pdf'][275];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_fontsize" size="1" maxlength="2" value="<?php echo $pdf_tp_land_fontsize;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][277]?>"><?php echo $text['pdf'][276];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_iconsize_tp_land" size="1" maxlength="2" value="<?php echo $pdf_iconsize_tp_land;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][286]?>"><?php echo $text['pdf'][274].": ".$text['pdf'][8];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_Datum" size="1" maxlength="2" value="<?php echo $pdf_tp_land_Datum;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][287]?>"><?php echo $text['pdf'][274].": ".$text[549];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_Zeit" size="1" maxlength="2" value="<?php echo $pdf_tp_land_Zeit;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][288]?>"><?php echo $text['pdf'][274].": ".$text[41]."/".$text['pdf'][6];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_Team" size="1" maxlength="3" value="<?php echo $pdf_tp_land_Team;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text['pdf'][289]?>"><?php echo $text['pdf'][274].": ".$text['pdf'][9];?></acronym></td>
            <td class="nobr" colspan="2"><input class="lmo-formular-input" type="text" name="xpdf_tp_land_Result" size="1" maxlength="2" value="<?php echo $pdf_tp_land_Result;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td width="20" colspan="3">&nbsp;</td>
          </tr><?php }?>
          <tr>
            <td colspan="3" align="center"><input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]?>"></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>