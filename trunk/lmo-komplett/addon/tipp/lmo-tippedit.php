<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
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
//require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if ($file!="") {
  $tipp_showzus=0;
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  if (!isset($nlines)) {
    $nlines=array();
  }
  
  function gewinn($gsp,$gmod,$m1,$m2){
    $erg=0;
    if ($gmod==1) {
      if ($m1[0]>$m2[0]) {
        $erg=1;
      } else if ($m1[0]<$m2[0]) {
        $erg=2;
      }
    } else if ($gmod==2) {
      if (($m1[0]+$m1[1])>($m2[0]+$m2[1])) {
        $erg=1;
      } else if (($m1[0]+$m1[1])<($m2[0]+$m2[1])) {
        $erg=2;
      } else {
        if ($m2[0]>$m1[1]) {
          $erg=1;
        } else if ($m2[0]<$m1[1]) {
          $erg=2;
        }
      }
    } else {
      $erg1=0;
      $erg2=0;
      for ($k=0; $k<$gmod; $k++) {
        if (($m1[$k]!="_") && ($m2[$k]!="_")) {
          if ($m1[$k]>$m2[$k]) {
            $erg1++;
          } else if ($m1[$k]<$m2[$k]) {
            $erg2++;
          }
        }
      }
      if ($erg1>($gmod/2)) {
        $erg=1;
      } else if ($erg2>($gmod/2)) {
        $erg=2;
      }
    }
    return $erg;
  }
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfile.php");
  
  if (!isset($save)) {
    $save=0;
  }
  if ($save==1) {
    if ($tipp_jokertipp==1) {
      $jksp=trim($_POST["xjokerspiel"]);
    }
    for ($i=0; $i<$anzsp; $i++) {
      if ($lmtype==0) {
        $plus=0;
        $btip=tippaenderbar($mterm[$st-1][$i],$datum1[$st-1],$datum2[$st-1]);
        if ($btip==true) {
          if ($tipp_tippmodus==1) {
            $goaltippa[$i]=trim($_POST["xtippa".$i]);
            if ($goaltippa[$i]=="" || $goaltippa[$i]<0) {
              $goaltippa[$i]=-1;
            } else if ($goaltippa[$i]=="_") {
              $goaltippa[$i]=-1;
            } else {
              $goaltippa[$i]=intval(trim($goaltippa[$i]));
              if ($goaltippa[$i]=="") {
                $goaltippa[$i]="0";
              }
            }
            $goaltippb[$i]=trim($_POST["xtippb".$i]);
            if ($goaltippb[$i]=="" || $goaltippb[$i]<0) {
              $goaltippb[$i]=-1;
            } else if ($goaltippb[$i]=="_") {
              $goaltippb[$i]=-1;
            } else {
              $goaltippb[$i]=intval(trim($goaltippb[$i]));
              if ($goaltippb[$i]=="") {
                $goaltippb[$i]="0";
              }
            }
          } else if ($tipp_tippmodus==0) {
            if (!isset($_POST["xtipp".$i])) {
              $_POST["xtipp".$i]=0;
            }
            if ($_POST["xtipp".$i]==1) {
              $goaltippa[$i]="1";
              $goaltippb[$i]="0";
            } else if ($_POST["xtipp".$i]==2) {
              $goaltippa[$i]="0";
              $goaltippb[$i]="1";
            } else if ($_POST["xtipp".$i]==3) {
              $goaltippa[$i]="0";
              $goaltippb[$i]="0";
            } else {
              $goaltippa[$i]="-1";
              $goaltippb[$i]="-1";
            }
          }
        }
      } else {
        for ($n=0; $n<$modus[$st-1]; $n++) {
          $plus=0;
          $btip=tippaenderbar($mterm[$st-1][$i][$n],$datum1[$st-1],$datum2[$st-1]);
          if ($btip==true) {
            if ($tipp_tippmodus==1) {
              $goaltippa[$i][$n]=trim($_POST["xtippa".$i.$n]);
              if ($goaltippa[$i][$n]=="" || $goaltippa[$i][$n]<0) {
                $goaltippa[$i][$n]=-1;
              } else if ($goaltippa[$i][$n]=="_") {
                $goaltippa[$i][$n]=-1;
              } else {
                $goaltippa[$i][$n]=intval(trim($goaltippa[$i][$n]));
                if ($goaltippa[$i][$n]=="") {
                  $goaltippa[$i][$n]="0";
                }
              }
              $goaltippb[$i][$n]=trim($_POST["xtippb".$i.$n]);
              if ($goaltippb[$i][$n]=="" || $goaltippb[$i][$n]<0) {
                $goaltippb[$i][$n]=-1;
              } else if ($goaltippb[$i][$n]=="_") {
                $goaltippb[$i][$n]=-1;
              } else {
                $goaltippb[$i][$n]=intval(trim($goaltippb[$i][$n]));
                if ($goaltippb[$i][$n]=="") {
                  $goaltippb[$i][$n]="0";
                }
              }
            } else if ($tipp_tippmodus==0) {
              if (!isset($_POST["xtipp".$i.$n])) {
                $_POST["xtipp".$i.$n]=0;
              }
              if ($_POST["xtipp".$i.$n]==1) {
                $goaltippa[$i][$n]="1";
                $goaltippb[$i][$n]="0";
              } else if ($_POST["xtipp".$i.$n]==2) {
                $goaltippa[$i][$n]="0";
                $goaltippb[$i][$n]="1";
              } else if ($_POST["xtipp".$i.$n]==3) {
                $goaltippa[$i][$n]="0";
                $goaltippb[$i][$n]="0";
              } else {
                $goaltippa[$i][$n]="-1";
                $goaltippb[$i][$n]="-1";
              }
            }
          }
        }
      }
    }
    if ($tipp_jokertipp==1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippjokeranticheat.php");
    }
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php");
    if ($tipp_akteinsicht==1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveeinsicht1.php");
    }
  }
  $addr=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite=17;
  if ($spez==1) {
    $breite+=2;
  }
  if ($tipp_showtendenzabs==1) {
    $breite+=2;
  }
  if ($tipp_showtendenzpro==1) {
    $breite+=2;
  }
  if ($tipp_showdurchschntipp==1) {
    $breite+=2;
  }
  if ($datm==1) {
    $breite++;
  }
  if (!isset($hidr)) {
    $hidr=0;
  }
  //  if($lmtype==1 && $modus[$st-1]!=2){$hidr=1;} // bei KO-Turnier außer bei Hin- und Rückspiel keinen Remistipp zulassen
  if ($hidr==1) {
    $breite--;
  }
  if ($tipp_tippmodus==0) {
    $breite-=2;
  }
  $savebutton=0;
  if ($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1 || ($tipp_showdurchschntipp==1 && $tipp_tippmodus==1)) {
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");
  }
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="lmost1"><?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></td>
  </tr>
  <tr>
    <td class="lmost4" align="center"><? if($tipp_tippBis>0){echo $text['tipp'][87]." ".$tipp_tippBis." ".$text['tipp'][88];} ?></td>
  </tr>
  <tr>
    <td align="center">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="right" valign="top" class="lmost1" colspan="3" rowspan="4"><?
  if ($lmtype==1) {
    echo $text[370];
  } else {
    echo $text[2];
  }
  echo ":";
  echo "&nbsp;</td>";
  for ($i=1; $i<=$anzst; $i++) {
    if ($lmtype==1) {
      if ($i==$anzst) {
        $j=$text[364];
        $k=$text[365];
      } else if ($i==$anzst-1) {
        $j=$text[362];
        $k=$text[363];
      } else if ($i==$anzst-2) {
        $j=$text[360];
        $k=$text[361];
      } else if ($i==$anzst-3) {
        $j=$text[358];
        $k=$text[359];
      } else {
        $j=$i;
        $k=$text[366];
      }
    } else {
      $j=$i;
      $k=$text[9];
    }
    echo "<td align=\"right\" ";
    if ($i<>$st) {
      echo "class=\"lmost0\"><a href=\"".$addr.$i."\" title=\"".$k."\">".$j."</a>";
    } else {
      echo "class=\"lmost1\">".$j;
    }
    echo "&nbsp;</td>";
    if (($anzst>49) && (($anzst%4)==0)) {
      if (($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)) {
        echo "</tr><tr>";
      }
    } else if (($anzst>38) && (($anzst%3)==0)) {
      if (($i==$anzst/3) || ($i==$anzst/3*2)) {
        echo "</tr><tr>";
      }
    } else if (($anzst>25) && (($anzst%2)==0)) {
      if ($i==$anzst/2) {
        echo "</tr><tr>";
      }
    }
  }?>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
    <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="action" value="tipp">
      <input type="hidden" name="todo" value="edit">
      <input type="hidden" name="save" value="1">
      <input type="hidden" name="file" value="<?=$file; ?>">
      <input type="hidden" name="st" value="<?=$st; ?>">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr><?
  if ($datum1[$st-1]!="") {
    $datum = split("[.]",$datum1[$st-1]);
    $dum1=$me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum1="";
  }
  if ($datum2[$st-1]!="") {
    $datum = split("[.]",$datum2[$st-1]);
    $dum2=$me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum2="";
  }
  if ($lmtype==1) {
    if ($st==$anzst) {
      $j=$text[374];
    } else if ($st==$anzst-1) {
      $j=$text[373];
    } else if ($st==$anzst-2) {
      $j=$text[372];
    } else if ($st==$anzst-3) {
      $j=$text[371];
    } else {
      $j=$st.". ".$text[370];
    }
  }?>
          <td class="lmost4" colspan="<?=$datm+5; ?>">
            <nobr>
