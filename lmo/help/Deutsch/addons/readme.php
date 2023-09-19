<?php
/** This file is part of Pdf Addon for LMO 4.
..* Copyright (C) 2017 by Dietmar Kersting
..*
..* MINITABLE Addon for LigaManager Online (pdf-tabelle.php and pdf-spielplan.php)
..* Copyright (C) 2003 by Tim Schumacher
..* timme@uni.de /
..*
..* Pdf Addon for LMO 4 für Spielplan (pdf-spielplan.php)
..* Copyright (C)  by Torsten Hofmann V 2.0
..*
..* Pdf Addon für LMO 4 is free software: you can redistribute it and/or modify
..* it under the terms of the GNU General Public License as published by
..* the Free Software Foundation, either version 3 of the License, or
..* (at your option) any later version.
..*
..* Pdf Addon für LMO 4 is distributed in the hope that it will be useful,
..* but WITHOUT ANY WARRANTY; without even the implied warranty of
..* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
..* GNU General Public License for more details.
..*
..* You should have received a copy of the GNU General Public License
..* along with Pdf Addon für LMO 4.  If not, see <http://www.gnu.org/licenses/>.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
..*
..* Diese Datei ist Teil des PDF Addon für LMO 4.
..*
..* Pdf Addon für LMO 4 ist Freie Software: Sie können es unter den Bedingungen
..* der GNU General Public License, wie von der Free Software Foundation,
..* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
..* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
..*
..* Pdf Addon für LMO 4 wird in der Hoffnung, dass es nützlich sein wird, aber
..* OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
..* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
..* Siehe die GNU General Public License für weitere Details.
..*
..* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
..* Pdf Addon für LMO 4 erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
  *
  * DAS ENTFERNEN ODER DIE ÄNDERUNG DER COPYRIGHT-HINWEISE IST NICHT ERLAUBT!
**/

error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

require_once(dirname(__FILE__).'/../../../init.php');
require_once(PATH_TO_ADDONDIR."/pdf/ini.php");

class Creport extends Cezpdf {
  public $reportContents = [];
  public function __construct($p, $o, $t, $op) {
    parent::__construct($p, $o, $t, $op);
  }

  function rf($info){
    $tmp = $info['p'];
    $lvl = $tmp[0];
    $lbl = rawurldecode(substr($tmp,1));
    $num=$this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
    $this->reportContents[] = array($lbl,$num,$lvl );
    $this->addDestination('toc'.(count($this->reportContents)-1),'Fit',$info['y']+$info['height']);
  }

  public function dots($info) {
    // Zeichne eine gepunktete Linie nach rechts und setze eine Seitenzahl
    $tmp = $info['p'];
    $lvl = $tmp[0];
    $lbl = substr($tmp, 1);
    $xpos = 520;

    switch ($lvl) {
      case '1':
        $size = 16;
        $thick = 1;
      break;
      case '2':
        $size = 12;
        $thick = 0.5;
      break;
    }

    $this->saveState();
    $this->setLineStyle($thick, 'round', '', [0, 2]);
    $this->line($xpos, $info['y'], $info['x'] + 5, $info['y']);
    $this->restoreState();
    $this->addText($xpos + 5, $info['y'], $size, $lbl);
  }
}

$project_url = "https://www.vest-sport.de/forum/viewtopic.php?f=11&t=40";
$project_lmo_url ="https://www.liga-manager-online.de";
$pdf_class_url = "https://github.com/rospdf/";
$project_version = "3.0.1";

$pdf = new Creport('a4','portrait', 'none', null);
// to test on windows xampp
if(strpos(PHP_OS, 'WIN') !== false){
    $pdf->tempPath = PATH_TO_LMO.'/output';
}
$start = microtime(true);

$pdf->allowedTags .= '|uline|rf:?.*?|dots:[0-9]+';

$pdf->ezSetMargins(50,70,50,50);

$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,40,578,40);
$pdf->line(20,822,578,822);
$pdf->addText(20,30,8,$project_url);
$pdf->addText(494,30,8,'PDF-Addon Version ' . $project_version);
$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all');
$pdf->ezSetDy(-150);

$mainFont = PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/Helvetica.afm';
$codeFont = PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/Courier.afm';
$pdf->selectFont($mainFont);
if (file_exists(PATH_TO_IMGDIR.'/pdf/lmo.jpg')){
  $pdf->ezText($project_lmo_url,10,array('justification'=>'centre'));
  $pdf->ezImage($pdfimg, 1, 250, 'none', 'center',0,0);
  $pdf->addJpegFromFile(PATH_TO_IMGDIR.'/pdf/lmo.jpg', 246, 640, 100,0);
  $pdf->ezText("PDF Addon\n",30,array('justification'=>'centre'));
  $pdf->ezText("Addons für LMO ab Version 4.0.2\n",20,array('justification'=>'centre'));
  $pdf->ezText("unter zu Hilfenahme von \nPHP Pdf Class Version ".VERSIONPDF." von\n",20,array('justification'=>'centre'));
  if (file_exists(PATH_TO_IMGDIR.'/pdf/ros.jpg')){
    $pdf->ezText($pdf_class_url,10,array('justification'=>'centre'));
    $pdf->addJpegFromFile(PATH_TO_IMGDIR.'/pdf/ros.jpg',230,300,150,0);
  }
  $pdf->openHere('Fit');
}

