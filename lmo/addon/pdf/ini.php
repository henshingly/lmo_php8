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

require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
if (!defined('VERSIONPDF'))    define('VERSIONPDF','0.12.67'); //Versionsnummer PDF-Class
if (!defined('VERSIONA'))      define('VERSIONA','3.1.1');     //Versionsnummer Teamplan
if (!defined('VERSION'))       define('VERSION','3.1.6');      //Versionsnummer Spielplan
if (!defined('ADDON_NAMEPDF')) define('ADDON_NAMEPDF','ROS PHP Pdf creation class');
if (!defined('ADDON_NAMEA'))   define('ADDON_NAMEA','Teamplan');
if (!defined('ADDON_NAME'))    define('ADDON_NAME','Spielplan');
if (!defined('VERSlON'))       define('VERSlON',ADDON_NAME." ".VERSION." Addon for <c:alink:http://www.liga-manager-online.de>LMO 4</c:alink> (C) 2004 by Tim Schumacher");
if (!defined('VERSlONA'))      define('VERSlONA',"(C) 2005 by <c:alink:http://httipp.bplaced.de>HT</c:alink>");
if (!defined('TEAM_PLAN'))     define('TEAM_PLAN',ADDON_NAMEA." ".VERSIONA." for <c:alink:http://www.liga-manager-online.de>LMO 4</c:alink> ");
if (!defined('PDF_VERSION'))   define('PDF_VERSION',VERSlON);
if (!defined('PDF_CLASS'))     define('PDF_CLASS',"(C) <c:alink:https://github.com/rospdf/pdf-php>".ADDON_NAMEPDF."</c:alink> ".VERSIONPDF);