<?if ($lmtype==0) {
    echo $st.". ".$text[2];
  } else {
    echo $j;
  }
  if ($dats==1) {
    if ($datum1[$st-1]!="") {
      echo " ".$text[3]." ".$datum1[$st-1];
    }
    if ($datum2[$st-1]!="") {
      echo " ".$text[4]." ".$datum2[$st-1];
    }
  }?>
            </nobr>
          </td><? 
  if($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1){ ?>
          <td class="lmost4" align="center" colspan="<? if($tipp_showtendenzabs==1 && $tipp_showtendenzpro==1){echo "4";}else{echo "2";} ?>">
            <nobr><?=$text['tipp'][188]; /* Tipptendenz absolut */?></nobr>
          </td>
<?}
  if($tipp_tippmodus==1){  
    if($tipp_showdurchschntipp==1){ ?>
          <td class="lmost4" align="center" colspan="2">
            <nobr><?="Ø-".$text['tipp'][30]; /* DurchschnittsTipp*/ ?></nobr>
          </td><?  
    } ?>
          <td class="lmost4" align="center" colspan="<? if($tipp_pfeiltipp==1){echo "5";}else{echo "3";} ?>">
            <nobr><?=$text['tipp'][209]; /* Dein Tipp */?></nobr>
          </td><?
  }
  if($tipp_tippmodus==0){ ?>
          <td class="lmost4" align="center">1</td><?  
    if($hidr==0){ ?>
          <td class="lmost4" align="center">0</td><?  
    }?>
          <td class="lmost4" align="center">2</td><?
  }
  if ($tipp_jokertipp==1){ ?>
          <td class="lmost4" align="center">
            <nobr><?=$text['tipp'][289]; ?></nobr>
          </td><?
  } ?>
          <td class="lmost4" colspan="3" align="center">
            <nobr><?=$text['tipp'][31]; /* Ergebnis */?></nobr>
          </td><?
  if($spez==1){?>
          <td class="lmost4" colspan="2">&nbsp;</td><?
  }?>
          <td class="lmost4" colspan="2" align="right">
            <nobr><?=$text[37]; /* PP */?></nobr>
          </td>
          <td class="lmost4">&nbsp;</td>
        </tr><?
  if ($lmtype!=0) {
    $anzsp=$anzteams;
    for ($i=0; $i<$st; $i++) {
      $anzsp=$anzsp/2;
    }
    if (($klfin==1) && ($st==$anzst)) {
      $anzsp=$anzsp+1;
    }
  }
  $punktespieltag=0;
  $nw=0;
  $tipp_jokertippaktiv=true;
  $plus=1;
  if ($lmtype==0) {
    $btip = array_pad($array,$anzsp+1,"false");
    for ($i=0; $i<$anzsp; $i++) {
      $btip[$i]=tippaenderbar($mterm[$st-1][$i],$datum1[$st-1],$datum2[$st-1]);
      if ($tipp_jokertipp==1 && $jksp==($i+1) && $btip[$i]==false) {
        $tipp_jokertippaktiv=false;
      }
    }
  } else {
    $btip = array_pad($array,$anzsp+1,"");
    for ($i=0; $i<$anzsp; $i++) {
      $btip[$i] = array_pad(array("false"),$modus[$st-1]+1,"false");
      for ($n=0; $n<$modus[$st-1]; $n++) {
        $btip[$i][$n]=tippaenderbar($mterm[$st-1][$i][$n],$datum1[$st-1],$datum2[$st-1]);
        if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1) && $btip[$i][$n]==false) {
          $tipp_jokertippaktiv=false;
        }
      }
    }
  }
  
  for ($i=0; $i<$anzsp; $i++) {
    if ($teama[$st-1][$i]>0 && $teamb[$st-1][$i]>0) {
      if ($lmtype==0) {?>
        <tr><?
        if ($tipp_einsichterst==2) {
          if ($goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_") {
            $btip1=false;
          } else {
            $btip1=true;
          }
        } else {
          $btip1=false;
        }
        
        if ($datm==1) {
          if ($mterm[$st-1][$i]>0) {
            $dum1=strftime($datf, $mterm[$st-1][$i]);
          } else {
            $dum1="";
          }?>
          <td class="lmost5"><nobr><?=$dum1; ?></nobr></td><? 
        }?>
          <td class="lmost5" width="2">&nbsp;</td>
          <td class="lmost5" align="right">
            <nobr><?
         if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
           echo "<strong>";
         }
         echo $teams[$teama[$st-1][$i]];
         if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
           echo "</strong>";
         }?>
            </nobr>
          </td>
          <td class="lmost5" align="center" width="10">-</td>
          <td class="lmost5">
            <nobr><?
          if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
            echo "<strong>";
          }
          echo $teams[$teamb[$st-1][$i]];
          if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
            echo "</strong>";
          }
          
          if ($goaltippa[$i]=="_") {
            $goaltippa[$i]="";
          }
          if ($goaltippb[$i]=="_") {
            $goaltippb[$i]="";
          }
          if ($goaltippa[$i]=="-1") {
            $goaltippa[$i]="";
          }
          if ($goaltippb[$i]=="-1") {
            $goaltippb[$i]="";
          }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
          if($tipp_showtendenzabs==1){ ?>
          <td align="center" class="lmost5">
            <nobr><? 
          if ($btip1==false) {
            if (!isset($tendenz1[$i])) {
              $tendenz1[$i]=0;
            }
            if (!isset($tendenz0[$i])) {
              $tendenz0[$i]=0;
            }
            if (!isset($tendenz2[$i])) {
              $tendenz2[$i]=0;
            }
            echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
          }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
        } 
        if($tipp_showtendenzpro==1){ ?>
          <td align="center" class="lmost5">
            <nobr><? 
        if ($btip1==false) {
          if (!isset($anzgetippt[$i])) {
            $anzgetippt[$i]=0;
          }
          if ($anzgetippt[$i]>0) {
            if (!isset($tendenz1[$i])) {
              $tendenz1[$i]=0;
            }
            if (!isset($tendenz0[$i])) {
              $tendenz0[$i]=0;
            }
            if (!isset($tendenz2[$i])) {
              $tendenz2[$i]=0;
            }
            echo number_format(($tendenz1[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz0[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz2[$i]/$anzgetippt[$i]*100),0,".",",")."%";
          } else {
            echo "&nbsp;";
          }
        }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
      }
      if ($btip[$i]==true) {
        $savebutton=1;
      }
      if ($tipp_tippmodus==1) {
        if ($tipp_showdurchschntipp==1) {?>
          <td align="center" class="lmost5">
            <nobr><? 
          if ($btip1==false) {
            if (!isset($anzgetippt[$i])) {
              $anzgetippt[$i]=0;
            }
            if ($anzgetippt[$i]>0) {
              if (!isset($toregesa[$i])) {
                $toregesa[$i]=0;
              }
              if (!isset($toregesb[$i])) {
                $toregesb[$i]=0;
              }
              if ($toregesa[$i]<10 && $toregesb[$i]<10) {
                $nachkomma=1;
              } else {
                $nachkomma=0;
              }
              echo number_format(($toregesa[$i]/$anzgetippt[$i]),$nachkomma,".",",").":".number_format(($toregesb[$i]/$anzgetippt[$i]),$nachkomma,".",",");
            } else {
              echo "&nbsp;";
            }
          }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
        }
        if($btip[$i]==true){ ?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][241] ?>">
              <input class="lmoadminein" type="text" name="xtippa<?=$i; ?>" size="4" maxlength="4" value="<?=$goaltippa[$i]; ?>" onKeyDown="lmotorclk('a','<?=$i; ?>',event.keyCode)">
            </acronym>
          </td><? 
          if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i; ?>\',1);" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>a" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i; ?>\',-1);" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>b" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
            </table>
          </td><? 
          }
        }else{
          if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5">&nbsp;</td><? 
          }?>
          <td class="lmost5" align="right"><?=$goaltippa[$i]; ?></td><? 
        }?>
          <td class="lmost5">:</td><? 
        if($btip[$i]==true){ ?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][242] ?>">
              <input class="lmoadminein" type="text" name="xtippb<?=$i; ?>" size="4" maxlength="4" value="<?=$goaltippb[$i]; ?>" onKeyDown="lmotorclk('b','<?=$i; ?>',event.keyCode)">
            </acronym>
          </td><? 
          if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i; ?>\',1);" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>f\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>f\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>f" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i; ?>\',-1);" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>d\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>d\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>d" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
            </table>
          </td><? 
          }
        }else{ ?>
          <td class="lmost5"><?=$goaltippb[$i]; ?></td><? 
          if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5">&nbsp;</td><? 
          }
        }
      } /* ende ($tipp_tippmodus==1) */
      if($tipp_tippmodus==0){ 
    	  $tipp=-1;
        if ($goaltippa[$i]=="" || $goaltippb[$i]=="") {
          $tipp=-1;
        } else if ($goaltippa[$i]>$goaltippb[$i]) {
          $tipp=1;
        } else if ($goaltippa[$i]==$goaltippb[$i]) {
          $tipp=0;
        } else if ($goaltippa[$i]<$goaltippb[$i]) {
          $tipp=2;
        }?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][95] ?>">
              <input type="radio" name="xtipp<?=$i; ?>" value="1" <? if($tipp==1){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
         if($hidr==0){ ?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][96] ?>">
              <input type="radio" name="xtipp<?=$i; ?>" value="3" <? if($tipp==0){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
         }?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][97] ?>">
              <input type="radio" name="xtipp<?=$i; ?>" value="2" <? if($tipp==2){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
          } /* ende ($tipp_tippmodus==0) */
          if ($tipp_jokertipp==1){ ?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][290] ?>">
              <input type="radio" name="xjokerspiel" value="<?=$i+1; ?>" <? if($jksp==$i+1){echo " checked";} if ($btip[$i]==false){echo " disabled";}elseif($tipp_jokertippaktiv==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
          } ?>                                                                                                                   
          <td class="lmost7" align="right"><?=$goala[$st-1][$i]; ?></td>
          <td class="lmost7">:</td>
          <td class="lmost7"><?=$goalb[$st-1][$i]; ?></td><? 
          if($spez==1){ ?>
          <td class="lmost7" width="2">&nbsp;</td>
          <td class="lmost7"><?=$mspez[$st-1][$i]; ?></td><? 
          } ?>
          <td class="lmost5" width="2">&nbsp;</td>
          <td class="lmost5">
            <strong><? 
          if ($tipp_jokertipp==1 && $jksp==$i+1) {
            $jkspfaktor=$tipp_jokertippmulti;
          } else {
            $jkspfaktor=1;
          }
          $punktespiel=-1;
          if ($goaltippa[$i]!="" && $goaltippb[$i]!="" && $goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_") {
            $punktespiel=tipppunkte($goaltippa[$i], $goaltippb[$i], $goala[$st-1][$i], $goalb[$st-1][$i], $msieg[$st-1][$i], $mspez[$st-1][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i]);
          }
          if ($punktespiel==-1) {
            echo "-";
          } else if ($punktespiel==-2) {
            echo $text['tipp'][230];
            $nw=1;
          } else {
            if ($tipp_tippmodus==1) {
              echo $punktespiel;
            } else {
              if ($punktespiel>0) {
                echo "<img src='".URL_TO_IMGDIR."/right.gif' width='16' height='16' border='0' alt='0x263a;'>";
                if ($punktespiel>1) {
                  echo "+".($punktespiel-1);
                }
              } else {
                echo "<img src='".URL_TO_IMGDIR."/wrong.gif' width='16' height='16' border='0' alt='0x2639;'>";
              }
            }
          }
          if ($punktespiel>0) {
            $punktespieltag+=$punktespiel;
          }?>
            </strong>
          </td>
          <td class="lmost5"><?
          if ($urlb==1) {
            if ($mberi[$st-1][$i]!="") {
              echo "<a href=\"".$mberi[$st-1][$i]."\" target=\"_blank\" title=\"".$text[270]."\"><img src='img/lmo-st1.gif' width=\"10\" height=\"12\" border=\"0\"></a>";
            } else {
              echo "&nbsp;";
            }
          }
          if (($mnote[$st-1][$i]!="") || ($msieg[$st-1][$i]>0)) {
            $dummy=addslashes($teams[$teama[$st-1][$i]]." - ".$teams[$teamb[$st-1][$i]]." ".$goala[$st-1][$i].":".$goalb[$st-1][$i]);
            if ($msieg[$st-1][$i]==3) {
              $dummy=$dummy." / ".$goalb[$st-1][$i].":".$goala[$st-1][$i];
            }
            if ($spez==1) {
              $dummy=$dummy." ".$mspez[$st-1][$i];
            }
            if ($msieg[$st-1][$i]==1) {
              $dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($teams[$teama[$st-1][$i]]." ".$text[211]);
            }
            if ($msieg[$st-1][$i]==2) {
              $dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($teams[$teamb[$st-1][$i]]." ".$text[211]);
            }
            if ($msieg[$st-1][$i]==3) {
              $dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($text[212]);
            }
            if ($mnote[$st-1][$i]!="") {
              $dummy=$dummy."\\n\\n".$text[22].":\\n".$mnote[$st-1][$i];
            }
            echo "<a href='#' onClick=\"alert('".$dummy."');\" title=\"".str_replace("\\n","&#10;",$dummy)."\"><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width=\"10\" height=\"12\" border='0'></a>";
          } else {
            echo "&nbsp;";
          }?>
          </td>
        </tr><?
        }else{ 
          for($n=0;$n<$modus[$st-1];$n++){
            if(($klfin==1) && ($st==$anzst)){ ?>
        <tr>
          <td class="lmost8" colspan=<?=$breite; ?>>
            <nobr><? if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></nobr>
          </td>
        </tr><? 
        }?>
        <tr><?
        if ($tipp_einsichterst==2) {
          if ($goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_") {
            $btip1=false;
          } else {
            $btip1=true;
          }
        } else {
          $btip1=false;
        }
        
        if ($datm==1) {
          if ($mterm[$st-1][$i][$n]>0) {
            $dum1=strftime($datf, $mterm[$st-1][$i][$n]);
          } else {
            $dum1="";
          }?>
          <td class="lmost5"><nobr><?=$dum1; ?></nobr></td><? 
        }?>
          <td class="lmost5" width="2">&nbsp;</td><? 
        if ($n==0) {
          $m1=array($goala[$st-1][$i][0],$goala[$st-1][$i][1],$goala[$st-1][$i][2],$goala[$st-1][$i][3],$goala[$st-1][$i][4],$goala[$st-1][$i][5],$goala[$st-1][$i][6]);
          $m2=array($goalb[$st-1][$i][0],$goalb[$st-1][$i][1],$goalb[$st-1][$i][2],$goalb[$st-1][$i][3],$goalb[$st-1][$i][4],$goalb[$st-1][$i][5],$goalb[$st-1][$i][6]);
          $m=call_user_func('gewinn',$i,$modus[$st-1],$m1,$m2);
          if (($klfin==1) && ($st==$anzst)) {
            if ($i==0) {
              if ($m==1) {
                echo "<td class=\"lmost9a\" align=\"right\"><nobr>";
              } else if ($m==2) {
                echo "<td class=\"lmost9b\" align=\"right\"><nobr>";
              } else {
                echo "<td class=\"lmost5\" align=\"right\"><nobr>";
              }
            } else if ($i==1) {
              if ($m==1) {
                echo "<td class=\"lmost9c\" align=\"right\"><nobr>";
              } else {
                echo "<td class=\"lmost5\" align=\"right\"><nobr>";
              }
            }
          } else {
            if ($m==1) {
              echo "<td class=\"lmost7\" align=\"right\"><nobr>";
            } else {
              echo "<td class=\"lmost5\" align=\"right\"><nobr>";
            }
          }
          if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
            echo "<strong>";
          }
          echo $teams[$teama[$st-1][$i]];
          if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
            echo '</strong>';
          }
          echo '</nobr>';?>
          </td>
          <td class="lmost5" align="center" width="10">-</td><?
          if (($klfin==1) && ($st==$anzst)) {
            if ($i==0) {
              if ($m==2) {
                echo "<td class=\"lmost9a\"><nobr>";
              } else if ($m==1) {
                echo "<td class=\"lmost9b\"><nobr>";
              } else {
                echo "<td class=\"lmost5\"><nobr>";
              }
            } else if ($i==1) {
              if ($m==2) {
                echo "<td class=\"lmost9c\"><nobr>";
              } else {
                echo "<td class=\"lmost5\"><nobr>";
              }
            }
          } else {
            if ($m==2) {
              echo "<td class=\"lmost7\"><nobr>";
            } else {
              echo "<td class=\"lmost5\"><nobr>";
            }
          }
          if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
            echo "<strong>";
          }
          echo $teams[$teamb[$st-1][$i]];
          if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
            echo "</strong>";
          }
          echo '</nobr>';?>
          </td><? 
        }else{ ?>
          <td class="lmost5" colspan="3">&nbsp;</td><?
        }
        if ($goaltippa[$i][$n]=="_") {
          $goaltippa[$i][$n]="";
        }
        if ($goaltippb[$i][$n]=="_") {
          $goaltippb[$i][$n]="";
        }
        if ($goaltippa[$i][$n]=="-1") {
          $goaltippa[$i][$n]="";
        }
        if ($goaltippb[$i][$n]=="-1") {
          $goaltippb[$i][$n]="";
        }?>
          <td class="lmost5" width="2">&nbsp;</td><?
        if($tipp_showtendenzabs==1){ ?>
            <td align="center" class="lmost5">
              <nobr><? 
          if ($btip1==false) {
            if (!isset($tendenz1[$i][$n])) {
              $tendenz1[$i][$n]=0;
            }
            if (!isset($tendenz0[$i][$n])) {
              $tendenz0[$i][$n]=0;
            }
            if (!isset($tendenz2[$i][$n])) {
              $tendenz2[$i][$n]=0;
            }
            echo $tendenz1[$i][$n]."-".$tendenz0[$i][$n]."-".$tendenz2[$i][$n];
          }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
        }
        if($tipp_showtendenzpro==1){ ?>
          <td align="center" class="lmost5">
            <nobr><? 
          if ($btip1==false) {
            if (!isset($anzgetippt[$i][$n])) {
              $anzgetippt[$i][$n]=0;
            }
            if ($anzgetippt[$i][$n]>0) {
              if (!isset($tendenz1[$i][$n])) {
                $tendenz1[$i][$n]=0;
              }
              if (!isset($tendenz0[$i][$n])) {
                $tendenz0[$i][$n]=0;
              }
              if (!isset($tendenz2[$i][$n])) {
                $tendenz2[$i][$n]=0;
              }
              echo number_format(($tendenz1[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%-".number_format(($tendenz0[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%-".number_format(($tendenz2[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%";
            } else {
              echo "&nbsp;";
            }
          }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
        }
        if($btip[$i][$n]==true){
          $savebutton=1;
        }
        if($tipp_tippmodus==1){
          if($tipp_showdurchschntipp==1){?>
          <td align="center" class="lmost5">
            <nobr><? 
            if ($btip1==false) {
              if (!isset($anzgetippt[$i][$n])) {
                $anzgetippt[$i][$n]=0;
              }
              if ($anzgetippt[$i][$n]>0) {
                if (!isset($toregesa[$i][$n])) {
                  $toregesa[$i][$n]=0;
                }
                if (!isset($toregesb[$i][$n])) {
                  $toregesb[$i][$n]=0;
                }
                if ($toregesa[$i][$n]<10 && $toregesb[$i][$n]<10) {
                  $nachkomma=1;
                } else {
                  $nachkomma=0;
                }
                echo number_format(($toregesa[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",").":".number_format(($toregesb[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",");
              } else {
                echo "&nbsp;";
              }
            }?>
            </nobr>
          </td>
          <td class="lmost5">&nbsp;</td><? 
          }
          if($btip[$i][$n]==true){ ?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][241] ?>">
              <input class="lmoadminein" type="text" name="xtippa<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goaltippa[$i][$n]; ?>" onKeyDown="lmotorclk('a','<?=$i.$n; ?>',event.keyCode)">
            </acronym>
          </td><? 
            if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',1);" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>a" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',-1);" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>b" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
            </table>
          </td><? 
            }
          }else{
            if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5">&nbsp;</td><? 
            }?>
          <td class="lmost5" align="right"><?=$goaltippa[$i][$n]; ?></td><? 
          } ?>
          <td class="lmost5">:</td><? 
          if($btip[$i][$n]==true){ ?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][242] ?>">
              <input class="lmoadminein" type="text" name="xtippb<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goaltippb[$i][$n]; ?>" onKeyDown="lmotorclk('b','<?=$i.$n; ?>',event.keyCode)">
            </acronym>
          </td><? 
            if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',1);" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>f\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>f\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>f" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',-1);" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>d\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>d\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>d" width="7" height="7" border="0"></a>')</script>
                </td>
              </tr>
            </table>
          </td><? 
            }
          }else{?>
          <td class="lmost5"><?=$goaltippb[$i][$n]; ?></td><? 
            if($tipp_pfeiltipp==1){ ?>
          <td class="lmost5">&nbsp;</td><? 
            }
          }
        } /* ende $tipp_tippmodus==1 */
        if ($tipp_tippmodus==0) {
          if ($goaltippa[$i][$n]=="" || $goaltippb[$i][$n]=="") {
            $tipp=-1;
          } else if ($goaltippa[$i][$n]>$goaltippb[$i][$n]) {
            $tipp=1;
          } else if ($goaltippa[$i][$n]==$goaltippb[$i][$n]) {
            $tipp=0;
          } else if ($goaltippa[$i][$n]<$goaltippb[$i][$n]) {
            $tipp=2;
          }?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][95] ?>">
              <input type="radio" name="xtipp<?=$i.$n; ?>" value="1" <? if($tipp==1){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
           if($hidr==0){ ?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][96] ?>">
              <input type="radio" name="xtipp<?=$i.$n; ?>" value="3" <? if($tipp==0){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
           }?>
          <td class="lmost5" align="right">
            <acronym title="<?=$text['tipp'][97] ?>">
              <input type="radio" name="xtipp<?=$i.$n; ?>" value="2" <? if($tipp==2){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
          } /* ende ($tipp_tippmodus==0) */
          if ($tipp_jokertipp==1){ ?>
          <td class="lmost5" align="center">
            <acronym title="<?=$text['tipp'][290] ?>">
              <input type="radio" name="xjokerspiel" value="<?=($i+1).($n+1); ?>" <? if($jksp==($i+1).($n+1)){echo " checked";} if($btip[$i][$n]==false){echo " disabled";}elseif($tipp_jokertippaktiv==false){echo " disabled";} ?>>
            </acronym>
          </td><? 
          }?>                                                                                                                   
          <td class="lmost7" align="right"><?=$goala[$st-1][$i][$n]; ?></td>
          <td class="lmost7">:</td>
          <td class="lmost7"><?=$goalb[$st-1][$i][$n]; ?></td>
          <td class="lmost7"><?=$mspez[$st-1][$i][$n]; ?></td>
          <td class="lmost5" width="2">&nbsp;</td>
          <td class="lmost5">
            <strong><? 
          if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1)) {
            $jkspfaktor=$tipp_jokertippmulti;
          } else {
            $jkspfaktor=1;
          }
          $punktespiel=-1;
          if ($goaltippa[$i][$n]!="" && $goaltippb[$i][$n]!="" && $goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_") {
            $punktespiel=tipppunkte($goaltippa[$i][$n], $goaltippb[$i][$n], $goala[$st-1][$i][$n], $goalb[$st-1][$i][$n], 0, $mspez[$st-1][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i][$n]);
          }
          if ($punktespiel==-1) {
            echo "-";
          } else if ($punktespiel==-2) {
            echo $text['tipp'][230];
            $nw=1;
          } else {
            if ($tipp_tippmodus==1) {
              echo $punktespiel;
            } else {
              if ($punktespiel>0) {
                echo "<img src='".URL_TO_IMGDIR."/right.gif' width='16' height='16' border='0' alt='0x263a;'>";
                if ($punktespiel>1) {
                  echo "+".($punktespiel-1);
                }
              } else {
                echo "<img src='".URL_TO_IMGDIR."/wrong.gif' width='16' height='16' border='0' alt='0x2639;'>";
              }
            }
          }
          if ($punktespiel>0) {
            $punktespieltag+=$punktespiel;
          }?>
            </strong>
          </td>
          <td class="lmost5" width="2">&nbsp;</td>
          <td class="lmost5"><?
          if ($urlb==1) {
            if ($mberi[$st-1][$i][$n]!="") {
              echo "<a href=\"".$mberi[$st-1][$i][$n]."\" target=\"_blank\" title=\"".$text[270]."\"><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width=\"10\" height=\"12\" border=\"0\" alt=''></a>";
            } else {
              echo "&nbsp;";
            }
          }
          if ($mnote[$st-1][$i][$n]!="") {
            $dummy=addslashes($teams[$teama[$st-1][$i][$n]]." - ".$teams[$teamb[$st-1][$i][$n]]." ".$goala[$st-1][$i][$n].":".$goalb[$st-1][$i][$n])." ".$mspez[$st-1][$i][$n];
            if ($mnote[$st-1][$i][$n]!="") {
              $dummy=$dummy."\\n\\n".$text[22].":\\n".$mnote[$st-1][$i][$n];
            }
            echo "<a href='' onClick=\"alert('".$dummy."');\" title=\"".str_replace("\\n","&#10;",$dummy)."\"><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width=\"10\" height=\"12\" border=\"0\" alt=''></a>";
          } else {
            echo "&nbsp;";
          }?>
          </td>
        </tr><? 
        }
        if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
        <tr>
          <td class="lmost5" colspan="<?=$breite; ?>">&nbsp;</td>
        </tr><? 
        }
      }
    }
  }?>
        <tr>
          <td class="lmost4" colspan="<?=$datm*2+10-$hidr; ?>" align="right"><? 
  if($tipp_imvorraus>=0 && $st>($stx+$tipp_imvorraus)){
    echo $text['tipp'][177];
  } 
  if($savebutton==1){ ?>
            <acronym title="<?=$text[114] ?>">
              <input class="lmoadminbut" type="submit" name="best" value="<?=$text['tipp'][8]; ?>"<? if($tipp_imvorraus>=0 && $st>($stx+$tipp_imvorraus)){echo " disabled";} ?>>
            </acronym><? 
  }else{
    echo "&nbsp;";
  }?>
          </td>
          <td class="lmost4" colspan="<?=$breite-$datm-9; ?>" align="right">
            <nobr><?
  echo $text[37]." ";
  if($lmtype==0){
   echo $text[2];
  }else{
   echo $j;
  }
  echo ": ".$punktespieltag;?>
            </nobr>
          </td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><? 
  $st0=$st-1;
  if($st>1){
    echo "<td class=\"lmost2\"><a href=\"".$addr.$st0."\" title=\"".$text[6]."\">".$text[5]."</a></td>";
  }
  $st0=$st+1;
  if($st<$anzst){
    echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addr.$st0."\" title=\"".$text[8]."\">".$text[7]."</a></td>";
  }?>
        </tr>
      </table>
    </td>
  </tr>
</table><? 
} ?>