function ros_logo(&$pdf,$x,$y,$height,$wl=0,$wr=0){
  global $project_url;
  $pdf->saveState();
  $h=100;
  $factor = $height/$h;
  $pdf->selectFont('Helvetica-Bold');
  $text = 'PDF-Addon';
  $ts=100*$factor;
  $th = $pdf->getFontHeight($ts);
  $td = $pdf->getFontDescender($ts);
  $tw = $pdf->getTextWidth($ts,$text);
  $pdf->setColor(0.6,0,0);
  $z = 0.86;
  $pdf->filledRectangle($x-$wl,$y-$z*$h*$factor,$tw*1.2+$wr+$wl,$h*$factor*$z);
  $pdf->setColor(1,1,1);
  $pdf->addText($x,$y-$th-$td,$ts,$text);
  $pdf->setColor(0.6,0,0);
  $pdf->addText($x,$y-$th-$td,$ts*0.1, $project_url);
  $pdf->restoreState();
  return $height;
}

$pdf->selectFont($mainFont);

//-----------------------------------------------------------
// load up the document content
$data=file('./pdf_addon.txt');

$pdf->ezNewPage();

$pdf->ezStartPageNumbers(intval($pdf->ez['pageWidth']/2) + 20 ,28,10,'','',1);

$size=12;
$height = $pdf->getFontHeight($size);
$textOptions = array('justification'=>'full');
$collecting=0;
$code='';

foreach ($data as $line){
  // go through each line, showing it as required, if it is surrounded by '<>' then
  // assume that it is a title
  $line=chop($line);
  if (strlen($line) && $line[0]=='#'){
    // comment, or new page request
    switch($line){
      case '#NP':
        $pdf->ezNewPage();
        break;
      case '#C':
        $pdf->selectFont($codeFont);
        $textOptions = array('justification'=>'left','left'=>20,'right'=>20);
        $size=10;
        break;
      case '#c':
        $pdf->selectFont($mainFont);
        $textOptions = array('justification'=>'full');
        $size=12;
        break;
      case '#X':
        $collecting=1;
        break;
      case '#x':
        $pdf->saveState();
        eval($code);
        $pdf->restoreState();
        $pdf->selectFont($mainFont);
        $code='';
        $collecting=0;
        break;
    }
  } else if ($collecting){
    $code.=$line;
  } else if (((strlen($line)>1 && $line[1]=='<') )) {
    // then this is a title
    $tmp = substr($line,2,strpos($line, '>')-2);
    $tmp2 = $tmp .'<C:rf:'.$line[0].''.rawurlencode($tmp).'>';
    $tmp3 = substr($line, strpos($line, '>') + 1);

    switch($line[0]){
      case '1':
        $pdf->saveState();
        $pdf->setColor(0.5,0.5,0.5);
        $pdf->ezText("# " . $tmp2 . " #" ,26,array('justification'=>'centre'));
        $pdf->restoreState();
        break;
      case '2':
        // add a grey bar, highlighting the change
        $pdf->transaction('start');
        $ok=0;
        while (!$ok){
          $thisPageNum = $pdf->ezPageCount;
          $pdf->saveState();
          $pdf->setColor(0.5,0.5,0.5);
          //$pdf->filledRectangle($pdf->ez['leftMargin'],$pdf->y-$pdf->getFontHeight(18)+$pdf->getFontDescender(18),$pdf->ez['pageWidth']-$pdf->ez['leftMargin']-$pdf->ez['rightMargin'],$pdf->getFontHeight(18));
          $pdf->ezText("# " . $tmp2,18);

          $w = $pdf->getTextWidth(18, "# " . $tmp2);
          $pdf->y = $pdf->y + 15;
          $pdf->ezText($tmp3, 12, array('left' => $w));
          $pdf->restoreState();
          
          if ($pdf->ezPageCount==$thisPageNum){
            $pdf->transaction('commit');
            $ok=1;
          } else {
            // then we have moved onto a new page, bad bad, as the background colour will be on the old one
            $pdf->transaction('rewind');
            $pdf->ezNewPage();
          }
        }
        break;
      case '3':
        $pdf->saveState();
        $pdf->setColor(0.5,0.5,0.5);
        $pdf->ezText("" . $tmp2,12,array('justification'=>'left'));
        $pdf->restoreState();
        break;
    }
  } else {
    // then this is just text
    // the ezpdf function will take care of all of the wrapping etc.
    $pdf->ezText($line,$size,$textOptions);
  }

}

$pdf->ezStopPageNumbers(1,1);

// now add the table of contents, including internal links
$pdf->ezInsertMode(1,1,'after');
$pdf->ezNewPage();

$pdf->saveState();
$pdf->setColor(0.5,0.5,0.5);
$pdf->ezText("Inhaltsverzeichnis\n",26,array('justification'=>'centre'));
$xpos = 520;
$contents = $pdf->reportContents;
foreach($contents as $k=>$v){
  switch ($v[2]){
    case '1':
      $y=$pdf->ezText('<c:ilink:toc'.$k.'>'.$v[0].'</c:ilink><C:dots:1'.$v[1].'>',16,array('aright'=>$xpos));
      break;
    case '2':
      $pdf->ezText('<c:ilink:toc'.$k.'>'.$v[0].'</c:ilink><C:dots:2'.$v[1].'>',12,array('left'=>50,'aright'=>$xpos));
      break;
  }
}
$pdf->restoreState();

if (isset($_GET['d']) && $_GET['d']){
  echo "<pre>";
  echo $pdf->ezOutput(TRUE);
  echo "</pre>";
} else {
  $pdf->ezStream(['Content-Disposition'=>'readme.pdf']);
}

$end = microtime(true) - $start;
error_log($end);

?>