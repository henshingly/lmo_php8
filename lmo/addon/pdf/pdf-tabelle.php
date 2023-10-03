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
$Total_Width=595.28;
$Total_Height=841.89;

//$empty='';
$endSeason='';

$error=FALSE;
$protectRows=20;
if ($file <> '') {
  $liga=new liga();
  if ($liga->loadFile(PATH_TO_LMO."/".$dirliga.$file)==TRUE) {
    $ligaName=$liga->name;
    $filename=$ligaName." - ".$text[2]." ".$st;
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
      $width=(int)($Total_Width-2*$Rectangle_Width-2*$Distance_Side_Edge)/100*$table_md_width;
      $tb_width=(int)($Total_Width-2*$Rectangle_Width-2*$Distance_Side_Edge)/100*$table_tb_width;
    } else {
      $pdf->setColor(0,0,0);
      $pdf->addText($Total_Width/2-35,10,10,$pdfhomepage,0, '',0);
      $width=$Total_Width/100*$table_md_width;
      $tb_width=$Total_Width/100*$table_tb_width;
    }
    $pdf->setColor(0,0,0);
    $pdf->addText(8,3,6,PDF_VERSION);
    $pdf->restoreState();
    $pdf->closeObject();
    $pdf->addObject($all,'all');
    $partieOptionsMD=array(
      $text['pdf'][8]  =>  array('justification'=>'center'),
      $text[549]       =>  array('justification'=>'center'),
      $text[41]        =>  array('justification'=>'right'),
      $text['pdf'][6]  =>  array('justification'=>'left'),
      $text['pdf'][9]  =>  array('justification'=>'center'));
    $spTagOptionsMD=array(
      'cols'               =>  $partieOptionsMD,
      'titleFontSize'      =>  $table_md_tfontsize,
      'innerLineThickness' => 0.5,
      'outerLineThickness' => 3,
      'fontSize'           =>  $table_md_fontsize,
      'gridlines'          =>  $table_md_gridlines,
      'width'              =>  $width);
    $pos=1;
    if($st<0) $st=1;
    $akt=        isset($liga->options->keyValues['Actual'])?   $liga->options->keyValues['Actual']:1;
    $st=         $st==0?                                       $akt:$st;
    $favTeamNr=  isset($liga->options->keyValues['favTeam'])?  $liga->options->keyValues['favTeam']:0;
    $table=      $liga->calcTable($st);
    $keys=       array_keys($table[0]);
    $pdfTable=   array();

    $cols=array(
      'pos'                =>  $text['tipp'][205],
      'team'               =>  $text[124],
      'spiele'             =>  $text[63],
      's'                  =>  $text[34],
      'u'                  =>  $text[35],
      'n'                  =>  $text[36],
      'pTor'               =>  "+ ".$text[38],
      'mTor'               =>  "- ".$text[38],
      'dTor'               =>  $text[39],
      'pPkt'               =>  $text[37]);

    $align=array(  //Sets the column width and the alignment in the cells of the League table
      'pos'                =>  array('justification'  =>  'center'),
      'team'               =>  array('justification'  =>  'left'),
      'spiele'             =>  array('justification'  =>  'center'),
      's'                  =>  array('justification'  =>  'center'),
      'u'                  =>  array('justification'  =>  'center'),
      'n'                  =>  array('justification'  =>  'center'),
      'pTor'               =>  array('justification'  =>  'center'),
      'mTor'               =>  array('justification'  =>  'center'),
      'dTor'               =>  array('justification'  =>  'center'),
      'pPkt'               =>  array('justification'  =>  'right'));

    $TableLeagueOptions=array(
      'cols'               =>  $align,
      'titleFontSize'      =>  $table_tb_tfontsize,
      'innerLineThickness' => 0.5,
      'outerLineThickness' => 3,
      'fontSize'           =>  $table_tb_fontsize,
      'gridlines'          =>  $table_tb_gridlines,
      'width'              =>  $tb_width);

    //create Leaguetable
    $pos=1;
    foreach ($table as $tableRow) {
      $pdfTableRow=array();
      foreach ($keys as $key) {
        if ($table_icon==1) {  //show icon in current matchday
          $pdfTableRow[$key]=$key == 'team'?  '<C:showimage:'.HTML_iconPDF($tableRow[$key]->name,'teams').' '.$iconsize_tb.'>'."       ".$tableRow[$key]->name : $tableRow[$key];  //Between $iconsize_tb.'>'." and ".$tableRow[$key]->name Less or more spaces to set the distance between the icon and the team name.
        } else {  //don't show icon in current matchday
          $pdfTableRow[$key]=$key == 'team'?  $tableRow[$key]->name : $tableRow[$key];
        }
      }
      $pdfTableRow['pos']=$pos++;
      $pdfTable[] =$pdfTableRow;
    }  //End Leaguetable

    //Current matchday in array
    $pdfAktuellerSpieltag=array();
    $AKspieltag=$liga->spieltagForNumber($st);
    if ($liga->options->keyValues['enableGameSort'] == "1") {
      //Sorting is active
      $partien = $AKspieltag->getPartien("datum");
    } else {
      $partien = $AKspieltag->getPartien();
    }
    foreach($partien as $partie) {
      if ($matchday_icon==1) {  //with icon in matchday table
        $pdfPartie=array(
          $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
          $text[549]       =>  $partie->zeitString($leer='__:__'),
          $text[41]        =>  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$iconsize_md.'>'."    ",
          $text['pdf'][6]  =>  '<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$iconsize_md.'>'."       ".$partie->gast->name,  //Between $iconsize_md.'>'." and ".$partie->gast->name. Less or more spaces to set the distance between the icon and the team name.
          $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
      } else {  //without icon in matchday table
        $pdfPartie=array(
          $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
          $text[549]       =>  $partie->zeitString($leer='__:__'),
          $text[41]        =>  $partie->heim->name,
          $text['pdf'][6]  =>  $partie->gast->name,
          $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
      }
      $pdfAktuellerSpieltag[]=$pdfPartie;
    }  //End current matchday

    //Next matchday in array
    $pdfSpieltag=array();
    $pdfPartie=array();
    $spieltag=$liga->spieltagForNumber($st+1);
    if ($liga->options->keyValues['enableGameSort'] == "1") {
      //Sorting is active
      $partien = $spieltag->getPartien("datum");
    } else {
      $partien = $spieltag->getPartien();
    }
    if ($spieltag!=$AKspieltag) {
      foreach($partien as $partie) {
        if ($nmatchday_icon==1) {  //with icon in next matchday table
          $pdfPartie=array(
            $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
            $text[549]       =>  $partie->zeitString($leer='__:__'),
            $text[41]        =>  $partie->heim->name." ".'<C:showimage:'.HTML_iconPDF($partie->heim->name,'teams').' '.$iconsize_md.'>'."    ",
            $text['pdf'][6]  =>  '<C:showimage:'.HTML_iconPDF($partie->gast->name,'teams').' '.$iconsize_md.'>'."       ".$partie->gast->name, //Between $iconsize_md.'>'." and ".$partie->gast->name. Less or more spaces to set the distance between the icon and the team name.
            $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
        } else {                   //without icon in next matchday table
          $pdfPartie=array(
            $text['pdf'][8]  =>  $partie->datumString($leer='__.__.____'),
            $text[549]       =>  $partie->zeitString($leer='__:__'),
            $text[41]        =>  $partie->heim->name,
            $text['pdf'][6]  =>  $partie->gast->name,
            $text['pdf'][9]  =>  $partie->hToreString()." : ".$partie->gToreString());
        }
        $pdfSpieltag[]=$pdfPartie;
      }
    } else {  //Season ended: print "Season ended"
      $endSeason=$text[568];
    }  //End next matchday in array

  } else {
    $error=TRUE;
    $message= getMessage("<b><u>".$text['pdf'][13].":</u></b> ".$file,True);
    $ligaName= $message;
  }
}
if (!$error) {
    if ($lmo_show_gameday<>0) {
      $pdf->ezTable($pdfAktuellerSpieltag,"",$st.". ".$text[2],$spTagOptionsMD);             //The current or selected match day
      $pdf->ezText('', 8);  //Distance to the next table by empty text line
    }
    if ($lmo_show_table<>0) {
      $pdf->ezTable($pdfTable,$cols,$text[16]." - ".$st.". ".$text[2],$TableLeagueOptions);  //Show table league
      $pdf->ezText($text[576], 8, array('justification' => 'center'));
      $pdf->ezText('', 8); //Distance to the next table by empty text line
    }
    if ($lmo_show_nextgameday<>0) {
      $pdf->ezTable($pdfSpieltag,"",$spieltag->nr.". ".$text[2],$spTagOptionsMD);            //Show next matchday
      $pdf->ezText($endSeason, 10, array('justification' => 'center'));                      //If there is no next matchday, print "Season ended"
    }
  $filename=str_replace(" ", "", $filename);  //creating filename
  $pdf->ezStream(['Content-Disposition'=>$filename.'.pdf']);
  $end = microtime(true) - $start;
  error_log("Page Building pdf-tabelle.php: ".round($end, 2)." seconds");
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
