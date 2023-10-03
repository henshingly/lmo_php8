<?php
/** Pdf Addon for LMO 4 für Spielplan
  *
  * (c) by Torsten Hofmann V 2.0
  *
  * PDF CLASS
  * http://ros.co.nz/pdf - http://www.sourceforge.net/projects/pdf-php
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
  * Bei Problemen des Style's siehe Kommentare unten
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

$pdfround="";
$Team_Name="";

$error=FALSE;
$protectRows=10;
if ($file <> '') {
  $liga=new liga();
  if ($liga->loadFile(PATH_TO_LMO."/".$dirliga.$file)==TRUE) {
    $ligaName=$liga->name;
    $filename=$text['pdf'][104];
    //$pages=count($pdf->ezPages);
    //A4 is 210 x 297 mm or 595.28 x 841.89 points
    if ($pdfformat==1) {  // portrait format
      $Total_Width="595.28";
      $Total_Height="841.89";
      $pdf_imagesize=$iconsize_tp_port;
      $pdf=new CezTableImage('a4');
    } else {  //  landscape format
      $Total_Width="841.89";
      $Total_Height="595.28";
      $pdf_imagesize=$iconsize_tp_land;
      $pdf=new CezTableImage('a4', 'landscape');
    }
    $all=$pdf->openObject();
    $pdf->tempPath=PATH_TO_LMO.'/output';
    $start = microtime(true);
    $pdf->saveState();
    $pdf->openHere('Fit');
    if ($lmo_show_pdfimg==1) {
  $pdf->ezImage($pdfimg, -35, 100, 'none', 'center');
    }
    $pdf->ezSetMargins(50,30,50,50);  //(top,bottom,left,right)
    $pdf->selectFont(PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/'.$pdf_PDF_font);
    $pdf->addText($Total_Width-170,$Total_Height-15,10,strftime ("%d.%m.%Y - %H:%M")." ".$text['pdf'][103]);
    $pdf->addText(50,$Total_Height-25,15,"$liga->name");
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
    $pdf->addText(8,3,6,TEAM_PLAN);
    $pdf->addText($Total_Width-50,3,6,VERSlONA);
    $pdf->restoreState();
    $pdf->closeObject();
    $pdf->addObject($all,'all');

    if ($selteam  < 1) {
      $pdf->ezText($text['24'],16,array('justification'=>'centre'));
    } elseif ($selteam >= 1) {
      $sortedGames=$liga->gamesSorted($pdfanzeige);
      foreach ($sortedGames as $game) {
        $partie=&$game['partie'];
        $spieltag=&$game['spieltag'];
        $pdfSpieltag=array();
        $runde=isset($liga->options->keyValues['Rounds'])?$liga->options->keyValues['Rounds']:0;
        if ($pdfserie==1 and $game['spieltag']->nr < 2) {
          $pdfround=$text['pdf'][105];
        } else {
          $dummy="";
        }
        if ($partie->heim->nr==$selteam) {
          $Team_Name=$partie->heim->name;
          if ($pdfserie==1 and $game['spieltag']->nr === $runde/2+1) {
            $pdf->ezNewPage();
            $pdfround=$text['pdf'][106];
          } else {
            $dummy="";
          }
          $Datum=$partie->datumString($leer='__.__.____');
          $Zeit=$partie->zeitString($leer='__:__');
          if ($pdfteamfett==1 ) {
            if ($pdfteamnamen==2) {
              if ($teamplanicon==1) {
                $Heim  =  "<b>".$partie->heim->mittel."</b> ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->mittel;
              } else {
                $Heim  =  "<b>".$partie->heim->mittel."</b>";
                $Gast  =  "-  ".$partie->gast->mittel;
              }
            } elseif ($pdfteamnamen==1) {
              if ($teamplanicon==1) {
                $Heim  =  "<b>".$partie->heim->kurz."</b> ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->kurz;
              } else {
                $Heim  =  "<b>".$partie->heim->kurz."</b>";
                $Gast  =  "-  ".$partie->gast->kurz;
              }
            } else {
              if ($teamplanicon==1) {
                $Heim  =  "<b>".$partie->heim->name."</b> ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->name;
              } else {
                $Heim  =  "<b>".$partie->heim->name."</b>";
                $Gast  =  "-  ".$partie->gast->name;
              }
            }
          } else {
            if ($pdfteamnamen==2) {
              if ($teamplanicon==1) {
                $Heim  =  $partie->heim->mittel." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->mittel;
              } else {
                $Heim  =  $partie->heim->mittel;
                $Gast  =  "-  ".$partie->gast->mittel;
              }
            } elseif ($pdfteamnamen==1) {
              if ($teamplanicon==1) {
                $Heim  =  $partie->heim->kurz." ".'<C:showimage:'.HTML_iconPDF($partie->heim->kurz,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->kurz,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->kurz;
              } else {
                $Heim  =  $partie->heim->kurz;
                $Gast  =  "-  ".$partie->gast->kurz;
              }
            } else {
              if ($teamplanicon==1) {
                $Heim  =  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->name;
              } else {
                $Heim  =  $partie->heim->name;
                $Gast  =  "-  ".$partie->gast->name;
              }
            }
          }
          $Result=$partie->hToreString()." : ".$partie->gToreString();
          $pdfSpieltag=array(
            array(
              'Datum'   =>  $Datum,
              'Zeit'    =>  $Zeit,
              'Heim'    =>  $Heim,
              'Gast'    =>  $Gast,
              'Result'  =>  $Result));
        } else {
          if ($partie->gast->nr ==$selteam) {
            $Team_Name=$partie->gast->name;
            if ($pdfserie==1 and $game['spieltag']->nr === $runde/2+1) {
              $pdf->ezNewPage();
              $pdfround=$text['pdf'][106];
            } else {
              $dummy=" ";
            }
            $Datum=$partie->datumString($leer='__.__.____');
            $Zeit=$partie->zeitString($leer='__:__');
            if ($pdfteamfett==1) {
              if ($pdfteamnamen==2) {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->mittel." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  <b>".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->mittel."</b>";
                } else {
                  $Heim  =  $partie->heim->mittel;
                  $Gast  =  "-  <b>".$partie->gast->mittel."</b>";
                }
              } elseif ($pdfteamnamen==1) {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->kurz." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  <b>".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->kurz."</b>";
                } else {
                  $Heim  =  $partie->heim->kurz;
                  $Gast  =  "-  <b>".$partie->gast->kurz."</b>";
                }
              } else {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  <b>".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->name."</b>";
                } else {
                  $Heim  =  $partie->heim->name;
                  $Gast  =  "-  <b>".$partie->gast->name."</b>";
                }
              }
            } else {
              if ($pdfteamnamen==2) {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->mittel." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->mittel;
                } else {
                  $Heim  =  $partie->heim->mittel;
                  $Gast  =  "-  ".$partie->gast->mittel;
                }
              } elseif ($pdfteamnamen==1) {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->kurz." ".'<C:showimage:'.HTML_iconPDF($partie->heim->kurz,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->kurz,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->kurz;
                } else {
                  $Heim  =  $partie->heim->kurz;
                  $Gast  =  "-  ".$partie->gast->kurz;
                }
              } else {
                if ($teamplanicon==1) {
                  $Heim  =  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$pdf_imagesize.'>'."  ";
                  $Gast  =  "-  ".'<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$pdf_imagesize.'>'."     ".$partie->gast->name;
                } else {
                  $Heim  =  $partie->heim->name;
                  $Gast  =  "-  ".$partie->gast->name;
                }
              }
            }
            $Result=$partie->hToreString()." : ".$partie->gToreString();
            $pdfSpieltag= array(
              array(
                'Datum'   =>  $Datum,
                'Zeit'    =>  $Zeit,
                'Heim'    =>  $Heim,
                'Gast'    =>  $Gast,
                'Result'  =>  $Result));
          }
        }
        if ($pdfserie==0) $pdfround=$text['pdf'][104];
/**
  * Start Output
  * $pdfformat==1 is portrait format. $pdfformat==0 is landscape format
  * fontSize and the other values are controlled in the admin menu
**/
        if ($pdfformat==1) {
          $pdf->addText($Total_Width/2-80,$Total_Height-45,$tp_port_tfontsize,$pdfround." - ".$Team_Name);
          $pdf->ezTable($pdfSpieltag,'','',array(
            'xPos'          =>  'center',
            'fontSize'      =>  $tp_port_fontsize,
            'showHeadings'  =>  0,
            'shaded'        =>  0,
            'showLines'     =>  0,
            'cols'          =>  array(
              'Datum'   =>  array('width'=>$pdf_tp_port_Datum,'justification'=>'left'),
              'Zeit'    =>  array('width'=>$pdf_tp_port_Zeit,'justification'=>'center'),
              'Heim'    =>  array('width'=>$pdf_tp_port_Team,'justification'=>'right'),
              'Gast'    =>  array('width'=>$pdf_tp_port_Team),
              'Result'  =>  array('width'=>$pdf_tp_port_Result,'justification'=>'center'))));
        } else {
          $pdf->addText(($Total_Width/2)-100,$Total_Height-45,$tp_land_tfontsize,$pdfround." - ".$Team_Name);
          $pdf->ezTable($pdfSpieltag,'','',array(
            'xPos'          =>  'center',
            'fontSize'      =>  $tp_land_fontsize,
            'showHeadings'  =>  0,
            'shaded'        =>  0,
            'showLines'     =>  0,
            'cols'          =>  array(
              'Datum'   =>  array('width'=>$pdf_tp_land_Datum,'justification'=>'left'),
              'Zeit'    =>  array('width'=>$pdf_tp_land_Zeit,'justification'=>'center'),
              'Heim'    =>  array('width'=>$pdf_tp_land_Team,'justification'=>'right'),
              'Gast'    =>  array('width'=>$pdf_tp_land_Team),
              'Result'  =>  array('width'=>$pdf_tp_land_Result,'justification'=>'center'))));
        }
      }
    }
  } else {
    $error=TRUE;
    $message= getMessage("<b><u>".$text['pdf'][13].":</u></b> ".$file,True);
    $ligaName= $message;
  }
}

if (!$error) {
  $Team_Name=str_replace(" ", "", $Team_Name);
  $pdf->ezStream(['Content-Disposition'=>$filename."_".$Team_Name.'.pdf']);
  $end = microtime(true) - $start;
  error_log("Page Building pdf-teamplan.php: ".round($end, 2)." seconds");
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
