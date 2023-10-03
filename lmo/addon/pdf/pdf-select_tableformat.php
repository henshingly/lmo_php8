<?php
/** This file is part of Pdf Addon for LMO 4.
  * Copyright (C) 2021 by Dietmar Kersting
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
$Total_Width=595.28;
$Total_Height=841.89;

$pdf=new CezTableImage('a4');
$all=$pdf->openObject();
$pdf->tempPath=PATH_TO_LMO.'/output';
$pdf->saveState();
$pdf->openHere('Fit');
if ($lmo_show_pdfimg==1) {
  $pdf->ezImage($pdfimg, -35, 100, 'none', 'center');
}
$pdf->ezSetMargins(35,35,50,50);  //(top,bottom,left,right)
$pdf->selectFont(PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/'.$pdf_PDF_font);
$pdf->addText($Total_Width-170,$Total_Height-15,10, date("d.m.Y - H:i")." ".$text['pdf'][103]);
$pdf->addText(50,$Total_Height-30,15,"\n<b>".$text['pdf'][279]." ".$text[86]."</b>");
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

$data = array(
  array('Platz' => '1',  'Mannschaft' => 'Bayer 04 Leverkusen', 'Spiele' => '8', 's' => '6', 'u' => '2', 'n' => '0', '+Tore' => '18', '-Tore' => '5',  'Diff.' => '13',  'Pkt' => '20'),
  array('Platz' => '2',  'Mannschaft' => 'Hamburger SV',        'Spiele' => '8', 's' => '6', 'u' => '2', 'n' => '0', '+Tore' => '20', '-Tore' => '8',  'Diff.' => '12',  'Pkt' => '20'),
  array('Platz' => '3',  'Mannschaft' => 'FC Schalke 04',       'Spiele' => '8', 's' => '5', 'u' => '1', 'n' => '2', '+Tore' => '11', '-Tore' => '5',  'Diff.' => '6',   'Pkt' => '16'),
  array('Platz' => '4',  'Mannschaft' => 'Werder Bremen',       'Spiele' => '8', 's' => '4', 'u' => '3', 'n' => '1', '+Tore' => '14', '-Tore' => '6',  'Diff.' => '8',   'Pkt' => '15'),
  array('Platz' => '5',  'Mannschaft' => 'TSG Hoffenheim',      'Spiele' => '8', 's' => '4', 'u' => '2', 'n' => '2', '+Tore' => '15', '-Tore' => '7',  'Diff.' => '8',   'Pkt' => '14'),
  array('Platz' => '6',  'Mannschaft' => 'FSV Mainz 05',        'Spiele' => '8', 's' => '4', 'u' => '2', 'n' => '2', '+Tore' => '12', '-Tore' => '13', 'Diff.' => '-1',  'Pkt' => '14'),
  array('Platz' => '7',  'Mannschaft' => 'VfL Wolfsburg',       'Spiele' => '8', 's' => '4', 'u' => '1', 'n' => '3', '+Tore' => '16', '-Tore' => '15', 'Diff.' => '1',   'Pkt' => '13'),
  array('Platz' => '8',  'Mannschaft' => 'Bayern München',      'Spiele' => '8', 's' => '3', 'u' => '3', 'n' => '2', '+Tore' => '13', '-Tore' => '7',  'Diff.' => '6',   'Pkt' => '12'),
  array('Platz' => '9',  'Mannschaft' => 'Eintracht Frankfurt', 'Spiele' => '8', 's' => '2', 'u' => '4', 'n' => '2', '+Tore' => '8',  '-Tore' => '10', 'Diff.' => '-2',  'Pkt' => '10'),
  array('Platz' => '10', 'Mannschaft' => 'SC Freiburg',         'Spiele' => '8', 's' => '3', 'u' => '1', 'n' => '4', '+Tore' => '13', '-Tore' => '17', 'Diff.' => '-4',  'Pkt' => '10'),
  array('Platz' => '11', 'Mannschaft' => 'Hannover 96',         'Spiele' => '8', 's' => '2', 'u' => '3', 'n' => '3', '+Tore' => '11', '-Tore' => '10', 'Diff.' => '1',   'Pkt' => '9'),
  array('Platz' => '12', 'Mannschaft' => 'Borussia Dortmund',   'Spiele' => '8', 's' => '2', 'u' => '3', 'n' => '3', '+Tore' => '7',  '-Tore' => '13', 'Diff.' => '-6',  'Pkt' => '9'),
  array('Platz' => '13', 'Mannschaft' => 'VfB Stuttgart',       'Spiele' => '8', 's' => '2', 'u' => '2', 'n' => '4', '+Tore' => '9',  '-Tore' => '12', 'Diff.' => '-3',  'Pkt' => '8'),
  array('Platz' => '14', 'Mannschaft' => 'VfL Bochum',          'Spiele' => '8', 's' => '2', 'u' => '2', 'n' => '4', '+Tore' => '9',  '-Tore' => '15', 'Diff.' => '-6',  'Pkt' => '8'),
  array('Platz' => '15', 'Mannschaft' => 'Borussia M´gladbach', 'Spiele' => '8', 's' => '2', 'u' => '1', 'n' => '5', '+Tore' => '9',  '-Tore' => '16', 'Diff.' => '-7',  'Pkt' => '7'),
  array('Platz' => '16', 'Mannschaft' => '1. FC Köln',          'Spiele' => '8', 's' => '1', 'u' => '2', 'n' => '5', '+Tore' => '5',  '-Tore' => '10', 'Diff.' => '-5',  'Pkt' => '5'),
  array('Platz' => '17', 'Mannschaft' => '1. FC Nürnberg',      'Spiele' => '8', 's' => '1', 'u' => '2', 'n' => '5', '+Tore' => '4',  '-Tore' => '12', 'Diff.' => '-8',  'Pkt' => '5'),
  array('Platz' => '18', 'Mannschaft' => 'Hertha BSC',          'Spiele' => '8', 's' => '1', 'u' => '0', 'n' => '7', '+Tore' => '7',  '-Tore' => '20', 'Diff.' => '-13', 'Pkt' => '3'),
);
$cols = array('Platz' => 'Platz', 'Mannschaft' => 'Mannschaft', 'Spiele' => 'Spiele', 's' => 's', 'u' => 'u', 'n' => 'n', '+Tore' => '+Tore', '-Tore' => '-Tore', 'Diff' => 'Diff', 'Pkt' => 'Pkt');
$coloptions = array('Platz' => array('justification' => 'center'), 'Mannschaft' => array('justification' => 'left'), 'Spiele' => array('justification' => 'center'), 's' => array('justification' => 'center'), 'u' => array('justification' => 'center'), 'n' => array('justification' => 'center'), '+Tore' => array('justification' => 'center'), '-Tore' => array('justification' => 'center'), 'Diff.' => array('justification' => 'center'), 'Pkt' => array('justification' => 'center'));

$j = 0;
for ($i = 0; $i <=EZ_GRIDLINE_ALL ; $i++) {
  if (!($j % 4) && $j != 0) {
    $pdf->ezNewPage();
  }
  $title = sprintf($text['pdf'][280].': %d %s', $i, '', '');
  $pdf->ezTable($data, $cols, $title, array(
    'showHeadings'        =>  1,
    'shaded'              =>  1,
    'gridlines'           =>  $i,
    'cols'                =>  $coloptions,
    'innerLineThickness'  =>  0.5,
    'outerLineThickness'  =>  3));
  $pdf->ezText('', 60);  //Distance to the next block by empty text line
  $j++;
}
$pdf->ezStream();
?>
