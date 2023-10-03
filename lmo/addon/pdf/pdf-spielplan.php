<?php
/** Pdf Addon for LMO 4
  *
  * (c) by Tim Schumacher
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
/** Change the design, clean up errors and insert a new PDF class.
  * Insert new features and formatting.
  * Now everything can be controlled via the Admin menu.
  * Merge all PDF Addons from Torsten Hofmann and Tim Schumacher
  *
  * Copyright (C) 2017 by Dietmar Kersting
  *
  * New PDF CLASS
  * https://github.com/rospdf/pdf-php/
  */

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/pdf/ini.php");

//A4 ist 210mm x 297mm oder 595.28 x 841.89 points
$Total_Width='595.28';
$Total_Height='841.89';
$leer='';

$error=FALSE;
$protectRows=11;
if ($file <> '') {
  $liga=new liga();
  if ($liga->loadFile(PATH_TO_LMO."/".$dirliga.$file)==TRUE) {
    $ligaName=$liga->name;
    $filename=$text['pdf'][107]."_".$ligaName;
    $pdf=new CezTableImage('a4');
    $all=$pdf->openObject();
    $pdf->tempPath=PATH_TO_LMO.'/output';
    $start = microtime(true);
    $pdf->saveState();
    $pdf->openHere('Fit');
    if ($lmo_show_pdfimg==1) {
  $pdf->ezImage($pdfimg, -35, 100, 'none', 'center');
    }
    $pdf->ezSetMargins(30,30,50,50);  //(top,bottom,left,right)
    $pdf->selectFont(PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/'.$pdf_PDF_font);
    $pdf->addText($Total_Width-170,$Total_Height-15,10,strftime ("%d.%m.%Y - %H:%M")." ".$text['pdf'][103]);
    $pdf->addText(50,$Total_Height-30,15,"$liga->name");
    if ($lmo_show_rectangle==1) {
      $pdf->setColor($RectangleColorRed,$RectangleColorGreen,$RectangleColorBlue);
      $pdf->filledRectangle($Distance_Side_Edge,$Distance_Lower_Edge,$Rectangle_Width,$Total_Height-(2*$Distance_Lower_Edge));
      $pdf->filledRectangle($Total_Width-$Rectangle_Width-$Distance_Side_Edge,$Distance_Lower_Edge,$Rectangle_Width,$Total_Height-(2*$Distance_Lower_Edge));
      $pdf->setColor($TextColorRed,$TextColorGreen,$TextColorBlue);
      $pdf->addText($Distance_Side_Edge+$Rectangle_Width/2+5,$Total_Height/2-100,20,$pdfhomepage,0, '',-90);
      $width=($Total_Width-2*$Rectangle_Width-2*$Distance_Side_Edge)/100*$table_gd_width;
    } else {
      $pdf->setColor(0,0,0);
      $pdf->addText($Total_Width/2-35,10,10,$pdfhomepage,0, '',0);
      $width=$Total_Width/100*$table_gd_width;
    }
    $pdf->setColor(0,0,0);
    $pdf->addText(8,3,6,PDF_VERSION);
    $pdf->restoreState();
    $pdf->closeObject();
    $pdf->addObject($all,'all');

    $partieOptions=array(
      $text['pdf'][8]      =>  array('justification'=>'center'),
      $text[549]           =>  array('justification'=>'center'),
      $text[41]            =>  array('justification'=>'right'),
      $text['pdf'][6]      =>  array('justification'=>'left'),
      $text['pdf'][9]      =>  array('justification'=>'center'));

    $spTagOptionsSP=array(
      'cols'               =>  $partieOptions,
      'titleFontSize'      =>  $table_gd_tfontsize,
      'fontSize'           =>  $table_gd_fontsize,
      'protectRows'        =>  $protectRows,
      'innerLineThickness' =>  0.5,
      'outerLineThickness' =>  2,
      'shaded'             =>  1,
      'gridlines'          =>  $table_gd_gridlines,
      'width'              =>  $width);

    // Gesamtspielplan der Ligadatei
    foreach($liga->spieltage as $spieltag) {
      if ($liga->options->keyValues['enableGameSort'] == "1") {  //Sorting is active in the league file
        $partien = $spieltag->getPartien("datum");
      } else {                                                   //Sorting is not active in the league file
        $partien = $spieltag->partien;
      }
      $pdfSpieltag=array();
      if ($schedule_icon==1) {
        foreach($partien as $partie) {
          $pdfPartie=array(
            $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
            $text[549]       =>  $partie->zeitString($leer='__:__'),
            $text[41]        =>  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$iconsize_gd.'>'."  ",
            $text['pdf'][6]  =>  '<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$iconsize_gd.'>'."     ".$partie->gast->name,
            $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
        $pdfSpieltag[]=$pdfPartie;
        }
      } else {
        foreach($partien as $partie) {
          $pdfPartie=array(
            $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
            $text[549]       =>  $partie->zeitString($leer='__:__'),
            $text[41]        =>  $partie->heim->name,
            $text['pdf'][6]  =>  $partie->gast->name,
            $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
          $pdfSpieltag[]=$pdfPartie;
        }
      }
      $pdf->ezTable($pdfSpieltag,"",$spieltag->nr.". ".$text[2],$spTagOptionsSP);
      $pdf->ezText('', 15);  //Distance to the next table by empty text line
    }
  } else {
    $error=TRUE;
    $message= getMessage("<b><u>".$text['pdf'][13].":</u></b> ".$file,True);
    $ligaName=$message;
  }
}
if (!$error) {
  $filename=str_replace(" ", "", $filename);
  $pdf->ezStream(['Content-Disposition'=>$filename.'.pdf']);
  $end = microtime(true) - $start;
  error_log("Page Building pdf-spielplan.php: ".round($end, 2)." seconds");
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
          "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title><?php echo "Pdf Addon ".($ligaName)?></title>
</head>
<body>
<?php echo $message;?>
</body>
</html>
<?php
}
?>
