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

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/pdf/ini.php");

//A4 ist 210mm x 297mm oder 595.28 x 841.89 points
$Total_Width='595.28';
$Total_Height='841.89';
//$all='';

$pdf = new CezPDF('a4', 'portrait');
$all=$pdf->openObject();
$pdf->tempPath=PATH_TO_LMO.'/output';
$pdf->saveState();
$pdf->openHere('Fit');
if ($lmo_show_pdfimg==1) {
  $pdf->ezImage($pdfimg, -20, 180, 'none', 'center');
}
$pdf->ezSetMargins(35,35,50,50);  //(top,bottom,left,right)
$pdf->selectFont(PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/'.$pdf_PDF_font);
$pdf->addText($Total_Width-170,$Total_Height-15,10, date("d.m.Y - H:i")." ".$text['pdf'][103]);
$pdf->addText(50,$Total_Height-30,15,"\n<b>PDF - ".$text['pdf'][232]."</b>");
if ($lmo_show_rectangle==1) {
  $pdf->setColor($RectangleColorRed,$RectangleColorGreen,$RectangleColorBlue);
  $pdf->filledRectangle($Distance_Side_Edge,$Distance_Lower_Edge,$Rectangle_Width,$Total_Height-(2*$Distance_Lower_Edge));
  $pdf->filledRectangle($Total_Width-$Rectangle_Width-$Distance_Side_Edge,$Distance_Lower_Edge,$Rectangle_Width,$Total_Height-(2*$Distance_Lower_Edge));
  $pdf->setColor($TextColorRed,$TextColorGreen,$TextColorBlue);
  $pdf->addText($Distance_Side_Edge+$Rectangle_Width/2+5,$Total_Height/2-100,20,$pdfhomepage,0, '',-90);
} else {
  $pdf->setColor(0,0,0);
  $pdf->addText($Total_Width/2-35,10,10,$pdfhomepage,0, '',0);
}
$pdf->setColor(0,0,0);
$pdf->addText(8,3,6,PDF_CLASS);
$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all');
$pdf->ezText('',10);
$pdf->ezText('Code: '.$text['pdf'][228].' | '.$text['pdf'][229].' | '.$text['pdf'][230].' ('.$text['pdf'][235].')',10);
$pdf->ezText('',10);
for($number3=0.0; $number3 <= 1.0; $number3=$number3+0.1) {
  for($number2=0.0; $number2 <= 1.0; $number2=$number2+0.1) {
    for($number1=0.0; $number1 <= 1.0; $number1=$number1+0.1) {
      $x=number_format($number1, 1);
      $y=number_format($number2, 1);
      $z=number_format($number3, 1);
      $pdf->setColor(0.0,0.0,0.0);
      $pdf->ezText('Code:   '.$x.' | '.$y.' | '.$z.' ', 10);
      $pdf->setColor($number1,$number2,$number3);
      $pdf->filledRectangle(145, $pdf->y, 350, 10);
    }
  }
}
if (isset($_GET['d']) && $_GET['d']) {
  echo $pdf->ezOutput(true);
} else {
  $pdf->ezStream(array('compress' => 0, 'Content-Disposition' => $text['pdf'][232].'.pdf'));
}
