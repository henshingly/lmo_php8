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
**/

error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

require_once(dirname(__FILE__).'/../../../init.php');
require_once(PATH_TO_ADDONDIR."/pdf/ini.php");


// define a class extension to allow the use of a callback to get the table of contents, and to put the dots in the toc
class Creport extends Cezpdf {
  public $reportContents = [];
  public function __construct($p, $o, $t, $op) {
    parent::__construct($p, $o, $t, $op);
  }

  public function rf($info) {
    // this callback records all of the table of contents entries, it also places a destination marker there
    // so that it can be linked too
    $tmp = $info['p'];
    $lvl = $tmp[0];
    $lbl = rawurldecode(substr($tmp, 1));
    $num = $this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
    $this->reportContents[] = [$lbl, $num, $lvl];
    $this->addDestination('toc' . (count($this->reportContents) - 1), 'XYZ', 0, $info['y'] + $info['height'], 0);
  }

  public function dots($info) {
    // draw a dotted line over to the right and put on a page number
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
// this code has been modified to use ezpdf.

$project_url = "https://github.com/henshingly/";
$project_version = "Version 3.2.0";

$pdf = new Creport('a4', 'portrait', 'none', null);

$start = microtime(true);

// IMPORTANT: To allow custom callbacks being executed
$pdf->allowedTags .= '|uline|rf:?.*?|dots:[0-9]+';

$pdf->ezSetMargins(50, 70, 50, 50);

// put a line top and bottom on all the pages
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0, 0, 0, 1);
$pdf->line(20, 40, 578, 40);
$pdf->line(20, 822, 578, 822);
$pdf->addText(20, 30, 8, $project_url);

$w = $pdf->getTextWidth(8, $project_version);
$pdf->addText(578 - intval($w), 30, 8, $project_version);

$pdf->restoreState();
$pdf->closeObject();
// note that object can be told to appear on just odd or even pages by changing 'all' to 'odd'
// or 'even'.
$pdf->addObject($all, 'all');

$pdf->ezSetDy(-150);

$mainFont = 'Helvetica';
$codeFont = PATH_TO_ADDONDIR."/classes/pdf/fonts/Courier.afm";
// select a font
$pdf->selectFont($mainFont);

$pdf->ezText("LMO PDF Addon\n", 30, ['justification' => 'centre']);
$pdf->ezText($text['pdf'][16]."\n".$text['pdf'][17]."\nwww.liga-manager-online.de\n", 20, ['justification' => 'centre']);
$pdf->ezText($text['pdf'][19]."\n\n<c:alink:https://github.com/henshingly/lmo-pdf-addon/graphs/contributors>".$text['pdf'][20]."</c:alink>\n", 14, ['justification' => 'centre']);
$pdf->ezText($project_version, 12, ['justification' => 'centre']);
$pdf->ezText('php ' . phpversion(), 12, ['justification' => 'centre']);
$pdf->ezSetDy(-150);
// modified to use the local file if it can
$pdf->ezText("FORK AUF GITHUB.COM", 12, ['justification' => 'right']);

$pdf->openHere('Fit');

function ros_logo(&$pdf, $x, $y, $height, $wl = 0, $wr = 0) {
  global $project_url;
  $pdf->saveState();
  $h = 100;
  $factor = $height / $h;
  $pdf->selectFont('Helvetica-Bold');
  $text = 'PDF-Addon';
  $ts = 100 * $factor;
  $th = $pdf->getFontHeight($ts);
  $td = $pdf->getFontDescender($ts);
  $tw = $pdf->getTextWidth($ts, $text);
  $pdf->setColor(0, 0.2, 0.8);
  $z = 0.86;
  $pdf->filledRectangle($x - $wl, $y - $z * $h * $factor, $tw * 1.2 + $wr + $wl, $h * $factor * $z);
  $pdf->setColor(0, 0.9, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',-10);
  $pdf->setColor(0.2, 0.9, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',-8);
  $pdf->setColor(0.4, 0.9, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',-6);
  $pdf->setColor(0.6, 0.9, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',-4);
  $pdf->setColor(0.8, 0.9, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',-2);
  $pdf->setColor(1, 1, 1);
  $pdf->addText($x, $y - $th - $td, $ts, $text,0, 'left',0);
    $pdf->setColor(0.6, 0, 0);
  $pdf->addText($x, $y - $th - $td, $ts * 0.1, $project_url);
  $pdf->restoreState();
  return $height;
}
ros_logo($pdf, 100, $pdf->y - 80, 80, 180, 300);
$pdf->selectFont($mainFont);

if (file_exists(PATH_TO_IMGDIR."/pdf/addon-pdf.png")) {
  $pdf->addPngFromFile(PATH_TO_IMGDIR."/pdf/addon-pdf.png", 199, 650, 200, 0);
}
if (file_exists(PATH_TO_IMGDIR."/pdf/github.jpg")) {
  $pdf->ezSetDy(-30);
  $pdf->addJpegFromFile(PATH_TO_IMGDIR."/pdf/github.jpg", 330, $pdf->y);
  $pdf->addLink($project_url . 'lmo-pdf-addon', 330, $pdf->y, 394, $pdf->y + 64);
}

//-----------------------------------------------------------
// load up the document content
if (file_exists(PATH_TO_LMO."/help/{$lmouserlang}/addons/pdf_addon.txt")) {
  $data = file(PATH_TO_LMO."/help/{$lmouserlang}/addons/pdf_addon.txt");
} else $data = file(PATH_TO_LMO."/help/Deutsch/addons/pdf_addon.txt");

$pdf->ezNewPage();

$pdf->ezStartPageNumbers(intval($pdf->ez['pageWidth'] / 2), 28, 10, 'center');

$size = 12;
$height = $pdf->getFontHeight($size);
$textOptions = ['justification' => 'full'];
$collecting = 0;
$code = '';

foreach ($data as $line) {
  // go through each line, showing it as required, if it is surrounded by '<>' then
  // assume that it is a title
  $line = chop($line);
  if (strlen($line) && $line[0] == '#') {
    // comment, or new page request
    switch ($line) {
      case '#NP':
        $pdf->ezNewPage();
      break;
      case '#C':
        $pdf->selectFont($codeFont);
        $textOptions = ['justification' => 'left', 'left' => 20, 'right' => 20];
        $size = 10;
      break;
      case '#c':
        $pdf->selectFont($mainFont);
        $textOptions = ['justification' => 'full'];
        $size = 12;
      break;
      case '#X':
        $collecting = 1;
      break;
      case '#x':
        $pdf->saveState();
        eval($code);
        $pdf->restoreState();
        $pdf->selectFont($mainFont);
        $code = '';
        $collecting = 0;
      break;
    }
  } else if ($collecting) {
    $code .= $line;
  } else if (((strlen($line) > 1 && $line[1] == '<'))) {
    // then this is a title
    $tmp = substr($line, 2, strpos($line, '>') - 2);
    $tmp2 = $tmp . '<C:rf:' . $line[0] . '' . rawurlencode($tmp) . '>';
    $tmp3 = substr($line, strpos($line, '>') + 1);
    switch ($line[0]) {
      case '1':
        $pdf->saveState();
        $pdf->setColor(0.5, 0.5, 0.5);
        $pdf->ezText("# " . $tmp2 . " #", 26, ['justification' => 'centre']);
        $pdf->restoreState();
      break;
      case '2':
        // add a grey bar, highlighting the change
        $pdf->transaction('start');
        $ok = 0;
        while (!$ok) {
          $thisPageNum = $pdf->ezPageCount;
          $pdf->saveState();
          $pdf->setColor(0.5, 0.5, 0.5);
          //$pdf->filledRectangle($pdf->ez['leftMargin'],$pdf->y-$pdf->getFontHeight(18)+$pdf->getFontDescender(18),$pdf->ez['pageWidth']-$pdf->ez['leftMargin']-$pdf->ez['rightMargin'],$pdf->getFontHeight(18));
          $pdf->ezText("# " . $tmp2, 18);
          $w = $pdf->getTextWidth(18, "# " . $tmp2);
          $pdf->y = $pdf->y + 15;
          $pdf->ezText($tmp3, 12, ['left' => $w]);
          $pdf->restoreState();
          if ($pdf->ezPageCount == $thisPageNum) {
            $pdf->transaction('commit');
            $ok = 1;
          } else {
            // then we have moved onto a new page, bad bad, as the background colour will be on the old one
            $pdf->transaction('rewind');
            $pdf->ezNewPage();
          }
        }
      break;
      case '3':
        $pdf->saveState();
        $pdf->setColor(0.5, 0.5, 0.5);
        $pdf->ezText("" . $tmp2, 12, ['justification' => 'left']);
        $pdf->restoreState();
      break;
    }
  } else {
    // then this is just text
    // the ezpdf function will take care of all of the wrapping etc.
    $pdf->ezText($line, $size, $textOptions);
  }
}

$pdf->ezStopPageNumbers(1, 1);

// now add the table of contents, including internal links
$pdf->ezInsertMode(1, 1, 'after');
$pdf->ezNewPage();

$pdf->saveState();
$pdf->setColor(0.5, 0.5, 0.5);
$pdf->ezText($text['pdf'][14] . "\n", 26, ['justification' => 'centre']);
$xpos = 520;
$contents = $pdf->reportContents;
foreach ($contents as $k => $v) {
  switch ($v[2]) {
    case '1':
      $y = $pdf->ezText('<c:ilink:toc' . $k . '>' . $v[0] . '</c:ilink><C:dots:1' . $v[1] . '>', 16, ['aright' => $xpos]);
    break;
    case '2':
      $pdf->ezText('<c:ilink:toc' . $k . '>' . $v[0] . '</c:ilink><C:dots:2' . $v[1] . '>', 12, ['left' => 50, 'aright' => $xpos]);
    break;
  }
}
$pdf->restoreState();

if (isset($_GET['d']) && $_GET['d']) {
  echo "<pre>";
  echo $pdf->ezOutput(true);
  echo "</pre>";
} else {
  $pdf->ezStream(['Content-Disposition' => 'readme.pdf']);
}

$end = microtime(true) - $start;
error_log($end);
