<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_LMO."/lmo-admintest.php");
if (($_SESSION['lmouserok']==2)||($_SESSION['lmouserok']==1)) {
  if ($file!="") {
    if (substr($file,-4)==".l98") {
      if ($einsavehtml==1) {
        if (file_exists("lmo-savehtml.php")) {
          include(PATH_TO_LMO."/lmo-savehtml.php");
        }
        if (file_exists("lmo-savehtml1.php")) {
          include(PATH_TO_LMO."/lmo-savehtml1.php");
        }
      }
      if ($einzutore==1 || $einzutoretab==1 || $einzustats==1) {
        if (file_exists("lmo-zustat.php")) {
          include(PATH_TO_LMO."/lmo-zustat.php");
        }
      }
      $datei = fopen(PATH_TO_LMO."/$file","wb");
      
      if ($datei) {
        echo "<font color=\"#008800\">".$text[138]."</font>";
        flock($datei,LOCK_EX);
        fputs($datei,"[Options]\n");
        fputs($datei,"Title=".$text[54]."\n");
        fputs($datei,"Name=".$titel."\n");
        fputs($datei,"Type=".$lmtype."\n");
        fputs($datei,"Teams=".$anzteams."\n");
        if ($lmtype==0) {
          fputs($datei,"Rounds=".$anzst."\n");
          fputs($datei,"Matches=".$anzsp."\n");
        }
        if ($st>0) {
          fputs($datei,"Actual=".$st."\n");
        } else {
          fputs($datei,"Actual=".$stx."\n");
        }
        if ($lmtype==0) {
          fputs($datei,"Kegel=".$kegel."\n");
          fputs($datei,"HandS=".$hands."\n");
          fputs($datei,"PointsForWin=".$pns."\n");
          fputs($datei,"PointsForDraw=".$pnu."\n");
          fputs($datei,"PointsForLost=".$pnn."\n");
          fputs($datei,"Spez=".$spez."\n");
          fputs($datei,"HideDraw=".$hidr."\n");
          fputs($datei,"OnRun=".$onrun."\n");
          if ($spez==1) {
            fputs($datei,"XtraS=".$pxs."\n");
            fputs($datei,"XtraU=".$pxu."\n");
            fputs($datei,"XtraV=".$pxn."\n");
            fputs($datei,"SpezS=".$pps."\n");
            fputs($datei,"SpezU=".$ppu."\n");
            fputs($datei,"SpezV=".$ppn."\n");
          }
          fputs($datei,"MinusPoints=".$minus."\n");
          fputs($datei,"Direct=".$direkt."\n");
          fputs($datei,"Champ=".$champ."\n");
          fputs($datei,"CL=".$anzcl."\n");
          fputs($datei,"CK=".$anzck."\n");
          fputs($datei,"UC=".$anzuc."\n");
          fputs($datei,"AR=".$anzar."\n");
          fputs($datei,"AB=".$anzab."\n");
          if (isset($namepkt)) {
            fputs($datei,"namePkt=".$namepkt."\n");
          }
          if (isset($nametor)) {
            fputs($datei,"nameTor=".$nametor."\n");
          }
        } else {
          fputs($datei,"KlFin=".$klfin."\n");
        }
        fputs($datei,"DatC=".$datc."\n");
        fputs($datei,"DatS=".$dats."\n");
        fputs($datei,"DatM=".$datm."\n");
        fputs($datei,"DatF=".$datf."\n");
        fputs($datei,"urlT=".$urlt."\n");
        fputs($datei,"urlB=".$urlb."\n");
        fputs($datei,"Plan=".$plan."\n");
        fputs($datei,"Sprachauswahl=".$sprachauswahl."\n");
        fputs($datei,"Ergebnis=".$ergebnis."\n");
        fputs($datei,"mittore=".$mittore."\n");
        fputs($datei,"favTeam=".$favteam."\n");
        fputs($datei,"selTeam=".$selteam."\n");
        fputs($datei,"ticker=".$nticker."\n");
        
        if ($lmtype==0) {
          fputs($datei,"Graph=".$kurve."\n");
          fputs($datei,"Kreuz=".$kreuz."\n");
          fputs($datei,"Tabelle=".$tabelle."\n");
          fputs($datei,"Ligastats=".$ligastats."\n");
          fputs($datei,"kurve1=".$stat1."\n");
          fputs($datei,"kurve2=".$stat2."\n");
        }
        if ($nticker==1) {
          fputs($datei,"\n[News]\n");
          fputs($datei,"NC=".count($nlines)."\n");
          for ($i=0; $i<count($nlines); $i++) {
            fputs($datei,"N".$i."=".$nlines[$i]."\n");
          }
        }
        fputs($datei,"\n[Teams]\n");
        for ($i=1; $i<=$anzteams; $i++) {
          fputs($datei,$i."=".$teams[$i]."\n");
        }
        fputs($datei,"\n[Teamk]\n");
        for ($i=1; $i<=$anzteams; $i++) {
          fputs($datei,$i."=".$teamk[$i]."\n");
        }
        for ($i=1; $i<=$anzteams; $i++) {
          fputs($datei,"\n[Team".$i."]\n");
          if ($lmtype==0) {
            fputs($datei,"SP=".$strafp[$i]."\n");
            if ($minus==2) {
              fputs($datei,"SM=".$strafm[$i]."\n");
            }
          }
          fputs($datei,"URL=".$teamu[$i]."\n");
          fputs($datei,"NOT=".$teamn[$i]."\n");
        }
        if ($lmtype!=0) {
          $anzsp=$anzteams;
        }
        for ($i=1; $i<=$anzst; $i++) {
          fputs($datei,"\n[Round".$i."]\n");
          if ($hands==1) {
            fputs($datei,"HS=".$handp[$i-1]."\n");
          }
          fputs($datei,"D1=".$datum1[$i-1]."\n");
          fputs($datei,"D2=".$datum2[$i-1]."\n");
          if ($lmtype!=0) {
            fputs($datei,"MO=".$modus[$i-1]."\n");
            $anzsp=$anzsp/2;
            if (($klfin==1) && ($i==$anzst)) {
              $anzsp=$anzsp+1;
            }
          }
          for ($j=1; $j<=$anzsp; $j++) {
            if (!isset($msieg[$i-1][$j-1])) {
              $msieg[$i-1][$j-1]=0;
            }
            fputs($datei,"TA".$j."=".$teama[$i-1][$j-1]."\n");
            fputs($datei,"TB".$j."=".$teamb[$i-1][$j-1]."\n");
            if ($lmtype==0) {
              if ($goala[$i-1][$j-1]=="_") {
                fputs($datei,"GA".$j."=-1\n");
              } else if ($msieg[$i-1][$j-1]==1) {
                fputs($datei,"GA".$j."=-2\n");
              } else {
                fputs($datei,"GA".$j."=".$goala[$i-1][$j-1]."\n");
              }
              if ($goalb[$i-1][$j-1]=="_") {
                fputs($datei,"GB".$j."=-1\n");
              } else if ($msieg[$i-1][$j-1]==2) {
                fputs($datei,"GB".$j."=-2\n");
              } else {
                fputs($datei,"GB".$j."=".$goalb[$i-1][$j-1]."\n");
              }
              if ($msieg[$i-1][$j-1]==3) {
                fputs($datei,"ET".$j."=3\n");
              }
              if ($spez==1) {
                if ($mspez[$i-1][$j-1]=="_") {
                  fputs($datei,"SP".$j."=0\n");
                } else if ($mspez[$i-1][$j-1]==$text[0]) {
                  fputs($datei,"SP".$j."=2\n");
                } else if ($mspez[$i-1][$j-1]==$text[1]) {
                  fputs($datei,"SP".$j."=1\n");
                }
              }
              fputs($datei,"NT".$j."=".$mnote[$i-1][$j-1]."\n");
              fputs($datei,"BE".$j."=".$mberi[$i-1][$j-1]."\n");
              fputs($datei,"TI".$j."=".$mtipp[$i-1][$j-1]."\n");
              fputs($datei,"AT".$j."=".$mterm[$i-1][$j-1]."\n");
            } else {
              for ($n=1; $n<=$modus[$i-1]; $n++) {
                if ($goala[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"GA".$j.$n."=-1\n");
                } else {
                  fputs($datei,"GA".$j.$n."=".$goala[$i-1][$j-1][$n-1]."\n");
                }
                if ($goalb[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"GB".$j.$n."=-1\n");
                } else {
                  fputs($datei,"GB".$j.$n."=".$goalb[$i-1][$j-1][$n-1]."\n");
                }
                if ($mspez[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"SP".$j.$n."=0\n");
                } else if ($mspez[$i-1][$j-1][$n-1]==$text[0]) {
                  fputs($datei,"SP".$j.$n."=2\n");
                } else if ($mspez[$i-1][$j-1][$n-1]==$text[1]) {
                  fputs($datei,"SP".$j.$n."=1\n");
                }
                fputs($datei,"NT".$j.$n."=".$mnote[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"BE".$j.$n."=".$mberi[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"TI".$j.$n."=".$mtipp[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"AT".$j.$n."=".$mterm[$i-1][$j-1][$n-1]."\n");
              }
            }
          }
        }
        flock($datei,LOCK_UN);
        fclose($datei);
      } else {
        echo "<font color=\"#ff0000\">".$text[283]."</font>";
      }
      clearstatcache();
    }
  }
}  

?>