$pdfhomepage=           isset($cfgarray['pdf']['lmo_pdf_homepage'])?             $cfgarray['pdf']['lmo_pdf_homepage']:'';             // Homepage URL
$TextColorRed=          isset($cfgarray['pdf']['TextColorRed'])?                 $cfgarray['pdf']['TextColorRed']:'';                 // Value of Red Text
$TextColorGreen=        isset($cfgarray['pdf']['TextColorGreen'])?               $cfgarray['pdf']['TextColorGreen']:'';               // Value of Green Text
$TextColorBlue=         isset($cfgarray['pdf']['TextColorBlue'])?                $cfgarray['pdf']['TextColorBlue']:'';                // Value of Blue Text
$RectangleColorRed=     isset($cfgarray['pdf']['RectangleColorRed'])?            $cfgarray['pdf']['RectangleColorRed']:'';            // Value of Red Rectangle
$RectangleColorGreen=   isset($cfgarray['pdf']['RectangleColorGreen'])?          $cfgarray['pdf']['RectangleColorGreen']:'';          // Value of Green Rectangle
$RectangleColorBlue=    isset($cfgarray['pdf']['RectangleColorBlue'])?           $cfgarray['pdf']['RectangleColorBlue']:'';           // Value of Blue Rectangle
$table_tb_width=        isset($cfgarray['pdf']['table_tb_width'])?               $cfgarray['pdf']['table_tb_width']:'';               // Width of League table
$table_md_width=        isset($cfgarray['pdf']['table_md_width'])?               $cfgarray['pdf']['table_md_width']:'';               // Width of the Matchday table
$table_gd_width=        isset($cfgarray['pdf']['table_gd_width'])?               $cfgarray['pdf']['table_gd_width']:'';               // Width of table in spieltag.php
$Rectangle_Width=       isset($cfgarray['pdf']['lmo_pdf_Rectangle_Width'])?      $cfgarray['pdf']['lmo_pdf_Rectangle_Width']:'';      // Width of the Rectangle
$Distance_Side_Edge=    isset($cfgarray['pdf']['lmo_pdf_Distance_Side_Edge'])?   $cfgarray['pdf']['lmo_pdf_Distance_Side_Edge']:'';   // point pitch of margin left
$Distance_Lower_Edge=   isset($cfgarray['pdf']['lmo_pdf_Distance_Lower_Edge'])?  $cfgarray['pdf']['lmo_pdf_Distance_Lower_Edge']:'';  // point pitch of margin down
$img=                   isset($cfgarray['pdf']['lmo_pdf_bild'])?                 $cfgarray['pdf']['lmo_pdf_bild']:'';                 // name of the image file to be displayed in the pdf
$pdfformat=             isset($cfgarray['pdf']['lmo_pdf_format'])?               $cfgarray['pdf']['lmo_pdf_format']:0;                // Format 1 is portrait format, format 0 is landscape format
$pdfanzeige=            isset($cfgarray['pdf']['lmo_pdf_anzeige'])?              $cfgarray['pdf']['lmo_pdf_anzeige']:1;               //
$pdfteamfett=           isset($cfgarray['pdf']['lmo_pdf_teamfett'])?             $cfgarray['pdf']['lmo_pdf_teamfett']:0;              //
$pdfserie=              isset($cfgarray['pdf']['lmo_pdf_serie'])?                $cfgarray['pdf']['lmo_pdf_serie']:0;                 //
$pdfteamnamen=          isset($cfgarray['pdf']['lmo_pdf_teamnamen'])?            $cfgarray['pdf']['lmo_pdf_teamnamen']:0;             //
$schedule_icon=         isset($cfgarray['pdf']['lmo_pdf_schedule_icon'])?        $cfgarray['pdf']['lmo_pdf_schedule_icon']:0;         // Icon in Schedule Table
$teamplanicon=          isset($cfgarray['pdf']['lmo_pdf_teamplanicon'])?         $cfgarray['pdf']['lmo_pdf_teamplanicon']:0;          // Icon in Teamplan Table
$table_icon=            isset($cfgarray['pdf']['lmo_pdf_table_icon'])?           $cfgarray['pdf']['lmo_pdf_table_icon']:0;            // Icon in League Table
$matchday_icon=         isset($cfgarray['pdf']['lmo_pdf_matchday_icon'])?        $cfgarray['pdf']['lmo_pdf_matchday_icon']:0;         // Icon in Matchday Table
$nmatchday_icon=        isset($cfgarray['pdf']['lmo_pdf_nmatchday_icon'])?       $cfgarray['pdf']['lmo_pdf_nmatchday_icon']:0;        // Icon in next Matchday Table
$pdf_PDF_font=          isset($cfgarray['pdf']['lmo_pdf_font'])?                 $cfgarray['pdf']['lmo_pdf_font']:'';                 // Font for the PDF document
$lmo_show_background=   isset($cfgarray['pdf']['lmo_show_background'])?          $cfgarray['pdf']['lmo_show_background']:0;           //
$lmo_show_gameday=      isset($cfgarray['pdf']['lmo_show_gameday'])?             $cfgarray['pdf']['lmo_show_gameday']:0;              //
$lmo_show_pdfimg=       isset($cfgarray['pdf']['lmo_show_pdfimg'])?              $cfgarray['pdf']['lmo_show_pdfimg']:0;               //
$lmo_show_rectangle=    isset($cfgarray['pdf']['lmo_show_rectangle'])?           $cfgarray['pdf']['lmo_show_rectangle']:0;            //
$lmo_show_table=        isset($cfgarray['pdf']['lmo_show_table'])?               $cfgarray['pdf']['lmo_show_table']:0;                //
$lmo_show_nextgameday=  isset($cfgarray['pdf']['lmo_show_nextgameday'])?         $cfgarray['pdf']['lmo_show_nextgameday']:0;          //
$table_md_gridlines=    isset($cfgarray['pdf']['table_md_gridlines'])?           $cfgarray['pdf']['table_md_gridlines']:0;            //
$table_gd_gridlines=    isset($cfgarray['pdf']['table_gd_gridlines'])?           $cfgarray['pdf']['table_gd_gridlines']:0;            //
$table_tb_gridlines=    isset($cfgarray['pdf']['table_tb_gridlines'])?           $cfgarray['pdf']['table_tb_gridlines']:0;            //
$lmo_pdf_linktarget=    isset($cfgarray['pdf']['lmo_pdf_linktarget'])?           $cfgarray['pdf']['lmo_pdf_linktarget']:0;            //
$table_gd_fontsize=     isset($cfgarray['pdf']['table_gd_fontsize'])?            $cfgarray['pdf']['table_gd_fontsize']:0;             // Font size of the table content matchday in spieltag.php
$table_gd_tfontsize=    isset($cfgarray['pdf']['table_gd_tfontsize'])?           $cfgarray['pdf']['table_gd_tfontsize']:0;            // Font size of table heading table matchday in spieltag.php
$table_md_fontsize=     isset($cfgarray['pdf']['table_md_fontsize'])?            $cfgarray['pdf']['table_md_fontsize']:0;             // Font size of the table content matchday in table.php
$table_md_tfontsize=    isset($cfgarray['pdf']['table_md_tfontsize'])?           $cfgarray['pdf']['table_md_tfontsize']:0;            // Font size of table heading table matchday in table.php
$table_tb_fontsize=     isset($cfgarray['pdf']['table_tb_fontsize'])?            $cfgarray['pdf']['table_tb_fontsize']:0;             // Font size of the table content league in table.php
$table_tb_tfontsize=    isset($cfgarray['pdf']['table_tb_tfontsize'])?           $cfgarray['pdf']['table_tb_tfontsize']:0;            // Font size of table heading table league in table.php
$tp_port_fontsize=      isset($cfgarray['pdf']['tp_port_fontsize'])?             $cfgarray['pdf']['tp_port_fontsize']:0;              // Font size of the table content in portrait format in teamplan.php
$tp_port_tfontsize=     isset($cfgarray['pdf']['tp_port_tfontsize'])?            $cfgarray['pdf']['tp_port_tfontsize']:0;             // Font size of table heading in portrait format in teamplan.php
$tp_port_Datum=         isset($cfgarray['pdf']['tp_port_Datum'])?                $cfgarray['pdf']['tp_port_Datum']:0;                 // Column width Date in portrait format in teamplan.php
$tp_port_Zeit=          isset($cfgarray['pdf']['tp_port_Zeit'])?                 $cfgarray['pdf']['tp_port_Zeit']:0;                  // Column width Time in portrait format in teamplan.php
$tp_port_Team=          isset($cfgarray['pdf']['tp_port_Team'])?                 $cfgarray['pdf']['tp_port_Team']:0;                  // Column width hometeam and guestteam in portrait format in teamplan.php
$tp_port_Result=        isset($cfgarray['pdf']['tp_port_Result'])?               $cfgarray['pdf']['tp_port_Result']:0;                // Column width Result in portrait format in teamplan.php
$tp_land_fontsize=      isset($cfgarray['pdf']['tp_land_fontsize'])?             $cfgarray['pdf']['tp_land_fontsize']:0;              // Font size of the table content in landscape format in teamplan.php
$tp_land_tfontsize=     isset($cfgarray['pdf']['tp_land_tfontsize'])?            $cfgarray['pdf']['tp_land_tfontsize']:0;             // Font size of table heading in landscape format in teamplan.php
$tp_land_Datum=         isset($cfgarray['pdf']['tp_land_Datum'])?                $cfgarray['pdf']['tp_land_Datum']:0;                 // Column width Date in landscape format in teamplan.php
$tp_land_Zeit=          isset($cfgarray['pdf']['tp_land_Zeit'])?                 $cfgarray['pdf']['tp_land_Zeit']:0;                  // Column width Time in landscape format in teamplan.php
$tp_land_Team=          isset($cfgarray['pdf']['tp_land_Team'])?                 $cfgarray['pdf']['tp_land_Team']:0;                  // Column width hometeam and guestteam in landscape format in teamplan.php
$tp_land_Result=        isset($cfgarray['pdf']['tp_land_Result'])?               $cfgarray['pdf']['tp_land_Result']:0;                // Column width Result in landscape format in teamplan.php
$iconsize_gd=           isset($cfgarray['pdf']['iconsize_gd'])?                  $cfgarray['pdf']['iconsize_gd']:0;                   // Icon size in table matchday in spielplan.php
$iconsize_md=           isset($cfgarray['pdf']['iconsize_md'])?                  $cfgarray['pdf']['iconsize_md']:0;                   // Icon size in table matchday in table.php
$iconsize_tb=           isset($cfgarray['pdf']['iconsize_tb'])?                  $cfgarray['pdf']['iconsize_tb']:0;                   // Icon size in table league in table.php
$iconsize_tp_port=      isset($cfgarray['pdf']['iconsize_tp_port'])?             $cfgarray['pdf']['iconsize_tp_port']:0;              // Icon size in portrait format in teamplan.php
$iconsize_tp_land=      isset($cfgarray['pdf']['iconsize_tp_land'])?             $cfgarray['pdf']['iconsize_tp_land']:0;              // Icon size in landscape format in teamplan.php
$pdfimg=                URL_TO_IMGDIR."/pdf/".$img;                                                                                   // The entered file under "lmo_pdf_bild" is located in the folder "URL_TO_LMO/img/pdf/"
$selteam=               isset($_GET['selteam'])?                                 $_GET['selteam']:'';                                 // The number of the selected team
$file=                  isset($_GET['file'])?                                    $_GET['file']:'';                                    // name of the league file
$st=                    isset($_GET['st'])?                                      $_GET['st']:0;                                       // number of the matchday



function HTML_iconPDF($img_name,$img_type,$img_size='big') {
  $subFolder = "/".$img_type."/".$img_size."/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImagePDF($img_name,$subFolder,$extension) ) {
      break;
    }
    else {
      $imgHTML = URL_TO_IMGDIR."/pdf/no_icon.png";
    }
  }
  return $imgHTML;
}

function findImagePDF ($key,$path,$imgType,$htmlParameter="",$alternative_text='') {
  //$key=str_replace("/","",isset($key));
  $key=str_replace("/","",$key);
  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    $key=preg_replace("/[^a-zA-Z0-9]/",'',$key);
    // echo $key;
  }
  else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType";
  }

  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    $key=preg_replace("/[I(A)0-9]+$/",'',$key);
    // echo $key;
  }
  else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType";
  }

  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    return $alternative_text;
  } else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType";
  }
}
?>
